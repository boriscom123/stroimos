<?php

namespace AppBundle\Entity\Repository;

use Amg\Bundle\MenuBundle\MenuLoaderInterface;
use AppBundle\Entity\Menu;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Happyr\DoctrineSpecification\EntitySpecificationRepositoryTrait;
use Knp\Menu\NodeInterface;

class MenuNodeRepository extends NestedTreeRepository implements MenuLoaderInterface
{
    use PublicationTrait;
    use EntitySpecificationRepositoryTrait;

    /**
     * @param string $name
     * @return NodeInterface|null
     */
    public function findMenu($name)
    {
        $qb = $this->getRootNodesQueryBuilder()
            ->select('
                node, node_1, node_2, node_3
            ')
            ->andWhere('node.nodeName = :name')
            ->setParameter('name', $name)
            ->leftJoin('node.children', 'node_1')
            ->leftJoin('node_1.children', 'node_2')
            ->leftJoin('node_2.children', 'node_3')
        ;

        $query = $qb->getQuery();

        $singleResult = $query->getSingleResult();
        return $singleResult;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasMenu($name)
    {
        $qb = $this->getRootNodesQueryBuilder()
            ->andWhere('node.nodeName = :name')
            ->setParameter('name', $name);

        $qb->select('COUNT(node)');

        return 1 === (int)$qb->getQuery()->getSingleScalarResult();
    }

    public function findRootNodeWithChildByMenu(Menu $menu)
    {
        $qb = $this->getRootNodesQueryBuilder()
            ->select('
                node, node_page,
                node_1, node_1_page,
                node_2, node_2_page,
                node_3, node_3_page
            ')
            ->andWhere('node = :node')
            ->setParameter('node', $menu->getRootNode())
            ->leftJoin('node.children', 'node_1')
            ->leftJoin('node_1.children', 'node_2')
            ->leftJoin('node_2.children', 'node_3')

            ->leftJoin('node.page', 'node_page')
            ->leftJoin('node_1.page', 'node_1_page')
            ->leftJoin('node_2.page', 'node_2_page')
            ->leftJoin('node_3.page', 'node_3_page')

            ->orderBy('node.lft')
            ->addOrderBy('node_1.lft')
            ->addOrderBy('node_2.lft')
            ->addOrderBy('node_3.lft')
        ;

        return $qb->getQuery()->getSingleResult();
    }
}
