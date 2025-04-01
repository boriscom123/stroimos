<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\EmailSubscription;
use AppBundle\Entity\Newsletter;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Twig_Template;

class NewsletterCRUDController extends Controller
{
    const MESSAGE__EMPTY_NEWSLETTER = 'Пустая рассылка';

    const MESSAGE__NEWSLETTER_SENDING_STARTED = 'Отправка успешно запущена';
    const MESSAGE__NEWSLETTER_TEST = 'Отправка тестовой рассылки запущена';

    public function previewWithCustomPostsAction($id) {
        /** @var Newsletter $newsletter */
        $newsletter = $this->admin->getSubject();

        if (false === $this->admin->isGranted('EDIT', $newsletter)) {
            throw new AccessDeniedException();
        }

        if (!$newsletter) {
            throw new NotFoundHttpException(sprintf('unable to find newsletter with id : %s', $id));
        }

        if (!$newsletter->getPosts()) {
            $this->addFlash('sonata_flash_error', self::MESSAGE__EMPTY_NEWSLETTER);

            return $this->redirect($this->admin->generateUrl('list'));
        }

        return new Response($this->renderNewsletterForPreview($newsletter));
    }

    public function previewWithGeneralPostsAction($id)
    {
        /** @var Newsletter $newsletter */
        $newsletter = $this->admin->getSubject();

        if (false === $this->admin->isGranted('EDIT', $newsletter)) {
            throw new AccessDeniedException();
        }

        if (!$newsletter) {
            throw new NotFoundHttpException(sprintf('unable to find newsletter with id : %s', $id));
        }

        if (!$newsletter->getPosts()) {
            $this->addFlash('sonata_flash_error', self::MESSAGE__EMPTY_NEWSLETTER);

            return $this->redirect($this->admin->generateUrl('list'));
        }

        return new Response($this->renderNewsletterForPreview($newsletter, 'personaliseByGeneralPosts'));
    }

    public function sendAction($id)
    {
        $this->send($id);
        $this->addFlash('sonata_flash_success', self::MESSAGE__NEWSLETTER_SENDING_STARTED);

        return $this->redirect($this->admin->generateUrl('list'));
    }

    public function testAction($id)
    {
        $this->send($id, true);
        $this->addFlash('sonata_flash_success', self::MESSAGE__NEWSLETTER_TEST);

        return $this->redirect($this->admin->generateUrl('list'));
    }

    /**
     * @param $id int
     * @param $isTest bool
     */
    private function send($id, $isTest = false)
    {
        /** @var Newsletter $newsletter */
        $newsletter = $this->admin->getSubject();

        if (false === $this->admin->isGranted('EDIT', $newsletter)) {
            throw new AccessDeniedException();
        }

        if (!$newsletter) {
            throw new NotFoundHttpException(sprintf('unable to find newsletter with id : %s', $id));
        }

        if (!$newsletter->getPosts()) {
            throw new BadRequestHttpException(self::MESSAGE__EMPTY_NEWSLETTER);
        }

        if($newsletter->getStatus() !== Newsletter::STATUS_NEW) {
            throw new AccessDeniedException('Отправка рассылки уже запущена');
        }

        if(!$isTest) {
            $newsletter->setStatus(Newsletter::STATUS_IN_PROGRESS);
            $this->admin->getModelManager()->update($newsletter);
        }

        if(!$isTest && $this->getParameter('newsletter_production') == true) {
            $subscribedUsers = $this->getDoctrine()->getRepository('AppBundle:EmailSubscription')->findBy(['confirmed' => true]);
        } else {
            $subscribedUsers = $this->getDoctrine()->getRepository('AppBundle:EmailSubscription')->findBy([
                'email' => $this->getParameter('newsletter_debug_users_list')
            ]);
        }

        if ($subscribedUsers) {
            $emailManager = $this->get('app.email_manager');
            foreach ($subscribedUsers as $subscribedUser) {
                if (!empty(array_filter($subscribedUser->getPublicationsType()))) {
                    $body = $this->renderNewsletter($newsletter, $subscribedUser);
                    $subject = $newsletter->getSubject() ?: sprintf('%s: Новостная рассылка', $this->canonicalTitle);
                    $emailManager->sendNewsletterPreRendered($body, $subscribedUser->getEmail(), $subject);
                }
            }
        }

        // todo Proper status change after queue is processed?
        if(!$isTest) {
            $newsletter->setStatus(Newsletter::STATUS_SENT);
            $this->admin->getModelManager()->update($newsletter);
        }
    }

