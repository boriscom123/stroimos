<?php
namespace AppBundle\Block;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractBlockService extends BaseBlockService
{
    /**
     * @var Admin|null
     */
    protected $admin;

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults($this->getDefaultSettings());
    }

    abstract public function getDefaultSettings();

    /**
     * @param FormMapper $form
     * @param BlockInterface $block
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block)
    {
        $formSettingKeys = $this->getFormSettingsKeys($form);

        if (empty($formSettingKeys)) {
            return;
        }

        if (isset($this->requiredTemplate) && true === $this->requiredTemplate) {
            $formSettingKeys = array_merge($this->getTemplateFormSettingKey(), $formSettingKeys);
        }

        $form
            ->with('Данные')
                ->add('settings', 'sonata_type_immutable_array', array(
                    'label' => false,
                    'keys' => $formSettingKeys,
                ))
            ->end()
        ;
    }

    public function getFormSettingsKeys(FormMapper $form)
    {
        return [];
    }

    protected function getTemplateFormSettingKey()
    {
        return [
            ['template', 'text', ['required' => false, 'label' => 'Шаблон']],
        ];
    }

    public function setAdmin(Admin $admin)
    {
        $this->admin = $admin;
    }
}
