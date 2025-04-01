<?php
namespace Import;

use Application\Sonata\UserBundle\Entity\Group;
use Application\Sonata\UserBundle\Entity\User;

class ImportUserData extends BaseImport
{
    protected $groupsById = [];

    protected $userManager;

    public function doLoad()
    {
        $this->userManager = $this->container->get('fos_user.user_manager');

        $this->loadPredefinedGroups();
        $this->importGroups();
        $this->importUsers();

        $user = $this->userManager->create();

        $user->setUsername('superadmin');
        $user->setEmail('super@admin.local');
        $user->setPlainPassword('superadmin');
        $user->addRole('ROLE_SUPER_ADMIN');
        $user->setEnabled(true);

        $this->userManager->save($user);
    }

    protected function loadPredefinedGroups() {

        $groupVipJournalists = new Group('VIP-пул журналистов', ['ROLE_VIP_JOURNALIST']);
        $this->manager->persist($groupVipJournalists);

        $groupRegularJournalists = new Group('Пул журналистов', ['ROLE_JOURNALIST']);
        $this->manager->persist($groupRegularJournalists);

        $this->setReference('group-journalist', $groupVipJournalists);
        $this->setReference('group-journalist-vip', $groupRegularJournalists);
    }

    protected function importGroups()
    {
        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from('st_group');

        foreach ($query->execute() as $groupRow) {
            $group = new Group($groupRow['name']);
            $this->manager->persist($group);

            $this->groupsById[$groupRow['id']] = $group;
        }
    }

    protected function importUsers()
    {
        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from('st_user');

        foreach ($query->execute() as $userRow) {
            /** @var User $user */
            $user = $this->userManager->create();
            $user->setUsername($userRow['username']);
            $user->setEmail($userRow['username']);
            $user->setPlainPassword($userRow['username'] . $userRow['username']);
            $user->setEnabled($userRow['is_active']);

            $user->setFirstname($userRow['display_name']);

            $user->setPhone($userRow['phone']);
            $user->setBiography($userRow['media_name']);

            if (empty($userRow['is_journalis'])) {
                $user->setGroups($this->getUserGroups($userRow['id']));
            } else {
                $user->addGroup($this->getReference('group-journalist'));
            }

            $this->userManager->save($user);
        }
    }

    protected function getUserGroups($userId)
    {
        $groupIds = $this->getSourceDb()->createQueryBuilder()
            ->select('group_id')
            ->from('st_user_group')
            ->where('user_id = :user_id')
            ->setParameter('user_id', $userId)
            ->execute()
            ->fetchAll(\PDO::FETCH_COLUMN);

        return array_intersect_key($this->groupsById, array_flip($groupIds));
    }
}