<?php

namespace ApiBundle\InfrastructureLayer\DataMapper\Report;

use Application\Sonata\MediaBundle\Admin\MediaAdmin;
use Application\Sonata\MediaBundle\Entity\Media;
use Sonata\FormatterBundle\Admin\CkeditorAdminExtension;
use Symfony\Component\HttpFoundation\RequestStack;

class InfographicDataMapper
{
    /**
     * @var CkeditorAdminExtension
     */
    private $mediaAdmin;
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(MediaAdmin $mediaAdmin, RequestStack $requestStack)
    {
        $this->mediaAdmin = $mediaAdmin;
        $this->requestStack = $requestStack;
    }

    public function __invoke(Media $rawData)
    {
        $request = $this->requestStack->getCurrentRequest();
        $httpHost = $request->getHttpHost();
        $linkToEdit = $this->mediaAdmin->generateUrl('edit', ['id' => $rawData->getId()]);
        return  [
            'id' => $rawData->getId(),
            'name' => $rawData->getName(),
            'author' => $rawData->getAuthorName(),
            'created' => $rawData->getCreatedAt()->format('d.m.Y H:i'),
            'editUrl' => [
                'text' => "https://$httpHost$linkToEdit",
                'tooltip' => 'Link to edit',
                'hyperlink' => "https://$httpHost$linkToEdit",
            ],
        ];
    }
}
