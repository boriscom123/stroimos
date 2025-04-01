<?php

namespace ApiBundle\InfrastructureLayer\DataMapper\Report;

use AppBundle\Entity\Newsletter;
use Symfony\Component\HttpFoundation\RequestStack;

class NewsletterDataMapper
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
     * @param Newsletter $rawData
     * @return array
     */
    public function __invoke($rawData)
    {
        $request = $this->requestStack->getCurrentRequest();
        $httpHost = $request->getHttpHost();

        $linkToPreview = $this->adminLocator->getAdminForObject($rawData)->generateObjectUrl(
            'preview_with_general_posts',
            $rawData
        );

        return [
            'id' => $rawData->getId(),
            'status' => $rawData->getStatusLabel(),
            'createdAt' => $rawData->getCreatedAt()->format('d.m.Y H:i'),
            'previewUrl' => [
                'text' => "https://$httpHost$linkToPreview",
                'tooltip' => 'Link to preview',
                'hyperlink' => "https://$httpHost$linkToPreview",
            ],
        ];
    }
}
