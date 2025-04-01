<?php

namespace AppBundle\Block;

use AppBundle\Entity\Construction;
use AppBundle\Entity\MetroStation;
use AppBundle\Entity\Road;
use AppBundle\Model\ConstructionObjectsSearch;
use AppBundle\Search\ConstructionObjectSearchService;
use FOS\ElasticaBundle\HybridResult;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class ConstructionListBlock extends AbstractBlockService
{
    const LIST_LIMIT = 20;

    use TemplateMapperTrait;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /** @var ConstructionObjectSearchService */
    protected $searchService;

    public function setSearchService(ConstructionObjectSearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack($requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getTemplateMap()
    {
        return [
            'ajax_list' => '::/Construction/_ajax_list.html.twig',
        ];
    }

    public function getDefaultSettings()
    {
        return array(
            'template' => '::Construction/_list.html.twig',
            'limit' => self::LIST_LIMIT,
            'offset' => 0,
            'func_type' => [],
            'adm_unit' => null,
            'search' => '',
            'finish_year' => null,
            'construction' => null,
            'order' => null
        );
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if ($blockContext->getSetting('construction')) {
            //TODO: remove this condition into separate method
            $searchParams = ConstructionObjectsSearch::createFromRequest($this->requestStack->getMasterRequest());
            $searchParams->setLimit(10);
            $result = $this->searchService->getNearConstruction(
                $searchParams,
                $blockContext->getSetting('construction')
            );

            /** @var HybridResult[] $objects */
            $objects = $result['objects'];
            $total = $result['total'];

            $items = array();
            foreach ($objects as &$object) {
                /** @var Construction|MetroStation|Road $construction */
                $construction = $object->getTransformed();
                $construction->setDistance($object->getResult()->getScore());
                $items[] = $construction;
            }
            unset($object);

            if($this->requestStack->getCurrentRequest()->isXmlHttpRequest() && $searchParams->getOffset() > 0) {
                $nextOffset = null;
                $template = '::Construction/_list_items.html.twig';
            } else {
                $template = $blockContext->getTemplate();
                $nextOffset = $searchParams->getOffset() + $searchParams->getLimit();
                $nextOffset = $nextOffset <= $total ? $nextOffset : null;
            }

            return $this->renderResponse($template, array(
                'total' => $total,
                'construction' => $blockContext->getSetting('construction'),
                'func_types' => $searchParams->getFuncPurposes(),
                'items' => $items,
                'limit' => $searchParams->getLimit(),
                'next_offset' => $nextOffset,
                'context' => $blockContext,
                'block' => $this,
            ), $response);
        }

        $searchParams = ConstructionObjectsSearch::createFromBlockContext($blockContext);
        if (!$searchParams->getLimit()) {
            $searchParams->setLimit($blockContext->getSetting('limit'));
        }
        $paginator = $this->searchService->getPaginator($searchParams, $blockContext->getSetting('order'));
        return $this->renderResponse($blockContext->getTemplate(), array(
            'items' => $paginator->getCurrentPageResults(),
            'limit' => $searchParams->getLimit(),
            'next_offset' => $paginator->hasNextPage() ? $paginator->getCurrentPageOffsetEnd() : null,
            'context' => $blockContext,
            'block' => $this,
        ), $response);
    }
}
