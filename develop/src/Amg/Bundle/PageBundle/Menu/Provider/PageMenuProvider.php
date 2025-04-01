<?php
namespace Amg\Bundle\PageBundle\Menu\Provider;

use Amg\Bundle\PageBundle\Menu\Loader\ArrayPageLoader;
use Amg\Bundle\PageBundle\Model\PageRepositoryInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\Provider\MenuProviderInterface;

class PageMenuProvider implements MenuProviderInterface
{
    const MENU_PREFIX = 'page-';
    const SECTION_MENU_PREFIX = 'page-section-';

    /**
     * @var FactoryInterface
     */
    private $factory;
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    public function __construct(FactoryInterface $factory, PageRepositoryInterface $pageRepository)
    {
        $this->factory = $factory;
        $this->pageRepository = $pageRepository;
    }

    protected function checkMenuName($name, $is = self::MENU_PREFIX)
    {
        return substr_compare($name, $is, 0, strlen($is)) === 0;
    }

    protected function getPageIdFromMenuName($name)
    {
        return (int)substr($name, strrpos($name, '-') + 1);
    }

    protected function getSectionPage($name)
    {
        if (!$this->checkMenuName($name)) {
            return null;
        }

        $pageId = $this->getPageIdFromMenuName($name);
        $page = $this->pageRepository->find($pageId);

        if ($this->checkMenuName($name, self::SECTION_MENU_PREFIX)) {
            $page = $this->pageRepository->getPageSection($page);
        }

        return $this->pageRepository->getPageForMenuCount($page) > 0
            ? $page
            : null;

    }

    public function get($name, array $options = array())
    {
        $page = $this->getSectionPage($name);
        if (!$page) {
            throw new \InvalidArgumentException('Menu not found.');
        }

        $rootPage = $this->pageRepository->getPageForMenu($page);

        $loader = new ArrayPageLoader($this->factory);

        return $loader->load($rootPage);
    }

    public function has($name, array $options = array())
    {
        return (bool)$this->getSectionPage($name);
    }
}
