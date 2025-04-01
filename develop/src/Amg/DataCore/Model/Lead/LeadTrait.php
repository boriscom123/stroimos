<?php
namespace Amg\DataCore\Model\Lead;

trait LeadTrait
{
    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="string", length=1023, nullable=true)
     */
    protected $lead;

    public function getLead()
    {
        return $this->lead;
    }

    public function setLead($lead)
    {
        $this->lead = $lead;

        return $this;
    }
}
