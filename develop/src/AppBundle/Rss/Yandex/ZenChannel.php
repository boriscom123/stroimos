<?php
namespace AppBundle\Rss\Yandex;

use Suin\RSSWriter\Channel as BaseChannel;

class ZenChannel extends BaseChannel
{
    public function asXML()
    {
        $xml = parent::asXML();

        $dom = dom_import_simplexml($xml->xpath('/channel/pubDate')[0]);
        $dom->parentNode->removeChild($dom);

        return $xml;
    }
}
