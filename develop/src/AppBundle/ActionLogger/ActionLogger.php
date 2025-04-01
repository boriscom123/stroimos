<?php

namespace AppBundle\ActionLogger;

use AppBundle\Entity\ActionLog;
use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ActionLogger implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function save($module, $action, $title, $url)
    {
        $securityContex = $this->container->get('security.context');
        /** @var User $user */
        $user = $securityContex->getToken()->getUser();
        $ip = $this->container->get('request_stack')->getCurrentRequest()->getClientIp();

        $em = $this->container->get('doctrine.orm.entity_manager');

        $actionLog = new ActionLog();
        $actionLog
            ->setTitle($title)
            ->setAction($action)
            ->setDate(new \DateTime())
            ->setIp($ip)
            ->setUser($user)
            ->setUsername($user->getUsername())
            ->setModule($module)
            ->setUrl($url)
        ;

        $em->persist($actionLog);
        $em->flush($actionLog);
    }
}