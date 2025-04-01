<?php
namespace AppBundle\Soap\BusUgdMosRu;

class SoapClient extends \SoapClient
{
    const WSDL = 'http://bus.ugd.mos.ru/docs/S_006/S_006_006_02/S_006_006_02.wsdl';
    const NS_WSSE = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
    const NS_CONFIRMATION = 'http://issk.ugd.mos.ru/ISSK/Confirmation/v1.0';

    private static $options = [
        // 'soap_version' => SOAP_1_1, // this is a must, but is a default value anyway
        'trace' => 1, // enables SoapClient::__getLast*() methods
        'exceptions' => 1,
    ];

    public function __construct($wsdl, $options, $username, $password)
    {
        $options = array_merge($options, self::$options);

        parent::__construct($wsdl, $options);

        $header = $this->createHeader($username, $password);
        $this->__setSoapHeaders([$header]);
    }

    private function createHeader($username, $password)
    {
        $usernameTokenClass = new \stdClass();
        $usernameTokenClass->Username = new \SoapVar($username, XSD_STRING, null, null, 'Username', self::NS_WSSE);

//        $usernameTokenClass->Password = new \SoapVar(
//            sprintf(
//                '<wsseNs:Password xmlns:wsseNs="%s" Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">%s</wsseNs:Password>',
//                self::NS_WSSE,
//                $password
//            ),
//            XSD_ANYXML,
//            null,
//            self::NS_WSSE,
//            'Password',
//            self::NS_WSSE
//        );
        $usernameTokenClass->Password = new \SoapVar($password, XSD_STRING, null, null, 'Password', self::NS_WSSE);

        $wsseTokenClass = new \stdClass();
        $wsseTokenClass->UsernameToken = new \SoapVar($usernameTokenClass, SOAP_ENC_OBJECT, null, self::NS_WSSE, 'usernameTokenClass', self::NS_WSSE);

        $wsseToken = new \SoapVar($wsseTokenClass, SOAP_ENC_OBJECT, null, self::NS_WSSE, 'usernameTokenClass', self::NS_WSSE);
        $headerValue = new \SoapVar($wsseToken, SOAP_ENC_OBJECT, null, self::NS_WSSE, 'Security', self::NS_WSSE);
        $header = new \SoapHeader(self::NS_WSSE, 'Security', $headerValue);

        return $header;
    }

    public function callGetData()
    {
        $this->__soapCall('getData', []);

        $response = $this->__getLastResponse();

        return new SoapResponse($response);
    }

    public function callConfirm(SoapResponse $soapResponse)
    {
        $confirmation = new \stdClass();
        $confirmation->requestID = new \SoapVar($soapResponse->requestID, XSD_STRING, null, null, 'requestID', self::NS_CONFIRMATION);
        $confirmation->resultCode = new \SoapVar('000', XSD_STRING, null, null, 'resultCode', self::NS_CONFIRMATION);
        $confirmation->resultDescription = new \SoapVar('Сохранение документов прошло успешно', XSD_STRING, null, null, 'resultDescription', self::NS_CONFIRMATION);

        $this->confirm(new \SoapVar($confirmation, SOAP_ENC_OBJECT, null, null, 'systemEventNotification', self::NS_CONFIRMATION));

        $response = $this->__getLastResponse();

        return new SoapResponse($response);
    }
}
