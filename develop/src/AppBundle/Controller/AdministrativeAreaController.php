<?php

namespace AppBundle\Controller;

use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdministrativeAreaController extends Controller
{
    /**
     * @Route("/stroitelstvo-v-okrugah-raionah/{slug}",
     *     name="app_administrative_area_show",
     *     requirements={"slug" = "^[a-zA-z_0-9-]+$"}
     * )
     * @param string $slug
     * @return Response
     */
    public function showAction($slug)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:AdministrativeArea');
        $administrativeArea = $repo->findOneBy(['slug' => $slug]);

        if ($administrativeArea === null) {
            return $this->forward(
                'AmgPageBundle:Page:page',
                [
                    '_route' => 'page',
                    'slug' => sprintf('stroitelstvo-v-okrugah-raionah/%s', $slug),
                ]
            );
        }

        $em = $this->getDoctrine()->getManager();
        $constructions = $em->getRepository('AppBundle:Construction')->findAllInSidePolygone(
            $administrativeArea->getPolygon()
        );

        $serializer = $this->container->get('serializer');
        $mapConstructions = $serializer->serialize(
            $constructions,
            'json',
            SerializationContext::create()->setGroups('api')
        );

        return $this->render(
            'AdministrativeArea/show.html.twig',
            array(
                'administrativeArea' => $administrativeArea,
                'page' => $administrativeArea,
                'constructions' => $constructions,
                'map_constructions' => $mapConstructions,
            )
        );
    }
}
