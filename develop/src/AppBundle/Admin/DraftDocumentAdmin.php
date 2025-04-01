<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DraftDocumentAdmin extends DocumentBaseAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id');
        $list->addIdentifier('title');
        $list->addIdentifier('createdAt');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('Основное')
                ->with('Контент')
                    ->add('files', 'sonata_type_collection', array(
                        'cascade_validation' => false,
                        'type_options' => array('delete' => true),
                        'required' => false,
                        'label' => 'Файлы'
                    ), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ))
                    ->add('externalUrl', 'url', array(
                        'required' => false,
                        'label' => 'Внешняя ссылка'
                    ))
                ->end()
                ->with('Параметры')
                    ->add('archive', 'choice', array(
                        'required' => true,
                        'label' => 'Статус',
                        'choices' => array(
                            '0' => 'Актуальный',
                            '1' => 'В архиве',
                        ),
                    ))
                    ->add('dateOfAdding', 'sonata_type_date_picker', array(
                        'label' => 'Дата размещения',
                        'required' => true,
                        'dp_language' => 'ru',
                        'format' => 'dd/MM/yyyy'
                    ))
                    ->add('expirationDate', 'sonata_type_date_picker', array(
                        'label' => 'Дата окончания срока проведения независимой антикоррупционной экспертизы',
                        'required' => true,
                        'dp_language' => 'ru',
                        'format' => 'dd/MM/yyyy'
                    ))
                    ->add('dateOfReceipt', 'sonata_type_date_picker', array(
                        'label' => 'Дата поступления текста заключения независимой антикоррупционной экспертизы',
                        'required' => true,
                        'dp_language' => 'ru',
                        'format' => 'dd/MM/yyyy'
                    ))
                ->end()
            ->end()
        ;
    }
}
