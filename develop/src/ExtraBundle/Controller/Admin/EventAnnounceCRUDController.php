<?php

namespace ExtraBundle\Controller\Admin;

use ExtraBundle\Entity\EventAnnounce;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EventAnnounceCRUDController extends Controller
{
    const MESSAGE__EMPTY_ANNOUNCE = 'Пустая рассылка';

    const MESSAGE__ANNOUNCE_SENDING_STARTED = 'Отправка успешно завершена';

    public function sendAction($id)
    {
        /** @var EventAnnounce $eventAnnounce */
        $eventAnnounce = $this->admin->getSubject();

        if (false === $this->admin->isGranted('EDIT', $eventAnnounce)) {
            throw new AccessDeniedException();
        }

        if (!$eventAnnounce) {
            throw new NotFoundHttpException(sprintf('unable to find announce with id : %s', $id));
        }

        $subscribedUsers = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:User')->findUsersByRole([
            'ROLE_VIP_JOURNALIST',
            'ROLE_JOURNALIST',
        ]);
        if ($subscribedUsers) {
            $emailManager = $this->get('app.email_manager');
            foreach ($subscribedUsers as $subscribedUser) {
                $emailManager->sendEventAnnounce($eventAnnounce, $subscribedUser);
            }
        }

        // todo Proper status change after queue is processed?
        $eventAnnounce->setStatus(EventAnnounce::STATUS_SENT);
        $this->admin->getModelManager()->update($eventAnnounce);

        $this->addFlash('sonata_flash_success', self::MESSAGE__ANNOUNCE_SENDING_STARTED);

        return $this->redirect($this->admin->generateUrl('list'));
    }
}
