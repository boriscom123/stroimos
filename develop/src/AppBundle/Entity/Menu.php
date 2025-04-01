<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\MenuRepository")
 */
class Menu
{
    use EntitledTrait;

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
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern="/^[a-zA-z_0-9-]+$/",
     *     message="Поле может содержать только цифры и латинские буквы, а также знаки дефиса и подчеркивания"
     * )
     */
    protected $name;

    /**
     * @var MenuNode
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\MenuNode", cascade={"persist"})
     */
    protected $rootNode;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Menu
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return MenuNode
     */
    public function getRootNode()
    {
        return $this->rootNode;
    }

    /**
     * @param MenuNode $rootNode
     *
     * @return $this
     */
    public function setRootNode($rootNode)
    {
        $this->rootNode = $rootNode;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
