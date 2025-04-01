<?php
namespace Amg\Bundle\PageBundle\Controller\Admin;

use Amg\Bundle\PageBundle\Entity\PageRepository;
use AppBundle\Controller\Admin\BaseAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PageController extends BaseAdminController
{
    /**
     * Список пользователей, которым разрешён доступ к редактированию главной страницы
     * http://red.demo-room.ru/issues/191#note-1
     * @var array
     */
    private $mainPageEditors = [
        'alexandr.batalov@gmail.com',
        'superadmin'
    ];

    protected $possibleDirections = [
        'up' => true,
        'down' => true,
    ];

    public function moveAction(Request $request, $direction)
    {
        $this->checkUserOwnerAccess();
        if (!isset($this->possibleDirections[$direction])) {
            throw new BadRequestHttpException('Impossible direction');
        }

        $page = $this->admin->getSubject();
        $moveByPosition = $request->query->get('end') ? true : 1;

        if ('up' === $direction) {
            $this->getPageRepository()->moveUp($page, $moveByPosition);
        } else {
            $this->getPageRepository()->moveDown($page, $moveByPosition);
        }

        if ($this->isXmlHttpRequest()) {
            return $this->renderJson(array(
                'result' => 'ok',
                'objectId' => $this->admin->getNormalizedIdentifier($page)
            ));
        }

        $this->get('session')->getFlashBag()->set('sonata_flash_info', 'Позиция обновлена');

        return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }

    /**
     * @return PageRepository
     */
    public function getPageRepository()
    {
        return $this->getDoctrine()->getRepository(
            get_class($this->admin->getSubject())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function editAction($id = null)
    {
        if($id == 1 && $this->getRequest()->get('_route') === 'admin_app_page_edit'
            && !in_array($this->getUser()->getUserName(), $this->mainPageEditors)
        ) {
            throw $this->createAccessDeniedException(
                'Редактировать данную страницу могут ' . implode(',', $this->mainPageEditors)
            );
        }

        return parent::editAction($id);
    }
}