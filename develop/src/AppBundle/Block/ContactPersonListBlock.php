<?php

namespace AppBundle\Block;

use AppBundle\Model\Specification\EntitySpecificationRepository;
use Doctrine\ORM\EntityManager;
use Happyr\DoctrineSpecification\Filter\Like;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Logic\OrX;
use Happyr\DoctrineSpecification\Spec;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class ContactPersonListBlock extends AbstractBlockService
{
    const LIST_LIMIT = 20;
    const LIST_END_TEST = 1;

    use TemplateMapperTrait;

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
            'ajax_list' => '::/ContactPerson/_ajax_list.html.twig',
        ];
    }

    public function getDefaultSettings()
    {
        return array(
            'template' => '::ContactPerson/_list.html.twig',
            'limit' => self::LIST_LIMIT,
            'offset' => 0,
            'letter' => '',
            'search' => '',
        );
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        /** @var EntitySpecificationRepository $repo */
        $repo = $this->em->getRepository('AppBundle:ContactPerson');

        $limit = $blockContext->getSetting('limit');
        $specs = new AndX(
            Spec::leftJoin('organization', 'o'),
            new OrX(
                Spec::isNull('organization'),
                Spec::eq('publishable', true, 'o')
            ),
            Spec::limit($limit + self::LIST_END_TEST)
        );

        $offset = $blockContext->getSetting('offset');
        if ($offset) {
            $specs->andX(
                Spec::offset($offset)
            );
        }

        $letter = $this->requestStack->getMasterRequest()->get('letter');
        if ($letter) {
            $specs->andX(
                Spec::like('lastName', $letter, Like::STARTS_WITH)
            );

            if (!$blockContext->getSetting('letter')) {
                $blockContext->setSetting('letter', $letter);
            }
        }

        $search = $this->requestStack->getMasterRequest()->get('search');
        if ($search) {
            $specs->andX(
                Spec::like('lastName', $search)
            );

            if (!$blockContext->getSetting('search')) {
                $blockContext->setSetting('search', $search);
            }
        }

        $items = $repo->match($specs);

        if (count($items) === $limit + self::LIST_END_TEST) {
            $items = array_slice($items, 0, -self::LIST_END_TEST);
            $nextOffset = $offset + count($items);
        } else {
            $nextOffset = null;
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'items' => $items,
            'limit' => $limit,
            'next_offset' => $nextOffset,
            'context' => $blockContext,
            'block' => $this,
        ), $response);
    }
}
