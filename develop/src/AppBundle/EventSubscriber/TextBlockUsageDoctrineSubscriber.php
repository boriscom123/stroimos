<?php

namespace AppBundle\EventSubscriber;

use AppBundle\Service\TextBlockService;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;

class TextBlockUsageDoctrineSubscriber implements EventSubscriber
{
    /**
     * @var TextBlockService
     */
    private $textBlockService;
    /**
     * @var null
     */
    private $options;

    /**
     * RequestListener constructor.
     * @param TextBlockService $textBlockService
     * @param array $options
     */
    public function __construct(
        TextBlockService $textBlockService,
        $options
    ) {
        $this->textBlockService = $textBlockService;
        $this->options = [
            'interfaces' => isset($options['interfaces']) ? $options['interfaces'] : [],
            'exclude' => isset($options['exclude']) ? $options['exclude'] : [],
        ];
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postUpdate,
            Events::postPersist,
            Events::onFlush,
        ];
    }

    public function postUpdate(LifecycleEventArgs $event)
    {
        $this->updateTextBlockUsageInfo($event);
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $this->updateTextBlockUsageInfo($event);
    }

    public function onFlush(OnFlushEventArgs $event)
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            if (!$this->isObservable($entity)) {
                continue;
            }
            $this->textBlockService->removeUsageInfo($entity);
        }
    }

    protected function updateTextBlockUsageInfo(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();
        if (!$this->isObservable($entity)) {
            return;
        }

        $changeSet = $event->getEntityManager()->getUnitOfWork()->getEntityChangeSet($entity);
        $this->textBlockService->updateTextBlockUsageInfo($entity, $changeSet);
    }

    protected function isObservable($object)
    {
        if ($this->options['exclude'] && in_array(get_class($object), $this->options['exclude'], true)) {
            return false;
        }

        if ($this->options['interfaces']) {
            $interfaces = class_implements($object);

            return !empty(array_intersect($this->options['interfaces'], $interfaces));
        }

        return false;
    }
}
