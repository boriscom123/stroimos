<?php
namespace AppBundle\Entity\Listener;

use AppBundle\Entity\AdministrativeUnit;
use AppBundle\Entity\Construction;
use AppBundle\Entity\Embeddable\ConstructionData;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ConstructionListener
{
    const NOTIFICATION_TYPE__NEW = 'new';
    const NOTIFICATION_TYPE__UPDATE = 'update';

    use ContainerAwareTrait;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @param \AppBundle\Entity\Construction $construction
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     */
    public function assignAdministrativeUnit(Construction $construction, LifecycleEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();

        $district = $construction->getDataField('ObjectDistrict');
        $areaAbbreviation = $construction->getDataField('ObjectArea');
        if ($district && $areaAbbreviation) {
            $cityDistrictRepository = $em->getRepository('AppBundle:CityDistrict');
            $admUnit = $cityDistrictRepository->findDistrictByTitleAndAreaAbbreviation($district, $areaAbbreviation);
        } elseif ($areaAbbreviation) {
            $administrativeAreaRepository = $em->getRepository('AppBundle:AdministrativeArea');
            $admUnit = $administrativeAreaRepository->findOneBy(['abbreviation' => $areaAbbreviation]);
        }

        if (isset($admUnit) && $admUnit instanceof AdministrativeUnit) {
            $construction->setAdministrativeUnit($admUnit);
        }
    }

    /**
     * @ORM\PostPersist
     *
     * @param \AppBundle\Entity\Construction $construction
     */
    public function postPersistHandler(Construction $construction)
    {
        $this->sendNotification(self::NOTIFICATION_TYPE__NEW, $construction);
    }

    /**
     * @ORM\PostUpdate
     *
     * @param \AppBundle\Entity\Construction $construction
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     */
    public function postUpdateHandler(Construction $construction, LifecycleEventArgs $eventArgs)
    {
        $entityChangeSet = $eventArgs->getEntityManager()->getUnitOfWork()->getEntityChangeSet($construction);

        $changeSet = [];
        foreach ($entityChangeSet as $property => $values) {
            if (!strpos($property, 'pendingData.') === 0) {
                continue;
            }

            $dataProperty = substr($property, strlen('pendingData.'));
            if (!in_array($dataProperty, ConstructionData::$versionedProperties)) {
                continue;
            }

            $oldData = $construction->getData();

            $getter = 'get' . $dataProperty;
            if (!method_exists($oldData, $getter)) {
                continue;
            }

            $oldValue = $oldData->$getter();
            if ($oldValue !== $values[1]) {
                $changeSet[$dataProperty] = [$oldValue, $values[1]];
            }
        }

        if (!empty($changeSet)) {
            $this->sendNotification(self::NOTIFICATION_TYPE__UPDATE, $construction, $changeSet);
        }
    }

    private function sendNotification($type, Construction $construction, $changeSet = null)
    {
        $usersToBeNotified = $this->container->get('fos_user.user_manager')->findUsersBy([
            'enabled' => true,
            'receivesConstructionNotifications' => true,
        ]);

        if ($usersToBeNotified) {
            $emailManager = $this->container->get('app.email_manager');

            foreach ($usersToBeNotified as $user) {
               switch ($type) {
                   case self::NOTIFICATION_TYPE__NEW:
                       $emailManager->sendConstructionCreatedNotification($construction, $user);
                       break;
                   case self::NOTIFICATION_TYPE__UPDATE:
                       $emailManager->sendConstructionUpdatedNotification($construction, $user, $changeSet);
                       break;
                   default:
                       return;
               }
            }
        }
    }
}
