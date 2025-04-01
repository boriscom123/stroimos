<?php
namespace AppBundle\Soap\BusUgdMosRu;

/**
 * Class SoapResponse
 *
 * @property string requestID
 * @property string resultCode
 * @property string ObjectID
 * @property string ObjectName
 * @property string ObjectArea
 * @property string ObjectDistrict
 * @property string ObjectAddress
 * @property string ConstructionWorkType
 * @property string MainFunctional
 * @property string SourceOfFinance
 * @property string ObjectStatus
 * @property string Floor
 * @property string Square
 * @property string DeveloperOrgForm
 * @property string DeveloperOrgName
 * @property string UpdateDateTime
 * @property string PointXyContourGeometryPointCoordinates
 * @property string LandContourGeometryPolygonOuterBoundaryIsLinearRingCoordinates
 * @property string ExpireDate
 */
class SoapResponse
{
    const XPATH_OBJECT_NG_OUT = '/s:Envelope/s:Body/oo:ObjectNGOut';
    const XPATH_OBJECT = '/s:Envelope/s:Body/oo:ObjectNGOut/oo:Object/o:Object';
    const XPATH_NOTIFICATION = '/s:Envelope/s:Body/c:systemEventNotification';

    private static $namespaces = [
        's' => 'http://schemas.xmlsoap.org/soap/envelope/',
        'oo' => 'http://issk.ugd.mos.ru/MSG_RC/ObjectNGOut/v1.0',
        'o' => 'http://xmlns.oracle.com/MSG_RC_ObjectNG',
        'c' => 'http://issk.ugd.mos.ru/ISSK/Confirmation/v1.0',
        'g' => 'http://www.opengis.net/gml',
    ];

    private static $resultCodes = [
        '000' => 'Доставка пакета документов успешно подтверждена',
        '001' => 'Неверный формат входных параметров запроса',
        '002' => 'Неверные параметры аутентификации',
        '003' => 'Системная ошибка ИССК',
        '004' => 'Нет данных. Очередь публикаций пуста',
    ];

    /** @var string */
    private $_response;

    /** @var \SimpleXMLElement */
    private $_xml;

    /** @param $response */
    public function __construct($response)
    {
        $this->_response = $response;

        $this->parse();
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->_response;
    }

    public function isObject()
    {
        if (!isset($this->_isObject)) {
            $this->_isObject = (bool)count($this->_xml->xpath(self::XPATH_OBJECT_NG_OUT));
        }

        return $this->_isObject;
    }

    public function isNotification()
    {
        if (!isset($this->_isNotification)) {
            $this->_isNotification = (bool)count($this->_xml->xpath(self::XPATH_NOTIFICATION));
        }

        return $this->_isNotification;
    }

    public function isError()
    {
        if (!$this->isNotification()) {
            return false;
        }

        return $this->resultCode !== '000' && $this->resultCode !== '004';
    }

    public function getError()
    {
        if (!$this->isError()) {
            return null;
        }

        return self::$resultCodes[$this->resultCode];
    }

    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }

        throw new \InvalidArgumentException(sprintf('No getter for "%s" defined', $name));
    }

    private function registerNamespaces()
    {
        foreach (self::$namespaces as $prefix => $namespace) {
            $this->_xml->registerXPathNamespace($prefix, $namespace);
        }
    }

    private function parse()
    {
        $this->_xml = new \SimpleXMLElement($this->_response);

        $this->registerNamespaces();

        try {
            if ($this->isObject()) {
                $this->parseAsObject();
            } elseif ($this->isNotification()) {
                $this->parseAsNotification();
            } else {
                throw new \InvalidArgumentException('Unknown content');
            }
        } catch (\Exception $e) {
            throw new \InvalidArgumentException(sprintf('Could not parse response XML: %s. Stack trace: %s', $e->getMessage(), $e->getTraceAsString()));
        }
    }

    private function parseAsObject()
    {
        $this->requestID = (string)$this->_xml->xpath(self::XPATH_OBJECT_NG_OUT . '/oo:requestID')[0];

        // simple types
        $simpleProperties = $this->_xml->xpath(self::XPATH_OBJECT . '/o:*[count(*)=0]');
        foreach ($simpleProperties as $sxe) {
            $propertyName = $sxe->getName();
            $this->$propertyName = (string)$sxe;
        }

        // complex types: Developer, PointXY, Land, etc.
        $this->DeveloperOrgForm = $this->xpath(self::XPATH_OBJECT . '/o:Developer/o:OrgForm');
        $this->DeveloperOrgName = $this->xpath(self::XPATH_OBJECT . '/o:Developer/o:OrgName');
        $this->PointXyContourGeometryPointCoordinates = $this->xpath(
            self::XPATH_OBJECT . '/o:PointXY/o:Contour/o:GEOMETRY/g:Point/g:coordinates'
        );
        $this->LandContourGeometryPolygonOuterBoundaryIsLinearRingCoordinates = $this->xpath(
            self::XPATH_OBJECT . '/o:Land/o:Contour/o:GEOMETRY/g:Polygon/g:outerBoundaryIs/g:LinearRing/g:coordinates'
        );
        $this->ExpireDate = $this->xpath(self::XPATH_OBJECT . '/o:PermissionToConstruction/o:ExpireDate');
    }

    private function parseAsNotification()
    {
        $simpleProperties = $this->_xml->xpath(self::XPATH_NOTIFICATION . '/c:*[count(*)=0]');

        foreach ($simpleProperties as $sxe) {
            $propertyName = $sxe->getName();
            $this->$propertyName = (string)$sxe;
        }
    }

    private function xpath($xpath)
    {
        $sxe = $this->_xml->xpath($xpath);

        return (string)array_shift($sxe) ?: null;
    }
    //endregion
}
