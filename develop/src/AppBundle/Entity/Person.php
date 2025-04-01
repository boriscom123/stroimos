<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodTrait;
use Amg\DataCore\Model\Searchable\SearchableTrait;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use Amg\DataCore\Model\Timestampable\TimestampableInterface;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\MediaImageInterface;
use AppBundle\Model\Person\PersonFullNameTrait;
use AppBundle\Model\PriorityPosition\PriorityPositionInterface;
use AppBundle\Model\PriorityPosition\PriorityPositionTrait;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PersonRepository")
 */
class Person implements
    TeasingInterface,
    PublishableInterface,
    PublishingPeriodInterface,
    TimestampableInterface,
    PriorityPositionInterface,
    MediaImageInterface
{
    use PersonFullNameTrait,
        TeasingTrait,
        ImageTrait,
        PublishableTrait,
        PublishingPeriodTrait,
        SearchableTrait,
        PriorityPositionTrait,
        TimestampableTrait;

    /**
     * @var Media
     *
     * @Assert\Expression(
     *     "this.getPriorityPosition() != 1 or this.getTopImage()",
     *     message="Требуется заполнить для первого в списке"
     * )
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $topImage;
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $biography;
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $education;
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $experience;
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $awards;
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $family;
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $notes;
    /**
     * @var Organization
     *
     * @ORM\OneToOne(targetEntity="Organization")
     */
    protected $lowerOrganization;
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default": false})
     */
    protected $showInStructure = false;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $shortPost;
    /**
     * @var array
     *
     * @ORM\Column(type="json",  nullable=true)
     */
    protected $socialAccountUrls = [];
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct()
    {
        $this->publishStartDate = new \DateTime();
    }

    public function getProfileFieldsList()
    {
        static $profileFields = [
            'biography',
            'education',
            'experience',
            'awards',
            'family',
        ];

        $notEmptyFields = [];
        foreach ($profileFields as $profileFieldName) {
            if (!empty($this->$profileFieldName)) {
                $notEmptyFields[] = $profileFieldName;
            }
        }

        return $notEmptyFields;
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
     * @return Media
     */
    public function getTopImage()
    {
        return $this->topImage;
    }

    /**
     * @param Media $topImage
     * @return $this
     */
    public function setTopImage($topImage)
    {
        $this->topImage = $topImage;

        return $this;
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

    /**
     * @return string
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @param string $education
     * @return $this
     */
    public function setEducation($education)
    {
        $this->education = $education;

        return $this;
    }

    /**
     * @return string
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @param string $experience
     * @return $this
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * @return string
     */
    public function getAwards()
    {
        return $this->awards;
    }

    /**
     * @param string $awards
     * @return $this
     */
    public function setAwards($awards)
    {
        $this->awards = $awards;

        return $this;
    }

    /**
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param string $family
     * @return $this
     */
    public function setFamily($family)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     * @return $this
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return Organization
     */
    public function getLowerOrganization()
    {
        return $this->lowerOrganization;
    }

    /**
     * @param Organization $lowerOrganization
     *
     * @return Person
     */
    public function setLowerOrganization($lowerOrganization)
    {
        $this->lowerOrganization = $lowerOrganization;

        return $this;
    }

    /**
     * @return bool
     */
    public function isShowInStructure()
    {
        return $this->showInStructure;
    }

    /**
     * @param bool $showInStructure
     * @return $this
     */
    public function setShowInStructure($showInStructure)
    {
        $this->showInStructure = $showInStructure;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortPost()
    {
        return $this->shortPost;
    }

    /**
     * @param string $shortPost
     */
    public function setShortPost($shortPost)
    {
        $this->shortPost = $shortPost;
    }

    public function __toString()
    {
        return $this->getFullName() ?: '(неназванная персона)';
    }

    /**
     * @return array
     */
    public function getSocialAccountUrls()
    {
        return $this->socialAccountUrls;
    }

    /**
     * @param array $socialAccountUrls
     */
    public function setSocialAccountUrls(array $socialAccountUrls)
    {
        $this->socialAccountUrls = $socialAccountUrls;
    }

    /**
     * @param string $socialnetKey
     * @return null
     */
    public function findSocialAccountUrl($socialnetKey)
    {
        return $this->socialAccountUrls[$socialnetKey] ?: null;
    }
}
