<?php

namespace AppBundle\Block;

use AppBundle\Entity\Video;
use AppBundle\Model\Specification\InOrderOf;
use AppBundle\Model\Specification\InRubric;
use AppBundle\Model\Specification\LastPublished;
use AppBundle\Model\Specification\HasTag;
use AppBundle\Model\Specification\UniversalSpec;
use Doctrine\ORM\EntityManager;
use Happyr\DoctrineSpecification\Logic\AndX;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class VideoListBlock extends AbstractBlockService
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
            'ajax_list' => '::/widgets/gallery/_ajax_list.html.twig'
        ];
    }

    public function getDefaultSettings()
    {
        return array(
            'template' => ':widgets:video/_list.html.twig',
            'limit'    => self::LIST_LIMIT,
            'offset'   => 0,
            'order_by' => InOrderOf::PUBLISHING,
            'rubric' => null,
            'tag' => null,
        );
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $limit = $blockContext->getSetting('limit');
        $offset = $blockContext->getSetting('offset');
        $specs = new AndX(
            new LastPublished(
                $limit + self::LIST_END_TEST,
                $offset,
                $blockContext->getSetting('order_by')
            )
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

        $specs->andX(
            new UniversalSpec('isVisibleInVideoCategory', 'eq', 0)
        );

        $video = $this->em->getRepository('AppBundle:Video')->match($specs);

        if (count($video) === $limit + self::LIST_END_TEST) {
            $video = array_slice($video, 0, -self::LIST_END_TEST);
            $nextOffset = $offset + count($video);
        } else {
            $nextOffset = null;
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'video' => $video,
            'limit' => $limit,
            'next_offset' => $nextOffset,
            'context' => $blockContext,
            'block' => $this
        ), $response);
    }
}
