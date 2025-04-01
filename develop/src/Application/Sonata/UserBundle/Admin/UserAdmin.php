<?php
namespace Application\Sonata\UserBundle\Admin;

use AppBundle\Entity\Owner;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;

class UserAdmin extends BaseUserAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        // define group zoning
        $formMapper
            ->tab('User')
                ->with('Profile', array('class' => 'col-md-6'))->end()
                ->with('General', array('class' => 'col-md-6'))->end()
            ->end()
            ->tab('Security')
                ->with('Status', array('class' => 'col-md-4'))->end()
                ->with('Groups', array('class' => 'col-md-4'))->end()
//                ->with('Keys', array('class' => 'col-md-4'))->end()
                ->with('Roles', array('class' => 'col-md-12'))->end()
            ->end()
        ;

        $now = new \DateTime();

        $formMapper
            ->tab('User')
                ->with('General')
                    ->add('username')
                    ->add('email')
                    ->add('plainPassword', 'text', array(
                        'required' => (!$this->getSubject() || is_null($this->getSubject()->getId()))
                    ))
                    ->add('owner', 'entity', [
                        'required' => false,
                        'multiple' => false,
                        'choice_translation_domain' => true,
                        'label' => 'Сотрудник организации',
                        'class' => 'AppBundle:Owner',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('o')
                                ->where('o.name <> :excluded')
                                ->setParameter('excluded', Owner::OWNER_STROI_MOS);
                        },
                    ])
                ->end()
                ->with('Profile')
                    ->add('dateOfBirth', 'sonata_type_date_picker', array(
                        'years' => range(1900, $now->format('Y')),
                        'dp_min_date' => '1-1-1900',
                        'dp_max_date' => $now->format('d-m-Y'),
                        'dp_language' => 'ru',
                        'required' => false,
                        'format' => 'dd-MM-yyyy'
                    ))
                    ->add('firstname', null, array('required' => false))
                    ->add('lastname', null, array('required' => false))
                    ->add('phone', null, array('required' => false))
                    ->add('post', null, array('required' => false))
                    ->add('receivesNewCommentNotifications', null, array('required' => false))
                    ->add('receivesConstructionNotifications', null, array('required' => false))
                    ->add('receivesErrorReportNotifications', null, array('required' => false))
                ->end()
                ->with('Social')
                    ->add('vkontakteUid', null, array('required' => false))
                    ->add('gplusUid', null, array('required' => false))
                    ->add('facebookUid', null, array('required' => false))
                    ->add('loginMosUid', null, array('required' => false))
                ->end()
            ->end()
        ;

        if ($this->getSubject() && !$this->getSubject()->hasRole('ROLE_SUPER_ADMIN')) {
            $formMapper
                ->tab('Security')
                ->with('Status')
                ->add('locked', null, array('required' => false))
                ->add('expired', null, array('required' => false))
                ->add('enabled', null, array('required' => false))
                ->add('credentialsExpired', null, array('required' => false))
                ->end()
                ->with('Groups')
                ->add('groups', 'sonata_type_model', array(
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true
                ))
                ->end()
                ->with('Roles')
                ->add('realRoles', 'sonata_security_roles', array(
                    'label'    => 'form.label_roles',
                    'expanded' => true,
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'treeview',
                    ],
                ))
                ->end()
                ->end()
            ;
        }

/*        $formMapper
            ->tab('Security')
            ->with('Keys')
            ->add('token', null, array('required' => false))
            ->add('twoStepVerificationCode', null, array('required' => false))
            ->end()
            ->end()
        ;*/
    }

    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('id')
            ->add('username')
            ->add('firstname')
            ->add('lastname')
            ->add('locked')
            ->add('email')
            ->add('groups')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper
            ->add('lastLogin')
            /*->addIdentifier('activity', 'string', array(
                'template' => ':Admin:User/activity_list_field.html.twig',
                'route' => ['name' => 'activity']
            ))*/
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('activity', $this->getRouterIdParameter() . '/activity');
    }

    public function getTemplate($name)
    {
        if ('activity' === $name) {
            return ':Admin:User/activity.html.twig';
        }

        return parent::getTemplate($name);
    }
}
