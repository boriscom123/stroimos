<?php
namespace Amg\Bundle\PageBundle\Entity;

use Amg\Bundle\PageBundle\Model\PageInterface;
use Amg\Bundle\PageBundle\Model\PageRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Happyr\DoctrineSpecification\EntitySpecificationRepositoryTrait;

/**
 * Class PageRepository
 * @method QueryBuilder getPathQueryBuilder($node)
 */
class PageRepository extends NestedTreeRepository implements PageRepositoryInterface
{
    use EntitySpecificationRepositoryTrait;

    public function findBySlug($slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function findByRoute($route)
    {
        return $this->findOneBy(['route' => $route]);
    }

    public function getPagePath(PageInterface $page, $minLevel = 0)
    {
        return $this->getPathQueryBuilder($page)
            ->andWhere('node.level >= :minLevel')
            ->orderBy('node.level', 'DESC')
            ->setParameter('minLevel', $minLevel)
            ->getQuery()
            ->getResult();
    }

    public function getPageForMenu(PageInterface $page = null)
    {
        $pages = $this->childrenHierarchy($page, false, [], true);
        return isset($pages[0]) ? $pages[0] : [];
    }

    public function getPageForMenuCount(PageInterface $page = null)
    {
        return (int) $this->childrenQueryBuilder($page, false)
            ->select('COUNT(node)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getPageList($owner = null)
    {
        $qb = $this->createQueryBuilder("p")
            ->orderBy('p.root', 'ASC')
            ->addOrderBy('p.left', 'ASC');
        if($owner !== null) {
            $qb->andWhere('p.owner = :owner')
                ->setParameter('owner', $owner);
        }

        return $qb->getQuery()
            ->execute();
    }

    /**
     * @param PageInterface $page
     * @return bool
     */
    public function getPageSection(PageInterface $page)
    {
        return $this->getPathQueryBuilder($page)
            ->andWhere('node.level >= :minLevel AND (node.section = true OR node.level = 1)')
            ->orderBy('node.level', 'DESC')
            ->setParameter('minLevel', 1)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
