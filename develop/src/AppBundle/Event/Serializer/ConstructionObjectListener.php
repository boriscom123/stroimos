<?php
namespace AppBundle\Event\Serializer;

use AppBundle\Entity\Construction;
use AppBundle\Routing\EntityUrlGenerator;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ConstructionObjectListener implements EventSubscriberInterface
{
    /**
     * @var \AppBundle\Routing\EntityUrlGenerator
     */
    private $entityUrlGenerator;

    public function __construct(EntityUrlGenerator $entityUrlGenerator)
    {
        $this->entityUrlGenerator = $entityUrlGenerator;
    }

    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => Events::POST_SERIALIZE,
                'method' => 'onPostSerialize',
            ],
        ];
    }

    public function onPostSerialize(ObjectEvent $event)
    {
        /** @var Construction $construction */
        $construction = $event->getObject();

        $event->getVisitor()->addData('url', $this->entityUrlGenerator->generate($construction, [], UrlGeneratorInterface::ABSOLUTE_URL));
    }
}
