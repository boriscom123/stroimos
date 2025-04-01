<?php
namespace Application\Sonata\MediaBundle\Controller;

use AppBundle\Entity\MediaCategory;
use Application\Sonata\MediaBundle\Admin\MediaAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\MediaBundle\Controller\MediaAdminController as BaseMediaAdminController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Validator\Constraints as Assert;

class MediaAdminController extends BaseMediaAdminController
{
    /**
     * @var MediaAdmin
     */
    protected $admin;
    private $doctrine;

    public function editImageFormatAction(Request $request)
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('EDIT', $object)) {
            throw new AccessDeniedException();
        }

        $format = $request->request->get('format');
        $editableFormats = $this->admin->getEditableFormats($object, [$format]);
        if (!isset($editableFormats[$format])) {
            throw new BadRequestHttpException("Format '$format' is not editable");
        }
        $editableFormat = $editableFormats[$format];

        $crop = array_map('round', $request->request->get('crop'));
        $mask = $request->request->get('mask');

        $provider = $this->admin->getMediaProvider($object);
        $editableFormatManager = $this->get('sonata.media.editable_format.manager');

        try {
            $editableFormatManager->editFormat($provider, $object, $editableFormat, $crop, $mask);

            return new JsonResponse([
                'status' => 'ok',
                'crop' => $crop,
                'edited_format' => $editableFormatManager->getEditedFormatPath($provider, $object, $format),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'debug' => $e->getMessage()
            ]);
        }
    }

    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        if ($this->admin->getPersistentParameter('context')) {
            $datagrid->setValue('context', null, $this->admin->getPersistentParameter('context'));
        }

        if ($this->admin->getPersistentParameter('category')) {
            $datagrid->setValue('category', null, $this->admin->getPersistentParameter('category'));
        }

        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());


        return $this->render($this->admin->getTemplate('list'), array(
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ));
    }

    public function render($view, array $parameters = array(), Response $response = null)
    {
        $rootCategory = $this->getDoctrine()->getRepository(MediaCategory::class)->findOneBy(['root' => 1, 'lvl' => 0], ['title' => 'ASC']);

        $currentCategory = $this->admin->getPersistentParameter('category')
            ? $this->getDoctrine()->getRepository(MediaCategory::class)->find($this->admin->getPersistentParameter('category'))
            : $rootCategory;

        $parameters['current_category'] = $currentCategory;
        $parameters['root_category'] = $rootCategory;

        if (count($currentCategory->getChildren()) > 0) {
            $parameters['base_category'] = $currentCategory;
            $parameters['category_list'] = $currentCategory->getChildren();
        } elseif ($currentCategory->getParent()) {
            $parameters['base_category'] = $currentCategory->getParent();
            $parameters['category_list'] = $currentCategory->getParent()->getChildren();
        } else {
            $parameters['base_category'] = $currentCategory;
            $parameters['category_list'] = [];
        }

        return parent::render($view, $parameters, $response);
    }

    public function batchActionCopyright(ProxyQueryInterface $query)
    {
        if (false === $this->admin->isGranted('EDIT')) {
            throw new AccessDeniedException();
        }

        $copyright_new = json_decode($_POST['data'])->copyright;

        $selectedElements = $query->execute();
        $modelManager = $this->admin->getModelManager();

        foreach ($selectedElements as $element) {
            $element->setCopyright($copyright_new);
            $modelManager->update($element);
        }

        $this->addFlash(
            'sonata_flash_success',
            'Копирайт "'.$copyright_new.'" добавлен к выбранным элементам'
        );

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function batchUploadAction()
    {
        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $catRepo = $this->getDoctrine()->getRepository(MediaCategory::class);
        $categoryPath = $catRepo->getPath(
            $catRepo->find(
                $this->admin->getPersistentParameter('category') ?: $this->getDoctrine()->getRepository(MediaCategory::class)->findOneBy(['root' => 1, 'lvl' => 0], ['title' => 'ASC'])
            )
        );
        $categoryTitle = [];
        foreach ($categoryPath as $categoryInPath) {
            $categoryTitle[] = $categoryInPath->getTitle();
        }
        $categoryTitle = implode(' / ', $categoryTitle);

        $form = $this->createFormBuilder(null, ['csrf_protection' => false])
            ->add('images', 'file', [
                'label' => 'Изображения',
                'multiple' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\All([
                        'constraints' => [
                            new Assert\NotBlank(),
                            new Assert\Image(),
                        ]
                    ])
                ]
            ])
            ->add('copyright', 'text', array(
                'mapped' => false,
                'required' => false,
                'label' => 'Копирайт',
            ))
            ->add('category', 'text', array(
                'mapped' => false,
                'data' => $categoryTitle,
                'disabled' => true,
                'label' => 'Категория',
            ))
            ->add('create_category', 'text', array(
                'mapped' => false,
                'required' => false,
                'label' => 'Создать категорию в выбранной',
            ))
            ->getForm();

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            if ($isFormValid) {
                try {
                    $createdCategoryId = $this->batchCreateMedia(
                        $form->get('images')->getData(),
                        $form->get('create_category')->getData(),
                        $form->get('copyright')->getData()
                    );

                    $redirectParameters = !empty($createdCategoryId)
                        ? ['category' => $createdCategoryId]
                        : [];

                    $this->addFlash('sonata_flash_success', 'Пакетная загрузка прошла успешно.');

                    return new RedirectResponse($this->admin->generateUrl('list', $redirectParameters));
                } catch (\Exception $e) {
                    $isFormValid = false;
                }
            }

            if (!$isFormValid) {
                $this->addFlash('sonata_flash_error', 'Во время загрузки произошла ошибка.');
            }
        }

        return $this->render('SonataMediaBundle:MediaAdmin:batch_upload.html.twig', array(
            'action' => 'batch_upload',
            'admin' => $this->admin,
            'form' => $form->createView()
        ));
    }

    /**
     * @param UploadedFile[] $images
     * @param string $createCategory
     * @return int
     * @throws \Exception
     */
    private function batchCreateMedia(array $images, $createCategory, $copyright)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->beginTransaction();
        try {
            foreach ($images as $image) {
                $imageMedia = $this->admin->getNewInstance();
                $imageMedia->setCopyright($copyright);
                $imageMedia->setBinaryContent($image);
                $imageMedia->setProviderName('sonata.media.provider.image');
                $imageMedia->setEnabled(true);

                if (isset($newCategory)) {
                    $imageMedia->setCategory($newCategory);
                } elseif (!empty($createCategory)) {
                    $newCategory = new MediaCategory();
                    $newCategory->setTitle($createCategory);
                    $newCategory->setParent($imageMedia->getCategory());

                    $imageMedia->setCategory($newCategory);
                }

                $this->admin->create($imageMedia);
            }

            $em->flush();
            $em->commit();

            if (isset($newCategory)) {
                return $newCategory->getId();
            }
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

}
