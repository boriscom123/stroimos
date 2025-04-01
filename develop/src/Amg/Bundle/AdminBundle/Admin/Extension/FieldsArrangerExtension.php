<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class FieldsArrangerExtension extends AdminExtension
{
    use ContainerAwareTrait;

    const DEFAULT_TAB_NAME = 'default';

    private static $defaultOptions = [
        'collapsed' => false,
        'class' => false,
        'description' => false,
        'translation_domain' => null,
        'auto_created' => false,
    ];

    public function configureFormFields(FormMapper $form)
    {
        $this->moveFieldsFromDefaultGroupIntoConfiguredGroups($form);
        $this->mergeOptions($form);
        $this->reorderFields($form);
        $this->reorderGroups($form);
    }

    private function moveFieldsFromDefaultGroupIntoConfiguredGroups(FormMapper $form)
    {
        $admin = $form->getAdmin();
        $formGroups = $admin->getFormGroups();
        $defaultGroupName = $this->getDefaultGroupName($admin);

        $danglingFields = [];
        if (isset($formGroups[$defaultGroupName])) {
            $danglingFields = $formGroups[$defaultGroupName]['fields'];
        }

        if (empty($danglingFields)) {
            return;
        }

        $groupsConfig = $this->container->getParameter('amg_admin.fields_mapping');
        foreach ($danglingFields as $key => $field) {
            foreach ($groupsConfig as $code => $group) {
                if (in_array($field, $group['fields'])) {
                    $this->moveField($form, $field, $code);
                    unset($danglingFields[$key]);
                }
            }
        }

        if (empty($danglingFields)) {
            $this->removeDefaultTabAndGroup($form);
        }
    }

    private function getDefaultGroupName(AdminInterface $admin)
    {
        return $admin->getLabel();
    }

    private function moveField(FormMapper $form, $field, $to, $from = null)
    {
        $admin = $form->getAdmin();
        $from = !isset($from) ? $this->getDefaultGroupName($admin) : $from;

        $formGroups = $admin->getFormGroups();

        if (!isset($formGroups[$to])) {
            $this->createGroup($form, $to);
            $formGroups = $admin->getFormGroups();
        }

        unset($formGroups[$from]['fields'][$field]);
        $formGroups[$to]['fields'][$field] = $field;

        $admin->setFormGroups($formGroups);
    }

    private function createGroup(FormMapper $form, $code)
    {
        $admin = $form->getAdmin();
        $formGroups = $admin->getFormGroups();

        $groupsConfig = $this->container->getParameter('amg_admin.fields_mapping');
        if (!isset($groupsConfig[$code])) {
            throw new \InvalidArgumentException(sprintf('No configuration defined for group ("%s")', $code));
        }

        list($tab, $group) = explode('.', $code);

        if (!isset($formGroups[$code])) {
            $options = !empty($groupsConfig[$code]['options']) ? $groupsConfig[$code]['options'] : [];
            $formGroups[$code] = array_merge(self::$defaultOptions, $options, [
                'name' => $group,
                'fields' => [],
            ]);
        }

        $formTabs = $admin->getFormTabs();
        if (!isset($formTabs[$tab])) {
            $formTabs[$tab] = array_merge(self::$defaultOptions, [
                'name' => $tab,
                'tab' => true,
                'groups' => [$code],
            ]);
        } else {
            $formTabs[$tab]['groups'][] = $code;
            $formTabs[$tab]['groups'] = array_unique($formTabs[$tab]['groups']);
        }

        $admin->setFormGroups($formGroups);
        $admin->setFormTabs($formTabs);
    }

    private function removeDefaultTabAndGroup(FormMapper $form)
    {
        $admin = $form->getAdmin();
        $formGroups = $admin->getFormGroups();
        unset($formGroups[$this->getDefaultGroupName($admin)]);
        $admin->setFormGroups($formGroups);

        $formTabs = $admin->getFormTabs();
        unset($formTabs[self::DEFAULT_TAB_NAME]);
        $admin->setFormTabs($formTabs);
    }

    private function reorderFields(FormMapper $form)
    {
        $groupsConfig = $this->container->getParameter('amg_admin.fields_mapping');

        /** @var Admin $admin */
        $admin = $form->getAdmin();

        foreach ($admin->getFormGroups() as $code => $groupData) {
            if ($code !== $this->getDefaultGroupName($admin)) {
                if (!isset($groupsConfig[$code])) {
                    throw new \InvalidArgumentException(sprintf('Group ("%s") is not configured', $code));
                }

                $keys = array_intersect($groupsConfig[$code]['fields'], $groupData['fields']);
                $admin->reorderFormGroup($code, $keys);
            }
        }
    }

    private function reorderGroups(FormMapper $form)
    {
        $admin = $form->getAdmin();
        $groupsConfig = $this->container->getParameter('amg_admin.fields_mapping');

        $formGroups = $admin->getFormGroups();
        $groupsOrdered = [];
        foreach (array_keys($groupsConfig) as $code) {
            if (isset($formGroups[$code])) {
                $groupsOrdered[$code] = $formGroups[$code];
            }
        }
        $admin->setFormGroups($groupsOrdered);

        $groupCodesOrdered = array_keys($groupsOrdered);

        $formTabs = $admin->getFormTabs();

        $positions = array_flip($groupCodesOrdered);
        $orderByPosition = function ($a, $b) use ($positions) {
            return $positions[$a] < $positions[$b] ? -1 : 1;
        };

        foreach ($formTabs as $name => $tab) {
            usort($formTabs[$name]['groups'], $orderByPosition);
        }

        $tabNamesOrdered = array_values(array_unique(array_map(function ($code) {
            return explode('.', $code)[0];
        }, array_keys($groupsOrdered))));
        $formTabs = array_merge(array_flip($tabNamesOrdered), $formTabs);

        $admin->setFormTabs($formTabs);
    }

    private function mergeOptions(FormMapper $form)
    {
        $admin = $form->getAdmin();
        $formGroups = $admin->getFormGroups();
        $groupsConfig = $this->container->getParameter('amg_admin.fields_mapping');

        foreach ($formGroups as $code => &$group) {
            if (!isset($groupsConfig[$code])) {
                throw new \InvalidArgumentException(sprintf('Fields ("%s") of group ("%s") were not listed in config', implode('", "', $group['fields']), $group['name']));
            }

            if (!isset($groupsConfig[$code]['options'])) {
                continue;
            }

            foreach ($groupsConfig[$code]['options'] as $name => $value) {
                if (empty($group[$name])) {
                    $group[$name] = $value;
                }
            }
        }
        // unset($group);

        $admin->setFormGroups($formGroups);
    }
}
