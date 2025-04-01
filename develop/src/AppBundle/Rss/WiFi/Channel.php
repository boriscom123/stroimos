<?php
namespace AppBundle\Rss\WiFi;

use Suin\RSSWriter\Channel as BaseChannel;

class Channel extends BaseChannel
{
    protected $logo;

    public function logo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    public function asXML()
    {
        $xml = parent::asXML();

        if ($this->logo !== null) {
            $toDom = dom_import_simplexml($xml);
            $image = $toDom->ownerDocument->createElement('image');
            $url = $toDom->ownerDocument->createElement('url', $this->logo);
            $image->appendChild($url);
            $toDom->appendChild($toDom->ownerDocument->importNode($image, true));
        }

        return $xml;
    }
}
