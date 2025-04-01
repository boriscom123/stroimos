<?php

namespace AppBundle\Block;

use AppBundle\Model\Specification\ExcludeHiddenFromGallery;
use AppBundle\Model\Specification\HasMultiOwner;
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


class SubordinateMediaBlock extends BaseBlockService
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
        $galleries = $this->em->getRepository('AppBundle:Gallery')->match(
            new AndX(
                new LastPublished(2, 0, InOrderOf::PRIORITY_POSITIONED_PUBLISHING),
                new ExcludeHiddenFromGallery(),
                new HasMultiOwner($blockContext->getSetting(self::SETTINGS_SUBORDINATE))
            )
        );

        $videos = $this->em->getRepository('AppBundle:Video')->match(
            new AndX(
                new LastPublished(3, 0, InOrderOf::PUBLISHING),
                new HasMultiOwner($blockContext->getSetting(self::SETTINGS_SUBORDINATE))
            )
        );

        return $this
            ->renderResponse(
                $blockContext->getTemplate(),
                [
                    'galleries' => $galleries,
                    'videos' => $videos,
                    'blockContext' => $blockContext,
                    'block' => $this
                ],
                $response
            )
            ->setTtl(60);
    }
}
