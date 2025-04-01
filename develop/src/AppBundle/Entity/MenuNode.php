<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Knp\Menu\NodeInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MenuNode
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\MenuNodeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Tree(type="nested")
 */
class MenuNode implements
    NodeInterface,
    EntitledInterface,
    PublishableInterface
{
    use EntitledTrait,
        ORMBehaviors\Blameable\Blameable,
        TimestampableTrait,
        PublishableTrait;

    const LINK_TYPE_PAGE = 'page';
    const LINK_TYPE_ROUTE = 'route';
    const LINK_TYPE_URI = 'uri';
    const LINK_TYPE_NEWS = 'post';
    const LINK_TYPE_CONSTRUCTION = 'construction';
    const LINK_TYPE_STADIUM = 'stadium';

    public static $linkTypeTitles = [
        self::LINK_TYPE_PAGE => 'Страница',
        self::LINK_TYPE_ROUTE => 'Маршрут',
        self::LINK_TYPE_URI => 'Ссылка',
        self::LINK_TYPE_NEWS => 'Публикация',
        self::LINK_TYPE_CONSTRUCTION => 'Объект строительства',
//        self::LINK_TYPE_STADIUM => 'Стадион',
    ];

    public static $linkTypeFields = [
        self::LINK_TYPE_PAGE => 'page',
        self::LINK_TYPE_ROUTE => ['route', 'routeParameters'],
        self::LINK_TYPE_URI => 'uri',
        self::LINK_TYPE_NEWS => 'post',
        self::LINK_TYPE_CONSTRUCTION => 'construction',
        self::LINK_TYPE_STADIUM => 'stadium',
    ];

    public static $skipLinkTypeOption = [
        self::LINK_TYPE_ROUTE => true,
        self::LINK_TYPE_URI => true,
    ];

    /**
     * @var integer
     *
     * @Doctrine\ORM\Mapping\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[a-zA-z_0-9-]+$/",
     *     message="Поле может содержать только цифры и латинские буквы, а также знаки дефиса и подчеркивания"
     * )
     */
    private $nodeName;

    /**
     * @var integer
     *
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @var integer
     *
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @var integer
     *
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @var integer
     *
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @var MenuNode
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="MenuNode", inversedBy="children", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $parent;

    /**
     * @var MenuNode[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MenuNode", mappedBy="parent", cascade={"persist"})
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uri;

    /**
     * @var Page
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Page")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $page;

    /**
     * @var Post
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Post")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $post;

    /**
     * @var Construction
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Construction")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $construction;

    /**
     * @var Stadium
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stadium")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $stadium;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $route;

    /**
     * @var string
     *
     * @ORM\Column(type="array", nullable=true)
     */
    private $routeParameters = [];

    /**
     * @var string
     *
     * @ORM\Column(type="array")
     */
    private $extras;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->publishable = true;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }

    /**
     * @param string $nodeName
     * @return $this
     */
    public function setNodeName($nodeName)
    {
        $this->nodeName = $nodeName;
        return $this;
    }

    /**
     * @return int
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @return MenuNode
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param MenuNode $parent
     *
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return MenuNode[]|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param MenuNode[]|ArrayCollection $children
     *
     * @return $this
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return $this
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
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
     * @return string
     */
    public function getRouteParameters()
    {
        return $this->routeParameters;
    }

    /**
     * @param string $routeParameters
     * @return $this
     */
    public function setRouteParameters($routeParameters)
    {
        $this->routeParameters = $routeParameters;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * @param string $extras
     * @return $this
     */
    public function setExtras($extras)
    {
        $this->extras = $extras;
        return $this;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param Page $page
     *
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return Stadium
     */
    public function getStadium()
    {
        return $this->stadium;
    }

    /**
     * @param Stadium $stadium
     *
     * @return $this
     */
    public function setStadium($stadium)
    {
        $this->stadium = $stadium;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        if (empty($this->type)) {
            foreach (self::$linkTypeFields as $type => $field) {
                $field = (array)$field;
                $fieldName = $field[0];
                if (!empty($this->$fieldName)) {
                    return $type;
                }
            }

            return self::LINK_TYPE_URI;
        }

        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Post $post
     * @return $this
     */
    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }

    /**
     * @return Construction
     */
    public function getConstruction()
    {
        return $this->construction;
    }

    /**
     * @param Construction $construction
     * @return $this
     */
    public function setConstruction($construction)
    {
        $this->construction = $construction;
        return $this;
    }

    public function getName()
    {
        return $this->getNodeName() ?: $this->getId();
    }

    /**
     * Get the options for the factory to create the item for this node
     *
     * @return array
     */
    public function getOptions()
    {
        static $propertyAccessor;
        if (!isset($propertyAccessor)) {
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        $options = [];
        $options['label'] = $this->getTitle();

        $type = $this->getType();
        if (!isset(self::$skipLinkTypeOption[$type]) ) {
            $options['link_type'] = $type;
        }

        foreach ((array)self::$linkTypeFields[$type] as $field) {
            $options[$field] = $propertyAccessor->getValue($this, $field);
        }

        if (!empty($this->extras)) {
            $options['extras'] = $this->extras;
        }

        return $options;
    }

    /**
     * @return int
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    public function getLevel()
    {
        return $this->getLvl();
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist()
    {
        if (empty($this->type)) {
            return;
        }

        foreach (self::$linkTypeFields as $type => $fields) {
            if ($this->type === $type) {
                continue;
            }

            foreach((array)$fields as $field) {
                $this->$field = null;
            }
        }
    }
}
