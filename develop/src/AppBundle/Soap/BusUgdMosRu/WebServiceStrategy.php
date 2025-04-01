<?php
namespace AppBundle\Soap\BusUgdMosRu;

class WebServiceStrategy implements DataSourceStrategy
{
    /**
     * @var SoapClient
     */
    private $soapClient;

    /** @var SoapResponse */
    private $_currentResponse;

    public function __construct(SoapClient $soapClient)
    {
        $this->soapClient = $soapClient;
    }

    public function getNext()
    {
        $this->_currentResponse = $this->soapClient->callGetData();

        return $this->_currentResponse;
    }

    public function confirm()
    {
        return $this->soapClient->callConfirm($this->_currentResponse);
    }
}
