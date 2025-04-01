<?php
namespace AppBundle\Block;

use AppBundle\Helper\UrlHelper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;

class HotNewsBannerBlock extends AbstractBlockService
{
    public function getDefaultSettings()
    {
        return [
            'template' => '::/widgets/hot_news_banner.html.twig',
            'publishable' => false,
            'header' => '',
            'title' => '',
            'url' => '',
            'target_blank' => false,
            'extra_class' => '',
        ];
    }

    public function getFormSettingsKeys(FormMapper $form)
    {
        return [
            ['publishable', 'checkbox', ['required' => false, 'label' => 'Опубликовано']],
            ['header', 'text', ['required' => true, 'label' => 'Заголовок блока']],
            ['title', 'text', ['required' => true, 'label' => 'Заголовок']],
            ['url', 'text', ['required' => true, 'label' => 'Ссылка']],
            ['target_blank', 'checkbox', ['required' => false, 'label' => 'Открывать в новом окне']],
//	        ['extra_class', 'choice', ['choices' => ['' => 'Нет', 'tallHotNewsBanner' => 'Увеличенный по высоте'], 'required' => false, 'label' => 'Дополнительные настройки баннера']],
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