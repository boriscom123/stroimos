<?php
namespace ExtraBundle\Entity;

use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class EventFeedback
{
    const CATEGORY_QUESTION = 1;
    const CATEGORY_PROBLEM = 2;
    const CATEGORY_SOLVE = 3;

    public static $categoryList = [
        self::CATEGORY_QUESTION => 'Вопрос',
        self::CATEGORY_PROBLEM => 'Сообщение о проблеме',
        self::CATEGORY_SOLVE => 'Предложение решения',
    ];

    use TimestampableTrait;

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
    private $category = self::CATEGORY_QUESTION;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=2048)
     */
    private $message;

    /**
     * @var Event
     *
     * @ORM\ManyToOne(targetEntity="ExtraBundle\Entity\Event")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    protected $event;

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
     * @return EventFeedback
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
     * @return EventFeedback
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

    /**
     * Set category
     *
     * @param integer $category
     *
     * @return EventFeedback
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
     * @return EventFeedback
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     * @return $this
     */
    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
    }

    public function __toString()
    {
        return substr($this->getMessage(), 0, 20);
    }
}
