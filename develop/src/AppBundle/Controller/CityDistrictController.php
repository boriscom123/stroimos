<?php
namespace AppBundle\Controller;

use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CityDistrictController extends Controller
{
    /**
     * @Route("/stroitelstvo-v-okrugah-raionah/{areaSlug}/{districtSlug}",
     *     name="app_city_district_show",
     *     requirements={"areaSlug" = "^[a-zA-z_0-9-]+$","districtSlug" = "^[a-zA-z_0-9-]+$"}
     * )
     * @param string $areaSlug
     * @param string $districtSlug
     * @return Response
     */
    public function showAction($areaSlug, $districtSlug)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:AdministrativeArea');
        $administrativeArea = $repo->findOneBy(['slug' => $areaSlug]);
        $repo = $this->getDoctrine()->getRepository('AppBundle:CityDistrict');
        $cityDistrict = $repo->findOneBy(['slug' => $districtSlug, 'parent' => $administrativeArea]);

        if($cityDistrict === null) {
            return $this->forward('AmgPageBundle:Page:page', [
                '_route' => 'page',
                'slug' => sprintf('stroitelstvo-v-okrugah-raionah/%s/%s', $areaSlug, $districtSlug)
            ]);
        }

        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Construction')->createQueryBuilder('c');

        $qb->where($qb->expr()->eq(
            sprintf('ST_Intersects(c.point, geomfromtext(\'MULTIPOLYGON(%s)\'))', $cityDistrict->getPolygon()),
            $qb->expr()->literal(true)
        ));

        $constructions = $qb->getQuery()->getResult();

        $serializer = $this->container->get('serializer');
        $mapConstructions = $serializer->serialize(
            $constructions,
            'json',
            SerializationContext::create()->setGroups('api')
        );


        return $this->render(':CityDistrict:show.html.twig', array(
            'district' => $cityDistrict,
            'constructions' => $constructions,
            'map_constructions' => $mapConstructions
        ));
    }
}