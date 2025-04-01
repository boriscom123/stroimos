<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\UserRole;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadUserRoleData implements FixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function load(ObjectManager $manager)
    {
        $roles = $this->getAllRoles();

        foreach ($roles as $code) {
            $userRole = new UserRole();
            $userRole->setCode($code);

            $manager->persist($userRole);
        }

        $manager->flush();
    }

    private function getAllRoles()
    {
        $allSonataRoles = ['ROLE_ADMIN'];

        foreach ($this->container->get('sonata.admin.pool')->getAdminServiceIds() as $id) {
            try {
                $admin = $this->container->get('sonata.admin.pool')->getInstance($id);
            } catch (\Exception $e) {
                continue;
            }

            $securityHandler = $admin->getSecurityHandler();
            $baseRole = $securityHandler->getBaseRole($admin);

            foreach ($admin->getSecurityInformation() as $role => $permissions) {
                $allSonataRoles[] = sprintf($baseRole, $role);
            }
        }

        return $allSonataRoles;
    }
}
