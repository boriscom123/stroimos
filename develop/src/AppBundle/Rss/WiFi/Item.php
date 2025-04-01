<?php
namespace AppBundle\Rss\WiFi;

use Suin\RSSWriter\Item as BaseItem;

class Item extends BaseItem
{
    /** @var array */
    protected $fullText;

    public function fullText($fullText)
    {
        $this->fullText = $fullText;

        return $this;
    }

    public function asXML()
    {
        $xml = parent::asXML();

        if (!empty($this->fullText)) {
            $domElement = dom_import_simplexml($xml);
            $fullText = $domElement->ownerDocument->createElement('full-text');
            $cdata = $domElement->ownerDocument->createCDATASection($this->fullText);
            $fullText->appendChild($cdata);
            $domElement->appendChild($fullText);
        }

        return $xml;
    }
}
