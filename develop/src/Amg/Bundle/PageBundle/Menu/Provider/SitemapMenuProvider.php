<?php
namespace Amg\Bundle\PageBundle\Menu\Provider;

use Amg\Bundle\PageBundle\Menu\Loader\ArrayPageLoader;
use Amg\Bundle\PageBundle\Model\PageRepositoryInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\Provider\MenuProviderInterface;

class SitemapMenuProvider implements MenuProviderInterface
{
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

    public function get($name, array $options = array())
    {
        if ('sitemap' !== $name) {
            throw new \InvalidArgumentException('Only "sitemap" menu supported');
        }

        // todo Create menu node tree from page node tree
        $rootPage = $this->pageRepository->getPageForMenu();

        $loader = new ArrayPageLoader($this->factory);

        return $loader->load($rootPage);
    }

    public function has($name, array $options = array())
    {
        return 'sitemap' === $name;
    }
}
