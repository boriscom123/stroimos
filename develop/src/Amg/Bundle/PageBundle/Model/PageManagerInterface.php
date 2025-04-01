<?php
namespace Amg\Bundle\PageBundle\Model;

interface PageManagerInterface
{
    /**
     * @param string $slug
     * @return PageInterface|null
     */
    public function findBySlug($slug);

    /**
     * @param string $route
     * @return PageInterface|null
     */
    public function findByRoute($route);

    /**
     * @param PageInterface $page
     * @return string
     */
    public function getPageLayoutTemplate(PageInterface $page);
}