<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Teasing\TeasingTrait;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class UserRole
{
    use TeasingTrait;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @ORM\Id
     */
    private $code;

    public function getId()
    {
        return $this->getCode();
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return UserRole
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function __toString()
    {
        return $this->code;
    }
}
