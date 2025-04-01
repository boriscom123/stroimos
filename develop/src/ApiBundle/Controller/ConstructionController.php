<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Construction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConstructionController extends Controller
{
    /**
     * @Method("GET")
     * @Route(
     *     "api/v2/problem-constructions",
     *     name="api_v2_problem_constructions_collection"
     * )
     */
    public function getProblemConstructions(Request $request)
    {
        $uri = $request->getRequestUri();
        $items = $this->findCachedData($uri);

        if ($items === null) {
            $criteria = ['publishable' => true];
            $criteria['customData.MainFunctional'] = 'problem-construction';
            $constructions = $this
                ->getDoctrine()
                ->getRepository(Construction::class)
                ->findBy($criteria);

            $items = [];
            $mediaExtension = $this->container->get('sonata.media.twig.extension');
            foreach ($constructions as $entity) {
                $items[] = [
                    'id' => $entity->getId(),
                    'title' => $entity->getTitle(),
                    'status' => $entity->getConstructionStatus()->getValue(),
                    'main_functional' => $entity->getCustomData()->getMainFunctional(),
                    'image' => $mediaExtension->path(
                        $entity->getImage(),
                        'main_image_thumb'
                    ),
                    'self' => $this->generateUrl('api_v2_get_construction_entity', ['id' => $entity->getId()]),
                ];
            }
            $items = gzencode(json_encode($items));
            $this->setCache($uri, $items);

            return new Response(
                $items,
                Response::HTTP_OK,
                [
                    'Content-Encoding' => 'gzip',
                    'Content-Type' => 'application/json; charset=utf-8',
                ]
            );
        }

        return new Response(
            ['error' => true, 'message' => 'empty for result'],
            Response::HTTP_OK,
            [
                'Content-Encoding' => 'gzip',
                'Content-Type' => 'application/json; charset=utf-8',
            ]
        );
    }

    /**
     * @Method("GET")
     * @Route(
     *     "api/v2/constructions",
     *     name="api_v2_constructions_collection_by_type"
     * )
     */
    public function getConstructions(Request $request)
    {
        $mainFunctional = $request->get('main_functional');
        $uri = $request->getRequestUri();
        $items = $this->findCachedData($uri);
        if ($items === null) {
            $criteria = ['publishable' => true];
            if ($mainFunctional !== null) {
                $criteria['customData.MainFunctional'] = $mainFunctional;
            }
            $constructions = $this
                ->getDoctrine()
                ->getRepository(Construction::class)
                ->findBy($criteria);

            $items = [];
            $mediaExtension = $this->container->get('sonata.media.twig.extension');
            foreach ($constructions as $entity) {
                $items[] = [
                    'id' => $entity->getId(),
                    'title' => $entity->getTitle(),
                    'status' => $entity->getConstructionStatus()->getValue(),
                    'main_functional' => $entity->getCustomData()->getMainFunctional(),
                    'image' => $mediaExtension->path(
                        $entity->getImage(),
                        'main_image_thumb'
                    ),
                    'self' => $this->generateUrl('api_v2_get_construction_entity', ['id' => $entity->getId()]),
                ];
            }
            $items = gzencode(json_encode($items));
            $this->setCache($uri, $items);
        }

        return new Response(
            $items,
            Response::HTTP_OK,
            [
                'Content-Encoding' => 'gzip',
                'Content-Type' => 'application/json; charset=utf-8',
            ]
        );
    }

    /**
     * @Method("GET")
     * @Route(
     *     "api/v2/constructions/{id}",
     *     name="api_v2_get_construction_entity",
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     * @ParamConverter("entity", class="AppBundle\Entity\Construction")
     */
    public function getConstruction(Construction $entity, Request $request)
    {
        $uri = $request->getRequestUri();
        $result = $this->findCachedData($uri);
        if ($result === null) {
            $result = [
                'title' => $entity->getTitle(),
                'description' => $entity->getMetaDescription(),
                'text' => ($entity->getExtraInformation()) ? $entity->getExtraInformation()->getContent() : '',
                'status' => $entity->getConstructionStatus()->getValue(),
                'start_year' => $entity->getStartYear(),
                'end_year' => $entity->getEndYear(),
                'params' => [],
                'galleries' => $this->generateUrl('api_v2_get_construction_galleries', ['id' => $entity->getId()]),
            ];

            $paramValues = $entity->getConstructionParameterValues();
            foreach ($paramValues as $paramValue) {
                $result['params'][] = [
                    'title' => $paramValue->getConstructionParameter()->getTitle(),
                    'value' => $paramValue->getValue(),
                ];
            }
            $result = gzencode(json_encode($result));
            $this->setCache($uri, $result);
        }

        return new Response(
            $result,
            Response::HTTP_OK,
            [
                'Content-Encoding' => 'gzip',
                'Content-Type' => 'application/json; charset=utf-8',
            ]
        );
    }

    /**
     * @Method("GET")
     * @Route("api/v2/constructions/{id}/galleries", name="api_v2_get_construction_galleries")
     * @ParamConverter("entity", class="AppBundle\Entity\Construction")
     */
    public function getGalleriesAction(Construction $entity, Request $request)
    {
        $uri = $request->getRequestUri();
        $result = $this->findCachedData($uri);
        if ($result === null) {
            $galleries = $entity->getRelatedGalleries();
            $resposeData = [];

            foreach ($galleries as $gallery) {
                $galleryDto = [
                    'title' => $gallery->getTitle(),
                    'medias' => [],
                ];
                $medias = $gallery->getMedias();
                foreach ($medias as $media) {
                    $galleryDto['medias'][] = $this->container->get('sonata.media.twig.extension')->path(
                        $media->getImage(),
                        'gallery_media_full'
                    );
                }

                $resposeData[] = $galleryDto;
            }

            $result = gzencode(json_encode($resposeData));
            $this->setCache($uri, $result);
        }

        return new Response(
            $result,
            Response::HTTP_OK,
            [
                'Content-Encoding' => 'gzip',
                'Content-Type' => 'application/json; charset=utf-8',
            ]
        );
    }

    protected function findCachedData($uri)
    {
        $predis = $this->container->get('snc_redis.api_cache');

        if (!$predis->exists($uri) || $this->getParameter('kernel.environment') === 'dev') {
            return null;
        }

        $data = $predis->get($uri);
        $predis->expire($uri, 600);

        return $data;
    }

    protected function setCache($uri, $data)
    {
        $predis = $this->container->get('snc_redis.api_cache');

        $predis->set($uri, $data, 'ex', 600);
    }
}
