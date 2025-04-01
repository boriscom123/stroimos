<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Tree\Traits\NestedSetEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\DocumentRubricRepository")
 * @Gedmo\Tree(type="nested")
 */
class DocumentRubric extends Rubric
{
    use NestedSetEntity;

    /**
     * @var DocumentRubric
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="DocumentRubric", inversedBy="children")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $parent;

    /**
     * @var DocumentRubric
     *
     * @ORM\OneToMany(targetEntity="DocumentRubric", mappedBy="parent")
     * @ORM\OrderBy({"left" = "ASC"})
     */
    private $children;

    /**
     * @return $this
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param DocumentRubric $parent
     * @return DocumentRubric
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return DocumentRubric[]|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children ?: $this->children = new ArrayCollection();
    }

    public function getLevel()
    {
        return $this->level;
    }
}

