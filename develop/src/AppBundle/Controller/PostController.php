<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Seo\SeoPage;

class PostController extends Controller
{
    const NEW_INTERVIEWS_TEMPLATE_DATE_APPLY = '02.09.2019';

    public function showAction(Post $post)
    {
        $dateApply = \DateTimeImmutable::createFromFormat('d.m.Y', self::NEW_INTERVIEWS_TEMPLATE_DATE_APPLY);

        $template = ":Post:show.html.twig";

        if ($post->getCategory()->getAlias() === 'interviews'
            && $post->getCreatedAt()->getTimestamp() > $dateApply->getTimestamp()) {
            $template = ":Post/{$post->getCategory()->getAlias()}:show.html.twig";
        }

        return $this->render($template, array(
            'post' => $post
        ));
    }

    /**
     * @ParamConverter("page", class="AppBundle:Page", options={"mapping": {"_route" = "route"}})
     *
     * @param Page $page
     * @param string $categoryAlias
     * @param bool $popular
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request, Page $page, $categoryAlias, $popular = false)
    {
        if ($request->query->get('category')) {
            return $this->redirectToRoute($request->attributes->get('_route'), [
                'rubric' => $request->query->get('category')
            ]);
        }


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
        
        $template = $this->getPostCategoryTemplate($categoryAlias, 'list');

        return $this->render($template, [
            'popular' => $popular,
            'categoryAlias' => $categoryAlias,
        ]);
    }

    protected function getPostCategoryTemplate($categoryAlias, $action)
    {
        $categoryTemplate = ":Post/{$categoryAlias}:$action.html.twig";

        return $this->get('templating')->exists($categoryTemplate)
            ? $categoryTemplate
            : ":Post:$action.html.twig";
    }
}
