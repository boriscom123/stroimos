<?php

namespace ApiBundle\ApplicationLayer\AbstractCommand;

interface CommandArgValidator
{
    /**
     * @param $value
     * @param array $additionalArgs
     *
     * @return mixed
     */
    public function validate($value, ...$additionalArgs);
}
