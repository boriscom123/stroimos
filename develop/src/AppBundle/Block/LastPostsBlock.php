<?php

namespace AppBundle\Block;

use AppBundle\Entity\Owner;
use AppBundle\Model\Specification\FetchImage;
use AppBundle\Model\Specification\FetchPostViews;
use AppBundle\Model\Specification\HasMultiOwner;
use AppBundle\Model\Specification\InCategory;
use AppBundle\Model\Specification\InOrderOf;
use AppBundle\Model\Specification\InTags;
use AppBundle\Model\Specification\LastPublished;
use AppBundle\Model\Specification\PublishedStartDateFrom;
use AppBundle\Model\Specification\SelectDistinct;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Spec;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Block\BaseBlockService as SonataBaseBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LastPostsBlock extends SonataBaseBlockService
{
    const LIST_LIMIT = 20;

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

    public function getDefaultSettings()
    {
        return [
            'template' => ':widgets:news/day_news.html.twig',
            'limit' => self::LIST_LIMIT,
            'offset' => 0,
            'order_by' => InOrderOf::PUBLISHING,
            'category' => 'news',
            'in_tags' => [],
            'title' => null,
            'owner' => Owner::OWNER_STROI_MOS,
            'use_cache' => true
        ];
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
        $limit = $blockContext->getSetting('limit');
        $category = $blockContext->getSetting('category');

        $specs = new AndX(
            new SelectDistinct(),
            new FetchPostViews(),
            new FetchImage(),
            new HasMultiOwner($blockContext->getSetting('owner')),
            new InCategory($category),
            new LastPublished($limit, 0, $blockContext->getSetting('order_by'))
        );

        if ($inTags = $blockContext->getSetting('in_tags')) {
            if ((is_array($inTags) || $inTags instanceof Collection) && count($inTags) > 0) {
                $specs->andX(new InTags($inTags));
            }
        }

        /** @var QueryModifier $specification */
        $specification = Spec::andX(
            $specs,
            new PublishedStartDateFrom((new \DateTime())->modify('-60 days'))
        );

        $posts = $this->em->getRepository('AppBundle:Post')->match($specification);

        return $this->renderResponse($blockContext->getTemplate(), array(
            'posts' => $posts,
            'limit' => $limit,
            'context' => $blockContext,
            'category' => $category,
            'block' => $this,
            'title' => $blockContext->getSetting('title'),
            'owner' => $blockContext->getSetting('owner')
        ), $response)->setTtl(60);
    }
}
