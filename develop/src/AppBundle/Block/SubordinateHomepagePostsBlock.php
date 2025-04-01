<?php

namespace AppBundle\Block;

use AppBundle\Entity\Category;
use AppBundle\Model\Specification\ExcludeById;
use AppBundle\Model\Specification\FetchImage;
use AppBundle\Model\Specification\HasMultiOwner;
use AppBundle\Model\Specification\InCategory;
use AppBundle\Model\Specification\InOrderOf;
use AppBundle\Model\Specification\LastPublished;
use AppBundle\Model\Specification\PublishedStartDateFrom;
use Happyr\DoctrineSpecification\Logic\AndX;
use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class SubordinateHomepagePostsBlock extends BaseBlockService
{
    use CacheTrait;

    const SETTINGS_SUBORDINATE = 'subordinate';

    /**
     * @var EntityManager
     */
    protected $em;

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
            self::SETTINGS_SUBORDINATE => null,
            'use_cache' => $this->useCache
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
        $owner = $this->em->getRepository('AppBundle:Owner')->findOneBy([
            'name' => $blockContext->getSetting(self::SETTINGS_SUBORDINATE)
        ]);
        if(!$owner) {
            return $response ? $response : new Response();
        }

        $postRepository = $this->em->getRepository('AppBundle:Post');
        $postsPicks = $postRepository->match(
            new AndX(
                new InCategory(Category::CATEGORY_PRESS_RELEASE),
                new LastPublished(3, 0, InOrderOf::PRIORITY_POSITIONED_PUBLISHING),
                new HasMultiOwner($owner->getName()),
                new FetchImage()
            )
        );
        $last = $postRepository->match(
            new AndX(
                new InCategory(Category::CATEGORY_PRESS_RELEASE),
                new LastPublished(7, 0, InOrderOf::PRIORITY_POSITIONED_PUBLISHING),
                new ExcludeById($postsPicks),
                new HasMultiOwner($owner->getName()),
                new FetchImage()
            )
        );

        return $this
            ->renderResponse(
                $blockContext->getTemplate(),
                [
                    'postsPicks' => $postsPicks,
                    'last' => $last,
                    'blockContext' => $blockContext,
                    'block' => $this,
                    'owner' => $owner
                ],
                $response
            )
            ->setTtl(60);
    }
}
