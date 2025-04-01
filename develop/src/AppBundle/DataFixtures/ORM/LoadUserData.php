<?php

namespace AppBundle\DataFixtures\ORM;

use Application\Sonata\UserBundle\Entity\Group;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;


class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $allSonataRoles = $this->getAllSonataRoles();

        /** @var \Sonata\UserBundle\Entity\UserManager $userManager */
        $userManager = $this->container->get('fos_user.user_manager');

        /** @var User $superadmin */
        $superadmin = $userManager->create();
        $superadmin->setUsername('superadmin');
        $superadmin->setPlainPassword('superadmin');
        $superadmin->setEmail('admin@gsk.local');
        $superadmin->addRole('ROLE_SUPER_ADMIN');
        $superadmin->setEnabled(true);
        $superadmin->setFirstname('Super');
        $superadmin->setLastname('Admin');
        $userManager->save($superadmin);

        $superAdminOnlyRoles = [
            'ROLE_ADMIN_CONSTRUCTION_TYPE_DELETE',
            'ROLE_SONATA_USER_ADMIN_USER_DELETE',
            'ROLE_SONATA_USER_ADMIN_USER_MASTER',
        ];
        $adminRoles = array_diff($allSonataRoles, $superAdminOnlyRoles);
        $groupAdmins = new Group('Администратор', $adminRoles);
        $manager->persist($groupAdmins);

        /** @var User $admin */
        $admin = $userManager->create();
        $admin->setUsername('admin');
        $admin->setPlainPassword('admin');
        $admin->setEmail('regularadmin@gsk.local');
        $admin->addRole('ROLE_ADMIN');
        $admin->addGroup($groupAdmins);
        $admin->setEnabled(true);
        $admin->setFirstname('Рядовой');
        $admin->setLastname('Администратор');
        $userManager->save($admin);

        $adminOnlyRoles = [
            'ROLE_SONATA_USER_ADMIN_USER_EDIT',
            'ROLE_SONATA_USER_ADMIN_USER_LIST',
            'ROLE_SONATA_USER_ADMIN_USER_CREATE',
            'ROLE_SONATA_USER_ADMIN_USER_VIEW',
            'ROLE_SONATA_USER_ADMIN_USER_DELETE',
            'ROLE_SONATA_USER_ADMIN_USER_EXPORT',
            'ROLE_SONATA_USER_ADMIN_USER_OPERATOR',
            'ROLE_SONATA_USER_ADMIN_GROUP_EDIT',
            'ROLE_SONATA_USER_ADMIN_GROUP_LIST',
            'ROLE_SONATA_USER_ADMIN_GROUP_CREATE',
            'ROLE_SONATA_USER_ADMIN_GROUP_VIEW',
            'ROLE_SONATA_USER_ADMIN_GROUP_DELETE',
            'ROLE_SONATA_USER_ADMIN_GROUP_EXPORT',
            'ROLE_SONATA_USER_ADMIN_GROUP_OPERATOR',
            'ROLE_SONATA_USER_ADMIN_GROUP_MASTER',

            'ROLE_ADMIN_MENU_NODES_EDIT',
            'ROLE_ADMIN_MENU_NODES_LIST',
            'ROLE_ADMIN_MENU_NODES_CREATE',
            'ROLE_ADMIN_MENU_NODES_VIEW',
            'ROLE_ADMIN_MENU_NODES_DELETE',
            'ROLE_ADMIN_MENU_NODES_EXPORT',
            'ROLE_ADMIN_MENU_NODES_OPERATOR',
            'ROLE_ADMIN_MENU_NODES_MASTER',
            'ROLE_ADMIN_MENU_EDIT',
            'ROLE_ADMIN_MENU_LIST',
            'ROLE_ADMIN_MENU_CREATE',
            'ROLE_ADMIN_MENU_VIEW',
            'ROLE_ADMIN_MENU_DELETE',
            'ROLE_ADMIN_MENU_EXPORT',
            'ROLE_ADMIN_MENU_OPERATOR',
            'ROLE_ADMIN_MENU_MASTER',

            'ROLE_ADMIN_USER_ROLE_CREATE',
            'ROLE_ADMIN_USER_ROLE_DELETE',
            'ROLE_ADMIN_USER_ROLE_EDIT',
            'ROLE_ADMIN_USER_ROLE_EXPORT',
            'ROLE_ADMIN_USER_ROLE_LIST',
            'ROLE_ADMIN_USER_ROLE_MASTER',
            'ROLE_ADMIN_USER_ROLE_OPERATOR',
            'ROLE_ADMIN_USER_ROLE_VIEW',
        ];
        $allNonAdminRoles = array_diff($adminRoles, $adminOnlyRoles);
        $groupRegularEditors = new Group('Главный редактор', $allNonAdminRoles);
        $manager->persist($groupRegularEditors);

        /** @var User $chiefEditor */
        $chiefEditor = $userManager->create();
        $chiefEditor->setUsername('chiefeditor');
        $chiefEditor->setPlainPassword('chiefeditor');
        $chiefEditor->setEmail('chief-editor@gsk.local');
        $chiefEditor->addGroup($groupRegularEditors);
        $chiefEditor->addRole('ROLE_ADMIN');
        $chiefEditor->setEnabled(true);
        $chiefEditor->setFirstname('Главный');
        $chiefEditor->setLastname('Редактор');
        $userManager->save($chiefEditor);

        $groupRegularEditors = new Group('Редактор', ['ROLE_SONATA_ADMIN']);
        $manager->persist($groupRegularEditors);

        /** @var User $regularEditor */
        $regularEditor = $userManager->create();
        $regularEditor->setUsername('editor');
        $regularEditor->setPlainPassword('editor');
        $regularEditor->setEmail('editor@gsk.local');
        $regularEditor->addGroup($groupRegularEditors);
        $regularEditor->addRole('ROLE_ADMIN');
        $regularEditor->setEnabled(true);
        $regularEditor->setFirstname('Рядовой');
        $regularEditor->setLastname('Редактор');
        $regularEditor->setReceivesNewCommentNotifications(true);
        $regularEditor->setReceivesConstructionNotifications(true);
        $userManager->save($regularEditor);

        $groupVipJournalists = new Group('VIP-пул журналистов', ['ROLE_VIP_JOURNALIST']);
        $manager->persist($groupVipJournalists);

        /** @var User $vipJournalist */
        $vipJournalist = $userManager->create();
        $vipJournalist->setUsername('vipjournalist');
        $vipJournalist->setPlainPassword('vipjournalist');
        $vipJournalist->setEmail('vipjournalist@gsk.local');
        $vipJournalist->addGroup($groupVipJournalists);
        $vipJournalist->addRole('ROLE_ADMIN');
        $vipJournalist->setEnabled(true);
        $vipJournalist->setFirstname('VIP');
        $vipJournalist->setLastname('Журналист');
        $userManager->save($vipJournalist);

        $groupRegularJournalists = new Group('Пул журналистов', ['ROLE_JOURNALIST']);
        $manager->persist($groupRegularJournalists);

        /** @var User $regularJournalist */
        $regularJournalist = $userManager->create();
        $regularJournalist->setUsername('journalist');
        $regularJournalist->setPlainPassword('journalist');
        $regularJournalist->setEmail('journalist@gsk.local');
        $regularJournalist->addGroup($groupRegularJournalists);
        $regularJournalist->addRole('ROLE_ADMIN');
        $regularJournalist->setEnabled(true);
        $regularJournalist->setFirstname('Рядовой');
        $regularJournalist->setLastname('Журналист');
        $userManager->save($regularJournalist);

        $this->setReference('user-super-admin', $superadmin);
        $this->setReference('journalist-1', $regularJournalist);
        $this->setReference('journalist-2', $vipJournalist);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return FixturesOrder::L1;
    }

    private function getAllSonataRoles()
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
