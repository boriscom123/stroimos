<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Video;
use AppBundle\Exception\ModelDeleteErrorException;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BaseAdminController extends Controller
{
    use BaseAdminControllerTrait;

    /**
     * @inheritdoc
     */
    public function deleteAction($id)
    {
        $this->checkUserOwnerAccess($id);
        try {
            return parent::deleteAction($id);
        } catch (ModelDeleteErrorException $e) {
            $this->addFlash('sonata_flash_error', $e->getMessage());

            return new RedirectResponse($this->admin->generateUrl('edit', ['id' => $id]));
        }
    }

    /**
     * @inheritdoc
     */
    public function editAction($id = null)
    {
        $this->checkUserOwnerAccess($id);
        return parent::editAction($id);
    }

    /**
     * @inheritdoc
     */
    public function batchActionDelete(ProxyQueryInterface $query)
    {
        $this->checkUserOwnerAccess();
        return parent::batchActionDelete($query);
    }
    public function batchActionVisibleVideo(ProxyQueryInterface $query)
    {
        if (!$this->admin->isGranted('EDIT'))
        {
            throw new AccessDeniedException();
        }

        $selectedVideos = $query->execute();
        $modelManager = $this->admin->getModelManager();
        try {
            /** @var Video $video */
            foreach($selectedVideos as $video) {
                $video->setIsVisibleInVideoCategory(false);
                $modelManager->update($video);
            }

        } catch (\Exception $e) {
            $this->addFlash('sonata_flash_error', 'Ошибка пакетного действия');

            return new RedirectResponse(
                $this->admin->generateUrl('list',$this->admin->getFilterParameters())
            );
        }

        $this->addFlash('sonata_flash_success', 'Выбранные элементы отображены в разделе видео');

        return new RedirectResponse(
            $this->admin->generateUrl('list',$this->admin->getFilterParameters())
        );
    }
    public function batchActionInvisibleVideo(ProxyQueryInterface $query)
    {
        if (!$this->admin->isGranted('EDIT'))
        {
            throw new AccessDeniedException();
        }

        $selectedVideos = $query->execute();
        $modelManager = $this->admin->getModelManager();
        try {
            /** @var Video $video */
            foreach($selectedVideos as $video) {
                $video->setIsVisibleInVideoCategory(true);
                $modelManager->update($video);
            }

        } catch (\Exception $e) {
            $this->addFlash('sonata_flash_error', 'Ошибка пакетного действия');

            return new RedirectResponse(
                $this->admin->generateUrl('list',$this->admin->getFilterParameters())
            );
        }

        $this->addFlash('sonata_flash_success', 'Выбранные элементы скрыты из раздела видео');

        return new RedirectResponse(
            $this->admin->generateUrl('list',$this->admin->getFilterParameters())
        );
    }

    /**
     * @inheritdoc
     */
    protected function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @inheritdoc
     */
    protected function getEditLocker()
    {
        return $this->container->get('admin.edit_locker');
    }
}
