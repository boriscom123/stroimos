<?php
namespace Amg\DataCore\Model\PublicationTranslation;

use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Teasing\TeasingTrait;

trait PublicationTranslationTrait
{
    use EntitledTrait;
    use TeasingTrait;
    use ContentfulTrait;
}
