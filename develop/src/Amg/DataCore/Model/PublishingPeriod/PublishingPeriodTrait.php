<?php

namespace Amg\DataCore\Model\PublishingPeriod;


trait PublishingPeriodTrait
{
    /**
     * @var \DateTime
     *
     * @Doctrine\ORM\Mapping\Column(name="publish_start_date", type="datetime", nullable=true)
     */
    protected $publishStartDate;

    /**
     * @var \DateTime
     *
     * @Doctrine\ORM\Mapping\Column(name="publish_end_date", type="datetime", nullable=true)
     */
    protected $publishEndDate;

    /**
     * Get publishStartDate
     *
     * @return \DateTime
     */
    public function getPublishStartDate()
    {
        return $this->publishStartDate;
    }

    /**
     * Set publishStartDate
     *
     * @param \DateTime $publishStartDate
     * @return $this
     */
    public function setPublishStartDate(\DateTime $publishStartDate = null)
    {
        $this->publishStartDate = $publishStartDate;

        return $this;
    }

    /**
     * Get publishEndDate
     *
     * @return \DateTime
     */
    public function getPublishEndDate()
    {
        return $this->publishEndDate;
    }

    /**
     * Set publishEndDate
     *
     * @param \DateTime $publishEndDate
     * @return $this
     */
    public function setPublishEndDate(\DateTime $publishEndDate = null)
    {
        $this->publishEndDate = $publishEndDate;

        return $this;
    }
}
