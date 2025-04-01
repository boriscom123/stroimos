<?php

namespace AppBundle\Twig;

use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Exception\NoValueException;
use Sonata\AdminBundle\Twig\Extension\SonataAdminExtension;

class DiffTwigExtension extends SonataAdminExtension
{
    private $allowedFields = array('title', 'teaser', 'lead', 'content');

    public function getFilters()
    {
        return array(
            'diff_compare' => new \Twig_Filter_Method($this, 'diff', array('is_safe' => array('html'))),
        );
    }

    public function diff(FieldDescriptionInterface $fieldDescription, $baseObject, $compareObject)
    {
        try {
            $baseValue = $fieldDescription->getValue($baseObject);
        } catch (NoValueException $e) {
            $baseValue = null;
        }

        try {
            $compareValue = $fieldDescription->getValue($compareObject);
        } catch (NoValueException $e) {
            $compareValue = null;
        }

        if (in_array($fieldDescription->getFieldName(), $this->allowedFields )) {

            $diff = new \Diff(array(strip_tags($compareValue)), array(strip_tags($baseValue)));

            $renderer = new \Diff_Renderer_Html_Array();

            $compareResult = $diff->render($renderer);

            if (isset($compareResult[0][0]['base']['lines']) && !empty($compareResult[0][0]['base']['lines'][0])) {
                $compareValue = nl2br(implode(' ', $compareResult[0][0]['base']['lines']));
            }
            if (isset($compareResult[0][0]['changed']['lines']) && !empty($compareResult[0][0]['changed']['lines'][0])) {
                $baseValue = nl2br(implode(' ', $compareResult[0][0]['changed']['lines']));
            }

            $template = $this->environment->loadTemplate('::SonataAdmin/base_show_field.html.twig');

        } else {
            $template = $this->getTemplate($fieldDescription, '::SonataAdmin/base_show_field.html.twig');
        }

        $baseValueOutput = $template->render(array(
            'admin'             => $fieldDescription->getAdmin(),
            'field_description' => $fieldDescription,
            'value'             => $baseValue
        ));

        $compareValueOutput = $template->render(array(
            'field_description' => $fieldDescription,
            'admin'             => $fieldDescription->getAdmin(),
            'value'             => $compareValue
        ));

        $isDiff = $baseValueOutput !== $compareValueOutput;

        return $this->output($fieldDescription, $template, array(
            'field_description' => $fieldDescription,
            'value'             => $baseValue,
            'value_compare'     => $compareValue,
            'is_diff'           => $isDiff,
            'admin'             => $fieldDescription->getAdmin()
        ));
    }

    public function getName()
    {
        return 'diff';
    }
}