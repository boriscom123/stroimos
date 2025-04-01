<?php
namespace Import;

use Amg\DataCore\ValueObject\EntityReference;
use AppBundle\Entity\Document;
use AppBundle\Entity\Infographics;
use AppBundle\Entity\MetroStation;
use AppBundle\Entity\Page;
use AppBundle\Entity\Post;
use AppBundle\Entity\Redirect;
use AppBundle\Entity\Road;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Finder\Finder;

class BuildRedirectsData extends BaseImport implements DependentFixtureInterface
{
    public function getDependencies()
    {
        $dependencies = [];

        /** @var \SplFileInfo $fixture */
        foreach (Finder::create()->name('*.php')->in(__DIR__) as $fixture) {
            if (
                'BaseImport.php' === $fixture->getFilename() ||
                'BuildRedirectsData.php' === $fixture->getFilename() ||
                strpos(file_get_contents($fixture), 'addRedirect') === false
            ) {
                continue;
            }

            $dependencies[] = 'Import\\' . pathinfo($fixture, PATHINFO_FILENAME);
        }

        return $dependencies;
    }

    public function doLoad()
    {
        self::$redirects['/dorozhnoe-stroitelstvo'] = '/road';

        $entityUrlGenerator = $this->container->get('app.entity_url_generator');

        foreach (self::$redirects as $oldUrl => $redirectTo) {
            $redirect = new Redirect();
            $redirect->setOldUrl($oldUrl);

            if (is_string($redirectTo)) {
                $redirect->setNewUrl($redirectTo);
            } else {
                $redirect->setEntityReference(EntityReference::createFromEntity($redirectTo));
                /*try {
                $redirect->setNewUrl($entityUrlGenerator->generate($redirectTo));
                } catch (\Exception $e) {
                    dump($redirectTo);
                }*/
                $redirect->setNewUrl('');
            }

            $this->manager->persist($redirect);
        }
        $this->manager->flush();

        /*$redirectMap = [];
        foreach($this->manager->createQuery("SELECT r.oldUrl, r.newUrl FROM AppBundle:Redirect r")->getArrayResult() as $redirect) {
            $redirectMap[$redirect['oldUrl']] = $redirect['newUrl'];
        }

        $this->updateContent(Page::class, $redirectMap);
        $this->updateContent(Road::class, $redirectMap);
        $this->updateContent(MetroStation::class, $redirectMap);
        $this->updateContent(Post::class, $redirectMap);
        $this->updateContent(Document::class, $redirectMap);
        $this->updateContent(Infographics::class, $redirectMap);*/
    }

    protected function updateContent($entityClass, $redirectMap)
    {
        $this->getConsoleOutput()->writeln("Update content: $entityClass");

        $batchSize = 20;
        $i = 0;

        $progress = $this->createProgressBar(
            $this->manager->createQuery("SELECT COUNT(e) FROM $entityClass e")->getSingleScalarResult()
        );

        $q = $this->manager->createQuery("SELECT e FROM $entityClass e");
        $iterableResult = $q->iterate();
        foreach ($iterableResult as $row) {
            $row[0]->setContent(
                strtr($row[0]->getContent(), $redirectMap)
            );

            $this->manager->persist($row[0]);

            if (($i % $batchSize) === 0) {
                $this->manager->flush();
                $this->manager->clear();
            }

            $progress->advance();
        }
        $this->manager->flush();
        $this->getConsoleOutput()->writeln('');
    }
}
