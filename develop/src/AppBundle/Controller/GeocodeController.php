<?php
namespace AppBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GeocodeController extends Controller
{
    /**
     * @Route("/api/geocode", name="app_geocode")
     */
    public function geocodeAction(Request $request)
    {
        $longLat = $request->query->get('lglt');

        $longLat = preg_replace('/[^\d,.]/', '', $longLat);

        $geocodeUrl = "https://geocode-maps.yandex.ru/1.x/?format=json&kind=district&geocode=$longLat";

        $geoResponse = file_get_contents($geocodeUrl);
        $geoResponse = json_decode($geoResponse, true);

        if (!isset($geoResponse['response']['GeoObjectCollection']['featureMember'][0]
            ['GeoObject']['metaDataProperty']['GeocoderMetaData']['AddressDetails']
            ['Country']['AdministrativeArea']
            ['Locality']['DependentLocality']['DependentLocalityName'])) {
            return new JsonResponse(['error' => true]);
        }

        $administrativeAreaLocality = $geoResponse['response']['GeoObjectCollection']['featureMember'][0]
        ['GeoObject']['metaDataProperty']['GeocoderMetaData']['AddressDetails']
        ['Country']['AdministrativeArea']
        ['Locality']['DependentLocality'];

        $unitTitles = [];
        if (isset($administrativeAreaLocality['DependentLocality']['DependentLocalityName'])) {
            $unitTitles[] = $administrativeAreaLocality['DependentLocality']['DependentLocalityName'];
        }
        $unitTitles[] = $administrativeAreaLocality['DependentLocalityName'];

        /** @var EntityRepository $admUnitRepo */
        $admUnitRepo = $this->getDoctrine()->getRepository('AppBundle\Entity\AdministrativeUnit');
        foreach ($unitTitles as $unitTitle) {
            $unitTitle = str_replace(['район', 'административный округ'], '', $unitTitle);
            $unitTitle = trim($unitTitle);

            $admUnit = $admUnitRepo->createQueryBuilder('u')
                ->where('u.title LIKE :unit_title')
                ->setParameter('unit_title', '%' . $unitTitle . '%')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

            if (null !== $admUnit) {
                return new JsonResponse([
                    'error' => false,
                    'unit' => $admUnit->asArray()
                ]);
            }
        }

        return new JsonResponse(['error' => true]);
    }
}