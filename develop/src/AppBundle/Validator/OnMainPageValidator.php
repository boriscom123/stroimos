<?php

namespace AppBundle\Validator;

use AppBundle\Entity\Gallery;
use AppBundle\Entity\GalleryPicks;
use AppBundle\Entity\Video;
use AppBundle\Entity\VideoPicks;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Psr\Log\LogLevel;
use Sonata\AdminBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\TranslatorInterface;

class OnMainPageValidator
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RequestStack
     */
    private $requestStack;

    private $picksViolationMessage = 'Виджет не может содержать материалы снятые с публикации';

    /**
     * @param Registry $doctrine
     * @param TranslatorInterface $translator
     * @param RequestStack $requestStack
     */
    public function __construct(Registry $doctrine, TranslatorInterface $translator, RequestStack $requestStack)
    {
        $this->doctrine = $doctrine;
        $this->translator = $translator;
        $this->requestStack = $requestStack;
    }

    /**
     * @param ErrorElement $errorElement
     * @param Gallery $gallery
     */
    public function validateGallery(ErrorElement $errorElement, Gallery $gallery)
    {
        if(!$gallery->isPublishable() &&
            $this->doctrine->getRepository('AppBundle:GalleryPicks')->hasGallery($gallery->getId())) {
            $this->addPublishableViolation($errorElement, 'breadcrumb.link_gallery_picks_list');
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param Video $video
     */
    public function validateVideo(ErrorElement $errorElement, Video $video)
    {
        if(!$video->isPublishable() &&
            $this->doctrine->getRepository('AppBundle:VideoPicks')->hasVideo($video->getId())) {
            $this->addPublishableViolation($errorElement, 'breadcrumb.link_video_picks_list');
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param VideoPicks $videoPicks
     */
    public function validateVideoPicks(ErrorElement $errorElement, VideoPicks $videoPicks)
    {
        if(!$videoPicks->getVideo()->isPublishable()) {
            $this->addViolationWithFlashBag($errorElement, 'video', $this->picksViolationMessage);
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param GalleryPicks $galleryPicks
     */
    public function validateGalleryPicks(ErrorElement $errorElement, GalleryPicks $galleryPicks)
    {
        if(!$galleryPicks->getGallery()->isPublishable()) {
            $this->addViolationWithFlashBag($errorElement, 'gallery', $this->picksViolationMessage);
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param $widget string
     */
    private function addPublishableViolation(ErrorElement $errorElement, $widget)
    {
        $message = sprintf(
            'Материал нельзя снять с публикации, так как он размещён в виджете "%s"',
            $this->translator->trans($widget)
        );
        $this->addViolationWithFlashBag($errorElement, 'publishable', $message);
    }

    /**
     * @param ErrorElement $errorElement
     * @param $field string
     * @param $message string
     */
    private function addViolationWithFlashBag(ErrorElement $errorElement, $field, $message)
    {
        $errorElement->with($field)->addViolation($message);
        $session = $this->requestStack->getMasterRequest()->getSession();
        if($session instanceof Session) {
            $session->getFlashBag()->add(LogLevel::ERROR, $message);
        }
    }
}