<?php

namespace AppBundle\Rss;

use Suin\RSSWriter\Item;

class RssItem extends Item
{
    /** @var string */
    protected $content;

    public function content($content = '')
    {
        $this->content = $content;

        return $this;
    }

    public function asXML()
    {
        $xml = parent::asXML();
        $contentElement = $xml->addChild('content');

        $node = dom_import_simplexml($contentElement);
        $no = $node->ownerDocument;
        $node->appendChild($no->createCDATASection($this->content));

        return $xml;
    }
}
