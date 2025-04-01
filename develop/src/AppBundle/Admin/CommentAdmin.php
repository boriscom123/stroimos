<?php
namespace AppBundle\Admin;

use Application\FOS\CommentBundle\Entity\Comment;
use Application\FOS\CommentBundle\Entity\Thread;
use Application\Sonata\MediaBundle\Entity\Media;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CommentAdmin extends Admin
{
    protected $datagridValues = [
        '_sort_by' => 'createdAt',
        '_sort_order' => 'DESC',
    ];

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        if ($this->isChild()) {
            /** @var Thread $thread */
            $thread = $this->getParent()->getSubject();

            $rootAliases = $query->getRootAliases();

            $query->where($rootAliases[0] . '.thread = :thread');
            $query->setParameter('thread', $thread);
        }

        return $query;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('state', 'sonata_comment_status', ['label' => 'Статус модерации'])
            ->add('author', null, ['disabled' => true])
            ->add('body', null, ['label' => 'Текст комментария'])
        ;

        /** @var Comment $subject */
        $subject = $this->getSubject();
        $media = $subject->getFile();
        if ($media instanceof Media) {
            /** @var Admin $admin */
            $admin = $formMapper->getAdmin();
            $mediaProvider = $admin->getConfigurationPool()->getContainer()->get('sonata.media.pool')->getProvider($media->getProviderName());

            $formMapper->add('file', 'hyperlink', [
                'text' => $media->getName(),
                'data' => $mediaProvider->generatePublicUrl($media, 'reference'),
            ]);
        }

        $formMapper
            ->add('createdAt', 'sonata_type_datetime_picker', [
                'label' => 'Дата создания',
                'format' => 'dd-MM-yyyy HH:mm:ss',
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('author')
            ->add('body')
            ->add('state')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, [
                'template' => ':CommentAdmin:id.html.twig',
            ])
            ->add('author', null, ['associated_property' => 'fullName'] )
            ->add('body', 'text')
            ->add('createdAt', 'datetime')
            ->add('state', 'string', [
                'template' => ':CommentAdmin:list_status.html.twig',
            ])
        ;
    }

    public function prePersist($object)
    {
        if ($this->isChild()) {
            $thread = $this->getParent()->getSubject();
            if ($thread) {
                /** @var Comment $object */
                $object->setThread($thread);
            }
        }
    }
}
