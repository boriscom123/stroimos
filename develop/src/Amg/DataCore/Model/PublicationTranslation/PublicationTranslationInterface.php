<?php
namespace Amg\DataCore\Model\PublicationTranslation;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\LocaleAware\LocaleAwareInterface;
use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use Amg\DataCore\Model\Translatable\TranslationInterface;

interface PublicationTranslationInterface extends
    EntitledInterface,
    TeasingInterface,
    TranslationInterface,
    LocaleAwareInterface,
    MetadataInterface
{
}
