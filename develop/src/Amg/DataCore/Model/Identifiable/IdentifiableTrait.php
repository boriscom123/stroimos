<?php
namespace Amg\DataCore\Model\Identifiable;

trait IdentifiableTrait
{
    /**
     * @var integer
     *
     * @Doctrine\ORM\Mapping\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
