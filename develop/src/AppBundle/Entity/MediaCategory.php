<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MenuNode
 *
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @ORM\Table
 * @Gedmo\Tree(type="nested")
 */
class MediaCategory implements
    EntitledInterface
{
    use EntitledTrait,
        ORMBehaviors\Blameable\Blameable,
        TimestampableTrait;

    /**
     * @var integer
     *
     * @Doctrine\ORM\Mapping\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


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
     * @var MediaCategory
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="MediaCategory", inversedBy="children", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $parent;

    /**
     * @var MediaCategory[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MediaCategory", mappedBy="parent", cascade={"persist"})
     * @ORM\OrderBy({"lft" = "ASC", "title" = "ASC"})
     */
    private $children;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }


    /**
     * @return MediaCategory
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param MediaCategory $parent
     *
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return MediaCategory[]|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param MediaCategory[]|ArrayCollection $children
     *
     * @return $this
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
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
}
