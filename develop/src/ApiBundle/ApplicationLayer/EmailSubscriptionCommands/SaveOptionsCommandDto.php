<?php

namespace ApiBundle\ApplicationLayer\EmailSubscriptionCommands;

use Symfony\Component\Validator\Constraints as Assert;

class SaveOptionsCommandDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Type(type="array")
     *
     * @var array
     */
    protected $administrativeUnits;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="int")
     *
     * @var string
     */
    protected $subscriptionId;


    protected function __construct()
    {
    }

    public static function createFromArray(array $values)
    {
        $self = new self();

        $self->subscriptionId = isset($values['subscriptionId']) ? $values['subscriptionId'] : null;
        $self->administrativeUnits = isset($values['administrativeUnits']) ? $values['administrativeUnits'] : null;

        return $self;
    }


    /**
     * @return array
     */
    public function getAdministrativeUnits()
    {
        return $this->administrativeUnits;
    }

    /**
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }
}
