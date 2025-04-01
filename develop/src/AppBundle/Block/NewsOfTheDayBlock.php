<?php

namespace AppBundle\Block;

use AppBundle\Model\Specification\HasMultiOwner;
use AppBundle\Model\Specification\InCategory;
use AppBundle\Model\Specification\InOrderOf;
use AppBundle\Model\Specification\LastPublished;
use AppBundle\Model\Specification\PublishedStartDateFrom;
use Doctrine\ORM\EntityManager;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Spec;
use Sonata\BlockBundle\Block\BaseBlockService as SonataBaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class NewsOfTheDayBlock extends SonataBaseBlockService
{
    const POST_LIMIT = 8,
          DEFAULT_TEMPLATE = ':widgets:news/day_news.html.twig';

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var RequestStack
     */
    protected $requestStack;

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

    public function getDefaultSettings()
    {
        return array(
            'template' => self::DEFAULT_TEMPLATE,
            'limit'    => self::POST_LIMIT,
            'offset'   => 0,
            'order_by' => InOrderOf::PUBLISHING,
            'category' => 'news',
            'popular'  => false,
            'use_cache' => true,
        );
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults($this->getDefaultSettings());
    }

    public function getCacheKeys(BlockInterface $block)
    {
        return $block->getSettings();
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $defaultSpec = Spec::andX(
            new LastPublished($blockContext->getSetting('limit'), 0, $blockContext->getSetting('order_by')),
            new InCategory($blockContext->getSetting('category')),
            new HasMultiOwner()
        );

        /** @var QueryModifier $specification */
        $specification = Spec::andX(
            $defaultSpec,
            new PublishedStartDateFrom((new \DateTime())->modify('-7 days'))
        );
        $posts = $this->em->getRepository('AppBundle:Post')->match($specification);

        return $this
            ->renderResponse($blockContext->getTemplate(), array(
                'posts' => $posts,
                'blockContext' => $blockContext,
                'block' => $this
            ), $response)
            ->setTtl(600);
    }
}
