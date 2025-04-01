<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\SpotlightItem;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SpotlightItemCRUDController extends Controller
{
    protected $possibleDirections = [
        'up' => true,
        'down' => true,
    ];

    public function createAction()
    {
        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();

        if (count($modelManager->findBy(SpotlightItem::class)) >= SpotlightItem::LIMIT) {
            $this->addFlash('sonata_flash_error', 'Превышен лимит на число элементов в блоке');

            return $this->redirect($this->admin->generateUrl('list'));
        }

        return parent::createAction();
    }

    public function moveAction(Request $request, $direction)
    {
        if (!isset($this->possibleDirections[$direction])) {
            throw new BadRequestHttpException('Impossible direction');
        }

        $moveToEdge = (bool)$request->query->get('end', false);

        $spotlightItem = $this->admin->getSubject();
        $repository = $this->get('doctrine')->getRepository(SpotlightItem::class);
        $repository->move($spotlightItem, $direction, $moveToEdge);

        if ($this->isXmlHttpRequest()) {
            return $this->renderJson(array(
                'result' => 'ok',
                'objectId' => $this->admin->getNormalizedIdentifier($spotlightItem)
            ));
        }

        $this->get('session')->getFlashBag()->set('sonata_flash_info', 'Позиция обновлена');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
