<?php
namespace AppBundle\Seo;

use AppBundle\Entity\AdministrativeUnit;
use AppBundle\Entity\Construction;
use AppBundle\Entity\Document;
use AppBundle\Entity\Gallery;
use AppBundle\Entity\Infographics;
use AppBundle\Entity\MetroStation;
use AppBundle\Entity\Page;
use AppBundle\Entity\Person;
use AppBundle\Entity\Post;
use AppBundle\Entity\Road;
use AppBundle\Entity\Video;
use AppBundle\Model\MediaImageInterface;
use AppBundle\Routing\EntityUrlGenerator;
use Doctrine\ORM\EntityManager;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class SitemapListener implements SitemapListenerInterface
{
    /**
     * @var EntityManager
     */
    private $manager;
    /**
     * @var EntityUrlGenerator
     */
    private $entityUrlGenerator;

    public function __construct(EntityManager $manager, EntityUrlGenerator $entityUrlGenerator)
    {
        $this->manager = $manager;
        $this->entityUrlGenerator = $entityUrlGenerator;
    }

    protected function getSitemapClasses()
    {
        return [
            new SitemapSection('page', Page::class, UrlConcrete::CHANGEFREQ_WEEKLY),
            new SitemapSection('post', Post::class, UrlConcrete::CHANGEFREQ_DAILY),
            new SitemapSection('infographic', Infographics::class, UrlConcrete::CHANGEFREQ_WEEKLY),
            new SitemapSection('document', Document::class, UrlConcrete::CHANGEFREQ_WEEKLY),
            new SitemapSection('gallery', Gallery::class, UrlConcrete::CHANGEFREQ_DAILY),
            new SitemapSection('video', Video::class, UrlConcrete::CHANGEFREQ_WEEKLY),
            new SitemapSection('construction', Construction::class, UrlConcrete::CHANGEFREQ_DAILY),
            new SitemapSection('metro', MetroStation::class, UrlConcrete::CHANGEFREQ_WEEKLY),
            new SitemapSection('road', Road::class, UrlConcrete::CHANGEFREQ_WEEKLY),
            new SitemapSection('person', Person::class, UrlConcrete::CHANGEFREQ_WEEKLY),
            new SitemapSection('adm_unit', AdministrativeUnit::class, UrlConcrete::CHANGEFREQ_WEEKLY)
        ];
    }

    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $section = $event->getSection();
        if (is_null($section) || 'default' === $section) {
            foreach ($this->getSitemapClasses() as $item) {
                $this->populateClass($event, $item);
            }
        }
    }

    protected function populateClass(SitemapPopulateEvent $event, SitemapSection $sitemapSection)
    {
        $entityRepository = $this->manager->getRepository($sitemapSection->getClass());

        $qb = $entityRepository->createQueryBuilder('e');

        switch ($sitemapSection->getClass()) {
            case Post::class:
                $qb->select('partial e.{id,slug,category,updatedAt}')
                    ->leftJoin('e.views', '_views')
                    ->addSelect('_views')
                    ->leftJoin('e.administrativeUnit', '_au')
                    ->addSelect('_au')
                ;
                break;
            case Page::class:
                $qb->select('partial e.{id,slug,route,updatedAt}');
                break;
            case Infographics::class:
            case AdministrativeUnit::class:
                $qb->select('partial e.{id,slug,updatedAt}');
                break;
            case Road::class:
                $qb->select('partial e.{id,roadType.value,updatedAt}');
                break;
            case Person::class:
                $qb->select('partial e.{id}')
                    ->andWhere('e.showInStructure = true');
                break;
            default:
                $qb->select('partial e.{id,updatedAt}');
        }

        if($sitemapSection->getClass() !== Person::class) {
            $qb->orderBy('e.updatedAt', 'DESC');
        }

        if (is_subclass_of($sitemapSection->getClass(), MediaImageInterface::class)) {
            $qb->join('e.image', 'image')
                ->addSelect('image');
        }

        $maxResults = 1000;
        $qb->setMaxResults($maxResults);
        $firstResult = 0;
        do {
            $entitiesIterableResult = $qb->getQuery()
                ->iterate();

            $i = 0;
            foreach ($entitiesIterableResult as list($entity)) {
                $event->getUrlContainer()->addUrl(
                    $this->createUrl($entity, $sitemapSection->getFrequency()), $sitemapSection->getSection()
                );
                if (++$i % 1000 === 0) {
                    $this->manager->clear();
                }
            }

            $qb->setFirstResult($firstResult += $maxResults);
        } while($i >= $maxResults);
    }

    protected function createUrl($entity, $frequency)
    {
        $updatedAt = null;
        if (method_exists($entity, 'getUpdatedAt')) {
            $updatedAt = $entity->getUpdatedAt();
        }

        return new UrlConcrete(
            $this->entityUrlGenerator->generate($entity, [], true),
            $updatedAt,
            $frequency,
            1
        );
    }
}
