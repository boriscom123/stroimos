<?php
namespace Amg\Bundle\PageBundle\Model;

use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Metadata\MetadataTrait;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Entity\Block;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class BasePage
 * @package Amg\Bundle\PageBundle\Model
 *
 * todo: override parent and children property and use NestedSetEntity in concrete page
 *
 * @ORM\MappedSuperclass
 * @Gedmo\Tree(type="nested")
 * @UniqueEntity("slug")
 */
abstract class BasePage implements PageInterface
{
    /* todo: use in concrete page
     * use NestedSetEntity;
     */

    use EntitledTrait,
        ContentfulTrait,
        MetadataTrait,
        PublishableTrait,
        TimestampableTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=511, nullable=true)
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="AppBundle\Sluggable\Handler\TreeSlugHandler", options={
     *          @Gedmo\SlugHandlerOption(name="parentRelationField", value="parent"),
     *          @Gedmo\SlugHandlerOption(name="separator", value="/"),
     *          @Gedmo\SlugHandlerOption(name="ownerSuffix", value="owner")
     *      })
     * }, fields={"title"}, updatable=false)
     * @Assert\Regex(
     *     pattern="/^[a-zA-z_\/0-9-]+$/",
     *     message="Поле может содержать только цифры и латинские буквы, а также знаки дефиса, подчеркивания и косую черту"
     * )
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $route;

    /**
     * @var array
     *
     * @ORM\Column(type="simple_array", nullable=true)
     */
    protected $subRoutes = [];

    /**
     * @var string
     *
     * @ORM\Column(name="layout", type="string", length=255, nullable=true)
     */
    protected $layout;

    /**
     * @var string
     *
     * @ORM\Column(name="children_layout", type="string", length=255, nullable=true)
     */
    protected $childrenLayout;

    /**
     * todo: override property in concrete page
     * @var $this
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="children")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $parent;

    /**
     * todo: override property in concrete page
     * @var $this[]
     *
     * @ORM\OneToMany(targetEntity="Page", mappedBy="parent")
     * @ORM\OrderBy({"left" = "ASC"})
     */
    protected $children;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Block", mappedBy="page", cascade={"persist"})
     */
    protected $blocks;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $section = false;

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get layout
     *
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Set layout
     *
     * @param string $layout
     * @return $this
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get children layout
     *
     * @return string
     */
    public function getChildrenLayout()
    {
        return $this->childrenLayout;
    }

    /**
     * Set children layout
     *
     * @param $childrenLayout
     * @return $this
     */
    public function setChildrenLayout($childrenLayout)
    {
        $this->childrenLayout = $childrenLayout;

        return $this;
    }

    /**
     * @return $this
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param PageInterface $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return $this[]|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children ?: $this->children = new ArrayCollection();
    }

    /**
     * @param null $container
     * @param string $type
     * @return Block[]|ArrayCollection
     */
    public function getBlocks($container = null, $type = null)
    {
        if ($container || $type) {
            $criteria = Criteria::create();

            if ($container) {
                $criteria->where(
                    Criteria::expr()->eq('container', $container)
                );
            }

            if ($type) {
                $criteria->andWhere(
                    Criteria::expr()->eq('type', $type)
                );
            }
            $criteria->andWhere(
                Criteria::expr()->eq('enabled', true)
            );

            $criteria->orderBy(array('position' => 'DESC'));

            return $this->blocks->matching($criteria);
        }

        return $this->blocks ?: $this->blocks = new ArrayCollection();
    }

    /**
     * @param array $blocks
     * @return $this
     */
    public function setBlocks($blocks)
    {
        $this->blocks = $blocks;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle() ?: 'untitled page';
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
    public function getSubRoutes()
    {
        return $this->subRoutes;
    }

    /**
     * @param array $subRoutes
     * @return $this
     */
    public function setSubRoutes($subRoutes)
    {
        $this->subRoutes = $subRoutes;
        return $this;
    }

    public function addSubRoutes($subRoute)
    {
        $this->subRoutes[] = $subRoute;
        $this->subRoutes = array_unique($this->subRoutes);
        return $this;
    }

    /**
     * @return boolean
     */
    public function isSection()
    {
        return $this->section;
    }

    /**
     * @param boolean $section
     * @return $this
     */
    public function setSection($section)
    {
        $this->section = $section;
        return $this;
    }
}
