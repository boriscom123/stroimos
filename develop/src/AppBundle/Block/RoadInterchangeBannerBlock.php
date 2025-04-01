<?php
namespace AppBundle\Block;

use AppBundle\Helper\UrlHelper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Response;

class RoadInterchangeBannerBlock extends AbstractBlockService
{
    public function getDefaultSettings()
    {
        return [
            'template' => ':Road:block/road_interchange_banner.html.twig',
            'title' => 'Реконструкция развязок МКАД',
            'link' => '#',
        ];
    }

    public function getFormSettingsKeys(FormMapper $form)
    {
        return [
            ['title', 'text', ['required' => true, 'label' => 'Заголовок']],
            ['link', 'text', ['required' => true, 'label' => 'Ссылка']],
        ];
    }


    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $blockContext->setSetting(
            'link',
            UrlHelper::fixUserEditableLink($blockContext->getSetting('link'))
        );
        return $this->renderResponse($blockContext->getTemplate(), $blockContext->getSettings());
    }
}