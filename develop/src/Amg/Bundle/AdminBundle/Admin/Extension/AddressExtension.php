<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class AddressExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('administrativeUnit')
            && !$form->has('administrativeAreas')
            && !$form->has('cityDistricts')
        ) {
            $form->add('administrativeUnit', 'sonata_type_model', [
                'required' => false,
                'property' => 'displayTitle',
            ]);
        }


        if (!$form->has('address')) {
            $form->add('address', 'address', ['required' => false, 'label' => false]);
        }
    }
}
