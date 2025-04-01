<?php

namespace ApiBundle\InfrastructureLayer\Service;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function applyDeltaForPrioritiesInCategoryAndRange($delta, Category $category, $priorityFrom, $priorityTo = null, $excludePriority = null)
    {
        $postAlias = 'post';
        $priorityField = 'priorityPosition';

        $qb = $this->entityManager->createQueryBuilder();
        $qb->update(Post::class, 'post')
            ->set("$postAlias.$priorityField", "$postAlias.$priorityField + ?1")
            ->where($qb->expr()->gt("$postAlias.$priorityField", $priorityFrom))
            ->andWhere($qb->expr()->eq("$postAlias.category", $category->getId()))
            ->setParameter(1, $delta);

        $qb->andWhere(
            (null === $excludePriority)
                ? $qb->expr()->isNotNull("$postAlias.$priorityField")
                : $qb->expr()->neq("$postAlias.$priorityField", $excludePriority)
        );

        if (null !== $priorityTo) {
            $qb->andWhere($qb->expr()->lt("$postAlias.$priorityField", $priorityTo));
        }

        return $qb->getQuery()->execute();
    }
}
