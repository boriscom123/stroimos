<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Gallery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GalleryController extends Controller
{
    /**
     * @Route("/gallery", name="app_gallery_list")
     * @Template(":Gallery:list.html.twig")
     */
    public function listAction()
    {
        return [];
    }

    /**
     * @Route("/gallery/{id}", name="app_gallery_show")
     * @ParamConverter()
     * @Template(":Gallery:show.html.twig")
     *
     * @param Gallery $gallery
     * @return array
     */
    public function showAction(Gallery $gallery)
    {
        return [
            'gallery' => $gallery
        ];
    }
}
