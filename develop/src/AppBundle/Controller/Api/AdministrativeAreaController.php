<?php
namespace AppBundle\Controller\Api;

use AppBundle\Entity\AdministrativeArea;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdministrativeAreaController extends Controller
{
    public function getCollectionAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(AdministrativeArea::class);

        $areas = $repository->findAll();

        $result = [];
        $urlPrefix = '/stroitelstvo-v-okrugah-raionah';
        foreach($areas as $area) {
            $resultItem = [
                'id' => $area->getId(),
                'title' => $area->getTitle(),
                'abbriviation' => $area->getAbbreviation(),
                'url' => "{$urlPrefix}/{$area->getSlug()}",
                'districts' => [],
            ];
            $districts = $area->getDistricts();
            foreach ($districts as $district) {
                $resultItem['districts'][] = [
                    'id' => $district->getId(),
                    'title' => $district->getTitle(),
                    'url' => "{$urlPrefix}/{$area->getSlug()}/{$district->getSlug()}",
                ];
            }
            $result[] = $resultItem;
        }
        return new JsonResponse($result);
    }
}
