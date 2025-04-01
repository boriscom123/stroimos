<?php
namespace Amg\DataCore\Model\Timestampable;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

trait TimestampableTrait
{
    use TimestampableEntity;
}
