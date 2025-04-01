<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Construction;
use AppBundle\Entity\EmbeddedContent\Quote;
use AppBundle\Entity\Person;
use AppBundle\Exception\ModelDeleteErrorException;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class PersonAdmin extends Admin
{
    const SOCIAL_ACCOUNTS_ORDER = ['telegram', 'rutube', 'dzen', 'odnoklassniki', 'vkontakte', 'moimir', 'facebook', 'twitter', 'instagram', 'youtube', 'google', 'lj' ];

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('fullName');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('lowerOrganization', 'sonata_type_model', [
                'required' => false,
                'label' => 'Подчинённая организация',
                'btn_add' => false,
                'btn_delete' => false,
            ])
            ->add('biography', 'ckeditor', ['required' => false])
            ->add('education', 'ckeditor', ['required' => false])
            ->add('experience', 'ckeditor', ['required' => false])
            ->add('awards', 'ckeditor', ['required' => false])
            ->add('family', 'ckeditor', ['required' => false])
            ->add('notes', 'ckeditor', ['required' => false])
            ->add('showInStructure', null, ['required' => false])
            ->add('shortPost', null, ['required' => false])
            ->add('socialAccountUrls', 'sonata_type_immutable_array', [
                'required' => false,
                'keys' => array_map(
                    function($key) {
                        return [$key, 'url', ['required' => false]];
                    },
                    self::SOCIAL_ACCOUNTS_ORDER
                ),
            ])
        ;
    }

    /**
     * @inheritdoc
     */
    public function getBatchActions()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function preRemove($object)
    {
        if($object instanceof Person) {
            $doctrine = $this->getConfigurationPool()->getContainer()->get('doctrine');
            if($doctrine->getRepository('AppBundle:EmbeddedContent\Quote')->personHasQuotes($object)) {
                throw new ModelDeleteErrorException('Невозможно удалить персону, так как у неё есть цитаты');
            }
        }
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $isPublishable= $this->getForm()->get('publishable')->getData();
        if ($isPublishable) {
            return;
        }

        $construction = $this->em->getRepository(Quote::class)->findOneBy(['person' => $object]);
        if (!$construction) {
            return;
        }

        $errorElement
            ->addViolation('Снять с публикации невозможно. У персоны есть опубликованные цитаты.');
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
}
