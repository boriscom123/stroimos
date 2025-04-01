<?php
namespace AppBundle\Block;

use AppBundle\Helper\UrlHelper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Response;

class RoadConstructionMapBannerBlock extends AbstractBlockService
{
    use ContainerAwareTrait;

    public function getDefaultSettings()
    {
        return [
            'template' => ':Road:block/road_construction_map_banner.html.twig',
            'title' => 'Карта строительства и реконструкции 114 дорожно-транспортных объектов',
            'file' => null,
        ];
    }

    public function getFormSettingsKeys(FormMapper $form)
    {
        $mediaAdmin = $this->container->get('sonata.media.admin.media');

        $fieldDescription = $mediaAdmin->getModelManager()->getNewFieldDescriptionInstance($mediaAdmin->getClass(), 'media');
        $fieldDescription->setAssociationAdmin($mediaAdmin);
        $fieldDescription->setAdmin($this->admin);
        $fieldDescription->setOption('edit', 'list');
        $fieldDescription->setAssociationMapping(array(
            'fieldName' => 'media',
            'type'      => \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_ONE,
        ));
        $fieldDescription->setOption('link_parameters', [
            'context' => 'file',
            'lock_context' => ['file']
        ]);
        $file = $form->create('file', 'sonata_type_model_list', array(
            'sonata_field_description' => $fieldDescription,
            'model_manager' => $mediaAdmin->getModelManager(),
            'class' => $mediaAdmin->getClass(),
            'label' => 'Файл',
        ));

        return [
            ['title', 'text', ['required' => true, 'label' => 'Заголовок']],
            [$file, null, []],
        ];
    }


    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->renderResponse($blockContext->getTemplate(), $blockContext->getSettings());
    }
}