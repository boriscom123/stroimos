<?php

namespace ApiBundle\InfrastructureLayer\DataMapper\Report;

use Gedmo\Loggable\Entity\LogEntry;

class LogEntryDataMapper
{
    /**
     * @param LogEntry $rawData
     * @return array
     */
    public function __invoke($rawData)
    {
        $data = $rawData->getData();

        return [
            'id' => $rawData->getObjectId(),
            'loggedAt' => $rawData->getLoggedAt()->format('d.m.Y H:i'),
            'title' => $data['title'],
            'author' => $rawData->getUsername(),
        ];
    }
}
