<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Construction;
use AppBundle\Model\ConstructionObjectsSearch;
use JMS\Serializer\SerializationContext;
use Predis\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Seo\SeoPage;

class ConstructionController extends Controller
{
    const LIMIT = 10;

    /**
     * @Route("/construction", name="app_construction")
     * @Template(":Construction:map.html.twig")
     */
    public function mapAction()
    {
        $page = $this->getDoctrine()->getRepository('AppBundle:Page')->findOneBy(['route' => 'app_construction']);
        $admUnits = $this->getDoctrine()->getRepository('AppBundle:AdministrativeArea')->findAll();
        $finishYearsRange = $this->container->get('app.search.construction_object')->getConstructionEndYearsRange();

        return [
            'page' => $page,
            'admUnits' => $admUnits,
            'finishYearsRange' => $finishYearsRange,
        ];
    }

    /**
     * @Route("/construction/{id}", name="app_construction_show", requirements={"id" = "\d+"})
     * @param Request $request
     * @param Construction $construction
     * @ParamConverter()
     *
     * @return Response
     */
    public function showAction(Request $request, Construction $construction)
    {
        if($construction === null) {
            throw $this->createNotFoundException();
        }

        if ($request->isXmlHttpRequest()) {
            return $this->render(':Construction:_near_objects_ajax_list.html.twig', array(
                'construction' => $construction
            ));
        }

        $search = ConstructionObjectsSearch::createFromRequest($request);
        $aggregation = $this->get('app.search.construction_object')->getNearConstructionAggregation(
            $search,
            $construction
        );

        $parameters = $this->getDoctrine()->getRepository('AppBundle:ConstructionParameterValue')
            ->findBy(['construction' => $construction], ['weight' => 'DESC']);

        /** @var SeoPage $seoPage */
        $seoPage = $this->container->get('sonata.seo.page.default');

        $address = $construction->getData()->getObjectAddress() ?: '';
        $title = $construction->getTitle() . ' — ' . $address .
                ' — ' . $this->container->getParameter('domain_canonical_title');

        $seoPage->setTitle($title);
        $seoPage->addMeta('property', 'og:title', $title);

        return $this->render(':Construction:show.html.twig', array(
            'construction' => $construction,
            'aggregation' => $aggregation,
            'total' => array_sum(array_values($aggregation)),
            'parameters' => $parameters
        ));
    }

    /**
     * @Route("/api/construction", name="api_construction_list")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apiAction(Request $request)
    {
        $uri = $request->getRequestUri();

        /** @var Client $predis */
        $predis = $this->container->get('snc_redis.api_cache');

        if ($predis->exists($uri) && $this->getParameter('kernel.environment') !== 'dev') {
            $items = $predis->get($uri);
            $predis->expire($uri, 600);
        } else {
            $paginator = $this->container->get('app.search.construction_object')
                ->getPaginator(ConstructionObjectsSearch::createFromRequest($request));
            $paginator->setMaxPerPage(9000);

            $serializer = $this->container->get('serializer');
            $items = $serializer->serialize(
                $paginator->getCurrentPageResults(),
                'json',
                SerializationContext::create()->setGroups('api')
            );

            $items = gzencode($items);
            $predis->set($uri, $items, 'ex', 600);
        }



        return new Response(
            $items, Response::HTTP_OK, [
                'Content-Encoding' => 'gzip',
                'Content-Type' => 'application/json; charset=utf-8'
            ]
        );
    }


    /**
     * @Route("/export/map/roads", name="app_construction_map")
     * @Template(":Construction:map_for_iframe.html.twig")
     */
    public function mapRoardAction(Request $request)
    {
        return [
            'width' => $request->get('width', '100%'),
            'height' => $request->get('height', '1000px'),
        ];
    }
}
