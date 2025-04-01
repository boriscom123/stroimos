<?php
namespace Rostec\AppBundle\Admin\Block;

use Doctrine\ORM\EntityManager;
use Application\Amg\DataBundle\Entity\Repository\ArticleRepository;
use Application\Amg\DataBundle\Entity\Repository\PublicationRepository;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PublicationListBlock extends BaseBlockService
{
    const ITEMS_LIMIT = 20;
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    public function setEntityManager(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => '@RostecApp/Admin/Block/feed_list_base.html.twig',
            'limit' => self::ITEMS_LIMIT
        ]);
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        /** @var PublicationRepository $repo */
        $repo = $this->em->getRepository('ApplicationAmgDataBundle:Publication');

        $publications = $repo->findBy(array(), array('updatedAt' => 'DESC'), $blockContext->getSetting('limit'));

        return $this->renderResponse($blockContext->getTemplate(), [
            'publications' => $publications,
        ], $response);
    }
}
