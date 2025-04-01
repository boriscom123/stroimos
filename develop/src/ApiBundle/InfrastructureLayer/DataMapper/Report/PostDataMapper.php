<?php

namespace ApiBundle\InfrastructureLayer\DataMapper\Report;

use AppBundle\Entity\Post;
use Symfony\Component\HttpFoundation\RequestStack;

class PostDataMapper
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

    public function __invoke($rawData)
    {
        $request = $this->requestStack->getCurrentRequest();
        $httpHost = $request->getHttpHost();
        $linkToEdit = $this->adminLocator->getAdminForObject($rawData)->generateObjectUrl('edit', $rawData);

        return [
            'id' => $rawData->getId(),
            'name' => $rawData->getTitle(),
            'author' => $rawData->getAuthorName(),
            'created' => $rawData->getCreatedAt()->format('d.m.Y H:i'),
            'priority' => (\method_exists($rawData, 'getPriorityPosition'))
                ? $rawData->getPriorityPosition()
                : null,
            'editUrl' => [
                'text' => "https://$httpHost$linkToEdit",
                'tooltip' => 'Link to edit',
                'hyperlink' => "https://$httpHost$linkToEdit",
            ],
        ];
    }
}
