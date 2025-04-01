<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table()
 */
class ConstructionParameterValue implements IdentifiableInterface
{
    use IdentifiableTrait;

    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="text", nullable=true)
     */
    protected $value;

    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="smallint", nullable=true, options={"default" : 0})
     */
    protected $weight;

    /**
     * @var Construction
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Construction", inversedBy="constructionParameterValues")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    protected $construction;

    /**
     * @var ConstructionParameter
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ConstructionParameter")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    protected $constructionParameter;

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return ConstructionParameter
     */
    public function getConstructionParameter()
    {
        return $this->constructionParameter;
    }

    /**
     * @param ConstructionParameter $constructionParameter
     */
    public function setConstructionParameter($constructionParameter)
    {
        $this->constructionParameter = $constructionParameter;
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
     */
    public function setConstruction($construction)
    {
        $this->construction = $construction;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function __toString()
    {
        return $this->value;
    }
}
