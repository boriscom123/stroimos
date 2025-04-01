<?php
namespace ExtraBundle\Admin;

use Doctrine\ORM\QueryBuilder;
use ExtraBundle\Entity\Event;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class EventAdmin extends Admin
{
    protected $formOptions = array(
        'cascade_validation' => true
    );

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('date')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('Основное')
                ->with('Конференция')
                    ->add('state', 'choice', ['required' => true, 'label' => 'Состояние', 'choices' => Event::$states])
                    ->add('date', 'sonata_type_datetime_picker', array(
                        'label' => 'Дата проведения',
                        'required' => true,
                        'dp_pick_time' => true,
                        'dp_language' => 'ru',
                        'dp_use_seconds' => false,
                        'format' => 'dd/MM/yyyy HH:mm'
                    ))
                    ->add('open', null, ['required' => false, 'label' => 'Открыто для аккредитации'])
                    ->add('guests', 'sonata_type_model_autocomplete', array(
                        'label' => 'Аккредитованные участники',
                        'property' => 'title',
                        'multiple' => true,
                        'attr' => array('style' => 'width: 100%'),
                        'required' => false,
                        'callback' => function (Admin $admin, $property, $value) {
                            $datagrid = $admin->getDatagrid();

                            /** @var QueryBuilder $queryBuilder */
                            $queryBuilder = $datagrid->getQuery();

                            $rootAliases = $queryBuilder->getRootAliases();
                            $queryBuilder
                                ->join($rootAliases[0] . '.groups', 'g')
                                ->andWhere('g.name IN (:names)')
                                ->setParameter('names', ['Пул журналистов', 'VIP-пул журналистов']);

                            $datagrid->setValue($property, null, $value);
                        }
                    ))
                    ->add('videoPlayerCode', 'textarea', ['required' => false])
                    ->add('attachments', 'sonata_type_collection', [
                        'label' => 'Материалы',
                        'required' => false,
                        'by_reference' => false,
                    ], [
                        'asd' => 'inline',
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ])
                    ->add('vipAttachments', 'sonata_type_collection', [
                        'label' => 'Эксклюзивные материалы',
                        'required' => false,
                        'by_reference' => false,
                    ], [
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ])
                ->end()
            ->end();

    }

    /**
     * @param Event $object
     * @return mixed|void
     */
    public function preUpdate($object)
    {
        if (!$object->isPublishable()) {
            $this->getModelManager()->getEntityManager('ExtraBundle\Entity\EventAnnounce')
                ->createQueryBuilder()
                ->update('ExtraBundle\Entity\EventAnnounce', 'ea')
                ->set('ea.homepage', ':false')
                ->where('ea.event = :event')
                ->setParameter('false', false)
                ->setParameter('event', $object)
                ->getQuery()
                ->execute()
            ;
        }
    }

    protected function configureTabMenu(ItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if ($childAdmin || !in_array($action, array('edit'))) {
            return;
        }

        /** @var $admin Admin */
        $admin = $this->isChild() ? $this->getParent() : $this;

        $menu->addChild('Сообщения', [
            'uri' => $admin->generateUrl('admin.event.feedback.list', ['id' => $admin->getRequest()->get('id')])
        ]);
    }
}
