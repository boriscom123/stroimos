<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Embeddable\RoadType;
use AppBundle\Entity\Road;
use AppBundle\Model\RoadsSearch;
use JMS\Serializer\SerializationContext;
use ReflectionClass;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RoadController extends Controller
{

    /**
     * @Method("GET")
     * @Route("api/road-types", name="api_get_road_types")
     */
    public function getRoadTypesAction()
    {
        $roadRepository = $this->getDoctrine()->getRepository(Road::class);

        $result = [];
        foreach ($this->findRoadTypes() as $type) {
            $searchParams = new RoadsSearch();
            $searchParams->setType($type);
            $searchParams->setPublished(true);

            $result[$type] = [];
            $searchResult = $roadRepository->search($searchParams);
            /* @var Road $road */
            foreach ($searchResult as $road) {
                $result[$type][] = $this->buildTeaser($road);
            }
        }

        return JsonResponse::create($result)->setEncodingOptions(JSON_UNESCAPED_UNICODE);

        $serializer = $this->container->get('serializer');
        $items = $serializer->serialize(
            $result,
            'json',
            SerializationContext::create()->setGroups('api')
        );

        return new Response(
            $items,
            Response::HTTP_OK,
            ['Content-Type' => 'application/json; charset=utf-8']
        );
    }

    protected function buildTeaser(Road $road)
    {
        return [
            'id' => $road->getId(),
            'title' => $road->getTitle(),
            'status' => $road->getConstructionStatus()->getValue(),
            'priority' => $road->getPriorityPosition(),
            'image' => $this->container->get('sonata.media.twig.extension')->path($road->getImage(), 'full'),
            'teaser' => $road->getTeaser(),
            'self' => $this->generateUrl('api_get_road', ['id' => $road->getId()]),
        ];
    }

    protected function findRoadTypes()
    {
        $reflector = new ReflectionClass(RoadType::class);
        $consts = $reflector->getConstants();
        if ($consts) {
            return array_values($consts);
        }

        return [];
    }

    /**
     * @Method("GET")
     * @Route("api/road/{id}", name="api_get_road")
     * @ParamConverter("road", class="AppBundle\Entity\Road")
     */
    public function getRoadAction(Road $road)
    {
        $result = $this->buildTeaser($road);
        $result = array_merge(
            $result,
            [
                'teaser' => $road->getTeaser(),
                'road_type' => $road->getRoadType()->getValue(),
                'extra_information' => $road->getExtraInformation() ? $road->getExtraInformation()->getContent() : '',
                'galleries' => $this->generateUrl('api_get_road_galleries', ['id' => $road->getId()]),
            ]
        );

        return JsonResponse::create($result)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * @Method("GET")
     * @Route("api/road/{id}/galleries", name="api_get_road_galleries")
     * @ParamConverter("road", class="AppBundle\Entity\Road")
     */
    public function getRoadGalleriesAction(Road $road)
    {
        $galleries = $road->getRelatedGalleries();
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

        return JsonResponse::create($resposeData)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
