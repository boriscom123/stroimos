<?php
namespace AppBundle\Admin;

use AppBundle\Entity\SpotlightItem;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

class SpotlightItemAdmin extends Admin
{
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'position',
    ];

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('type', null, ['code' => 'getTypeLabel'])
            ->add('position', null, ['editable' => true, 'label' => 'Сортировка'])
            ->add('uri', 'url', ['template' => ':SpotlightItemAdmin:title.html.twig'])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'move' => ['template' => ':SpotlightItemAdmin:_move.html.twig'],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('type', 'sonata_type_choice_field_mask', [
            'attr' => ['class' => "type-choice"],
            'choices' => SpotlightItem::$linkTypeTitles,
            'map' => array_map(function ($v) { return (array)$v; }, SpotlightItem::$linkTypeFields),
            'required' => true,
        ]);

        $form->add('uri', null);
        $form->add('title', null);
        $form->add('publicationType');
        $form->add('date', 'sonata_type_datetime_picker', array(
            'required' => false,
            'dp_pick_time' => true,
            'dp_language' => 'ru',
            'dp_use_seconds' => false,
            'format' => 'dd/MM/yyyy HH:mm'
        ));
        $form->add('openInNewTab', null);
        $form->add('backgroundImage');

        $options = ['btn_add' => false, 'btn_delete' => false, 'required' => false];
        $form->add('post', 'sonata_type_model_list', $options);
        $form->add('page', 'sonata_type_model_list', $options);
        $form->add('gallery', 'sonata_type_model_list', $options);
        $form->add('video', 'sonata_type_model_list', $options);
        $form->add('infographics', 'sonata_type_model_list', $options);
        $form->add('construction', 'sonata_type_model_list', $options);
        $form->add('metro', 'sonata_type_model_list', $options);
        $form->add('road', 'sonata_type_model_list', $options);

        $form->add(
            'image',
            'sonata_type_model_list',
            ['required' => false],
            [
                'link_parameters' => [
                    'context' => 'main_image',
                    'editable_formats' => ['thumb300', 'thumb300x420'],
                    'editable_formats_field' => 'image',
                    'image_admin_extra_key' => 'thumb300',
                    'lock_context' => ['main_image', 'gallery_media'],
                ],
            ]
        );
        for ($i = 1; $i < 6; $i++) {
            $form->add(
                "carouselImage{$i}",
                'sonata_type_model_list',
                ['required' => false],
                [
                    'link_parameters' => [
                        'context' => 'main_image',
                        'editable_formats' => ['thumb300', 'thumb300x420'],
                        'editable_formats_field' => "carouselImage{$i}",
                        'image_admin_extra_key' => 'thumb300',
                        'lock_context' => ['main_image', 'gallery_media'],
                    ],
                ]
            );
        }
    }

    public function prePersist($object)
    {
        $this->reorder($object, 'up');
        $this->cleanup($object);
    }

    public function preUpdate($object)
    {
        $this->cleanup($object);
    }
    public function preRemove($object)
    {
        $this->reorder($object, 'down');
    }

    private function cleanup(SpotlightItem $object)
    {
        if ($object->getType() === SpotlightItem::LINK_TYPE_URI) {
            $entityFields = SpotlightItem::$linkTypeTitles;
            unset($entityFields[SpotlightItem::LINK_TYPE_URI]);
            foreach ($entityFields as $field => $label) {
                $setter = 'set' . ucfirst($field);
                $object->$setter(null);
            }
        } else {
            $object->setUri(null);
            $object->setTitle(null);
            $object->setOpenInNewTab(null);
        }

        if ($object->getPosition() < 1 || $object->getPosition() > 19) {
            $this->reorder($object, 'top');
        }

    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'edit', 'list', 'delete']);
        $collection->add('move', $this->getRouterIdParameter() . '/move/{direction}');
    }

    private function reorder($object, $direction)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $repository = $modelManager->getEntityManager($this->getClass())->getRepository(SpotlightItem::class);
        $repository->move($object, $direction, true);
    }
}
