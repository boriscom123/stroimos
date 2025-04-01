<?php

namespace ApiBundle\PresentationLayer\HttpController;

use AppBundle\Entity\Gallery;
use AppBundle\Entity\GalleryMedia;
use Doctrine\ORM\EntityManagerInterface;
use Predis\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route(service="ApiBundle\PresentationLayer\HttpController\GalleryController")
 */
class GalleryController extends Controller
{
    const MAIN_IMAGE_FORMAT = 'reference';
    const PHOTO_FORMAT_DEFAULT = 'gallery_media_full';

    /**
     * @var MediaProviderInterface
     */
    private $mediaProvider;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var Client
     */
    private $redisClient;

    public function __construct(
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        MediaProviderInterface $mediaProvider,
        Client $redisClient
    ) {
        $this->mediaProvider = $mediaProvider;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->redisClient = $redisClient;
    }

    /**
     * @Method("GET")
     * @Route("api/galleries/{id}", name="api_galleries")
     * @ParamConverter("entity", class="AppBundle\Entity\Gallery")
     */
    public function getGalleryAction(Gallery $gallery, Request $request)
    {
        $uri = $request->getRequestUri();
        $result = $this->findCachedData($uri);
        if ($result === null) {
            $output = [
                'id' => $gallery->getId(),
                'title' => $gallery->getTitle(),
                'image' => $this->mediaProvider->generatePublicUrl($gallery->getImage(), self::MAIN_IMAGE_FORMAT),
                'photo' => $this->router->generate('api_gallery_photos', ['id' => $gallery->getId()]),
            ];

            $result = gzencode(json_encode($output));
            $this->setCache($uri, $result);
        }

        return new Response(
            $result, Response::HTTP_OK, [
                'Content-Encoding' => 'gzip',
                'Content-Type' => 'application/json; charset=utf-8',
            ]
        );
    }

    protected function findCachedData($uri)
    {
        if (!$this->redisClient->exists($uri) || $this->getParameter('kernel.environment') === 'dev') {
            return null;
        }

        $data = $this->redisClient->get($uri);
        $this->redisClient->expire($uri, 600);

        return $data;

    }

    protected function setCache($uri, $data)
    {
        $this->redisClient->set($uri, $data, 'ex', 600);
    }

    /**
     * @Method("GET")
     * @Route("api/galleries/{id}/photos", name="api_gallery_photos")
     * @ParamConverter("entity", class="AppBundle\Entity\Gallery")
     */
    public function getGalleryPhotosAction(Gallery $gallery, Request $request)
    {
        $uri = $request->getRequestUri();
        $result = $this->findCachedData($uri);
        if ($result === null) {
            $output = [];
            $galleryMedias = $gallery->getMedias()->toArray();
            usort(
                $galleryMedias,
                function (GalleryMedia $a, GalleryMedia $b) {
                    if ($a->getPosition() < $b->getPosition()) {
                        return -1;
                    }
                    if ($a->getPosition() === $b->getPosition()) {
                        return 0;
                    }
                    if ($a->getPosition() > $b->getPosition()) {
                        return 1;
                    }
                }
            );

            $requestedFormat = $request->get('format');
            $format = $requestedFormat && $this->mediaProvider->getFormat($requestedFormat)
                ? $requestedFormat
                : self::PHOTO_FORMAT_DEFAULT;

            foreach ($galleryMedias as $galleryMedia) {
                $output[] = $this->mediaProvider->generatePublicUrl($galleryMedia->getImage(), $format);
            }

            $result = gzencode(json_encode($output));
            $this->setCache($uri, $result);
        }

        return new Response(
            $result, Response::HTTP_OK, [
                'Content-Encoding' => 'gzip',
                'Content-Type' => 'application/json; charset=utf-8',
            ]
        );
    }
}
