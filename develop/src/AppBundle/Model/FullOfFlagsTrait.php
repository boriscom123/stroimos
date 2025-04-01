<?php
namespace AppBundle\Model;

use Amg\DataCore\Model\Feedable\FeedableTrait;
use Amg\DataCore\Model\PublishableInRss\PublishableInRssTrait;
use Amg\DataCore\Model\RelevantNewsShown\RelevantNewsShownTrait;
use Amg\DataCore\Model\Searchable\SearchableTrait;

trait FullOfFlagsTrait
{
    use FeedableTrait,
        PublishableInRssTrait,
        SearchableTrait,
        RelevantNewsShownTrait;
        //todo: CommentableTrait?
}