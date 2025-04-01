<?php
namespace AppBundle\Block;

use AppBundle\Helper\UrlHelper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;

class ServiceBannerBlock extends AbstractBlockService
{
    public function getDefaultSettings()
    {
        return [
            'template' => 'null',
            'title' => '',
            'url' => '',
            'target_blank' => false,
            'icon' => '',
        ];
    }

    public function getFormSettingsKeys(FormMapper $form)
    {
        return [
            ['title', 'text', ['required' => true, 'label' => 'Заголовок']],
            ['url', 'text', ['required' => true, 'label' => 'Ссылка']],
            ['target_blank', 'checkbox', ['required' => false, 'label' => 'Открывать в новом окне']],
            ['icon', 'choice', [
                'required' => true,
                'label' => 'Изображение',
                'choices' => [
                    'Снос' => 'destruction',
                    'Строительство' => 'building',
                    'Дороги' => 'road',
                    'Отходы' => 'oss',
                ],
                'choices_as_values' => true
            ]]
        ];
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $blockContext->setSetting(
            'url',
            UrlHelper::fixUserEditableLink($blockContext->getSetting('url'))
        );
        return $this->renderResponse($blockContext->getTemplate(), $blockContext->getSettings());
    }
}