<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AdministrativeUnit;
use AppBundle\Entity\EmailSubscription;
use AppBundle\Entity\UnsubscribeReason;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class EmailSubscriptionController extends Controller
{
    public function subscribeAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToRoute('app_homepage');
        }

        $formData = $request->request->get('form');
        $isAdmUnitsEmpty = $formData['administrativeUnits']
            && count($formData['administrativeUnits']) === 1
            && empty($formData['administrativeUnits'][0]);
        if ($isAdmUnitsEmpty) {
            unset($formData['administrativeUnits']);
            $request->request->set('form', $formData);
        }
        $subscribingUser = new EmailSubscription();
        $subscribeForm = $this->createFormBuilder($subscribingUser, ['csrf_protection' => false])
            ->add('email', 'email', ['attr' => ['placeholder' => 'email'], 'label' => false])
            ->add(
                'administrativeUnits',
                'entity',
                [
                    'class' => AdministrativeUnit::class,
                    'choice_label' => 'title',
                    'multiple' => true,
                    'expanded' => false,
                ]
            )
            ->add('submit', 'submit', ['label' => 'Подписаться'])
            ->getForm();

        $subscribeForm->handleRequest($request);
        if ($subscribeForm->isValid()) {
            /** @var ObjectManager $em */
            $em = $this->getDoctrine()->getManager();
            $subscribedUserRepo = $em->getRepository('AppBundle:EmailSubscription');
            $previouslySubscribedUser = $subscribedUserRepo->findOneBy(['email' => $subscribingUser->getEmail()]);
            if (!$previouslySubscribedUser) {
                $em->persist($subscribingUser);
                $em->flush();

                try {
                    $this->get('app.email_manager')->sendConfirmationRequest($subscribingUser);
                } catch(\Exception $e) {
                    $em->remove($subscribingUser);
                    $em->flush();
                    return new JsonResponse([
                        'errors' => [$this->get('translator')->trans('email_subscription.subscribe_request.error.email_not_valid')],
                    ]);
                }

                return new JsonResponse([
                    'message' => $this->get('translator')->trans('email_subscription.subscribe_request.success'),
                ]);
            }

            $response = new JsonResponse();
            /** @var EmailSubscription $previouslySubscribedUser*/
            if($previouslySubscribedUser->getConfirmed()) {
                $response->setData(['message' => $this->get('translator')->trans('email_subscription.subscribe_request.error.email_exists'), 'confirmed' => 'true']);
            } else {
                $response->setData(['message' => $this->get('translator')->trans('email_subscription.subscribe_request.error.email_not_confirmed')]);
            }

            return $response;
        }

        return new JsonResponse([
            'errors' => [$this->get('translator')->trans('email_subscription.subscribe_request.error.email_not_valid')],
        ]);
    }

    public function subscribeSuccessAction()
    {
        return $this->render(':EmailSubscription:success.html.twig', [
            'message' => $this->get('translator')->trans('email_subscription.subscribe_request.success'),
        ]);
    }

    public function unsubscribeSuccessAction()
    {
        return $this->render(':EmailSubscription:success.html.twig', [
            'message' => $this->get('translator')->trans('email_subscription.unsubscribe_request.success')
        ]);
    }

    public function controlAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $subscribedUserRepo = $em->getRepository('AppBundle:EmailSubscription');

        /** @var EmailSubscription $subscribedUser */
        $subscribedUser = $subscribedUserRepo->findOneBy(['email' => $request->get('email')]);
        if (!$subscribedUser || ($request->get('hash') !== $subscribedUser->getHash())) {
            throw $this->createNotFoundException();
        }

        if (!$subscribedUser->getConfirmed()) {
            $subscribedUser->setConfirmed(true);
            $em->persist($subscribedUser);
            $em->flush();
            return $this->render(':EmailSubscription:confirm.html.twig');
        }

        $reason = new UnsubscribeReason($request->get('email'));
        $form = $this->createFormBuilder($reason)
            ->add('reason', 'choice', [
                'choices' => array_combine(UnsubscribeReason::REASONS, UnsubscribeReason::REASONS),
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('comment', 'text', ['required' => false])
            ->add('submit', 'submit', ['label' => 'Отписаться'])
            ->getForm();


        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($reason);
            $em->remove($subscribedUser);
            $em->flush();
            return $this->redirectToRoute('email_subscription_unsubscribe_success');
        }

        return $this->render(':EmailSubscription:control.html.twig', [
            'subscribed_user' => $subscribedUser,
            'errors' => $form->getErrors(true),
            'form' => $form->createView(),
        ]);
    }


    public function manageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $subscribedUserRepo = $em->getRepository('AppBundle:EmailSubscription');

        /** @var EmailSubscription $subscribedUser */
        $subscribedUser = $subscribedUserRepo->findOneBy(['email' => $request->get('email')]);
        $userNotFound = !$subscribedUser
            || ($request->get('hash') !== $subscribedUser->getHash())
            || !$subscribedUser->getConfirmed();
        if ($userNotFound) {
            throw $this->createNotFoundException();
        }

        $form = $this->createFormBuilder($subscribedUser, ['csrf_protection' => true])
            ->add(
                'administrativeUnits',
                'entity',
                [
                    'class' => AdministrativeUnit::class,
                    'choice_label' => 'title',
                    'multiple' => true,
                    'expanded' => false,
                    'required' => false,
                ]
            )
            ->add('submit', 'submit', ['label' => 'Сохранить настройки'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($subscribedUser);
            $em->flush();
            return $this->render(':EmailSubscription:success.html.twig', [
                'message' => 'Настройки успешно изменены. Будьте всегда в курсе событий!'
            ]);
        }

        return $this->render(':EmailSubscription:manage.html.twig', [
            'subscribed_user' => $subscribedUser,
            'errors' => $form->getErrors(true),
            'form' => $form->createView(),
        ]);
    }
}
