<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ContactPerson;
use AppBundle\Entity\Organization;
use AppBundle\Entity\OrganizationDirectory;
use AppBundle\Model\ValueObject\PersonName;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadOrganizationData extends AbstractFixture
{
    const DATA_PATH = '/../data/organizations';
    const REFBASE_ORGDIR = 'organization-directory-';
    const REFBASE_ORG = 'organization-';
    const REFBASE_PERSON = 'contact-person-';

    /** @var ObjectManager */
    private $_manager;

    public function load(ObjectManager $manager)
    {
        $this->_manager = $manager;

        // все опубликованные персоны ссылаются на организации
        // множество персон может ссылаться на одну организацию — эти персоны гарантированно являются рядовыми членами организации, но также могут являться и её руководителями

        // организации либо ссылаются на персону-руководителя напрямую, либо хранят информацию о нём в текстовом виде
        // некоторые организации не имеют информации о руководителе

        $this->processFile('st_organization_category', [$this, 'createOrgCategory']);
        $this->processFile('st_organization', [$this, 'createOrganization']);
        $this->processFile('st_organization_personality', [$this, 'createContactPerson']); // link person as regular member
        $this->processFile('st_organization', [$this, 'setAssociations']); // link person as director, create if necessary, link parent organization

        $manager->flush();
    }

    private function processFile($basename, callable $rowCallback)
    {
        $filename = sprintf('%s/%s.csv', __DIR__ . self::DATA_PATH, $basename);
        $file = fopen($filename, 'r');
        if (false === $file) {
            throw new \RuntimeException(sprintf('Could not open %s for reading', $filename));
        }

        $headers = [];
        $first = true;
        while (!feof($file)) {
            $row = fgetcsv($file);

            if ($first) {
                $headers = $row;
                $first = false;
                continue;
            }

            $row = array_combine($headers, $row);
            $row = array_map(function ($v) {
                return 'NULL' === $v ? null : htmlspecialchars_decode($v, ENT_QUOTES);
            }, $row);

            $rowCallback($row);
        }

        fclose($file);
    }

    private function createOrgCategory($row)
    {
        $orgDir = new OrganizationDirectory();
        $orgDir->setId($row['id']);
        $orgDir->setTitle($row['name']);
        $orgDir->setPublishable($row['is_published']);
        $orgDir->setCreatedAt(new \DateTime($row['created_at']));
        $orgDir->setUpdatedAt(new \DateTime($row['updated_at']));
        // todo: Handle $row['priority']?

        $this->_manager->persist($orgDir);

        $this->setReference(self::REFBASE_ORGDIR . $orgDir->getId(), $orgDir);
    }

    private function createOrganization($row)
    {
        $organization = new Organization();
        $organization->setId($row['id']);
        $organization->setTitle($row['name']);
        $organization->setFullTitle($row['full_name']);

        if (!empty($row['address'])) {
            $organization->setActualAddress($row['address']);
        }

        if (!empty($row['legal_address'])) {
            $organization->setLegalAddress($row['legal_address']);
        }

        if (!empty($row['email'])) {
            $organization->setEmail($row['email']);
        }

        if (!empty($row['phone'])) {
            $organization->setPhone($row['phone']);
        }

        if (!empty($row['fax'])) {
            $organization->setFax($row['fax']);
        }

        if (!empty($row['site'])) {
            $organization->setWebsite($row['site']);
        }

        if (!empty($row['organization_rights_form'])) {
            $organization->setCompanyType($row['organization_rights_form']);
        }

        $organization->setPublishable($row['is_published']);

        // todo: sr_organization_category_id — ?????????
        // todo: Slug?
        // todo: priority?

        $organization->setCreatedAt(new \DateTime($row['created_at']));
        $organization->setUpdatedAt(new \DateTime($row['updated_at']));

        $this->setReference(self::REFBASE_ORG . $organization->getId(), $organization);

        $this->_manager->persist($organization);
    }

    private function createContactPerson($row)
    {
        // omit unpublished
        if (empty($row['is_published'])) {
            return;
        }

        // check for link to organization
        if (empty($row['organization_id'])) {
            throw new \LogicException('Every contact person supposed to be linked to an organization');
        }

        $contactPerson = new ContactPerson();
        $contactPerson->setId($row['id']);
        $contactPerson->setFirstName($row['name']);
        $contactPerson->setLastName($row['surname']);

        if (!empty($row['patronymic'])) {
            $contactPerson->setPatronymic($row['patronymic']);
        }

        if (!empty($row['post'])) {
            $contactPerson->setAppointment($row['post']);
        }

        if (!empty($row['email'])) {
            $contactPerson->setEmail($row['email']);
        }

        if (!empty($row['phone'])) {
            $contactPerson->setPhone($row['phone']);
        }

        if (!empty($row['fax'])) {
            $contactPerson->setFax($row['fax']);
        }

        $contactPerson->setPublishable($row['is_published']);
        // priority?
        // slug?

        $contactPerson->setCreatedAt(new \DateTime($row['created_at']));
        $contactPerson->setUpdatedAt(new \DateTime($row['updated_at']));

        $this->_manager->persist($contactPerson);

        $this->setReference(self::REFBASE_PERSON . $contactPerson->getId(), $contactPerson);

        // add person as regular member
        $organizationRef = self::REFBASE_ORG . $row['organization_id'];
        /** @var Organization $organization */
        $organization = $this->getReference($organizationRef);
        $contactPerson->setOrganization($organization);

        $this->_manager->flush();
    }

    private function setAssociations($row)
    {
        /** @var Organization $organization */
        $organization = $this->getReference(self::REFBASE_ORG . $row['id']);

        // link category
        if (!empty($row['organization_category_id'])) {
            $ordDirRef = self::REFBASE_ORGDIR . $row['organization_category_id'];
            $organization->setOrganizationDirectory($this->getReference($ordDirRef));
        }

        // link upstanding organization
        if (!empty($row['upstanding_organization_id'])) {
            $upstandingOrgRef = self::REFBASE_ORG . $row['upstanding_organization_id'];
            $organization->setHeadOrganization($this->getReference($upstandingOrgRef));
        }

        // link director
        if (!empty($row['director_id'])) {
            $contactPersonRef = self::REFBASE_PERSON . $row['director_id'];
            /** @var ContactPerson $contactPerson */
            if ($this->hasReference($contactPersonRef)) {
                $contactPerson = $this->getReference($contactPersonRef);

                $organization->setHead($contactPerson);
                $contactPerson->setOrganization($organization);
            }
        } elseif (!empty($row['director'])) {
            $personName = PersonName::createFromFIO($row['director']);
            $fio = $personName->getFIO();

            $contactPerson = new ContactPerson();

            $contactPerson->setFirstName($personName->getName());
            $contactPerson->setLastName($personName->getSurname());
            $contactPerson->setPatronymic($personName->getPatronymic());

            if (!empty($row['director_post'])) {
                $contactPerson->setAppointment($row['director_post']);
            }

            $contactPerson->setPublishable(false); // as on old site

            $contactPerson->setOrganization($organization);
            $organization->setHead($contactPerson);

            $this->_manager->persist($contactPerson);
        }
    }
}
