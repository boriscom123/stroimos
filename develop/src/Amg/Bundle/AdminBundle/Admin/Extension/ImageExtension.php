<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class ImageExtension extends AdminExtension
{
    const IMAGE_ADMIN_EXTRA_KEY = 'image_admin_extra_key';

    /**
     * @var array
     */
    private $imageFields;

    protected $defaultOptions = [
        'context' => 'main_image',
        'lock_context' => true,
        'required' => false,
        'btn_delete' => true,
        'editable_formats' => null,
        self::IMAGE_ADMIN_EXTRA_KEY => null
    ];

    protected $linkParameters = ['context', 'lock_context', 'editable_formats', self::IMAGE_ADMIN_EXTRA_KEY];

    public function __construct(array $imageFields)
    {
        $this->imageFields = $imageFields;
    }

    public function configureFormFields(FormMapper $form)
    {
        $imageFields = isset($this->imageFields[$form->getAdmin()->getClass()])
            ? $this->imageFields[$form->getAdmin()->getClass()]
            : $this->imageFields['default'];

        foreach ($imageFields as $imageField => $options) {
            if (!$form->has($imageField)) {
                $this->addImageField($form, $imageField, $options);
            }
        }
    }

    protected function addImageField(FormMapper $form, $imageField, $options)
    {
        if (is_string($options)) {
            $options = [
                'context' => $options
            ];
        } elseif(!is_array($options)) {
            $options = [];
        }

        $options = array_merge($this->defaultOptions, $options);
        if ($options['btn_delete'] === true) {
            unset($options['btn_delete']);
        }

        $linkParameters = [];
        foreach ($this->linkParameters as $linkParameter) {
            $linkParameters[$linkParameter] = $options[$linkParameter];
            unset($options[$linkParameter]);
        }

        if (!empty($linkParameters['lock_context'])) {
            if (true === $linkParameters['lock_context']) {
                $linkParameters['lock_context'] = $linkParameters['context'];
            }

            if (!is_array($linkParameters['lock_context'])) {
                $linkParameters['lock_context'] = [$linkParameters['lock_context']];
            }
        }

        if (is_array($linkParameters['editable_formats'])) {
            $linkParameters['editable_formats_field'] = $imageField;
        }

        $form->add($imageField, 'sonata_type_model_list', $options, array(
            'link_parameters' => $linkParameters
        ));
    }
}
