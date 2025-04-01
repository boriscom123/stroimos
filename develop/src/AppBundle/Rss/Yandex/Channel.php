<?php
namespace AppBundle\Rss\Yandex;

use Suin\RSSWriter\Channel as BaseChannel;

class Channel extends BaseChannel
{
    protected $logo;

    protected $logoSquare;

    public function logo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    public function logoSquare($logo)
    {
        $this->logoSquare = $logo;

        return $this;
    }

    public function asXML()
    {
        $xml = parent::asXML();

        if ($this->logo !== null) {
            $toDom = dom_import_simplexml($xml);
            $logo = $toDom->ownerDocument->createElement('yandex:logo', $this->logo);
            $toDom->appendChild($toDom->ownerDocument->importNode($logo, true));
        }

        if ($this->logoSquare !== null) {
            $toDom = dom_import_simplexml($xml);
            $logo = $toDom->ownerDocument->createElement('yandex:logo', $this->logoSquare);
            $logo->setAttribute('type', 'square');
            $toDom->appendChild($toDom->ownerDocument->importNode($logo, true));
        }

        return $xml;
    }
}
