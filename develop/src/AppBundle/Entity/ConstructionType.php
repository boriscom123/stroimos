<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ConstructionTypeRepository")
 */
class ConstructionType
{
    use EntitledTrait;
    use IdentifiableTrait;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     * @Gedmo\Slug(fields={"title"}, updatable=false)
     */
    private $alias;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Gedmo\Slug(fields={"codeGroup"}, updatable=true, separator=";")
     */
    private $codeGroup;
    /**
     * @return string
     */
    public function getCodeGroup()
    {
        return $this->codeGroup;
    }

    /**
     * @param $codeGroup
     * @return ConstructionType
     */
    public function setCodeGroup($codeGroup)
    {
        $this->codeGroup = $codeGroup;

        return $this;
    }


    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param mixed $alias
     *
     * @return ConstructionType
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle() ?: '(неназванная категория объектов строительства)';
    }
}
