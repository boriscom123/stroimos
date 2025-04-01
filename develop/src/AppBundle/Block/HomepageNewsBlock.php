<?php

namespace AppBundle\Block;

use AppBundle\Entity\Category;
use AppBundle\Model\Specification\ExcludeById;
use AppBundle\Model\Specification\FetchImage;
use AppBundle\Model\Specification\InCategory;
use AppBundle\Model\Specification\InOrderOf;
use AppBundle\Model\Specification\LastPublished;
use AppBundle\Model\Specification\PublishedStartDateFrom;
use Doctrine\ORM\EntityManager;
use Happyr\DoctrineSpecification\Logic\AndX;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class HomepageNewsBlock extends BaseBlockService
{
    const SLIDER_NEWS_COUNT = 4;
    const LAST_NEWS_COUNT = 10;
    const CITY_NEWS_COUNT = 4;
    const SETTINGS_PAGE = 'homepage';

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
            self::SETTINGS_PAGE => null,
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
        $postRepository = $this->em->getRepository('AppBundle:Post');

        $postsPicks = $postRepository->match(
            new AndX(
                new InCategory(Category::CATEGORY_NEWS),
                new LastPublished(self::SLIDER_NEWS_COUNT, 0, InOrderOf::PRIORITY_POSITIONED_PUBLISHING),
                new PublishedStartDateFrom((new \DateTime())->modify('-200 days')),
                new FetchImage()
            )
        );
        $lastNews = $postRepository->match(
            new AndX(
                new InCategory(Category::CATEGORY_NEWS),
                new LastPublished(self::LAST_NEWS_COUNT, 0, InOrderOf::PRIORITY_POSITIONED_PUBLISHING),
                new PublishedStartDateFrom((new \DateTime())->modify('-200 days')),
                new ExcludeById($postsPicks),
                new FetchImage()
            )
        );
        $lastCityNews = $postRepository->match(
            new AndX(
                new LastPublished(self::CITY_NEWS_COUNT),
                new PublishedStartDateFrom((new \DateTime())->modify('-200 days')),
                new InCategory(Category::CATEGORY_CITY_NEWS),
                new FetchImage()
            )
        );

        return $this
            ->renderResponse(
                $blockContext->getTemplate(),
                [
                    'page' => $blockContext->getSetting(self::SETTINGS_PAGE),
                    'postsPicks' => $postsPicks,
                    'lastNews' => $lastNews,
                    'lastCityNews' => $lastCityNews,
                    'blockContext' => $blockContext,
                    'block' => $this
                ],
                $response
            )
            ->setTtl(30);
    }
}
