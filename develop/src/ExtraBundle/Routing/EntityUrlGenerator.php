<?php
namespace ExtraBundle\Routing;

use AppBundle\Routing\EntityUrlGenerator as BaseEntityUrlGenerator;
use ExtraBundle\Entity\Event;
use ExtraBundle\Entity\Initiative;

class EntityUrlGenerator extends BaseEntityUrlGenerator
{
    public function getRouteParametersForInitiative(Initiative $initiative)
    {
        return ['app_initiative_show', ['id' => $initiative->getId()]];
    }

    public function getRouteParametersForEvent(Event $event)
    {
        return ['app_event_show', ['id' => $event->getId()]];
    }
}
