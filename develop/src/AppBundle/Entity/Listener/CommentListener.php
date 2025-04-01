<?php
namespace AppBundle\Entity\Listener;

use Amg\DataCore\ValueObject\EntityReference;
use Application\FOS\CommentBundle\Entity\Comment;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class CommentListener
{
    use ContainerAwareTrait;

    public function prePersist(Comment $comment/*, LifecycleEventArgs $event*/)
    {
        $author = $this->container->get('security.token_storage')->getToken()->getUser();

        if ($author) {
            $comment->setAuthor($author);
        }
    }

    public function postPersist(Comment $comment/*, LifecycleEventArgs $event*/)
    {
        $entityReference = EntityReference::createFromString($comment->getThread()->getId());
        $doctrine = $this->container->get('doctrine');
        $publication = $doctrine->getRepository($entityReference->getClass())->find($entityReference->getId());

        $usersToBeNotifiedOfNewComment = $this->container->get('fos_user.user_manager')->findUsersBy([
            'enabled' => true,
            'receivesNewCommentNotifications' => true,
        ]);

        if ($usersToBeNotifiedOfNewComment) {
            $emailManager = $this->container->get('app.email_manager');

            foreach ($usersToBeNotifiedOfNewComment as $user) {
                $emailManager->sendNewCommentNotification($comment, $publication, $user);
            }
        }
    }
}
