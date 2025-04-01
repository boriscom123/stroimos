<?php

namespace Amg\DataCore\Model\RelevantNewsShown;

trait RelevantNewsShownTrait
{
    /**
     * @var boolean
     *
     * @Doctrine\ORM\Mapping\Column(type="boolean")
     */
    protected $relevantNewsShown = true;

    /**
     * @param boolean $relevantNewsShown
     * @return $this
     */
    public function setRelevantNewsShown($relevantNewsShown)
    {
        $this->relevantNewsShown = $relevantNewsShown;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isRelevantNewsShown()
    {
        return $this->relevantNewsShown;
    }
}
