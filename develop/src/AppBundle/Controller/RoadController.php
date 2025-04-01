<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Embeddable\RoadType;
use AppBundle\Entity\Page;
use AppBundle\Entity\Road;
use AppBundle\Model\RoadsSearch;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RoadController extends Controller
{
    /**
     * @Route("/road", name="app_road_list")
     * @Template(":Road:list.html.twig")
     * @ParamConverter("page", converter="page_converter")
     */
    public function listAction(Page $page)
    {
        $roadRepository = $this->getDoctrine()->getRepository('AppBundle:Road');

        $trunkSearchParams = new RoadsSearch();
        $trunkSearchParams->setType(RoadType::TYPE_TRUNK);
        $trunkSearchParams->setWithPriorityPosition(true);
        $trunkRoads = $roadRepository->search($trunkSearchParams);

        $spanSearchParams = new RoadsSearch();
        $spanSearchParams->setType(RoadType::TYPE_SPAN);
        $spanRoads = $roadRepository->search($spanSearchParams);

        $overpassSearchParams = new RoadsSearch();
        $overpassSearchParams->setType(RoadType::TYPE_OVERPASS);
        $overpasses = $roadRepository->search($overpassSearchParams);

        $interchangeSearchParams = new RoadsSearch();
        $interchangeSearchParams->setType(RoadType::TYPE_INTERCHANGE);
        $interchanges = $roadRepository->search($interchangeSearchParams);

        $regionalSearchParams = new RoadsSearch();
        $regionalSearchParams->setType(RoadType::TYPE_REGIONAL);
        $regional = $roadRepository->search($regionalSearchParams);

        return [
            'page' => $page,
            'trunks' => $trunkRoads,
            'interchanges' => $interchanges,
            'spans' => $spanRoads,
            'overpasses' => $overpasses,
            'regional' => $regional
        ];
    }

    /**
     * @Route("/road/riekonstruktsiia-mkad", name="app_roads_mkad")
     * @Template(":Road:mkad.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function roadsMkadPageAction(Page $page)
    {
        $roadRepository = $this->getDoctrine()->getRepository('AppBundle:Road');
        $interchangeSearchParams = new RoadsSearch();
        $interchangeSearchParams->setType(RoadType::TYPE_INTERCHANGE);
        $interchanges = $roadRepository->search($interchangeSearchParams);

        return [
            'interchanges' => $interchanges,
            'page' => $page
        ];
    }

    /**
     * @Route("/road/interchange", name="app_road_interchange_list")
     * @Template(":Road:list_interchange.html.twig")
     * @ParamConverter("page", converter="page_converter")
     * @param \AppBundle\Entity\Page $page
     *
     * @return array
     */
    public function listInterchangesAction(Page $page)
    {
        $roadRepository = $this->getDoctrine()->getRepository('AppBundle:Road');

        $interchangeSearchParams = new RoadsSearch();
        $interchangeSearchParams->setType(RoadType::TYPE_INTERCHANGE);
        $interchanges = $roadRepository->search($interchangeSearchParams);

        return [
            'page' => $page,
            'interchanges' => $interchanges,
        ];
    }

    /**
     * @Route("/riekonstruktsiia-zhielieznodorozhnykh-pierieiezdov", name="app_putieprovody")
     * @Template(":Road:putieprovody.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function putieprovodyPageAction(Page $page)
    {
        return [
            'page' => $page
        ];
    }

    /**
     * @Route("/riekonstruktsiia-zhielieznodorozhnykh-pierieiezdov/list", name="app_putieprovody_list")
     * @Template(":Road:putieprovody_list.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function putieprovodyListPageAction(Page $page)
    {
        $roadRepository = $this->getDoctrine()->getRepository('AppBundle:Road');

        $overpassSearchParams = new RoadsSearch();
        $overpassSearchParams->setType(RoadType::TYPE_OVERPASS);
        $overpassSearchParams->setOrderByPriorityPosition(true);
        /** @var Road[] $trunkRoads */
        $overpassRoads = $roadRepository->search($overpassSearchParams);

        $overpassGroups = [];
        foreach ($overpassRoads as $road) {
            $overpassGroups[(string)$road->getConstructionStatus()][] = $road;
        }

        return [
            'page' => $page,
            'overpasses' => $overpassRoads,
            'overpass_groups' => $overpassGroups
        ];
    }

    /**
     * @Route("/riekonstruktsiia-zhielieznodorozhnykh-pierieiezdov/list_complete", name="app_putieprovody_list_complete")
     * @Template(":Road:putieprovody_list_complete.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function putieprovodyListCompletePageAction(Page $page)
    {
        $roadRepository = $this->getDoctrine()->getRepository('AppBundle:Road');

        $overpassSearchParams = new RoadsSearch();
        $overpassSearchParams->setType(RoadType::TYPE_OVERPASS);
        $overpassSearchParams->setOrderByPriorityPosition(true);
        /** @var Road[] $trunkRoads */
        $overpassRoads = $roadRepository->search($overpassSearchParams);

        $overpassGroups = [];
        foreach ($overpassRoads as $road) {
            $overpassGroups[(string)$road->getConstructionStatus()][] = $road;
        }

        return [
            'page' => $page,
            'overpasses' => $overpassRoads,
            'overpass_groups' => $overpassGroups
        ];
    }

    /**
     * @Route("/road/trunk", name="app_road_trunk_list")
     * @Template(":Road:list_trunk.html.twig")
     * @ParamConverter("page", converter="page_converter")
     */
    public function listTrunksAction(Page $page)
    {
        $roadRepository = $this->getDoctrine()->getRepository('AppBundle:Road');

        $trunkSearchParams = new RoadsSearch();
        $trunkSearchParams->setType(RoadType::TYPE_TRUNK);
        $trunkSearchParams->setOrderByPriorityPosition(true);
        /** @var Road[] $trunkRoads */
        $trunkRoads = $roadRepository->search($trunkSearchParams);

        $trunkGroups = [];
        foreach ($trunkRoads as $road) {
            $trunkGroups[(string)$road->getConstructionStatus()][] = $road;
        }

        return [
            'page' => $page,
            'trunks' => $trunkRoads,
            'trunk_groups' => $trunkGroups
        ];
    }

    /**
     * @Route("/road/trunk/{id}", name="app_road_trunk_show")
     * @ParamConverter()
     * @param Road $road
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showTrunkAction(Road $road)
    {
        return $this->render(':Road:show.html.twig', array(
            'subject' => $road,
        ));
    }

    /**
     * @Route("/road/interchange/{id}", name="app_road_interchange_show")
     * @ParamConverter()
     * @param Road $road
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showInterchangeAction(Road $road)
    {
        return $this->render(':Road:show.html.twig', array(
            'subject' => $road,
        ));
    }

    /**
     * @Route("/road/road/{id}", name="app_road_show")
     * @ParamConverter()
     * @param Road $road
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Road $road)
    {
        return $this->render(':Road:show.html.twig', array(
            'subject' => $road,
        ));
    }

    /**
     * @Route("/road/regional", name="app_road_regional_list")
     * @Template(":Road:list_regional.html.twig")
     * @ParamConverter("page", converter="page_converter")
     */
    public function listRegionalAction(Page $page)
    {
        $roadRepository = $this->getDoctrine()->getRepository('AppBundle:Road');

        $searchParams = new RoadsSearch();
        $searchParams->setType(RoadType::TYPE_REGIONAL);
        $searchParams->setOrderByPriorityPosition(true);
        /** @var Road[] $roads */
        $roads = $roadRepository->search($searchParams);

        $groups = [];
        foreach ($roads as $road) {
            $groups[(string)$road->getConstructionStatus()][] = $road;
        }

        return [
            'page' => $page,
            'roads' => $roads,
            'groups' => $groups
        ];
    }

    /**
     * @Route("/road/regional/{id}", name="app_road_regional_show")
     * @ParamConverter()
     * @param Road $road
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showRegionalAction(Road $road)
    {
        return $this->render(':Road:show.html.twig', array(
            'subject' => $road,
        ));
    }
}
