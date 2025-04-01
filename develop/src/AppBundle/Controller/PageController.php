<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    const SLIDER_NEWS_COUNT = 4;

    const LAST_NEWS_COUNT = 10;

    const CITY_NEWS_COUNT = 4;

    /**
     * @param \DateTime $date
     * @param Page $page
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @ParamConverter("page", converter="page_converter")
     */
    public function homePageAction(Page $page, \DateTime $date = null)
    {
        $doctrine = $this->getDoctrine();

        $spotlightItems = $doctrine->getRepository('AppBundle:SpotlightItem')->getAll();

        $galleryPicks = $doctrine->getRepository('AppBundle:GalleryPicks')->getPicks();

        $videoPicks = $doctrine->getRepository('AppBundle:VideoPicks')->getPicks();

        return $this->render(':Page:homepage.html.twig', array(
            'spotlightItems' => $spotlightItems,
            'galleryPicks' => $galleryPicks,
            'videoPicks' => $videoPicks,
            'page' => $page,
            'is_homepage' => true,
        ));
    }

    public function siteMapAction()
    {
        return $this->render(':Page:sitemap.html.twig');
    }

    /**
     * @Route("/hotline", name="app_hotline")
     * @Template(":Page:hotline.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function hotlineAction(Page $page)
    {
        return [
            'page' => $page
        ];
    }

    public function developerCabinetAction()
    {
        return $this->render(':Page:developer_cabinet.html.twig');
    }

    public function procedureCalcAction()
    {
        return $this->render(':Page:procedure_calc.html.twig');
    }

    /**
     * @param Page $page
     * @Route("/zhd", name="app_zhd_list")
     * @Template(":Page:zhd_list.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function listZhdAction(Page $page)
    {
        return [
            'page' => $page
        ];
    }

    /**
     * @param Page $page
     * @Route("/new-moscow", name="app_new_moscow")
     * @Template(":Page:new_moscow.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function newMoscowAction(Page $page)
    {
        return [
            'page' => $page
        ];
    }


    /**
     * @param Page $page
     * @Route("/dostroika-probliemnykh-obiektov", name="app_problem_construction")
     * @Template(":Page:problem_construction.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function problemConstructionPageAction(Page $page)
    {
        //$admUnits = $this->getDoctrine()->getRepository('AppBundle:AdministrativeArea')->findAll();

        return [
            'page' => $page,
//            'admUnits' => $admUnits
        ];
    }

    /**
     * @param Page $page
     * @Route("/novaia-proghramma-rienovatsii-piatietazhiek", name="app_renovation")
     * @Template(":Page:renovation.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function renovationPageAction(Page $page)
    {
        $admUnits = $this->getDoctrine()->getRepository('AppBundle:AdministrativeArea')->findAll();

        return [
            'page' => $page,
            'admUnits' => $admUnits
        ];
    }

    /**
     * @param Page $page
     * @Route("/renovaciya-promzon/proekt-planirovki", name="app_industrial_zil")
     * @Template(":Page:industrial_zil.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function industrialZilPageAction(Page $page)
    {
        return [
            'page' => $page
        ];
    }

    /**
     * @param Page $page
     * @Route("/stadiony-moskvy", name="app_stadiums")
     * @Template(":Page:stadiums.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function moscowStadiumsPageAction(Page $page)
    {
        return [
            'page' => $page
        ];
    }

    /**
     * @param Page $page
     * @Route("/moskovskiie-tsientral-nyie-diamietry-stroi_mos", name="app_diametry")
     * @Template(":Page:diametry.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function diametryPageAction(Page $page)
    {
        return [
            'page' => $page
        ];
    }

    /**
     * @param Page $page
     * @Route("/renovaciya-promzon", name="app_renovation_industrial")
     * @Template(":Page:renovation_industrial.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function renovationIndustrialPageAction(Page $page)
    {
        return [
            'page' => $page
        ];
    }

    /**
     * @param Page $page
     * @Route("/covid-vaccine", name="app_covid_vaccine")
     * @Template(":Page:covid_vaccine.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function covidVaccinePageAction(Page $page)
    {
        return [
            'page' => $page
        ];
    }


    /**
     * @param Page $page
     * @Route("/goriachiie-linii", name="app_contact_center")
     * @Template(":Page:contact_center.html.twig")
     * @ParamConverter("page", converter="page_converter")
     *
     * @return array
     */
    public function contactCenterAction(Page $page)
    {
        return [
            'page' => $page
        ];
    }
}
