<?php

namespace ApiBundle\ApplicationLayer\AbstractCommand;

interface CommandValidatorInterface
{
    public function validate($command);
}
