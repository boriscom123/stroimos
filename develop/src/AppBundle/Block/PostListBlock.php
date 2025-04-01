<?php

namespace AppBundle\Block;

use AppBundle\Entity\Owner;
use AppBundle\Model\Specification\HasMultiOwner;
use AppBundle\Model\Specification\InCategory;
use AppBundle\Model\Specification\InOrderOf;
use AppBundle\Model\Specification\InRubric;
use AppBundle\Model\Specification\FetchAdministrativeUnit;
use AppBundle\Model\Specification\FetchImage;
use AppBundle\Model\Specification\FetchRubrics;
use AppBundle\Model\Specification\HasTag;
use AppBundle\Model\Specification\FetchTags;
use AppBundle\Model\Specification\InTags;
use AppBundle\Model\Specification\TopNews;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Logic\OrX;
use Happyr\DoctrineSpecification\Spec;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class PostListBlock extends AbstractBlockService
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
            'ajax_list' => '::/widgets/news/_ajax_list.html.twig',
            'subordinate_news_ajax_list' => 'Subordinate/widgets/news/_ajax_list.html.twig',
            'subordinate_shorthand_report_ajax_list' => 'Subordinate/widgets/shorthand_report/_ajax_list.html.twig',
            'photo_lines_ajax_list' => '::/widgets/photo_lines/_ajax_list.html.twig',
            'last_news' => ':widgets:news/day_news.html.twig',
        ];
    }

    public function getDefaultSettings()
    {
        return array(
            'template' => '',
            'limit' => self::LIST_LIMIT,
            'offset' => 0,
            'order_by' => InOrderOf::PRIORITY_POSITIONED_PUBLISHING,
            'category' => null,
            'popular' => false,
            'rubric' => null,
            'tag' => null,
            'in_tags' => [],
            'q' => null,
            'title' => null,
            'set_settings_from_request' => true,
            'owner' => Owner::OWNER_STROI_MOS
        );
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if ($blockContext->getSetting('set_settings_from_request')) {
            $request = $this->requestStack->getMasterRequest();
            $owner = $request->get('owner', $request->get('_subordinate_route', Owner::OWNER_STROI_MOS));
            $blockContext->setSetting('owner', $owner);
            $blockContext->setSetting('q', $request->get('q'));
            $blockContext->setSetting('rubric', $request->get('rubric'));
            $blockContext->setSetting('tag', $request->get('tag'));
        }

        $category = $this->em->getRepository('AppBundle:Category')->findOneBy(['alias' => $blockContext->getSetting('category')]);

        if ($blockContext->getSetting('popular')) {
            $query = $this->em->getRepository('AppBundle:Post')->getQuery(
                new AndX(
                    new TopNews(),
                    new InCategory($blockContext->getSetting('category')),
                    new HasMultiOwner($blockContext->getSetting('owner'))
                )
            );

            return $this->renderResponse($blockContext->getTemplate(), array(
                'posts' => $query->getResult(),
                'limit' => 0,
                'next_offset' => 0,
                'context' => $blockContext,
                'category' => $category,
                'block' => $this,
                'title' => $blockContext->getSetting('title'),
            ), $response);
        }

        $specs = new AndX(
            new FetchImage(),
            new FetchAdministrativeUnit(),
            new FetchRubrics(),
            new FetchTags(),
            new HasMultiOwner($blockContext->getSetting('owner'))
        );

        if ($blockContext->getSetting('category')) {
            $specs->andX(
                new InCategory($blockContext->getSetting('category'))
            );
        }

        if ($search = $blockContext->getSetting('q')) {
            $specs->andX(
                Spec::orX(
                    Spec::like('title', $search),
                    Spec::like('teaser', $search),
                    Spec::like('content', $search)
                )
            );
        }

        if ($rubric = $blockContext->getSetting('rubric')) {
            if (is_array($rubric)) {
                $rubricSpec = new OrX();
                foreach ($rubric as $rubricItem) {
                    $rubricSpec->orX(new InRubric($rubricItem));
                }
            } else {
                $rubricSpec = new InRubric($rubric);
            }

            $specs->andX($rubricSpec);
        }

        if ($tag = $blockContext->getSetting('tag')) {
            $specs->andX(new HasTag($tag));
        }

        if ($inTags = $blockContext->getSetting('in_tags')) {
            if ((is_array($inTags) || $inTags instanceof Collection) && count($inTags) > 0) {
                $specs->andX(new InTags($inTags));
            }
        }

        $specs->andX(
            new InOrderOf($blockContext->getSetting('order_by'))
        );

        $query = $this->em->getRepository('AppBundle:Post')->getQuery($specs);

        $limit = $blockContext->getSetting('limit');
        $offset = $blockContext->getSetting('offset');

        $paginator = new Paginator($query);
        $paginator->setUseOutputWalkers(false); // http://www.doctrine-project.org/jira/browse/DDC-2381?focusedCommentId=21257&page=com.atlassian.jira.plugin.system.issuetabpanels:comment-tabpanel#comment-21257
        $paginator->getQuery()
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $nextOffset = ($offset + $limit < count($paginator)) ? $offset + $limit : null;

        return $this->renderResponse($blockContext->getTemplate(), array(
            'posts' => $paginator,
            'limit' => $limit,
            'next_offset' => $nextOffset,
            'context' => $blockContext,
            'category' => $category,
            'block' => $this,
            'title' => $blockContext->getSetting('title'),
            'owner' => $blockContext->getSetting('owner')
        ), $response);
    }
}
