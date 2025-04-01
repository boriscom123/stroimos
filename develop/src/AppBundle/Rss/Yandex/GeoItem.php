<?php
namespace AppBundle\Rss\Yandex;

class GeoItem extends Item
{
    /** @var string */
    protected $address;

    /** @var string */
    protected $geoData;

    public function address($address)
    {
        $this->address = $address;

        return $this;
    }

    public function geoData($geoData)
    {
        $this->geoData = $geoData;

        return $this;
    }

    public function asXML()
    {
        $xml = parent::asXML();

        if (!empty($this->address)) {
            $domElement = dom_import_simplexml($xml);
            $address = $domElement->ownerDocument->createElement('address', $this->address);
            $domElement->appendChild($address);
        }

        if (!empty($this->geoData)) {
            $domElement = dom_import_simplexml($xml);
            $geoData = $domElement->ownerDocument->createElement('geodata', $this->geoData);
            $domElement->appendChild($geoData);
        }

        return $xml;
    }
}
