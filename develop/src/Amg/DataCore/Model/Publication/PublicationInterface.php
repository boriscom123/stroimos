<?php
namespace Amg\DataCore\Model\Publication;

use Amg\DataCore\Model\Blamable\BlamableInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodInterface;
use Amg\DataCore\Model\SeoMetadata\SeoMetadataInterface;
use Amg\DataCore\Model\SeoTitle\SeoTitleInterface;
use Amg\DataCore\Model\Timestampable\TimestampableInterface;
use Amg\DataCore\Model\Translatable\TranslatableInterface;

interface PublicationInterface extends
    IdentifiableInterface,
    PublishableInterface,
    PublishingPeriodInterface,
    BlamableInterface,
    TimestampableInterface,
    TranslatableInterface,
    SeoTitleInterface,
    SeoMetadataInterface
{
}
