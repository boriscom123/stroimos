<?php
namespace Amg\DataCore\Model\Publication;

use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodTrait;

trait PublicationTrait
{
    use IdentifiableTrait;
    use PublishableTrait;
    use PublishingPeriodTrait;
}
