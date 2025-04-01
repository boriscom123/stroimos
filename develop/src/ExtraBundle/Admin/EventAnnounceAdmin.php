<?php
namespace ExtraBundle\Admin;

use ExtraBundle\Entity\EventAnnounce;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class EventAnnounceAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('Основное')
                ->with('Анонс')
                    ->add('homepage', null, ['label' => 'Отображать анонс на главной странице', 'required' => false])
                    ->add('event', 'sonata_type_model')
                ->end()
            ->end();
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('homepage')
            ->add('event.title')
            ->add('event.date')
        ;

        $list->add('_action', 'actions', ['label' => 'Действия', 'actions' => [
            'send' => ['template' => 'ExtraBundle:Admin:event_announce_list__action_send.html.twig'],
        ]]);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        $this->preUpdateClearHomepage($object);
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $this->preUpdateClearHomepage($object);
    }

    /**
     * @param EventAnnounce $object
     */
    public function preUpdateClearHomepage($object)
    {
        if ($object->getHomepage()) {
            $this->getModelManager()->getEntityManager('ExtraBundle\Entity\EventAnnounce')
                ->createQueryBuilder()
                ->update('ExtraBundle\Entity\EventAnnounce', 'ea')
                ->set('ea.homepage', ':false')
                ->setParameter('false', false)
                ->getQuery()
                ->execute()
            ;
        }
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('send', $this->getRouterIdParameter() . '/send');
    }
}