    public function renderNewsletter(Newsletter $newsletter, EmailSubscription $subscribedUser)
    {
        static $renderedNewsletterCache = [];
        $userBlocks = ['posts', 'infographics', 'galleries', 'videos', 'documents'];
        $renderBlocks = [
            'header',
            'quote',
            'highlight',
            'posts',
            'infographics',
            'galleries',
            'videos',
            'documents',
            'footer'
        ];

        $subscriptionContentHash = $subscribedUser->getContentHash();

        if (!isset($renderedNewsletterCache[$subscriptionContentHash])) {
            $personalNewsletter = $newsletter->personaliseFor($subscribedUser);

            /** @var Twig_Template $template */
            $template = $this->get('twig')->loadTemplate('Emails/newsletter.html.twig');

            $tmpNewsletterBlocks = [];
            $context = [
                'content' => $personalNewsletter,
                'request' => $this->getRequest(),
            ];
            foreach ($renderBlocks as $block) {
                $tmpNewsletterBlocks[$block] = $template->renderBlock($block, $context);
            }

            $renderedNewsletterCache[$subscriptionContentHash] = $tmpNewsletterBlocks;
        }

        $newsletterBlocks = $renderedNewsletterCache[$subscriptionContentHash];
        $newsletter = $newsletterBlocks['header'];
        $newsletter .= $newsletterBlocks['quote'];
        $newsletter .= $newsletterBlocks['highlight'];

        foreach ($userBlocks as $userBlock) {
            if (in_array($userBlock, $subscribedUser->getPublicationsType())) {
                $newsletter .= $newsletterBlocks[$userBlock];
            }
        }

        $unsubscribeUrl = $this->generateUrl(
            'email_subscription_control',
            [
                'email' => $subscribedUser->getEmail(),
                'hash' => $subscribedUser->getHash(),
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $manageSubscriptionUrl = $this->generateUrl(
            'email_subscription_manage_control',
            [
                'email' => $subscribedUser->getEmail(),
                'hash' => $subscribedUser->getHash(),
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $newsletter .= str_replace(
            ['%UNSUBSCRIBE_URL%', '%MANAGE_SUBSCRIPTION_URL%'],
            [$unsubscribeUrl, $manageSubscriptionUrl],
            $newsletterBlocks['footer']
        );

        return  $newsletter;
    }

    public function renderNewsletterForPreview(Newsletter $newsletter, $methodPersonalize  = null)
    {
        $renderBlocks = [
            'header',
            'quote',
            'highlight',
            'posts',
            'infographics',
            'galleries',
            'videos',
            'documents',
            'footer'
        ];

        $personalNewsletter = $newsletter;
        if ($methodPersonalize) {
            $personalNewsletter = $newsletter->$methodPersonalize();
        }


        /** @var Twig_Template $template */
        $template = $this->get('twig')->loadTemplate('Emails/newsletter.html.twig');

        $context = [
            'content' => $personalNewsletter,
            'request' => $this->getRequest(),
        ];

        $newsletter = '';
        foreach ($renderBlocks as $block) {
            $newsletter .= $template->renderBlock($block, $context);
        }

        return  $newsletter;
    }

    public function editAction($id = null)
    {
        return parent::editAction($id); // TODO: Change the autogenerated stub
    }
}
