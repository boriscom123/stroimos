<?php
namespace AppBundle\Form\Type\Loader;

use AppBundle\Entity\Menu;
use AppBundle\Entity\Repository\MenuNodeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;

class MenuTreeLoader implements EntityLoaderInterface
{
    /**
     * @var MenuNodeRepository
     */
    private $repo;

    protected $result;

    protected $level;

    /**
     * @var Menu
     */
    protected $menu;

    public function __construct(ObjectManager $em, $manager = null, $class = null)
    {
        $this->repo = $em->getRepository($class);
    }

    public function getEntities()
    {
        $menuRootNode = $this->menu->getRootNode();

        return $this->repo->getChildren($menuRootNode, false, null, 'ASC', true);
    }

    public function getEntitiesByIds($identifier, array $values)
    {
        return $this->repo->findBy(
            array($identifier => $values)
        );
    }

    public function setMenu($menu)
    {
        $this->menu = $menu;
    }
}
