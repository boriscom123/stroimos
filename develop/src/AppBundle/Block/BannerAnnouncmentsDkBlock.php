<?php

namespace AppBundle\Block;

use AppBundle\Helper\UrlHelper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\MediaBundle\Controller\MediaAdminController;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Response;

class BannerAnnouncmentsDkBlock extends AbstractBlockService
{
    use ContainerAwareTrait;

    public function getDefaultSettings()
    {
        return [
            'template' => '::/widgets/hot_news_banner.html.twig',
            'publishable' => false,
            'header' => '',
            'title' => '',
            'url' => '',
            'target_blank' => false,
        ];
    }

    public function getFormSettingsKeys(FormMapper $form)
    {
        $image = $this->buildBannerBackgroundField($form);

        return [
            ['publishable', 'checkbox', ['required' => false, 'label' => 'Опубликовано']],
            ['header', 'text', ['required' => true, 'label' => 'Заголовок блока']],
            ['title', 'text', ['required' => true, 'label' => 'Заголовок']],
            ['url', 'text', ['required' => true, 'label' => 'Ссылка']],
            ['target_blank', 'checkbox', ['required' => false, 'label' => 'Открывать в новом окне']],
            [$image, null, []],
        ];

    }

    public function setMediaAdmin(MediaAdminController $mediaAdmin)
    {
        $this->mediaAdmin = $mediaAdmin;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $blockContext->setSetting(
            'url',
            UrlHelper::fixUserEditableLink($blockContext->getSetting('url'))
        );

        return $this->renderResponse($blockContext->getTemplate(), $blockContext->getSettings());
    }

    protected function buildBannerBackgroundField(FormMapper $form)
    {
        $mediaAdmin = $this->container->get('sonata.media.admin.media');

        $fieldDescription = $mediaAdmin->getModelManager()->getNewFieldDescriptionInstance(
            $mediaAdmin->getClass(),
            'banner'
        );
        $fieldDescription->setAssociationAdmin($mediaAdmin);
        $fieldDescription->setAdmin($this->admin);
        $fieldDescription->setAssociationMapping(
            array(
                'fieldName' => 'image',
                'type' => \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_ONE,
            )
        );
        $fieldDescription->setOption(
            'link_parameters',
            [
                'context' => 'main_image',
                'editable_formats_field' => 'image',
                'editable_formats' => ['thumb715x250'],
                'lock_context' => ['main_image', 'gallery_media'],
                'image_admin_extra_key' => 'thumb715x250',
            ]
        );
        $field = $form->create(
            'banner_backgroud_image',
            'sonata_type_model_list',
            [
                'sonata_field_description' => $fieldDescription,
                'model_manager' => $mediaAdmin->getModelManager(),
                'class' => $mediaAdmin->getClass(),
                'label' => 'Фоновое изображение',
            ]
        );

        return $field;
    }
}
