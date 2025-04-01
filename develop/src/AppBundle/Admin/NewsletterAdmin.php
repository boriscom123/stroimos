<?php
namespace AppBundle\Admin;

use AppBundle\Admin\Newsletter\PostsSincePreviousNewsletterProvider;
use AppBundle\Constraints\NewsletterPostsCollectionConstraint;
use AppBundle\Constraints\UniqueCollectionConstraint;
use AppBundle\Entity\Newsletter;
use AppBundle\Entity\NewsletterItem\BaseItem;
use AppBundle\Entity\NewsletterItem\PostNewsletter;
use AppBundle\Model\Specification\InCategory;
use Doctrine\Common\Collections\ArrayCollection;
use Happyr\DoctrineSpecification\Spec;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Count;

class NewsletterAdmin extends Admin
{
    /**
     * @inheritdoc
     */
    protected $formOptions = array(
        'cascade_validation' => true,
    );

    /**
     * @inheritdoc
     */
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'date',
    ];

    /**
     * @var PostsSincePreviousNewsletterProvider
     */
    private $postSincePrevNewsletterProvider;

    /**
     * NewsletterAdmin constructor.
     * @param $code
     * @param $class
     * @param $baseControllerName
     * @param PostsSincePreviousNewsletterProvider $postSincePrevNewsletterProvider
     */
    public function __construct(
        $code,
        $class,
        $baseControllerName,
        PostsSincePreviousNewsletterProvider $postSincePrevNewsletterProvider
    ) {
        parent::__construct($code, $class, $baseControllerName);
        $this->postSincePrevNewsletterProvider = $postSincePrevNewsletterProvider;
    }

    /**
     * @inheritdoc
     */
    public function getNewInstance()
    {
        /** @var Newsletter $object */
        $object = parent::getNewInstance();

        $object->setPosts(
            $this->getItemsSincePreviousNewsletter(
                PostNewsletter::class,
                'post',
                'AppBundle:Post',
                Spec::andX(
                    new InCategory('news')
                )
            )
        );

        return $object;
    }

    protected function configureListFields(ListMapper $list)
    {
        $this->setTemplate('list', ':Admin:Newsletter/base_list.html.twig');

        $list->add('date', 'datetime', ['label' => 'Дата формирования']);
        $list->add('statusLabel', null, ['label' => 'Статус']);

        $list->add('_action', 'actions', ['label' => 'Действия', 'actions' => [
            'edit' => ['template' => '::Admin/CRUD/list__action_edit.html.twig'],
            'send' => ['template' => '::Admin/CRUD/list__action_send.html.twig'],
            'test' => ['template' => '::Admin/CRUD/list__action_test.html.twig'],
            'preview_with_custom_posts' => ['template' => '::Admin/CRUD/list__action_preview_with_custom_posts.html.twig'],
            'preview_with_general_posts' => ['template' => '::Admin/CRUD/list__action_preview_with_general_posts.html.twig'],
            'delete' => [],
        ]]);
    }

    protected function configureFormFields(FormMapper $form)
    {

        $this->setTemplate('edit', '::Admin/Newsletter/edit.html.twig');

        $commonOptions = [
            'edit'=> 'inline',
            'inline' => 'table',
            'sortable' => 'priorityPosition'
        ];

        $form
            ->add('subject', null, [
                'label' => 'Тема',
                'required' => true,
            ])
            ->add('quote', null, [
                'label' => 'Цитата',
                'property' => 'title',
                'multiple' => false,
                'required' => false,
                'placeholder' => ''
            ])
            ->add(
                'spotlightItemWallpaper',
                'sonata_type_model_list',
                ['required' => false],
                ['link_parameters' => ['lock_context' => ['main_image']]]
            )
            ->add('highlight', null, [
                'label' => 'Блок',
                'property' => 'teaser',
                'multiple' => false,
                'required' => false,
                'placeholder' => ''
            ])
            ->add('posts', 'sonata_type_collection', [
                'label'        => 'Новости',
                'required'     => false,
                'by_reference' => false,
                'constraints' => [
                    new NewsletterPostsCollectionConstraint(),
                    new UniqueCollectionConstraint([
                        'collectionName' => 'Новости',
                        'field' => 'post.id'
                    ])
                ]
            ], $commonOptions)
            ->add('infographicsNl', 'sonata_type_collection', [
                'label'        => 'Инфографика & Статистика',
                'required'     => false,
                'by_reference' => false,
                'constraints' => [
                    new Count(['max' => 1]),
                    new UniqueCollectionConstraint([
                        'collectionName' => 'Инфографика & Статистика',
                        'field' => 'infographics.id'
                    ])
                ]
            ], $commonOptions)
            ->add(
                'galleryWallpaper',
                'sonata_type_model_list',
                ['required' => false],
                ['link_parameters' => ['lock_context' => ['main_image']]]
            )
            ->add('galleryWallpaperType', 'choice', [
                'required' => true,
                'label' => 'Источник обложки для галереи',
                'choices' => [
                    Newsletter::GALLERY_WALLPAPER_SELF_LOADED => 'Загруженное изображение',
                    Newsletter::GALLERY_WALLPAPER_STATIC_IMAGE_FROM_GALLERY => 'Статическое изображение галереи',
                    Newsletter::GALLERY_WALLPAPER_STATIC_ANIMATED_FROM_GALLERY => 'Анимированное изображение галереи',
                ],
            ]
            )
            ->add('galleries', 'sonata_type_collection', [
                'label'        => 'Фото',
                'required'     => false,
                'by_reference' => false,
                'constraints' => [
                    new Count(['max' => 1]),
                    new UniqueCollectionConstraint([
                        'collectionName' => 'Фото',
                        'field' => 'gallery.id'
                    ])
                ]
            ], $commonOptions)

            ->add('videos', 'sonata_type_collection', [
                'label'        => 'Видео',
                'required'     => false,
                'by_reference' => false,
                'constraints' => [
                    new Count(['max' => 1])
                ]
            ], $commonOptions);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
        $collection->remove('show');
        $collection->add('send', $this->getRouterIdParameter() . '/send');
        $collection->add('test', $this->getRouterIdParameter() . '/test');
        $collection->add('preview_with_general_posts', $this->getRouterIdParameter() . '/preview-with-general-posts');
        $collection->add('preview_with_custom_posts', $this->getRouterIdParameter() . '/preview-with-custom-posts');
    }

    /**
     * @param string $contentClass Класс владельца контента
     * @param string $contentProperty Аттрибут класса, содержащий контент
     * @param string $class Класс сущности
     * @param Spec $andSpec Дополнительная спецификация, например категория для постов
     * @return ArrayCollection
     */
    protected function getItemsSincePreviousNewsletter($contentClass, $contentProperty, $class, $andSpec = null)
    {
        $posts = $this->postSincePrevNewsletterProvider->getData();

        $contentItems = new ArrayCollection();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        foreach ($posts as $post) {
            /** @var BaseItem $contentItem */
            $contentItem = new $contentClass();
            $propertyAccessor->setValue($contentItem, $contentProperty, $post);
            $contentItems->add($contentItem);
        }

        return $contentItems;
    }

    /**
     * {@inheritdoc}
     */
    public function update($object)
    {
        try {
            return parent::update($object);
        } catch (ModelManagerException $e) {
            $this->configurationPool->getContainer()->get('session')
                ->getFlashBag()
                ->add('error', $e->getPrevious());
            throw $e;
        }
    }
}
