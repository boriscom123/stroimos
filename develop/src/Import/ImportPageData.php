<?php
namespace Import;

use AppBundle\Entity\Page;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Import\Builder\PageBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Parser;

class ImportPageData extends BaseImport implements DependentFixtureInterface
{
    protected $importLevel= 1;

    public function getDependencies()
    {
        return [
            LoadPageData::class
        ];
    }

    public function doLoad()
    {
        foreach((new Finder)->in(__DIR__ . '/Resources/pages')->name('*.yml') as $pageMapFile) {
            $pageMap = (new Parser)->parse(file_get_contents($pageMapFile));
//            dump(file_get_contents($pageMapFile));
//            dump($pageMap);
            foreach ($pageMap as $rootPageReference => $pagesToImportMap) {
                $this->importMapIntoRoot($rootPageReference, $pagesToImportMap);
                $this->manager->flush();
                $this->manager->clear();
            }
        }
    }

    protected function importMapIntoRoot($rootPageReference, $pagesToImportMap)
    {
        $this->getConsoleOutput()->writeln($rootPageReference);
        $rootPage = $this->findPageByReference($rootPageReference);

        PageBuilder::setDefaultParent($rootPage);


        $this->importByMap($pagesToImportMap);
    }

    protected function importByMap($pagesToImportMap)
    {
        foreach ($pagesToImportMap as $pageKey => $importParameters) {
            $importParameters= $this->applyDefaultsImportParameters($importParameters, $pageKey);

            $this->importLevel = 0;
            $this->importPage($importParameters);
        }
    }

    protected function importChildren($importParameters, $pageRow)
    {
        $children = $this->findPageChildrenIds($pageRow);
        foreach ($children as $child) {
            if (
                in_array($child['id'], $importParameters['exclude']) ||
                in_array($child['slug'], $importParameters['exclude'])
            ) {
                continue;
            }

            $this->importPage($this->applyDefaultsImportParameters([
                'condition' => ['id' => $child['id']],
            ]));
        }
    }

    protected function applyDefaultsImportParameters($importParameters, $pageKey = null)
    {
        if (!is_array($importParameters)) {
            $chars = count_chars($importParameters);
            $importParameters = [
                'children' => !(bool)$chars[ord('-')],
                'is_section' => (bool)$chars[ord('+')],
            ];
        }

        $resultParameters = array_merge([
            'children' => true,
            'self' => true,
            'is_section' => false,
            'condition' => [
                'slug' => $pageKey
            ],
            'exclude' => [],
            'import_children' => []
        ], $importParameters);

        if (
            !isset($resultParameters['condition']) ||
            (array_key_exists('slug', $resultParameters['condition']) && empty($resultParameters['condition']['slug']))
        ) {
            throw new \InvalidArgumentException("Condition is missing in \n" . print_r($resultParameters, true));
        }

        return $resultParameters;
    }

    protected function importPage($importParameters)
    {
        $this->importLevel += 1;

        $pageRow = $this->findPageRowByCondition($importParameters['condition']);
//        $this->getConsoleOutput()->writeln(str_repeat(' ', $this->importLevel) . '<' . $pageRow['id'] . '/' . $pageRow['slug']);

        if ($importParameters['self']) {
            $pageBuilder = $this->importPageRow($pageRow, $importParameters);
            PageBuilder::setDefaultParent($pageBuilder->getPage());
            $this->setPageReference('import/' . $pageBuilder->getPage()->getSlug(), $pageBuilder->getPage());
        }

        if ($importParameters['children']) {
            $this->importChildren($importParameters, $pageRow);
        }
        $this->importByMap($importParameters['import_children']);

        if ($importParameters['self']) {
            PageBuilder::usePreviousDefaultParent();
        }

        $this->importLevel -= 1;
    }

    /**
     * @return PageBuilder
     */
    protected function importPageRow($pageRow, $importParameters)
    {
        $pageBuilder = PageBuilder::create();
        $this->getCommonFieldSetter()->importCommonFields($pageBuilder->getPage(), $pageRow);

        /** @var Page $page */
        $page = $pageBuilder->getPage();

        $page->setSection($importParameters['is_section']);

        $this->manager->persist($page);

        $this->addRedirect($pageRow['slug'], $page);

        return $pageBuilder;
    }

    /**
     * @return Page
     */
    protected function findPageByReference($rootPageReference)
    {
        $rootPageReference = ltrim($rootPageReference, '/');
        $rootPageCriteria = ['slug' => $rootPageReference];
        return $this->manager->getRepository('AppBundle:Page')->findOneBy($rootPageCriteria);
    }

    /**
     * @param $condition
     * @return mixed
     */
    protected function findPageRowByCondition($condition)
    {
        $pageQB = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from('st_structure_item', 'main');

        foreach ($condition as $field => $eq) {
            $pageQB
                ->andWhere($pageQB->expr()->eq("main.$field", ":$field"))
                ->setParameter($field, $eq);
        }

        return $pageQB->execute()->fetch();
    }

    /**
     * @param $pageRow
     * @return array
     */
    protected function findPageChildrenIds($pageRow)
    {
        return $this->getSourceDb()->createQueryBuilder()
            ->select('id, slug')
            ->from('st_structure_item', 'main')
            ->where("main.root_id = :root_id AND main.level = :next_level AND main.lft > :lft AND main.rgt < :rgt")
            ->orderBy('main.lft')
            ->setParameters([
                'root_id' => $pageRow['root_id'],
                'next_level' => $pageRow['level'] + 1,
                'lft' => $pageRow['lft'],
                'rgt' => $pageRow['rgt'],
            ])
            ->execute()
            ->fetchAll();
    }
}
