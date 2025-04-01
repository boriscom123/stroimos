<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Infographics;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InfographicsController extends Controller
{
    /**
     * @Route("/infographics", name="app_infographics_list")
     * @Template(":Infographics:list.html.twig")
     */
    public function listAction()
    {
        return [];
    }

    /**
     * @Route("/infographics/{slug}", name="app_infographics_show")
     * @ParamConverter()
     * @param Infographics $infographics
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Infographics $infographics)
    {
        return $this->render(':Infographics:show.html.twig', array(
            'infographics' => $infographics,
        ));
    }
}
