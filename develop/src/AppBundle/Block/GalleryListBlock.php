<?php

namespace AppBundle\Block;

use AppBundle\Model\BaseSearch;
use AppBundle\Model\Specification\InOrderOf;
use AppBundle\Model\Specification\InRubric;
use AppBundle\Model\Specification\LastPublished;
use AppBundle\Model\Specification\HasTagOrPhotoTag;
use AppBundle\Search\BaseSearchService;
use Doctrine\ORM\EntityManager;
use Elastica\Filter\Term;
use Happyr\DoctrineSpecification\Logic\AndX;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class GalleryListBlock extends AbstractBlockService
{
    const LIST_LIMIT = 9;
    const LIST_END_TEST = 1;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var BaseSearchService
     */
    protected $searchService;

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

    /**
     * @param BaseSearchService $searchService
     */
    public function setSearchService(BaseSearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function getTemplateMap()
    {
        return [
            'ajax_list' => '::/widgets/gallery/_ajax_list.html.twig'
        ];
    }

    public function getDefaultSettings()
    {
        return array(
            'template' => ':widgets:gallery/_list.html.twig',
            'limit'    => self::LIST_LIMIT,
            'offset'   => 0,
            'order_by' => InOrderOf::PRIORITY_POSITIONED_PUBLISHING,
            'rubric' => null,
            'tag' => null,
        );
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $limit = $blockContext->getSetting('limit');
        $search = BaseSearch::createFromRequest($this->requestStack->getMasterRequest());
        if (!$blockContext->getSetting('rubric')) {
            $blockContext->setSetting('rubric', $search->getRubric());
        }
        $this->searchService->setCustomFilter((new Term(['hidden_from_gallery' => false])));
        $pager = $this->searchService->getPager($search, 'gallery', $limit);
        $template = $blockContext->getTemplate();
        $templateMap = $this->getTemplateMap();

        if (isset($templateMap[$template])) {
            $blockContext->setSetting('template', $templateMap[$template]);
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
                'galleries' => $pager->getCurrentPageResults(),
                'limit' => $limit,
                'next_offset' => $pager->hasNextPage() ? $pager->getCurrentPageOffsetEnd() : null,
                'context' => $blockContext,
                'block' => $this
            ), $response);
    }

    public function execute2(BlockContextInterface $blockContext, Response $response = null)
    {
        $offset = $blockContext->getSetting('offset');
        $limit = $blockContext->getSetting('limit');
        $specs = new AndX(new LastPublished(
            $limit + self::LIST_END_TEST,
            $offset,
            $blockContext->getSetting('order_by')
        ));

        $rubric = $this->requestStack->getMasterRequest()->get('rubric');
        if ($rubric) {
            $specs->andX(
                new InRubric($rubric)
            );

            // if rubric was not passed to block yet
            if (!$blockContext->getSetting('rubric')) {
                $blockContext->setSetting('rubric', $rubric);
            }
        }

        $template = $blockContext->getTemplate();
        $templateMap = $this->getTemplateMap();

        if (isset($templateMap[$template])) {
            $blockContext->setSetting('template', $templateMap[$template]);
        }

        $tag = $this->requestStack->getMasterRequest()->get('tag');
        if ($tag) {
            $specs->andX(
                new HasTagOrPhotoTag($tag)
            );

            // if tag was not passed to block yet
            if (!$blockContext->getSetting('tag')) {
                $blockContext->setSetting('tag', $tag);
            }
        }

        $galleries = $this->em->getRepository('AppBundle:Gallery')->matchWithPhotosTags($specs);

        if (count($galleries) === $limit + self::LIST_END_TEST) {
            $galleries = array_slice($galleries, 0, -self::LIST_END_TEST);
            $nextOffset = $offset + count($galleries);
        } else {
            $nextOffset = null;
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'galleries' => $galleries,
            'limit' => $limit,
            'next_offset' => $nextOffset,
            'context' => $blockContext,
            'block' => $this
        ), $response);
    }
}
