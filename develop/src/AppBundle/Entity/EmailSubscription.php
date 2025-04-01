<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class EmailSubscription
{
    use TimestampableTrait;

    const HASH_SALT = 'vi7ucWFM';

    static public $publicationsTypeMapedByEntity = array(
        'posts' => 'Новости',
        'infographics' => 'Инфографика',
        'galleries' => 'Галереи',
        'videos' => 'Видео',
        'documents' => 'Документы',
    );

    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Поле не может быть пустым")
     * @Assert\Email(message="Указан невалидный электронный адрес")
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $hash;

    /**
     * @var string
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $contentHash;

    /**
     * @var integer
     * @ORM\Column(type="boolean")
     */
    private $confirmed = false;

    /**
     * @var AdministrativeUnit[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\AdministrativeUnit")
     * @ORM\JoinTable(name="email_subscription_administrative_unit")
     */
    private $administrativeUnits;


    /**
     * @var array
     * @ORM\Column(type="simple_array")
     */
    private $publicationsType;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->administrativeUnits = new ArrayCollection();
        $this->publicationsType = array_keys(self::$publicationsTypeMapedByEntity);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return EmailSubscription
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return EmailSubscription
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     *
     * @return EmailSubscription
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return int
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @param int $confirmed
     *
     * @return EmailSubscription
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function __toString()
    {
        return $this->getEmail() ?: '(email не задан)';
    }

    /**
     * @ORM\PrePersist
     */
    public function ensureHashPresent()
    {
        if (null === $this->hash) {
            $this->hash = $this->generateHash($this->getEmail());
        }
    }

    private function generateHash($email)
    {
        return md5(self::HASH_SALT . time() . $email);
    }

    public function getContentHash()
    {
        if ($this->contentHash) {
            return $this->contentHash;
        }

        return $this->generateContentHash();
    }

    /**
     * @ORM\PreUpdate
     */
    public function generateContentHash()
    {
        $publicationTypes = $this->getPublicationsType();
        $administrativeUnitIds = $this->getAdministrativeUnits()
            ->map(
                static function (AdministrativeUnit $obj) {
                    return $obj->getId();
                }
            )->getValues();
        sort($publicationTypes);
        sort($administrativeUnitIds);

        $this->contentHash = md5(
            self::HASH_SALT.time().implode('', $publicationTypes).implode('', $administrativeUnitIds)
        );

        return $this->contentHash;
    }

    /**
     * @return array
     */
    public function getPublicationsType()
    {
        return $this->publicationsType;
    }

    /**
     * @param array $publicationsType
     */
    public function setPublicationsType($publicationsType)
    {
        $this->publicationsType = $publicationsType;
    }

     /**
     * @param AdministrativeUnit[] $administrativeUnits
     */
    public function setAdministrativeUnits($administrativeUnits)
    {
        $this->administrativeUnits = $administrativeUnits;
    }

    /**
     * @return PersistentCollection
     */
    public function getAdministrativeUnits()
    {
        return $this->administrativeUnits;
    }

}
