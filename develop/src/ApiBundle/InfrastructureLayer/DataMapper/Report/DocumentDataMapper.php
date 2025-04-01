<?php

namespace ApiBundle\InfrastructureLayer\DataMapper\Report;

use AppBundle\Entity\Block;
use AppBundle\Entity\Document;
use Symfony\Component\HttpFoundation\RequestStack;

class DocumentDataMapper
{
    private $adminLocator;
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct($adminLocator, RequestStack $requestStack)
    {
        $this->adminLocator = $adminLocator;
        $this->requestStack = $requestStack;
    }

    /**
     * @param Document | Block $rawData
     * @return array
     */
    public function __invoke($rawData)
    {
        $request = $this->requestStack->getCurrentRequest();
        $httpHost = $request->getHttpHost();
        $linkToEdit = $this->adminLocator->getAdminForObject($rawData)->generateObjectUrl('edit', $rawData);

        return [
            'id' => $rawData->getId(),
            'name' => $rawData->getTitle(),
            'author' => '',
            'created' => $rawData->getCreatedAt()->format('d.m.Y H:i'),
            'editUrl' => [
                'text' => "https://$httpHost$linkToEdit",
                'tooltip' => 'Link to edit',
                'hyperlink' => "https://$httpHost$linkToEdit",
            ],
        ];
    }
}
