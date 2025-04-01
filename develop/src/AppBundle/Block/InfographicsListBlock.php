<?php

namespace AppBundle\Block;

use AppBundle\Model\Specification\HasTag;
use AppBundle\Model\Specification\InOrderOf;
use AppBundle\Model\Specification\InRubric;
use AppBundle\Model\Specification\LastPublished;
use AppBundle\Model\Specification\UniversalSpec;
use Doctrine\ORM\EntityManager;
use Happyr\DoctrineSpecification\Logic\AndX;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class InfographicsListBlock extends AbstractBlockService
{
    use TemplateMapperTrait;

    const LIMIT = 10;
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

    public function getTemplateMap()
    {
        return [
            'ajax_list' => '::/Infographics/_ajax_list.html.twig',
        ];
    }

    public function getDefaultSettings()
    {
        return array(
            'template' => '::Infographics/_list.html.twig',
            'limit'    => self::LIMIT,
            'offset'   => 0,
            'order_by' => InOrderOf::PRIORITY_POSITIONED_PUBLISHING,
            'extraKey' => null,
            'rubric' => null,
            'tag' => null,
            'use_cache' => true,
            'isVisibleOnHomepage' => true
        );
    }

    public function getCacheKeys(BlockInterface $block)
    {
        return $block->getSettings();
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {

        $limit = $blockContext->getSetting('limit');
        $offset = $blockContext->getSetting('offset');

        $specs = new AndX(new LastPublished(
            $limit + self::LIST_END_TEST,
            $offset,
            $blockContext->getSetting('order_by')
        ));

        $isVisibleOnHomepage =  $blockContext->getSetting('isVisibleOnHomepage');
        $specs->andX(
            new UniversalSpec('isVisibleOnHomepage', 'eq', $isVisibleOnHomepage)
        );

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

        $tag = $this->requestStack->getMasterRequest()->get('tag');
        if ($tag) {
            $specs->andX(
                new HasTag($tag)
            );

            // if tag was not passed to block yet
            if (!$blockContext->getSetting('tag')) {
                $blockContext->setSetting('tag', $tag);
            }
        }

        $infographics = $this->em->getRepository('AppBundle:Infographics')->match($specs);

        if (count($infographics) === $limit + self::LIST_END_TEST) {
            $infographics = array_slice($infographics, 0, -self::LIST_END_TEST);
            $nextOffset = $offset + count($infographics);
        } else {
            $nextOffset = null;
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
                'infographics' => $infographics,
                'limit' => $limit,
                'next_offset' => $nextOffset,
                'context' => $blockContext,
                'block' => $this,
            ), $response)
            ->setTtl(600)
        ;
    }
}
