<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\MetroLine;
use AppBundle\Entity\MetroStation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MetroLineAndStationController extends Controller
{
    /**
     * @Method("GET")
     * @Route("/api/metrolines", name="api_metrolines")
     */
    public function listAction()
    {
        $metroLines = $this
            ->getDoctrine()
            ->getRepository(MetroLine::class)
            ->findBy(['publishable' => true]);

        $result = [];
        foreach ($metroLines as $line) {
            $stations = $line->getStations();
            $stationCollection = [];
            foreach ($stations as $station) {
                if (!$station->isPublishable()) {
                    continue;
                }

                $stationCollection[] = [
                    'id' => $station->getId(),
                    'line_id' => $line->getId(),
                    'state' => $station->getConstructionStatus()->getValue(),
                    'title' => $station->getTitle(),
                    'administrative_unit' => $station->getAdministrativeUnit()
                        ? $station->getAdministrativeUnit()->asArray()
                        : null,
                    'image_url' => $this->container->get('sonata.media.twig.extension')->path(
                        $station->getImage(),
                        'thumb1440'
                    ),
                    'text' => $station->getContent(),
                    'x' => $station->getX(),
                    'y' => $station->getY(),
                    'address' => $station->getAddressText(),
                    'geo_point' => $station->getGeoPointAsLonLatArray(),
                    'url' => $this->generateUrl(
                        'app_metro_show',
                        ['id' => $station->getId()]
                    ),
                    'extrainfo_url' => $this->generateUrl(
                        'api_metrostations_extrainfo',
                        ['id' => $station->getId()]
                    ),
                    'galleries_url' => $this->generateUrl(
                        'api_metrostations_gallery',
                        ['id' => $station->getId()]
                    ),
                    'end_year' => $station->getConstructionEndYear(),
                ];
            }

            $result[] = [
                'id' => $line->getId(),
                'title' => $line->getTitle(),
                'text' => $line->getContent(),
                'color' => $line->getColor(),
                'number' => $line->getNumber(),
                'stations' => $stationCollection,
                'extrainfo_url' => $this->generateUrl(
                    'api_metrolines_extrainfo',
                    ['id' => $line->getId()]
                ),
                'galleries_url' => $this->generateUrl(
                    'api_metrolines_gallery',
                    ['id' => $line->getId()]
                ),
            ];
        }

        return JsonResponse::create($result)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * @Method("GET")
     * @Route("/api/metrostations/{id}/galleries", name="api_metrostations_gallery")
     */
    public function metrostationsGalleryAction($id)
    {
        $metroLine = $this
            ->getDoctrine()
            ->getRepository(MetroStation::class)
            ->find($id);

        if ($metroLine === null) {
            throw new NotFoundHttpException();
        }

        $galleries = $metroLine->getRelatedGalleries();
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


    /**
     * @Method("GET")
     * @Route("/api/metrolines/{id}/galleries", name="api_metrolines_gallery")
     */
    public function metrolinesGalleryAction($id)
    {
        $metroLine = $this
            ->getDoctrine()
            ->getRepository(MetroLine::class)
            ->find($id);

        if ($metroLine === null) {
            throw new NotFoundHttpException();
        }

        $galleries = $metroLine->getRelatedGalleries();
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

    /**
     * @Method("GET")
     * @Route("/api/metrostations/{id}/extrainfo", name="api_metrostations_extrainfo")
     */
    public function metrostationsExtrainfoAction(MetroStation $metroStation)
    {
        if ($metroStation->getExtraInformation()) {
            return JsonResponse::create($metroStation->getExtraInformation()->getContent())->setEncodingOptions(
                JSON_UNESCAPED_UNICODE
            );
        }

        return new JsonResponse('');
    }

    /**
     * @Method("GET")
     * @Route("/api/metrolines/{id}/extrainfo", name="api_metrolines_extrainfo")
     */
    public function metrolinesExtrainfoAction($id)
    {
        $metroLine = $this
            ->getDoctrine()
            ->getRepository(MetroLine::class)
            ->find($id);

        if ($metroLine === null) {
            throw new NotFoundHttpException();
        }

        if ($metroLine->getExtraInformation()) {
            return JsonResponse::create($metroLine->getExtraInformation()->getContent())->setEncodingOptions(
                JSON_UNESCAPED_UNICODE
            );
        }

        return new JsonResponse('');
    }
}
