<?php
namespace Import;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImportPostData extends BaseImport implements DependentFixtureInterface
{
    protected $canBeSkipped = true;

    public function getDependencies()
    {
        return [
            ImportTagData::class,
            ImportRubricData::class,
            GetCategoryReferences::class,
        ];
    }

    public function doLoad()
    {
        $this->loadPostsFromStructureTable('photo_lines', 25, 597, 672);
        $this->loadPostsFromStructureTable('builder_science', 25, 1236, 1553);
        $this->loadPostsFromStructureTable('builder_science', 25, 1554, 1651);
        $this->loadPostsFromPostsTable('press_release');
        $this->loadPostsFromPostsTable('article', 'article_tag');
        $this->loadPostsFromPostsTable('interview', 'interview_tag');
        $this->loadPostsFromPostsTable('shorthand_report');
    }

    public function loadPostsFromPostsTable($mainTable, $tagTable = null)
    {
        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from("st_{$mainTable}", "main")
            ->orderBy('main.id', 'ASC');

        if ($tagTable) {
            $query
                ->addSelect('(' . $this->getSource()->createTagsSubQuery(false, $mainTable, $tagTable) . ') as tags')
                ->addSelect('(' . $this->getSource()->createTagsSubQuery(true, $mainTable, $tagTable) . ') as rubrics');
        }

        $this->applyQuerySkips($mainTable, $query);

        $totalCount = $this->getSource()->getCountByQueryBuilder($query);

        $progressBar = $this->createProgressBar($totalCount);

        $i = 0;
        $flushStep = 20;
        $this->getConsoleOutput()->writeln($mainTable);
        foreach ($query->execute() as $sourceRow) {
            $this->loadPostFromPostRow($mainTable, $sourceRow);

            if (++$i % $flushStep == 0) {
                $this->manager->flush();
                $this->manager->clear();
            }
            $progressBar->advance();
        }
        $this->getConsoleOutput()->writeln('');
        $this->manager->flush();
        $this->manager->clear();
    }

    public function loadPostsFromStructureTable($type, $root, $lft, $rgt)
    {
        $mainTable = 'structure_item';
        $tagTable = 'news_tag';

        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from("st_{$mainTable}", "main")
            ->where("main.root_id=$root and lft > $lft and rgt < $rgt")
            ->orderBy('main.id', 'ASC');

        if ($tagTable) {
            $query
                ->addSelect('(' . $this->getSource()->createTagsSubQuery(false, $mainTable, $tagTable) . ') as tags')
                ->addSelect('(' . $this->getSource()->createTagsSubQuery(true, $mainTable, $tagTable) . ') as rubrics');
        }

        $this->applyQuerySkips($type, $query, $mainTable);

        $totalCount = $this->getSource()->getCountByQueryBuilder($query);

        $progressBar = $this->createProgressBar($totalCount);

        $i = 0;
        $flushStep = 20;
        $this->getConsoleOutput()->writeln($type);
        foreach ($query->execute() as $sourceRow) {
            $sourceRow['published_at'] = $sourceRow['created_at'];
            $this->loadPostFromPostRow($type, $sourceRow);

            if (++$i % $flushStep == 0) {
                $this->manager->flush();
                $this->manager->clear();
            }
            $progressBar->advance();
        }
        $this->getConsoleOutput()->writeln('');
        $this->manager->flush();
        $this->manager->clear();
    }

    private function loadPostFromPostRow($mainTable, $sourceRow)
    {
        $item = new Post();
        $this->manager->persist($item);

        $categoryMap = [
            'press_release' => Category::CATEGORY_PRESS_RELEASE,
            'article' => Category::CATEGORY_ARTICLE,
            'interview' => Category::CATEGORY_INTERVIEW,
            'photo_lines' => Category::CATEGORY_PHOTO_LINE,
            'builder_science' => Category::CATEGORY_BUILDER_SCIENCE,
            'shorthand_report' => Category::CATEGORY_SHORTHAND_REPORTS,
        ];
        if (!isset($categoryMap[$mainTable])) {
            throw new \RuntimeException("Post category for '$mainTable' not found");
        }
        $item->setCategory($this->getCategoryReference($categoryMap[$mainTable]));

        switch ($categoryMap[$mainTable]) {
            case Category::CATEGORY_PRESS_RELEASE:
                $oldUrl = "/press-releases/" . $sourceRow['slug'];
                break;
            case Category::CATEGORY_ARTICLE:
                $oldUrl = "/articles/" . $sourceRow['slug'];
                break;
            case Category::CATEGORY_INTERVIEW:
                $oldUrl = "/interviews/" . $sourceRow['slug'];
                break;
            case Category::CATEGORY_SHORTHAND_REPORTS:
                $oldUrl = "/shorthand-reports/" . $sourceRow['slug'];
                break;
            case Category::CATEGORY_BUILDER_SCIENCE:
            case Category::CATEGORY_PHOTO_LINE:
                $oldUrl = $sourceRow['slug'];
        }
        $this->addRedirect($oldUrl, $item);

        $this->getCommonFieldSetter()->importCommonFields($item, $sourceRow);
    }
}
