<?php
namespace AppBundle\Soap\BusUgdMosRu;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class DumpStrategy implements DataSourceStrategy
{
    /** @var SplFileInfo[]|\ArrayObject */
    private $files;

    /** @var int */
    private $position;

    public function __construct($dir)
    {
        $this->files = array_values(iterator_to_array(Finder::create()->in($dir)->files()->name('*.xml')->sortByName()));
        $this->position = 0;
    }

    public function getNext()
    {
        if (array_key_exists($this->position, $this->files)) {
            /** @var SplFileInfo $file */
            $file = $this->files[$this->position];

            return new SoapResponse($file->getContents());
        } else {
            return $this->generateEmptyResponse();
        }
    }

    public function confirm()
    {
        $this->position += 1;

        return $this->genereateConfirmSuccessResponse();
    }

    private function generateEmptyResponse()
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Body>
        <NS1:systemEventNotification xmlns:NS1="http://issk.ugd.mos.ru/ISSK/Confirmation/v1.0">
            <NS1:requestID>26e3148a-140c-11e5-a46b-ac1050140000</NS1:requestID>
            <NS1:resultCode>004</NS1:resultCode>
            <NS1:resultDescription>Документы не найдены</NS1:resultDescription>
        </NS1:systemEventNotification>
    </soapenv:Body>
</soapenv:Envelope>
XML;

        return new SoapResponse($xml);
    }

    private function genereateConfirmSuccessResponse()
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   <soapenv:Body>
      <NS1:systemEventNotification xmlns:NS1="http://issk.ugd.mos.ru/ISSK/Confirmation/v1.0">
         <NS1:resultCode>000</NS1:resultCode>
         <NS1:resultDescription>Подтверждение получения зафиксировано</NS1:resultDescription>
      </NS1:systemEventNotification>
   </soapenv:Body>
</soapenv:Envelope>
XML;

        return new SoapResponse($xml);
    }
}
