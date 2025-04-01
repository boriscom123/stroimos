<?php
namespace AppBundle\Block;

use AppBundle\Helper\UrlHelper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Response;

class DestructionBannerBlock extends AbstractBlockService
{
    public function getDefaultSettings()
    {
        return [
            'template' => ':Destruction:block/destruction_banner.html.twig',
            'title' => 'Снос пятиэтажек в Москве',
            'link' => '#',
        ];
    }

    public function getFormSettingsKeys(FormMapper $form)
    {
        return [
            ['title', 'text', ['required' => false, 'label' => 'Заголовок']],
            ['link', 'text', ['required' => false, 'label' => 'Ссылка']],
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