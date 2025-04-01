<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Model\PriorityPosition\PriorityPositionInterface;
use AppBundle\Model\PriorityPosition\PriorityPositionRepositoryInterface;
use AppBundle\Model\Specification\EntitySpecificationRepositoryTrait;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository implements PriorityPositionRepositoryInterface
{
    use EntitySpecificationRepositoryTrait;

    /**
     * @param Post $entity
     * @return array
     */
    public function getPriorityPositions($entity = null)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.category = :category')
            ->andWhere('e.priorityPosition < :default_priority_position')
            ->setParameter(':category', $entity->getCategory())
            ->setParameter(':default_priority_position', PriorityPositionInterface::DEFAULT_PRIORITY_POSITION)
            ->orderBy('e.priorityPosition', 'ASC');

        if (Category::CATEGORY_NEWS === $entity->getCategory()->getAlias()) {
            $qb->andWhere('e.publishDate = :publish_date')
                ->setParameter(':publish_date', $entity->getPublishStartDate()->format('Y-m-d'));
        }

        return $qb->getQuery()
            ->getResult();
    }

    /**
     * @param int $limit
     * @param bool $isGeoDataRequired
     * @param array $extra
     *
     * @return Post[]
     */
    public function getForRss($limit, $isGeoDataRequired = false, $extra = [])
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p', 'i', 'views', 'category')
            ->leftJoin('p.image', 'i')
            ->leftJoin('p.views', 'views')
            ->leftJoin('p.category', 'category')
            ->orderBy('p.publishStartDate', 'DESC')
            ->setMaxResults($limit);

        if ($isGeoDataRequired) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->isNotNull('p.address.text'),
                    $qb->expr()->isNotNull('p.address.geoPoint')
                )
            );
        }

        foreach ($extra as $key => $value) {
            $qb->andWhere($qb->expr()->eq('p.'.$key, $value));
        }

        if (isset($extra['wordIsSmallRss']) && $extra['wordIsSmallRss']) {
            $qb->andWhere(
                $qb->expr()->notIn(
                    'category.alias',
                    [
                        Category::CATEGORY_PRESS_RELEASE,
                        Category::CATEGORY_BUILDER_SCIENCE,
                        Category::CATEGORY_SHORTHAND_REPORTS,
                    ]
                )
            );
        }

        return $qb->getQuery()->getResult();
    }

    public function save(Post $post = null)
    {
        if (null !== $post) {
            $this->_em->persist($post);
        }
        $this->_em->flush($post);
    }

    public function findAllInPriorityRangeAndCategory($from, $to, $category, $limit, $priorityOrder = 'ASC')
    {
        $postAlias = 'p';
        $qb = $this->createQueryBuilder($postAlias);

        $qb->select($postAlias)
            ->setMaxResults($limit)
            ->orderBy("$postAlias.priorityPosition", $priorityOrder)
            ->andWhere($qb->expr()->gte("$postAlias.priorityPosition", $from))
            ->andWhere($qb->expr()->lte("$postAlias.priorityPosition", $to))
            ->andWhere($qb->expr()->eq("$postAlias.category", $category))
        ;

        return $qb->getQuery()->execute();
    }
}
