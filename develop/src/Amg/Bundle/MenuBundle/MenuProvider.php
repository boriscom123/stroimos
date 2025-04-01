<?php
namespace Amg\Bundle\MenuBundle;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\NodeInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuProvider implements MenuProviderInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory = null;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var MenuLoaderInterface[]
     */
    private $loaders;

    public function __construct(
        FactoryInterface $factory,
        RequestStack $requestStack
    )
    {
        $this->factory = $factory;
        $this->requestStack = $requestStack;
    }

    /**
     * @param string $name
     * @param array $options
     * @return ItemInterface
     * @throws \InvalidArgumentException
     */
    public function get($name, array $options = array())
    {
        $menu = $this->find($name, $options, true);

        $menuItem = $this->factory->createFromNode($menu);
        if (empty($menuItem)) {
            throw new \InvalidArgumentException("Menu at '$name' is misconfigured (f.e. the route might be incorrect) and could therefore not be instanciated");
        }

        $menuItem->setCurrentUri($this->requestStack->getMasterRequest()->getRequestUri());

        return $menuItem;
    }

    /**
     * @param MenuLoaderInterface $menuLoader
     */
    public function addMenuLoader(MenuLoaderInterface $menuLoader)
    {
        $this->loaders[] = $menuLoader;
    }

    /**
     * @param $name
     * @param $options
     * @param $throw
     * @return bool|NodeInterface
     * @throws \InvalidArgumentException
     */
    private function find($name, $options, $throw)
    {
        if (empty($name)) {
            if ($throw) {
                throw new \InvalidArgumentException('The menu name may not be empty');
            }
            return false;
        }

        foreach ($this->loaders as $loader) {
            if (!$loader->hasMenu($name)) {
                continue;
            }

            $menu = $loader->findMenu($name);

            if (!$menu instanceof NodeInterface) {
                if ($throw) {
                    throw new \InvalidArgumentException("Menu at '$name' is not a valid menu node");
                }
                return false;
            }

            return $menu;
        }

        if ($throw) {
            throw new \InvalidArgumentException(sprintf('The menu "%s" is not defined.', $name));
        }
        return false;
    }

    /**
     * @param string $name
     * @param array $options
     * @return bool
     */
    public function has($name, array $options = array())
    {
        foreach ($this->loaders as $loader) {
            if ($loader->hasMenu($name)) {
                return true;
            }
        }
        return false;
    }
}
