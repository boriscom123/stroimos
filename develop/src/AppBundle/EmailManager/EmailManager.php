<?php
namespace AppBundle\EmailManager;

use AppBundle\Entity\Construction;
use AppBundle\Entity\EmailSubscription;
use AppBundle\Entity\ErrorReport;
use AppBundle\Entity\Newsletter;
use Application\FOS\CommentBundle\Entity\Comment;
use Application\Sonata\UserBundle\Entity\User;
use ExtraBundle\Entity\EventAnnounce;
use Symfony\Bridge\Twig\TwigEngine;

class EmailManager
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var TwigEngine
     */
    private $twig;

    /**
     * @var string
     */
    private $canonicalTitle;

    private $senderAddress;
    private $senderName;

    /**
     * EmailManager constructor.
     *
     * @param TwigEngine $twig
     * @param \Swift_Mailer $mailer
     * @param string $canonicalTitle
     * @param string $senderAddress
     * @param string $senderName
     */
    public function __construct(TwigEngine $twig, \Swift_Mailer $mailer, $canonicalTitle, $senderAddress, $senderName)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->canonicalTitle = $canonicalTitle;
        $this->senderAddress = $senderAddress;
        $this->senderName = $senderName;
    }

    /**
     * @return \Swift_Message
     */
    protected function createMessage()
    {
        return \Swift_Message::newInstance()
            ->setFrom($this->senderAddress, $this->senderName);
    }

    public function sendConfirmationRequest(EmailSubscription $subscribingUser)
    {
        $body = $this->twig->render(':Emails:email_subscription_confirmation.html.twig', [
            'subscribed_user' => $subscribingUser,
        ]);

        $message = $this->createMessage()
            ->setTo($subscribingUser->getEmail())
            ->setSubject(sprintf('%s: Подписка на автоматическую рассылку', $this->canonicalTitle))
            ->setBody($body, 'text/html', 'UTF-8');

        $this->mailer->send($message);
    }

    public function sendNewsletter(Newsletter $newsletter, EmailSubscription $subscribedUser)
    {
        $body = $this->twig->render(':Emails:newsletter.html.twig', [
            'content' => $newsletter,
            'subscribed_user' => $subscribedUser,
        ]);

        $subject = $newsletter->getSubject() ?: sprintf('%s: Новостная рассылка', $this->canonicalTitle);
        $this->sendNewsletterPreRendered($body, $subscribedUser->getEmail(), $subject);
    }

    public function sendNewsletterPreRendered($body, $email, $subject)
    {
        $message = $this->createMessage()
            ->setSubject($subject)
            ->setTo($email)
            ->setBody($body, 'text/html', 'UTF-8');

        file_put_contents('/tmp/'.$email, $body);

        $this->mailer->send($message);
    }

    public function sendNewCommentNotification(Comment $comment, $publication, User $moderator)
    {
        $body = $this->twig->render(':Emails:new_comment_notification.html.twig', [
            'comment' => $comment,
            'publication' => $publication,
        ]);

        $message = $this->createMessage()
            ->setSubject(sprintf('%s: Уведомление о размещении комментария', $this->canonicalTitle))
            ->setTo($moderator->getEmailCanonical())
            ->setBody($body, 'text/html', 'UTF-8');

        $this->mailer->send($message);
    }

    public function sendConstructionCreatedNotification(Construction $construction, User $userToBeNotified)
    {
        $body = $this->twig->render(':Emails:construction_created_notification.html.twig', [
            'construction' => $construction,
        ]);

        $message = $this->createMessage()
            ->setSubject(sprintf('%s: Уведомление о появлении нового объекта строительства', $this->canonicalTitle))
            ->setTo($userToBeNotified->getEmailCanonical())
            ->setBody($body, 'text/html', 'UTF-8');

        $this->mailer->send($message);
    }

    public function sendConstructionUpdatedNotification(Construction $construction, User $userToBeNotified, $changeSet)
    {
        $body = $this->twig->render(':Emails:construction_updated_notification.html.twig', [
            'construction' => $construction,
            'changeSet' => $changeSet,
        ]);

        $message = $this->createMessage()
            ->setSubject(sprintf('%s: Уведомление об обновлении информации об объекте строительства', $this->canonicalTitle))
            ->setTo($userToBeNotified->getEmailCanonical())
            ->setBody($body, 'text/html', 'UTF-8');

        $this->mailer->send($message);
    }

    //todo: disabled extra features
//    public function sendEventAnnounce(EventAnnounce $announce, User $user)
//    {
//        $body = $this->twig->render('ExtraBundle:Emails:event_announce.html.twig', [
//            'announce' => $announce,
//            'user' => $user,
//        ]);
//
//        $message = $this->createMessage()
//            ->setSubject($announce->getTitle())
//            ->setTo($user->getEmailCanonical())
//            ->setBody($body, 'text/html', 'UTF-8');
//
//        $this->mailer->send($message);
//    }

    public function sendErrorReport(ErrorReport $errorReport,User $user)
    {
        $body = $this->twig->render(':Emails:error_report_notification.html.twig', [
            'errorReport' => $errorReport
        ]);

        $message = $this->createMessage()
            ->setSubject(ErrorReport::$categoryList[$errorReport->getCategory()])
            ->setTo($user->getEmailCanonical())
            ->setBody($body, 'text/html', 'UTF-8');

        $this->mailer->send($message);
    }
}
