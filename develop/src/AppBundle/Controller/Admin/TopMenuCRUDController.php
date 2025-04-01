<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Admin\PostAdmin;
use AppBundle\Entity\Post;
use AppBundle\Exception\AccessDeniedByOwnerException;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TopMenuCRUDController extends CRUDWithNotificationsController
{
    /**
     * The related Admin class.
     *
     * @var PostAdmin
     */
    protected $admin;

    public function createAction()
    {
        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $this->restrictNewsCreateEditForDkUser();
        $parameters = $this->admin->getPersistentParameters();
        if (!empty($parameters['category_alias'])) {
            return parent::createAction();
        }

        if($this->getUserOwner()) {
            $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findBy(
                ['alias' => $this->admin->getUserOwnerAllowedAliases()]
            );
        } else {
            $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        }

        return $this->render(':Admin:Post/select_category.html.twig', array(
            'categories'    => $categories,
            'base_template' => $this->getBaseTemplate(),
            'admin'         => $this->admin,
            'action'        => 'create',
        ));
    }

    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();

        $formView = $datagrid->getForm()->createView();

        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render(':SonataAdmin/Post:list.html.twig', array(
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
            'topMenuItems' => $this->admin->getTopMenuItems(),
            'category_alias'=> $this->admin->getPersistentParameter('category_alias'),
        ));
    }

    /**
     * Redirect the user depend on this choice
     *
     * @param object $object
     *
     * @return RedirectResponse
     */
    protected function redirectTo($object)
    {
        $url = false;

        $categoryAlias = $object->getCategory()->getAlias();
        $urlParam = array('category_alias' => $categoryAlias);

        if (null !== $this->get('request')->get('btn_update_and_list')) {
            $url = $this->admin->generateUrl('list', $urlParam);
        }
        if (null !== $this->get('request')->get('btn_create_and_list')) {
            $url = $this->admin->generateUrl('list', $urlParam);
        }

        if (null !== $this->get('request')->get('btn_create_and_create')) {
            $params = array();
            if ($this->admin->hasActiveSubClass()) {
                $params['subclass'] = $this->get('request')->get('subclass');
            }
            $url = $this->admin->generateUrl('create', $params);
        }

        if ($this->getRestMethod() == 'DELETE') {
            $url = $this->admin->generateUrl('list', $urlParam);
        }

        if (!$url) {
            $url = $this->admin->generateObjectUrl('edit', $object);
        }

        return new RedirectResponse($url);
    }

    public function toggleInTopAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        /** @var Post $object */
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('EDIT', $object)) {
            throw new AccessDeniedException();
        }

        $object->setInTop(!$object->isInTop());

        $this->admin->getModelManager()->update($object);

        $categoryAlias = $object->getCategory()->getId();
        $urlParam = array('category_alias' => $categoryAlias);

        return new RedirectResponse($this->admin->generateUrl('list', $urlParam));
    }

    /**
     * @param ProxyQueryInterface $query
     * @return RedirectResponse
     */
    public function batchActionClearTop(ProxyQueryInterface $query)
    {
        if (!$this->admin->isGranted('EDIT'))
        {
            throw new AccessDeniedException();
        }

        $selectedPosts = $query->execute();
        $modelManager = $this->admin->getModelManager();
        try {
            /** @var Post $post */
            foreach($selectedPosts as $post) {
                $post->setInTop(false);
                $modelManager->update($post);
            }

        } catch (\Exception $e) {
            $this->addFlash('sonata_flash_error', $this->admin->trans('flash_batch.clear_top_error'));

            return new RedirectResponse(
            $this->admin->generateUrl('list',$this->admin->getFilterParameters())
            );
        }

        $this->addFlash('sonata_flash_success', $this->admin->trans('flash_batch.clear_top_success'));

        return new RedirectResponse(
            $this->admin->generateUrl('list',$this->admin->getFilterParameters())
        );
    }

    /**
     * @inheritdoc
     */
    protected function checkUserOwnerAccess($id = null)
    {
        $this->restrictNewsCreateEditForDkUser();
        parent::checkUserOwnerAccess($id);
    }

    /**
     * @throws AccessDeniedByOwnerException
     */
    private function restrictNewsCreateEditForDkUser()
    {
        if($this->getUserOwner() === null) {
            return;
        }

        if($this->getRestMethod() !== 'POST') {
            return;
        }
        $request = $this->getRequest();
        $data = $request->request->get($request->query->get('uniqid'));
        if(!isset($data['category'])) {
            return;
        }

        $repo = $this->getDoctrine()->getRepository('AppBundle:Category');
        $category = $repo->findOneBy(['id' => $data['category']]);

        /** @var Post $object */
        if($category !== null && !in_array($category->getAlias(), $this->admin->getUserOwnerAllowedAliases())) {
            throw new AccessDeniedByOwnerException('Вы не имеете права редактировать новости');
        }
    }
}
