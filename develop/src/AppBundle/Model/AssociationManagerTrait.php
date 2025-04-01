<?php

namespace AppBundle\Model;

use Doctrine\Common\Collections\Collection;

trait AssociationManagerTrait
{
    protected function findNewEntitiesIn(Collection $entityCollection, Collection $collectionForCompare)
    {
        $newEntitiesCollection = $entityCollection->filter(
            function ($entity) use ($collectionForCompare) {
                return !$collectionForCompare->contains($entity);
            }
        );

        return $newEntitiesCollection;
    }

    protected function findMissingEntitiesIn(Collection $entityCollection, Collection $collectionForCompare)
    {
        return $this->findNewEntitiesIn($collectionForCompare, $entityCollection);
    }
}
