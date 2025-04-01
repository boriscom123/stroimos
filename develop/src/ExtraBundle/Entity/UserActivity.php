<?php

namespace ExtraBundle\Entity;

use Amg\Bundle\TagBundle\Entity\Tag;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Entity\Rubric;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserActivity
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UserActivity
{
    use TimestampableTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $anonUid;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $route;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $routeParams;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $viewedClass;
    /**
     *
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $viewedId;

    /**
     * @var array
     *
     * @ORM\Column(name="rubricsAggregation", type="array")
     */
    private $rubricsAggregation = [];

    /**
     * @var array
     *
     * @ORM\Column(name="tagsAggregation", type="array")
     */
    private $tagsAggregation = [];

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $query;

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
     * @return string
     */
    public function getAnonUid()
    {
        return $this->anonUid;
    }

    /**
     * @param string $anonUid
     * @return $this
     */
    public function setAnonUid($anonUid)
    {
        $this->anonUid = $anonUid;
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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return $this
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return array
     */
    public function getRouteParams()
    {
        return $this->routeParams;
    }

    /**
     * @param array $routeParams
     * @return $this
     */
    public function setRouteParams($routeParams)
    {
        $this->routeParams = $routeParams;
        return $this;
    }

    /**
     * @return string
     */
    public function getViewedClass()
    {
        return $this->viewedClass;
    }

    /**
     * @param string $viewedClass
     * @return $this
     */
    public function setViewedClass($viewedClass)
    {
        $this->viewedClass = $viewedClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getViewedId()
    {
        return $this->viewedId;
    }

    /**
     * @param string $viewedId
     * @return $this
     */
    public function setViewedId($viewedId)
    {
        $this->viewedId = $viewedId;
        return $this;
    }

    /**
     * Set rubricsAggregation
     *
     * @param array $rubricsAggregation
     *
     * @return UserActivityProfile
     */
    public function setRubricsAggregation($rubricsAggregation)
    {
        $this->rubricsAggregation = $rubricsAggregation;

        return $this;
    }

    /**
     * Get rubricsAggregation
     *
     * @return array
     */
    public function getRubricsAggregation()
    {
        return $this->rubricsAggregation;
    }

    /**
     * Set tagsAggregation
     *
     * @param array $tagsAggregation
     *
     * @return UserActivityProfile
     */
    public function setTagsAggregation($tagsAggregation)
    {
        $this->tagsAggregation = $tagsAggregation;

        return $this;
    }

    /**
     * Get tagsAggregation
     *
     * @return array
     */
    public function getTagsAggregation()
    {
        return $this->tagsAggregation;
    }

    public function addRubricView(Rubric $rubric)
    {
        $this->rubricsAggregation[$rubric->getId()] = $rubric->getTitle();
    }

    public function addTagView(Tag $tag)
    {
        $this->tagsAggregation[$tag->getId()] = $tag->getTitle();
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }
}

