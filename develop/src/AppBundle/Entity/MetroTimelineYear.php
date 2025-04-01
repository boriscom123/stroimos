<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\XYInterface;
use AppBundle\Model\XYTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @UniqueEntity("year")
 */
class MetroTimelineYear implements PublishableInterface, PublishingPeriodInterface, XYInterface
{
    use ImageTrait;
    use PublishableTrait;
    use PublishingPeriodTrait;
    use XYTrait;

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
     * @ORM\Column(type="smallint", unique=true)
     * @Assert\Range(min="1935", max="2200")
     */
    protected $year;

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
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     * @return $this
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getYear();
    }
}
