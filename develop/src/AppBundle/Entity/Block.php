<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Sonata\BlockBundle\Model\BaseBlock;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Block
 *
 * @ORM\Table(indexes={@Index(name="type_idx", columns={"type"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\BlockRepository")
 */
class Block extends BaseBlock
{
    const TYPE_HOT_NEWS_BLOCK = 'hot_news_block';
    const TYPE_SERVICE_BANNER = 'service_banner';
    const TYPE_DESTRUCTION_BANNER = 'destruction_banner';
    const TYPE_RENOVATION_BANNER = 'renovation_banner';
    const TYPE_METRO_CONSTRUCTED_STATIONS_BLOCK = 'metro_constructed_stations_block';
    const TYPE_ROAD_CONSTRUCTION_MAP_BANNER = 'road_construction_map_banner';
    const TYPE_ROAD_INTERCHANGE_BANNER = 'road_interchange_banner';

    public static $types = [
        self::TYPE_HOT_NEWS_BLOCK,
        self::TYPE_SERVICE_BANNER,
        self::TYPE_DESTRUCTION_BANNER,
        self::TYPE_RENOVATION_BANNER,
        self::TYPE_METRO_CONSTRUCTED_STATIONS_BLOCK,
        self::TYPE_ROAD_CONSTRUCTION_MAP_BANNER,
        self::TYPE_ROAD_INTERCHANGE_BANNER
    ];

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
     * @ORM\Column(name="container", type="string", length=255)
     */
    protected $container;

    /**
     * @var array
     * @ORM\Column(name="settings", type="array")
     */
    protected $settings;

    /**
     * @var boolean
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled;

    /**
     * @var integer
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    protected $position;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=64)
     */
    protected $type;

    /**
     * @var integer
     */
    protected $ttl;

    /**
     * @var Page
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="blocks")
     */
    protected $page;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * Set id
     *
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param Page $page
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return string
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param string $container
     * @return $this
     */
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }

    public function getChildren()
    {
        return isset($this->children) ? $this->children : $this->children = [];
    }

    public function __toString()
    {
        return $this->getType() ?: 'Без названия';
    }

    public function getTitle()
    {
        if(isset($this->settings['title'])) {
            return $this->settings['title'];
        }

        return $this->getContainer();
    }
}
