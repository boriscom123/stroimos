<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Video;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Seo\SeoPage;
use AppBundle\Entity\Page;

class VideoController extends Controller
{
    /**
     * @Route("/video", name="app_video_list")
     * @Template(":Video:list.html.twig")
     * @ParamConverter("page", class="AppBundle:Page", options={"mapping": {"_route" = "route"}})
     */
    public function listAction(Request $request, Page $page)
    {
        /** @var SeoPage $seoPage */
        $seoPage = $this->container->get('sonata.seo.page.default');
        
        $rubric = $request->query->get('rubric');
        $title = $page->getTitle();
        
        if ($rubric) {
            $title = $title . ' — ' . $rubric;
        }
        
        $title = $title . ' — ' . $this->container->getParameter('domain_canonical_title');

        $seoPage->setTitle($title);
        $seoPage->addMeta('property', 'og:title', $title);

        return [];
    }

    /**
     * @Route("/video/{id}", name="app_video_show")
     * @ParamConverter()
     * @Template(":Video:show.html.twig")
     *
     * @param Video $video
     * @return array
     */
    public function showAction(Video $video)
    {
        return [
            'video' => $video,
        ];
    }
}
