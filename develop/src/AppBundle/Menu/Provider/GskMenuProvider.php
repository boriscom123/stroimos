<?php
namespace AppBundle\Menu\Provider;

use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Knp\Menu\Loader\NodeLoader;
use Knp\Menu\Provider\MenuProviderInterface;

class GskMenuProvider implements MenuProviderInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @param EntityManager $em
     * @param FactoryInterface $factory
     */
    public function __construct(EntityManager $em, FactoryInterface $factory)
    {
        $this->em = $em;
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function get($name, array $options = array())
    {
        $menu = $this->em->getRepository('AppBundle:Menu')->findMenuByName($name);
        $menuRootNode = $this->em->getRepository('AppBundle:MenuNode')->findRootNodeWithChildByMenu($menu);

        $loader = new NodeLoader($this->factory);

        return $loader->load($menuRootNode);
    }

    /**
     * @inheritdoc
     */
    public function has($name, array $options = array())
    {
        return $this->em->getRepository('AppBundle:Menu')->isMenuExists($name);
    }
}
