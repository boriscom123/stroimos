<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Publishable\PublishableTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\MediaImageInterface;
use AppBundle\Model\Person\AppointmentTrait;
use AppBundle\Model\Person\ContactInformationTrait;
use AppBundle\Model\Person\PersonFullNameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ContactPersonRepository")
 */
class ContactPerson implements MediaImageInterface
{
    use PersonFullNameTrait,
        AppointmentTrait,
        ContactInformationTrait,
        PublishableTrait,
        Timestampable,
        ImageTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Organization[]|PersistentCollection|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organization", mappedBy="head", cascade={"persist","remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $lowerOrganizations;

    /**
     * @var Organization
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organization", inversedBy="members", cascade={"persist","remove"}, fetch="EAGER")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $organization;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $weight = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $biography;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ContactPerson
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Organization|false
     */
    public function getLowerOrganization()
    {
        return $this->getLowerOrganizations()->first();
    }

    /**
     * @return Organization[]|ArrayCollection
     */
    public function getLowerOrganizations()
    {
        return $this->lowerOrganizations ?: $this->lowerOrganizations = new ArrayCollection();
    }

    /**
     * @param Organization[]|ArrayCollection $organizations
     * @return $this
     */
    public function setLowerOrganizations($organizations)
    {
        $this->lowerOrganizations = $organizations;

        return $this;
    }

    /**
     * @param Organization $organization
     */
    public function addLowerOrganization(Organization $organization)
    {
        $this->getLowerOrganizations()->add($organization);
    }

    /**
     * @param Organization $organization
     */
    public function delLowerOrganization(Organization $organization)
    {
        $newOrganization = array_filter(
            $this->lowerOrganizations->toArray(),
            function (Organization $item) use ($organization) {
                return $item->getId() !== $organization->getId();
            }

        );

        $this->lowerOrganizations = empty($newOrganization)
            ? null
            : new ArrayCollection($newOrganization);
    }

    /**
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param Organization $organization
     *
     * @return ContactPerson
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;

        if ($organization === null) {
            $this->appointment = null;
        }
        return $this;
    }

    public function __toString()
    {
        return $this->getFullName() ?: '(неназванное контактное лицо)';
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
    /**
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param string $biography
     * @return $this
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }
}
