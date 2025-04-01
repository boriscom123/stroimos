<?php
namespace AppBundle\Block;

use AppBundle\Helper\UrlHelper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Response;

class MetroConstructedStationsBlock extends AbstractBlockService
{
    use ContainerAwareTrait;

    public function getDefaultSettings()
    {
        return [
            'template' => ':Metro:block/metro_constructed_stations_block.html.twig',
            'construction_complete_title' => 'Построенные станции в 2011-2014 гг.',
            'construction_complete_link' => '#',
            'all_stations_in_construction' => 'Все строящиеся станции до 2020 года на карте города',
            'all_stations_in_construction_file' => null,
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
        $file = $form->create('all_stations_in_construction_file', 'sonata_type_model_list', array(
            'sonata_field_description' => $fieldDescription,
            'model_manager' => $mediaAdmin->getModelManager(),
            'class' => $mediaAdmin->getClass(),
            'label' => 'Файл для ссылки "Все строящиеся станции до ..."',
        ));

        return [
            ['all_stations_in_construction', 'text', ['required' => true, 'label' => 'Надпись для ссылки "Все строящиеся станции до ..."']],
            [$file, null, []],

            ['construction_complete_title', 'text', ['required' => true, 'label' => 'Надпись для ссылки "Построенные станции в ..."']],
            ['construction_complete_link', 'text', ['required' => true, 'label' => 'Ссылка "Построенные станции в ..."']],
        ];
    }


    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $blockContext->setSetting(
            'construction_complete_link',
            UrlHelper::fixUserEditableLink($blockContext->getSetting('construction_complete_link'))
        );
        return $this->renderResponse($blockContext->getTemplate(), $blockContext->getSettings());
    }
}