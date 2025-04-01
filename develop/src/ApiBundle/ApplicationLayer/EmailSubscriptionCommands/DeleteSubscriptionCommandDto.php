<?php

namespace ApiBundle\ApplicationLayer\EmailSubscriptionCommands;

use Symfony\Component\Validator\Constraints as Assert;

class DeleteSubscriptionCommandDto
{
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

        return $self;
    }

    /**
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }
}
