<?php

namespace AppBundle\Admin\Extension;

use AppBundle\Entity\Draft;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class DraftExtension extends AdminExtension
{

    public function configureQuery(AdminInterface $admin, ProxyQueryInterface $query, $context = 'list') {
        $query->leftJoin(Draft::class, 'draft', 'WITH', 'o.id = draft.ownerEntityId');
    }

    public function configureFormFields(FormMapper $formMapper){
        $admin = $formMapper->getAdmin();

        $object = $admin->getSubject();
        if($object){
            $ownerClassName = get_class($object);
            $draft = $admin->getModelManager()->findOneBy(
                Draft::class,
                [
                    'ownerEntityId' => $object->getId(),
                    'ownerClassName' => $ownerClassName,
                ]
            );

            $formMapper
                ->with('Основное', ['tab' => true])
                ->with('Параметры')
                ->add(
                    'isDraft',
                    'checkbox',
                    [
                        'label' => 'Черновик',
                        'required' => false,
                        'mapped' => false,
                        'data' => (bool) $draft,
                    ])
                ->end()
                ->end();
        } else {
            $formMapper
                ->with('Основное', ['tab' => true])
                ->with('Параметры')
                ->add(
                    'isDraft',
                    'checkbox',
                    [
                        'label' => 'Черновик',
                        'required' => false,
                        'mapped' => false,
                        'data' => (bool)false,
                    ])
                ->end()
                ->end();
        }
    }

    public function validate(AdminInterface $admin, ErrorElement $errorElement, $object) {

        $isPublishanble = $admin->getForm()->get('publishable')->getData();
        $isDraft = $admin->getForm()->get('isDraft')->getData();
        if ($isPublishanble && $isDraft) {
            $errorElement
                ->with('isDraft')
                ->addViolation('Нельзя сделать черновиком материал, который опубликован');
        }
    }


    protected function createAndSaveDraft(AdminInterface  $admin, $object) {
        $adminLabel = $admin->getLabel();
        $editRoute = $admin->generateObjectUrl('edit', $object);

        $draft = new Draft($object, $adminLabel, $editRoute);
        $admin->getModelManager()->create($draft);
    }

    public function postUpdate(AdminInterface $admin, $object) {
        $isDraft = $admin->getForm()->get('isDraft')->getData();
        $draft = $admin->getModelManager()->findOneBy(
            Draft::class,
            [
                'ownerEntityId' => $object->getId(),
                'ownerClassName' => get_class($object),
            ]
        );

        if ($draft && !$isDraft) {
            $admin->getModelManager()->delete($draft);
        }
        else if ($isDraft && is_null($draft)) {
            $this->createAndSaveDraft($admin, $object);
        }
    }

    public function postPersist(AdminInterface $admin, $object) {
        $isDraft = $admin->getForm()->get('isDraft')->getData();
        if ($isDraft) {
            $this->createAndSaveDraft($admin, $object);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preRemove(AdminInterface $admin, $object)
    {
        $draft = $admin->getModelManager()->findOneBy(
            Draft::class,
            [
                'ownerEntityId' => $object->getId(),
                'ownerClassName' => get_class($object),
            ]
        );

        if ($draft) {
            $admin->getModelManager()->delete($draft);
        }
    }
}
