<?php
namespace Amg\Bundle\PageBundle\Model;

use AppBundle\Entity\Owner;

interface PageRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);

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
     * @param $minLevel
     * @return PageInterface[]
     */
    public function getPagePath(PageInterface $page, $minLevel = 0);

    /**
     * @param Owner|null $owner
     * @return PageInterface[]
     */
    public function getPageList($owner = null);

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return PageInterface[]
     *
     * @throws \UnexpectedValueException
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * @param PageInterface|null $page
     * @return PageInterface[]
     */
    public function getPageForMenu(PageInterface $page = null);
    /**
     * @param PageInterface|null $page
     * @return int
     */
    public function getPageForMenuCount(PageInterface $page = null);

    /**
     * @param PageInterface|null $page
     * @return PageInterface
     */
    public function getPageSection(PageInterface $page);
}