<?php
namespace ExtraBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use ExtraBundle\Entity\Event;
use ExtraBundle\Entity\EventChatMessage;
use ExtraBundle\Entity\EventFeedback;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Spec;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EventController extends Controller
{
    /**
     * @Route("/event", name="app_event_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $specs = new AndX(
            Spec::limit(10),
            Spec::offset($request->query->get('offset', 0)),
            Spec::orderBy('date', 'ASC')
        );

        if ($date = $request->query->get('date')) {
            $date = \DateTime::createFromFormat("d.m.Y", $date);
            $specs->andX(
                Spec::andX(
                    Spec::gte('date', $date->modify("today")->format('Y-m-d H:i:s')),
                    Spec::lte('date', $date->modify("tomorrow -1 sec")->format('Y-m-d H:i:s'))
                )
            );
        }

        $events = $this->getDoctrine()->getRepository('ExtraBundle:Event')->match($specs);

        $dateFormatter = new \IntlDateFormatter(
            'ru_RU',
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::NONE,
            'Europe/Moscow',
            \IntlDateFormatter::GREGORIAN,
            "LLLL YYYY"
        );


        $eventsByMonth = [];
        foreach($events as $event) {
            $eventMonth = $dateFormatter->format($event->getDate());
            $eventsByMonth[$eventMonth][] = $event;
        }

        return [
            'events_by_month' => $eventsByMonth,
            'date' => !empty($date) ? $date : null
        ];
    }

    /**
     * @Route("/event/{id}", name="app_event_show")
     * @ParamConverter()
     * @Template()
     */
    public function showAction(Event $event)
    {
        $form = $this->createFeedbackForm($event);

        return [
            'event' => $event,
            'form' => $form->createView(),
            'can_create_chat_message' => $this->canCreateChatMessage($event, $this->getUser()),
            'can_moderate_chat_message' => $this->canModerateChatMessage($event, $this->getUser()),
            'can_register_on_event' => $this->canRegisterOnEvent($event),
            'can_un_register_from_event' => $this->canUnRegisterFromEvent($event)
        ];
    }

    /**
     * @Route("/event/{id}/feedback", name="app_event_feedback", methods={"POST"})
     * @ParamConverter()
     * @Template("ExtraBundle:Event:show.html.twig")
     */
    public function feedbackAction(Request $request, Event $event)
    {
        $form = $this->createFeedbackForm($event);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($form->getData());
            $manager->flush();

            $this->addFlash('notice', 'Сообщение принято. Спасибо за внимание!');

            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
        }

        return [
            'event' => $event,
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/event/{id}/register", name="app_event_register", methods={"POST"})
     * @ParamConverter()
     */
    public function registerAction(Event $event)
    {
        if ($this->canRegisterOnEvent($event)) {
            $event->getGuests()->add($this->getUser());
            $this->getDoctrine()->getManager()->persist($event);
            $this->getDoctrine()->getManager()->flush();
        } elseif($this->canUnRegisterFromEvent($event)) {
            $event->getGuests()->removeElement($this->getUser());
            $this->getDoctrine()->getManager()->persist($event);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
    }

    /**
     * @Route("/event/{id}/chat", name="app_event_chat_message", methods={"POST"})
     * @ParamConverter()
     */
    public function chatMessageCreateAction(Request $request, Event $event)
    {
        $user = $this->getUser();

        if (!$this->canCreateChatMessage($event, $user)) {
            throw $this->createAccessDeniedException();
        }

        $message = $request->request->get('message');
        $message = trim($message);

        if (!$message) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Empty message');
        }

        $chatMessage = new EventChatMessage();
        $chatMessage->setMessage($message);
        $chatMessage->setUser($user);
        $chatMessage->setPublishable(true);
        $chatMessage->setEvent($event);

        $this->getDoctrine()->getManager()->persist($chatMessage);
        $this->getDoctrine()->getManager()->flush();


        return new JsonResponse('ok');
    }

    /**
     * @Route("/event/chat-message/{id}/remove", name="app_event_chat_message_remove", methods={"POST"})
     * @ParamConverter()
     */
    public function chatMessageRemoveAction(EventChatMessage $message)
    {
        if (!$this->canModerateChatMessage()) {
            throw $this->createAccessDeniedException();
        }

        $message->setPublishable(false);

        $this->getDoctrine()->getManager()->persist($message);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse('ok');
    }

    /**
     * @Route("/event/{id}/chat", name="app_event_chat_list")
     * @ParamConverter()
     * @Template("@Extra/Event/_chatList.html.twig")
     */
    public function chatMessageListAction(Event $event)
    {
        $chat_messages = $this->getChatMessages($event);

        return [
            'event' => $event,
            'chat_messages' => $chat_messages,
            'can_create_chat_message' => $this->canCreateChatMessage($event, $this->getUser()),
            'can_moderate_chat_message' => $this->canModerateChatMessage($event, $this->getUser()),
        ];
    }

    /**
     * @param Event $event
     * @return array|EventChatMessage[]
     */
    protected function getChatMessages(Event $event)
    {
        return (array)$this->getDoctrine()
            ->getRepository('ExtraBundle:EventChatMessage')
            ->findBy(['event' => $event], ['createdAt' => 'ASC']);
    }

    /**
     * @param Event $event
     * @return \Symfony\Component\Form\Form
     */
    protected function createFeedbackForm(Event $event)
    {
        $errorReport = new EventFeedback();
        $errorReport->setUser($this->getUser());
        $errorReport->setEvent($event);

        return $this->createForm('event_feedback', $errorReport, [
            'action' => $this->generateUrl('app_event_feedback', ['id' => $event->getId()]),
            'method' => 'POST',
        ]);
    }

    /**
     * @param Event $event
     * @param $user
     * @return bool
     */
    protected function canCreateChatMessage(Event $event, User $user = null)
    {
        if ($this->isGranted('ROLE_EVENT_MODERATOR') || $this->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        if ($user && $event->getGuests()->contains($user) && $event->getState() === Event::STATE_OPENED) {
            return true;
        }

        return false;
    }

    /**
     * @param Event $event
     * @param $user
     * @return bool
     */
    protected function canModerateChatMessage()
    {
        if ($this->isGranted('ROLE_EVENT_MODERATOR') || $this->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        return false;
    }

    /**
     * @param Event $event
     * @return bool
     */
    protected function canRegisterOnEvent(Event $event)
    {
        return $event->isOpen() &&
            ($event->getState() === Event::STATE_OPENED || $event->getState() === Event::STATE_AWAIT) &&
            $this->isGranted('ROLE_JOURNALIST') &&
            $this->getUser() &&
            !$event->getGuests()->contains($this->getUser());
    }

    /**
     * @param Event $event
     * @return bool
     */
    protected function canUnRegisterFromEvent(Event $event)
    {
        return $event->getState() === Event::STATE_AWAIT &&
            $this->getUser() &&
            $event->getGuests()->contains($this->getUser());
    }
}
