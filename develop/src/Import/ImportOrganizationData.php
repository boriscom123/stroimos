<?php
namespace Import;

use AppBundle\Entity\ContactPerson;
use AppBundle\Entity\Organization;
use AppBundle\Entity\OrganizationDirectory;
use AppBundle\Model\ValueObject\PersonName;

class ImportOrganizationData extends BaseImport
{
    protected $canBeSkipped = true;

    const REFBASE_ORGDIR = 'organization-directory-';
    const REFBASE_ORG = 'organization-';
    const REFBASE_PERSON = 'contact-person-';

    public function doLoad()
    {
        // все опубликованные персоны ссылаются на организации
        // множество персон может ссылаться на одну организацию — эти персоны гарантированно являются рядовыми членами организации, но также могут являться и её руководителями

        // организации либо ссылаются на персону-руководителя напрямую, либо хранят информацию о нём в текстовом виде
        // некоторые организации не имеют информации о руководителе

        $this->processFile('organization_category', [$this, 'createOrgCategory']);
        $this->processFile('organization', [$this, 'createOrganization']);
        $this->processFile('organization_personality', [$this, 'createContactPerson']); // link person as regular member
        $this->processFile('organization', [$this, 'setAssociations']); // link person as director, create if necessary, link parent organization

        $this->manager->flush();
        $this->manager->clear();
    }

    private function processFile($mainTable, callable $rowCallback)
    {
        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from("st_{$mainTable}", "main")
            ->orderBy('main.id', 'ASC');

        $totalCount = $this->getSource()->getCountByQueryBuilder($query);

        $progressBar = $this->createProgressBar($totalCount);

        $i = 0;
        $flushStep = 100;
        $this->getConsoleOutput()->writeln($mainTable);
        foreach ($query->execute() as $sourceRow) {
            $rowCallback($sourceRow);

            if (++$i % $flushStep == 0) {
                $this->manager->flush();
                $this->manager->clear();
            }
            $progressBar->advance();
        }
        $this->getConsoleOutput()->writeln('');
        $this->manager->flush();
        $this->manager->clear();
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

        $this->manager->persist($orgDir);

        $this->addRedirect("/organizations?category=" . $row['id'], $orgDir);

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

        $this->addRedirect("/organizations/all/" . $row['slug'], $organization);

        $this->manager->persist($organization);
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

        $this->setReference(self::REFBASE_PERSON . $contactPerson->getId(), $contactPerson);

        // add person as regular member
        $organizationRef = self::REFBASE_ORG . $row['organization_id'];
        /** @var Organization $organization */
        $organization = $this->getReference($organizationRef);
        $contactPerson->setOrganization($organization);

        $this->addRedirect("/organization-personality/" . $row['slug'], $contactPerson);

        $this->manager->persist($contactPerson);
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

            $this->manager->persist($contactPerson);
        }
    }
}
