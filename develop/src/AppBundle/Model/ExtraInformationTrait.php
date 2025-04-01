<?php
namespace AppBundle\Model;

use AppBundle\Entity\ExtraInformation;

trait ExtraInformationTrait
{
    /**
     * @var ExtraInformation
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ExtraInformation", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $extraInformation;

    /**
     * @return ExtraInformation
     */
    public function getExtraInformation()
    {
        return $this->extraInformation;
    }

    /**
     * @param ExtraInformation $extraInformation
     *
     * @return $this
     */
    public function setExtraInformation($extraInformation)
    {
        $this->extraInformation = $extraInformation;

        return $this;
    }
}
