<?php
namespace RedirectImport;

use Amg\DataCore\ValueObject\EntityReference;
use AppBundle\Entity\Document;
use AppBundle\Entity\Infographics;
use AppBundle\Entity\MetroStation;
use AppBundle\Entity\Page;
use AppBundle\Entity\Post;
use AppBundle\Entity\Road;
use Import\BaseImport;

class RedirectImport extends BaseImport
{
    public function doLoad()
    {
        $this->updateRedirects();

        $redirectMap = [];
        foreach($this->manager->createQuery("SELECT r.oldUrl, r.newUrl FROM AppBundle:Redirect r")->getArrayResult() as $redirect) {
            $redirectMap[$redirect['oldUrl']] = $redirect['newUrl'];
        }

        $this->updateContent(Page::class, $redirectMap);
        $this->updateContent(Road::class, $redirectMap);
        $this->updateContent(MetroStation::class, $redirectMap);
        $this->updateContent(Post::class, $redirectMap);
        $this->updateContent(Document::class, $redirectMap);
        $this->updateContent(Infographics::class, $redirectMap);
    }

    protected function updateRedirects()
    {
        $urlGenerator = $this->container->get('app.entity_url_generator');

        $batchSize = 200;
        $i = 0;

        $progress = $this->createProgressBar(
            $this->manager->createQuery("SELECT COUNT(r) FROM AppBundle:Redirect r")->getSingleScalarResult()
        );

        $query = $this->manager->createQuery("SELECT r FROM AppBundle:Redirect r");
        $iterableResult = $query->iterate();
        foreach ($iterableResult as $row) {
            if (!$row[0]->getEntityReference()) {
                continue;
            }

            $entityReference = EntityReference::createFromString($row[0]->getEntityReference());
            $row[0]->setNewUrl(
                $urlGenerator->generate(
                    $this->manager->find($entityReference->getClass(), $entityReference->getId())
                )
            );

            $this->manager->persist($row[0]);

            if (($i % $batchSize) === 0) {
                $this->manager->flush();
                $this->manager->clear();
            }

            $progress->advance();
        }

        $this->manager->flush();
        $this->manager->clear();
        $this->getConsoleOutput()->writeln('');
    }

    protected function updateContent($entityClass, $redirectMap)
    {
        $this->getConsoleOutput()->writeln("Update content: $entityClass");

        $batchSize = 200;
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