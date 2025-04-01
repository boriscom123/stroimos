<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\Construction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ConstructionDataGeoPointType extends AbstractType
{
    public function getName()
    {
        return 'construction_data_geo_point';
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('data_property_name', $options)) {
            $fieldName = $options['data_property_name'];

            /** @var Construction $construction */
            $construction = $form->getParent()->getData();

            if (null !== $construction) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $currentPropertyData = $accessor->getValue($construction, "data.$fieldName");
                $pendingPropertyData = $accessor->getValue($construction, "pendingData.$fieldName");
            } else {
                $currentPropertyData = $pendingPropertyData = null;
            }

            $view->vars['is_new_data_pending'] = $construction->isNewDataPending();
            $view->vars['property_name'] = $fieldName;
            $view->vars['property_data'] = [
                'current' => $currentPropertyData,
                'pending' => $pendingPropertyData,
            ];
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /** @var OptionsResolver $resolver */
        $resolver->setDefined([
            'data_property_name',
        ]);

        $resolver->setDefaults([
            'map_width' => 320,
            'map_height' => 240,
        ]);
    }

    public function getParent()
    {
        return 'geopoint';
    }
}
