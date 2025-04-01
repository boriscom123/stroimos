<?php

namespace Amg\DataCore\Model\RelevantNewsShown;


interface RelevantNewsShownInterface
{
    /**
     * @return boolean
     */
    public function isRelevantNewsShown();

    /**
     * @param boolean $relevantNewsShown
     * @return $this
     */
    public function setRelevantNewsShown($relevantNewsShown);
}
