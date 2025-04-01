<?php
namespace AppBundle\Model\PriorityPosition;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\UnitOfWork;

class PriorityPositionSubscriber implements EventSubscriber
{
    protected $updatedEntities;

    public function getSubscribedEvents()
    {
        return array(
            'onFlush',
            'postFlush'
        );
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $ouw = $args->getEntityManager()->getUnitOfWork();

        $this->processChanges($ouw, $ouw->getScheduledEntityUpdates());
        $this->processChanges($ouw, $ouw->getScheduledEntityInsertions());
    }

    protected function processChanges(UnitOfWork $ouw, $scheduledEntities)
    {
        foreach ($scheduledEntities as $entity) {
            if (!$entity instanceof PriorityPositionInterface) {
                continue;
            }

            $changeSet = $ouw->getEntityChangeSet($entity);
            if (isset($changeSet['priorityPosition'])) {
                $previousPosition = isset($changeSet['priorityPosition'][0])
                    ? $changeSet['priorityPosition'][0]
                    : PriorityPositionInterface::DEFAULT_PRIORITY_POSITION;

                $direction = $previousPosition - $changeSet['priorityPosition'][1];

                if (0 !== $direction) {
                    $this->updatedEntities[] = [
                        $entity,
                        $previousPosition,
                        $direction
                    ];
                }
            }
        }
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        if (!isset($this->updatedEntities)) {
            return;
        }

        $em = $args->getEntityManager();

        /** @var PriorityPositionInterface $entity */
        foreach ($this->updatedEntities as list($entity, $previousPosition, $direction)) {
            $qb = $em->createQueryBuilder()
                ->update(get_class($entity), 'e');

            $qb->where('e.id != :id AND e.priorityPosition < :defaultPosition')
                ->setParameter('id', $entity->getId())
                ->setParameter('newPosition', $entity->getPriorityPosition())
                ->setParameter('defaultPosition', PriorityPositionInterface::DEFAULT_PRIORITY_POSITION);

            if ($direction > 0) {
                $qb->set('e.priorityPosition', 'e.priorityPosition + 1')
                    ->andWhere('e.priorityPosition >= :newPosition');
            } else {
                $qb->set('e.priorityPosition', 'e.priorityPosition - 1')
                    ->andWhere('e.priorityPosition > :previousPosition AND e.priorityPosition <= :newPosition ')
                    ->setParameter('previousPosition', $previousPosition);
            }

            $qb
                ->getQuery()
                ->execute();
        }

        $this->updatedEntities = null;
    }
}
