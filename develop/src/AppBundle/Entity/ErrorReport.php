<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * ErrorReport
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ErrorReport
{
    const STATUS_NEW = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_CLOSED = 3;

    const CATEGORY_MISTYPE = 1;
    const CATEGORY_INFORMATION = 2;
    const CATEGORY_ERROR = 3;
    const CATEGORY_FEEDBACK = 4;

    public static $statusList = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_IN_PROGRESS => 'В работе',
        self::STATUS_CLOSED => 'Закрыто',
    ];

    public static $categoryList = [
        self::CATEGORY_MISTYPE => 'Ошибка в тексте',
        self::CATEGORY_INFORMATION => 'Ошибка в информации на сайте',
        self::CATEGORY_ERROR => 'Ошибка в работе сайта',
        self::CATEGORY_FEEDBACK => 'Сообщение для редакции',
    ];

    use TimestampableTrait,
        ORMBehaviors\Blameable\Blameable;

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
     * @ORM\Column(name="fullName", type="string", length=255, nullable=true)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=70, nullable=true)
     */
    private $email;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="category", type="smallint")
     */
    private $category = self::CATEGORY_MISTYPE;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=2048)
     */
    private $message;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status = self::STATUS_NEW;

    private $captcha = null;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $hpsmId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $referrer;

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
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return ErrorReport
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return ErrorReport
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get category
     *
     * @return integer
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function getCategoryName()
    {
        return self::$categoryList[$this->getCategory()];
    }

    /**
     * Set category
     *
     * @param integer $category
     *
     * @return ErrorReport
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return ErrorReport
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return ErrorReport
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function __toString()
    {
        return mb_substr($this->getMessage(), 0, 40, 'utf-8') . '...';
    }

    /**
     * @return string
     */
    public function getHpsmId()
    {
        return $this->hpsmId;
    }

    /**
     * @param string $hpsmId
     * @return $this
     */
    public function setHpsmId($hpsmId)
    {
        $this->hpsmId = $hpsmId;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * @param string $referrer
     */
    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;
    }

    /**
     * @return mixed
     */
    public function getCaptcha()
    {
        return $this->captcha;
    }

    /**
     * @param mixed $captcha
     */
    public function setCaptcha($captcha)
    {
        $this->captcha = $captcha;
    }
}

