<?php
namespace Application\Sonata\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findUsersByRole(array $roles, callable $filter = null)
    {
        $users = [];

        /** @var User $user */
        foreach ($this->findAll() as $user) {
            if (
                $user->isAccountNonLocked() &&
                array_intersect($roles, $user->getRoles()) &&
                (!is_callable($filter) || $filter($user))
            ) {
                $users[] = $user;
            }
        }

        return $users;
    }

    public function findUsersByReceivesErrorReportNotifications()
    {
        $qb = $this->createQueryBuilder('u');

        $qb
            ->andWhere('u.locked != 1')
            ->andWhere('u.receivesErrorReportNotifications = 1')
            ->andWhere('u.enabled = 1')
        ;

        return $qb->getQuery()->getResult();
    }
}
