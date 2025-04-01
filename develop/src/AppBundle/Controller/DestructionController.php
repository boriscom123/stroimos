<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DestructionController extends Controller
{
    /**
     * @Route("/destruction", name="app_destruction")
     * @ParamConverter("page", converter="page_converter")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Page $page)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Destruction');

        $undistructedByAdress = $repo->findBy(array('destructed' => false), array('address.text' => 'ASC'));

        $addresses = array();
        $addresses2 = array();
        foreach ($undistructedByAdress as $item) {

            $destructParams = array(
                'id' => $item->getId(),
                'lat' => $item->getAddress()->getGeoPoint()->getLatitude(),
                'lng' => $item->getAddress()->getGeoPoint()->getLongitude(),
                'address' => $item->getAddress()->getText(),
                'serialNum' => $item->getSeries()
            );
            $addresses[] = $destructParams;

            $area = $item->getAdministrativeArea()->getAbbreviation();

            if (isset($addresses2[$area])) {
                $addresses2[$area]['items'][] = $destructParams;
            } else {
                $addresses2[$area]['county'] = $area;
                $addresses2[$area]['items'][0] = $destructParams;
            }
        }
        asort($addresses2);

        return $this->render(':Destruction:list.html.twig', array(
            'page' => $page,
            'countAddr' => count($addresses),
            'addresses' => json_encode($addresses, JSON_UNESCAPED_UNICODE),
            'addresses2' => json_encode(array_values($addresses2), JSON_UNESCAPED_UNICODE),
        ));
    }
}
