<?php
namespace AppBundle\Admin\Extension;

use AppBundle\Admin\BaseAdmin;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class OwnerExtension extends AdminExtension
{
    /**
     * @inheritdoc
     */
    public function configureFormFields(FormMapper $form)
    {
        $admin = $form->getAdmin();
        $disabled = false;
        if($admin instanceof BaseAdmin) {
            $disabled = $admin->getUserOwner() === null ? false : true;
        }
        if (!$form->has('owner')) {
            $form->add('owner', null, [
                'required' => true,
                'multiple' => false,
                'choice_translation_domain' => true,
                'disabled' => $disabled
            ]);
        }
    }
}
