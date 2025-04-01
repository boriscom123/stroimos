<?php
namespace AppBundle\Rss\Yandex;

use Suin\RSSWriter\Item as BaseItem;

class ZenItem extends BaseItem
{
    /** @var string */
    protected $fullText;

    public function fullText($fullText)
    {
        $this->fullText = $fullText;

        return $this;
    }

    /** @var string */
    protected $figure;

    public function figure($figure)
    {
        $this->figure = $figure;

        return $this;
    }

    public function asXML()
    {
        $xml = parent::asXML();

        if (!empty($this->fullText)) {
            $domElement = dom_import_simplexml($xml);
            $fullText = $domElement->ownerDocument->createElement('content:encoded');
            $cdata = $domElement->ownerDocument->createCDATASection($this->fullText);
            if(!empty($this->figure)) {
                $figure = $domElement->ownerDocument->createDocumentFragment();
                $figure->appendXML($this->figure);
                $fullText->appendChild($figure->childNodes[0]);
            }
            $fullText->appendChild($cdata);
            $domElement->appendChild($fullText);
        }

        return $xml;
    }
}
