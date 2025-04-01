<?php
namespace AppBundle\Controller;

use AppBundle\Entity\MetroStation;
use AppBundle\Entity\MetroTimelineYear;
use AppBundle\Entity\Page;
use Elastica\Filter as Filter;
use Elastica\Query as Query;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Seo\SeoPage;

class MetroController extends Controller
{
    /**
     * @Route("/metro", name="app_metro_list")
     * @Template(":Metro:list.html.twig")
     * @ParamConverter("page", converter="page_converter")
     */
    public function listAction(Page $page)
    {
        $stationsUnderConstruction = $this->getDoctrine()->getRepository('AppBundle:MetroStation')->getStationsUnderConstructionByLine();

        return [
            'timeline' => $this->getTimeline(),
            'page' => $page,
            'stationsUnderConstruction' => $stationsUnderConstruction,
        ];
    }

    /**
     * @Route("/metro/station/{id}", name="app_metro_show", requirements={"id": "\d+"})
     * @ParamConverter()
     */
    public function showAction(MetroStation $metroStation)
    {
        $stationsUnderConstruction = $this->getDoctrine()->getRepository('AppBundle:MetroStation')->getStationsUnderConstructionByLine();
        $timelines = $this->getDoctrine()->getRepository('AppBundle:MetroTimelineYear')
            ->findBy([], ['year' => 'DESC'], 1);
        $timeline = count($timelines) > 0 ? $timelines[0] : null;
        $src = $this->get('sonata.media.twig.extension')->path($timeline->getImage(), 'reference');

        /** @var SeoPage $seoPage */
        $seoPage = $this->container->get('sonata.seo.page.default');

        $title = 'Станция метро ' . $metroStation->getTitle() . ' — ' . $metroStation->getLine()->getTitle() .
                ' — ' . $this->container->getParameter('domain_canonical_title');

        $seoPage->setTitle($title);
        $seoPage->addMeta('property', 'og:title', $title);

        return $this->render(':Metro:show.html.twig', [
            'stationsUnderConstruction' => $stationsUnderConstruction,
            'metroStation' => $metroStation,
            'timeline' => $timeline,
            'src' => $src
        ]);
    }

    private function getTimeline()
    {
        $years = $this->getDoctrine()->getRepository(MetroTimelineYear::class)->findBy([], ['year' => 'ASC']);

        $minYear = 100500;
        $maxYear = 0;

        $imagesByYears = [];

        foreach ($years as $year) {
            $imageYear = $year->getYear();
            $imagesByYears[$imageYear] = array(
                'small' => $this->get('sonata.media.twig.extension')->path($year->getImage(), 'thumb960'),
                'large' => $this->get('sonata.media.twig.extension')->path($year->getImage(), 'reference')
            );

            $minYear = min($minYear, $imageYear);
            $maxYear = max($maxYear, $imageYear);
        }

        $timelineData = [];
        $lastYearImage = null;
        for ($year = $minYear; $year <= $maxYear; $year++) {
            $yearImage = isset($imagesByYears[$year])
                ? $imagesByYears[$year]
                : $lastYearImage;

            $timelineData[$year] = [
                'year' => $year,
                'src' => $yearImage
            ];

            $lastYearImage = $yearImage;
        }

        $timelineData = array_reverse($timelineData);

        return $timelineData;
    }
}
