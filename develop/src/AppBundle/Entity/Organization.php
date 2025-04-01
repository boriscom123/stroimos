<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;

use Amg\DataCore\Model\Searchable\SearchableTrait;
use AppBundle\Model\Person\ContactInformationTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * Organization
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\OrganizationRepository")
 * @ORM\Table(indexes={@ORM\Index(name="title_canonical_idx", columns={"title_canonical"})})
 */
class Organization implements
    EntitledInterface,
    PublishableInterface
{
    use EntitledTrait,
        ContentfulTrait,
        PublishableTrait,
        SearchableTrait,
        ContactInformationTrait,
        Timestampable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fullTitle", type="string", length=511)
     */
    private $fullTitle;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $companyType;

    /**
     * @var ContactPerson
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ContactPerson", inversedBy="lowerOrganizations", cascade={"persist","remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $head = null;

    /**
     * @var ContactPerson[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ContactPerson", mappedBy="organization", cascade={"persist","remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $members;

    /**
     * @var Organization[]|ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Organization", inversedBy="lowerOrganizations")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $headOrganization;

    /**
     * @var Organization[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Organization", mappedBy="headOrganization")
     */
    protected $lowerOrganizations;

    /**
     * @var OrganizationDirectory
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrganizationDirectory", cascade={"persist","remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $organizationDirectory;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $legalAddress;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $actualAddress;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $website;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $titleCanonical;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

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
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set fullTitle
     *
     * @param string $fullTitle
     *
     * @return Organization
     */
    public function setFullTitle($fullTitle)
    {
        $this->fullTitle = $fullTitle;

        return $this;
    }

    /**
     * Get fullTitle
     *
     * @return string
     */
    public function getFullTitle()
    {
        return $this->fullTitle;
    }

    /**
     * @return string
     */
    public function getCompanyType()
    {
        return $this->companyType;
    }

    /**
     * @param string $companyType
     *
     * @return Organization
     */
    public function setCompanyType($companyType)
    {
        $this->companyType = $companyType;

        return $this;
    }

    /**
     * @return ContactPerson
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @param ContactPerson $head
     *
     * @return $this
     */
    public function setHead($head)
    {
        if ($head === null && $this->head) {
            $this->head->delLowerOrganization($this);
            $this->delMember($this->head);
        }

        if ($head !== null) {
            $head->addLowerOrganization($this);
            $this->addMember($head);
        }
        $this->head = $head;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param mixed $members
     *
     * @return Organization
     */
    public function setMembers($members)
    {
        $this->members = $members;

        return $this;
    }

    public function addMember(ContactPerson $member)
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->setOrganization($this);
        }
    }

    public function delMember(ContactPerson $member)
    {
        if ($this->members->removeElement($member)) {
            $member->setOrganization(null);
        }
    }

    /**
     * @return Organization[]|ArrayCollection
     */
    public function getHeadOrganization()
    {
        return $this->headOrganization;
    }

    /**
     * @param Organization[]|ArrayCollection $headOrganization
     *
     * @return Organization
     */
    public function setHeadOrganization($headOrganization)
    {
        $this->headOrganization = $headOrganization;

        return $this;
    }

    /**
     * @return Organization[]|ArrayCollection
     */
    public function getLowerOrganizations()
    {
        return $this->lowerOrganizations;
    }

    /**
     * @param Organization[]|ArrayCollection $lowerOrganizations
     *
     * @return Organization
     */
    public function setLowerOrganizations($lowerOrganizations)
    {
        $this->lowerOrganizations = $lowerOrganizations;

        return $this;
    }

    public function addLowerOrganization(Organization $organization)
    {
        $this->lowerOrganizations->add($organization);
    }

    /**
     * @return OrganizationDirectory
     */
    public function getOrganizationDirectory()
    {
        return $this->organizationDirectory;
    }

    /**
     * @param OrganizationDirectory $organizationDirectory
     *
     * @return Organization
     */
    public function setOrganizationDirectory($organizationDirectory)
    {
        $this->organizationDirectory = $organizationDirectory;

        return $this;
    }

    /**
     * @return string
     */
    public function getActualAddress()
    {
        return $this->actualAddress;
    }

    /**
     * @param string $actualAddress
     *
     * @return $this
     */
    public function setActualAddress($actualAddress)
    {
        $this->actualAddress = $actualAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getLegalAddress()
    {
        return $this->legalAddress;
    }

    /**
     * @param string $legalAddress
     *
     * @return $this
     */
    public function setLegalAddress($legalAddress)
    {
        $this->legalAddress = $legalAddress;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     *
     * @return $this
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        $this->setTitleCanonical($title);

        return $this;
    }

    /**
     * @return string
     */
    public function getTitleCanonical()
    {
        return $this->titleCanonical;
    }

    /**
     * @param string $titleCanonical
     * @return $this
     */
    public function setTitleCanonical($titleCanonical)
    {
        $this->titleCanonical = mb_strtolower(trim(str_replace(['\'', '"', '«', '»'], '', $titleCanonical)));

        return $this;
    }

    public function __toString()
    {
        return $this->getFullTitle() ?: '(неназванная организация)';
    }
}

