<?php

namespace Application\Sonata\UserBundle\Entity;

use AppBundle\Entity\CityDistrict;
use AppBundle\Entity\Owner;
use AppBundle\Model\SingleOwner;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;

class User extends BaseUser implements SingleOwner
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $post
     */
    protected $post;

    /**
     * @var bool
     */
    protected $receivesNewCommentNotifications = false;

    /**
     * @var bool
     */
    protected $receivesConstructionNotifications = false;

    /**
     * @var bool
     */
    protected $receivesErrorReportNotifications = false;

    /**
     * @var string
     * @todo remove on user remove
     */
    protected $vkontakteUid;

    /**
     * @var string
     * @todo remove on user remove
     */
    protected $loginMosUid;

    /**
     * @var CityDistrict
     * @todo remove on user remove
     */
    protected $cityDistrict;

    /**
     * @var Owner
     */
    protected $owner;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param string $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return boolean
     */
    public function getReceivesNewCommentNotifications()
    {
        return $this->receivesNewCommentNotifications;
    }

    /**
     * @param boolean $receivesNewCommentNotifications
     *
     * @return User
     */
    public function setReceivesNewCommentNotifications($receivesNewCommentNotifications)
    {
        $this->receivesNewCommentNotifications = $receivesNewCommentNotifications;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isReceivesConstructionNotifications()
    {
        return $this->receivesConstructionNotifications;
    }

    /**
     * @param boolean $receivesConstructionNotifications
     *
     * @return User
     */
    public function setReceivesConstructionNotifications($receivesConstructionNotifications)
    {
        $this->receivesConstructionNotifications = $receivesConstructionNotifications;

        return $this;
    }

    /**
     * @return string
     */
    public function getLoginMosUid()
    {
        return $this->loginMosUid;
    }

    /**
     * @param string $loginMosUid
     * @return $this
     */
    public function setLoginMosUid($loginMosUid)
    {
        $this->loginMosUid = $loginMosUid;
        return $this;
    }

    /**
     * @return string
     */
    public function getVkontakteUid()
    {
        return $this->vkontakteUid;
    }

    /**
     * @param string $vkontakteUid
     * @return $this
     */
    public function setVkontakteUid($vkontakteUid)
    {
        $this->vkontakteUid = $vkontakteUid;
        return $this;
    }

    public function getDisplayName()
    {
        $displayUsername = trim($this->getLastname() . ' ' . $this->getFirstname());

        if (empty($displayUsername)) {
            $displayUsername = $this->getUsername();
        }

        return $displayUsername;
    }

    /**
     * @return CityDistrict
     */
    public function getCityDistrict()
    {
        return $this->cityDistrict;
    }

    /**
     * @param CityDistrict $cityDistrict
     * @return $this
     */
    public function setCityDistrict($cityDistrict)
    {
        $this->cityDistrict = $cityDistrict;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isReceivesErrorReportNotifications()
    {
        return $this->receivesErrorReportNotifications;
    }

    /**
     * @param boolean $receivesErrorReportNotifications
     */
    public function setReceivesErrorReportNotifications($receivesErrorReportNotifications)
    {
        $this->receivesErrorReportNotifications = $receivesErrorReportNotifications;
    }

    /**
     * @return Owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param Owner $owner
     * @return $this
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @param Owner $owner
     * @return bool
     */
    public function hasOwner(Owner $owner)
    {
        return $this->getOwner()->getId() === $owner->getId();
    }

    public function __toString()
    {
        return trim($this->getFullname()) ?: $this->getUsername();
    }
}
