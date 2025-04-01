<?php
namespace AppBundle\Block;

use AppBundle\Entity\Gallery;
use AppBundle\Entity\Infographics;
use AppBundle\Entity\Post;
use AppBundle\Entity\Video;
use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RubricsListBlock extends BaseBlockService
{
    const PARAM__RUBRICS_CONTEXT = 'rubricsContext';
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack($requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $request = $this->requestStack->getMasterRequest();

        switch ($blockContext->getSetting(self::PARAM__RUBRICS_CONTEXT)) {
            case 'post':
                if (!$request->get('categoryAlias')) {
                    return new Response('');
                }

                $items = $this->em->getRepository('AppBundle:Rubric')->getRubricsForEntity(Post::class, $request->get('categoryAlias'));
                $route = 'app_post_list';
                break;
            case 'gallery':
                $items = $this->em->getRepository('AppBundle:Rubric')->getRubricsForEntity(Gallery::class);
                $route = 'app_gallery_list';
                break;
            case 'infographics':
                $items = $this->em->getRepository('AppBundle:Rubric')->getRubricsForEntity(Infographics::class);
                $route = 'app_infographics_list';
                break;
            case 'video':
                $items = $this->em->getRepository('AppBundle:Rubric')->getRubricsForEntity(Video::class);
                $route = 'app_video_list';
                break;
            default:
                return new Response('');
        }

        $routeParams = [];

        if ($request->get('categoryAlias')) {
            $routeParams['categoryAlias'] = $request->get('categoryAlias');
        }

        return $this->renderResponse($blockContext->getTemplate(), [
                'items' => $items,
                'currentItemTitle' => $request->get('rubric'),
                'route' => $route,
                'routeParams' => $routeParams,
            ]);
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => ':Block:themes.html.twig',
            self::PARAM__RUBRICS_CONTEXT => '',
            'use_cache' => false,
            'category_alias' => ''
        ]);
    }

    public function getCacheKeys(BlockInterface $block)
    {
        return $block->getSettings();
    }
}
