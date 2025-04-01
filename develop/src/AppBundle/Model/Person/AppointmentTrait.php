<?php
namespace AppBundle\Model\Person;

use Doctrine\ORM\Mapping as ORM;

trait AppointmentTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $appointment;

    /**
     * @return string
     */
    public function getAppointment()
    {
        return $this->appointment;
    }

    /**
     * @param string $appointment
     *
     * @return $this
     */
    public function setAppointment($appointment)
    {
        $this->appointment = $appointment;

        return $this;
    }
}
