<?php
namespace AppBundle\Rss\Yandex;

use Suin\RSSWriter\Item as BaseItem;

class Item extends BaseItem
{
    /** @var string */
    protected $fullText;

    /** @var string */
    protected $genre;

    public function fullText($fullText)
    {
        $this->fullText = $fullText;

        return $this;
    }

    public function genre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    public function asXML()
    {
        $xml = parent::asXML();

        if (!empty($this->fullText)) {
            $domElement = dom_import_simplexml($xml);
            $fullText = $domElement->ownerDocument->createElement('yandex:full-text');
            $cdata = $domElement->ownerDocument->createCDATASection($this->fullText);
            $fullText->appendChild($cdata);
            $domElement->appendChild($fullText);
        }

        if(!empty($this->genre)) {
            $domElement = dom_import_simplexml($xml);
            $genre = $domElement->ownerDocument->createElement('yandex:genre', $this->genre);
            $domElement->appendChild($genre);
        }

        return $xml;
    }
}
