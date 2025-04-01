<?php
namespace AppBundle\Rss;

use AppBundle\Entity\Post;
use AppBundle\Rss\Yandex\GeoItem;

class YandexGeoRssBuilder extends YandexRssBuilder
{
    protected function createItem()
    {
        return new GeoItem();
    }

    public function addItem(Post $post)
    {
        /** @var GeoItem $item */
        $item = parent::addItem($post);

        $address = $post->getAddress();
        if($address->getText()) {
            $item->address($address->getText());
        }
        if($address->getGeoPoint()) {
            $item->geoData($address->getGeoPoint()->getLonLatStringYandex());
        }

        return $item;
    }
}