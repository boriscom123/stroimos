<?php
namespace AppBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\UserBundle\Entity\BaseUser;

class ExtraInformationExtension extends AdminExtension
{
    /**
     * @inheritdoc
     */
    public function configureFormFields(FormMapper $form)
    {
        /** @var Admin $admin */
        $admin = $form->getAdmin();
        /** @var BaseUser $user */
        $user = $admin->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if($user->hasRole('ROLE_ADMIN_EXTRA_INFORMATION') && $user->hasRole('ROLE_SUPER_ADMIN')) {
            if (!$form->has('extraInformation')) {
                $form->add('extraInformation', 'sonata_type_admin', [
                    'delete' => false,
                    'required' => false,
                    'btn_add' => false,
                    'btn_list' => false,
                    'btn_delete' => false,
                    'btn_catalogue' => false
                ]);
            }
        }
    }
}
