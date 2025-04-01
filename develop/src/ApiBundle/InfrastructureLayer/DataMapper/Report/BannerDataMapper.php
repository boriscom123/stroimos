<?php

namespace ApiBundle\InfrastructureLayer\DataMapper\Report;

use AppBundle\Entity\Block;
use AppBundle\Entity\Document;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

class BannerDataMapper
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->router = $router;
    }

    /**
     * @param Document | Block $rawData
     * @return array
     */
    public function __invoke($rawData)
    {
        $request = $this->requestStack->getCurrentRequest();
        $httpHost = $request->getHttpHost();
        $linkToEdit = $this->router->generate(
            'admin_app_page_block_edit',
            [
                'childId' => $rawData->getId(),
                'id' => $rawData->getPage()->getId()
            ]
        );

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
