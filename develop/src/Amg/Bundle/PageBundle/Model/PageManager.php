<?php
namespace Amg\Bundle\PageBundle\Model;

use Amg\Bundle\PageBundle\Layout\LayoutManager;
use Doctrine\ORM\EntityManager;

class PageManager implements PageManagerInterface
{
    protected $pageClass;

    protected $pageRoute;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var LayoutManager
     */
    protected $layoutManager;

    public function __construct($pageClass, $pageRoute, EntityManager $em, LayoutManager $layoutManager)
    {
        $this->pageClass = $pageClass;
        $this->pageRoute = $pageRoute;
        $this->em = $em;
        $this->layoutManager = $layoutManager;
    }

    /**
     * @return PageRepositoryInterface
     */
    protected function getPageRepository()
    {
        return $this->em->getRepository($this->pageClass);
    }

    /**
     * @param string $slug
     * @return PageInterface|null
     */
    public function findBySlug($slug)
    {
        return $this->getPageRepository()->findBySlug($slug);
    }

    /**
     * @param string $route
     * @return PageInterface|null
     */
    public function findByRoute($route)
    {
        return $this->getPageRepository()->findByRoute($route);
    }

    public function getPageLayoutTemplate(PageInterface $page)
    {
        return $this->layoutManager->getLayoutTemplate($this->getPageLayout($page), true);
    }

    public function getPageLayout(PageInterface $page)
    {
        if ($pageLayout = $page->getLayout()) {
            return $pageLayout;
        }

        foreach ($this->getPageRepository()->getPagePath($page, 1) as $parentPage) {
            if ($childrenLayout = $parentPage->getChildrenLayout()) {
                return $childrenLayout;
            }
        }

        return null;
    }
}