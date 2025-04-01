<?php

namespace AppBundle\Entity;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * AuthenticationAttempt
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ActionLog
{
    const ACTION_LOGIN  = 1;
    const ACTION_LOGOUT = 2;
    const ACTION_CREATE = 3;
    const ACTION_UPDATE = 4;
    const ACTION_DELETE = 5;
    const ACTION_LOGIN_FAIL  = 6;

    public static $actionsLabels = array(
        ActionLog::ACTION_LOGIN => 'вход',
        ActionLog::ACTION_LOGOUT => 'выход',
        ActionLog::ACTION_CREATE => 'создание',
        ActionLog::ACTION_UPDATE => 'изменение',
        ActionLog::ACTION_DELETE => 'удаление',
        ActionLog::ACTION_LOGIN_FAIL => 'попытка входа',
    );

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="action", type="smallint")
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=true)
     */
    private $message = '';

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $ip = '';

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=254, nullable=true)
     */
    protected $module;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=254, nullable=true)
     */
    protected $url;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return AuthenticationAttempt
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return ActionLog
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return ActionLog
     */
    public function setMessage($message)
    {
        $this->message = $message;

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
    public function setUser(User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     * @return $this
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        if (self::ACTION_LOGIN_FAIL == $this->getAction()) {
            return $this->getUsername();
        }

        return $this->getUrl()
            ? "<a href='{$this->getUrl()}'>{$this->title}</a> "
            : $this->title;
    }

    /**
     * @param mixed $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}