<?php

namespace AppBundle\Block;

use AppBundle\Entity\AdministrativeArea;
use AppBundle\Entity\CityDistrict;
use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;


class EmailSubscriptionFormBlock extends AbstractBlockService
{
    use CacheTrait;

    const SETTINGS_SUBORDINATE = 'subordinate';

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    public function getDefaultSettings()
    {
        return [
            'template' => '::widgets/subscribe_popup.html.twig',
        ];
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $adminAreas = $this->em->getRepository(AdministrativeArea::class)->findBy(['publishable' => true]);
        $CityDistricts = $this->em->getRepository(CityDistrict::class)->findBy(['publishable' => true]);

        $options = [];
        foreach ($adminAreas as $adminArea) {
            $options[] = [
                'value' => $adminArea->getId(),
                'text' => $adminArea->getAbbreviation(),
                'isArea' => true,
            ];
            foreach ($adminArea->getDistricts() as $district) {
                if (!$district->isPublishable()) continue;
                $options[] = [
                    'value' => $district->getId(),
                    'text' => $district->getTitle(),
                ];
            }
        }
        return $this
            ->renderResponse(
                $blockContext->getTemplate(),
                [
                    'adminAreas' => $adminAreas,
                    'adminAreaOptions' => $options,
                ],
                $response
            )
            ->setTtl(0);
    }
}
