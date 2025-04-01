<?php
namespace AppBundle\Security;

use AppBundle\Entity\ActionLog;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class AuthenticationLogger
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function failure($ip, $username, $message = null)
    {
        $attempt = new ActionLog();
        $attempt->setAction(ActionLog::ACTION_LOGIN_FAIL);
        $attempt->setUsername($username);
        if ($message) {
            $attempt->setMessage($message);
        }
        $attempt->setIp($ip);

        $this->saveAttempt($attempt);
    }

    public function success($ip, User $user)
    {
        $attempt = new ActionLog();
        $attempt->setAction(ActionLog::ACTION_LOGIN);
        $attempt->setUsername($user->getUsername());
        $attempt->setUser($user);
        $attempt->setIp($ip);

        $this->saveAttempt($attempt);
    }

    public function logout($ip, User $user)
    {
        $attempt = new ActionLog();
        $attempt->setAction(ActionLog::ACTION_LOGOUT);
        $attempt->setUsername($user->getUsername());
        $attempt->setUser($user);
        $attempt->setIp($ip);

        $this->saveAttempt($attempt);
    }

    protected function saveAttempt(ActionLog $attempt)
    {
        $attempt->setDate(new \DateTime());
        $attempt->setModule('Авторизация');

        $this->entityManager->persist($attempt);
        $this->entityManager->flush($attempt);
    }
}