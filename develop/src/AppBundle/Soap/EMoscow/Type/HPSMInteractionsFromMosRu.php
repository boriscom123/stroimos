<?php

namespace AppBundle\Soap\EMoscow\Type;

class HPSMInteractionsFromMosRu extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
      'base64Binary' => 'AppBundle\\Soap\\EMoscow\\Type\\base64Binary',
      'hexBinary' => 'AppBundle\\Soap\\EMoscow\\Type\\hexBinary',
      'StringType' => 'AppBundle\\Soap\\EMoscow\\Type\\StringType',
      'DecimalType' => 'AppBundle\\Soap\\EMoscow\\Type\\DecimalType',
      'BooleanType' => 'AppBundle\\Soap\\EMoscow\\Type\\BooleanType',
      'DateTimeType' => 'AppBundle\\Soap\\EMoscow\\Type\\DateTimeType',
      'DateType' => 'AppBundle\\Soap\\EMoscow\\Type\\DateType',
      'TimeType' => 'AppBundle\\Soap\\EMoscow\\Type\\TimeType',
      'DurationType' => 'AppBundle\\Soap\\EMoscow\\Type\\DurationType',
      'IntType' => 'AppBundle\\Soap\\EMoscow\\Type\\IntType',
      'ShortType' => 'AppBundle\\Soap\\EMoscow\\Type\\ShortType',
      'LongType' => 'AppBundle\\Soap\\EMoscow\\Type\\LongType',
      'ByteType' => 'AppBundle\\Soap\\EMoscow\\Type\\ByteType',
      'FloatType' => 'AppBundle\\Soap\\EMoscow\\Type\\FloatType',
      'DoubleType' => 'AppBundle\\Soap\\EMoscow\\Type\\DoubleType',
      'Base64Type' => 'AppBundle\\Soap\\EMoscow\\Type\\Base64Type',
      'ArrayType' => 'AppBundle\\Soap\\EMoscow\\Type\\ArrayType',
      'StructureType' => 'AppBundle\\Soap\\EMoscow\\Type\\StructureType',
      'AttachmentType' => 'AppBundle\\Soap\\EMoscow\\Type\\AttachmentType',
      'AttachmentsType' => 'AppBundle\\Soap\\EMoscow\\Type\\AttachmentsType',
      'MessageType' => 'AppBundle\\Soap\\EMoscow\\Type\\MessageType',
      'MessagesType' => 'AppBundle\\Soap\\EMoscow\\Type\\MessagesType',
      'HPSMInteractionsFromMosRuKeysType' => 'AppBundle\\Soap\\EMoscow\\Type\\HPSMInteractionsFromMosRuKeysType',
      'HPSMInteractionsFromMosRuInstanceType' => 'AppBundle\\Soap\\EMoscow\\Type\\HPSMInteractionsFromMosRuInstanceType',
      'Description' => 'AppBundle\\Soap\\EMoscow\\Type\\Description',
      'Resolution' => 'AppBundle\\Soap\\EMoscow\\Type\\Resolution',
      'Feedback' => 'AppBundle\\Soap\\EMoscow\\Type\\Feedback',
      'Comments' => 'AppBundle\\Soap\\EMoscow\\Type\\Comments',
      'HPSMInteractionsFromMosRuModelType' => 'AppBundle\\Soap\\EMoscow\\Type\\HPSMInteractionsFromMosRuModelType',
      'RetrieveHPSMInteractionsFromMosRuRequest' => 'AppBundle\\Soap\\EMoscow\\Type\\RetrieveHPSMInteractionsFromMosRuRequest',
      'RetrieveHPSMInteractionsFromMosRuResponse' => 'AppBundle\\Soap\\EMoscow\\Type\\RetrieveHPSMInteractionsFromMosRuResponse',
      'RetrieveHPSMInteractionsFromMosRuKeysListRequest' => 'AppBundle\\Soap\\EMoscow\\Type\\RetrieveHPSMInteractionsFromMosRuKeysListRequest',
      'RetrieveHPSMInteractionsFromMosRuKeysListResponse' => 'AppBundle\\Soap\\EMoscow\\Type\\RetrieveHPSMInteractionsFromMosRuKeysListResponse',
      'RetrieveHPSMInteractionsFromMosRuListRequest' => 'AppBundle\\Soap\\EMoscow\\Type\\RetrieveHPSMInteractionsFromMosRuListRequest',
      'RetrieveHPSMInteractionsFromMosRuListResponse' => 'AppBundle\\Soap\\EMoscow\\Type\\RetrieveHPSMInteractionsFromMosRuListResponse',
      'CreateHPSMInteractionsFromMosRuRequest' => 'AppBundle\\Soap\\EMoscow\\Type\\CreateHPSMInteractionsFromMosRuRequest',
      'CreateHPSMInteractionsFromMosRuResponse' => 'AppBundle\\Soap\\EMoscow\\Type\\CreateHPSMInteractionsFromMosRuResponse',
      'UpdateHPSMInteractionsFromMosRuRequest' => 'AppBundle\\Soap\\EMoscow\\Type\\UpdateHPSMInteractionsFromMosRuRequest',
      'UpdateHPSMInteractionsFromMosRuResponse' => 'AppBundle\\Soap\\EMoscow\\Type\\UpdateHPSMInteractionsFromMosRuResponse',
    );

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(), $wsdl = '/home/ant/src/gsk/src/AppBundle/Command/test.wsdl')
    {
      foreach (self::$classmap as $key => $value) {
        if (!isset($options['classmap'][$key])) {
          $options['classmap'][$key] = $value;
        }
      }
      $options = array_merge(array (
      'features' => 1,
    ), $options);
      parent::__construct($wsdl, $options);
    }

    /**
     * @param RetrieveHPSMInteractionsFromMosRuRequest $RetrieveHPSMInteractionsFromMosRuRequest
     * @return RetrieveHPSMInteractionsFromMosRuResponse
     */
    public function RetrieveHPSMInteractionsFromMosRu(RetrieveHPSMInteractionsFromMosRuRequest $RetrieveHPSMInteractionsFromMosRuRequest)
    {
      return $this->__soapCall('RetrieveHPSMInteractionsFromMosRu', array($RetrieveHPSMInteractionsFromMosRuRequest));
    }

    /**
     * @param RetrieveHPSMInteractionsFromMosRuKeysListRequest $RetrieveHPSMInteractionsFromMosRuKeysListRequest
     * @return RetrieveHPSMInteractionsFromMosRuKeysListResponse
     */
    public function RetrieveHPSMInteractionsFromMosRuKeysList(RetrieveHPSMInteractionsFromMosRuKeysListRequest $RetrieveHPSMInteractionsFromMosRuKeysListRequest)
    {
      return $this->__soapCall('RetrieveHPSMInteractionsFromMosRuKeysList', array($RetrieveHPSMInteractionsFromMosRuKeysListRequest));
    }

    /**
     * @param RetrieveHPSMInteractionsFromMosRuListRequest $RetrieveHPSMInteractionsFromMosRuListRequest
     * @return RetrieveHPSMInteractionsFromMosRuListResponse
     */
    public function RetrieveHPSMInteractionsFromMosRuList(RetrieveHPSMInteractionsFromMosRuListRequest $RetrieveHPSMInteractionsFromMosRuListRequest)
    {
      return $this->__soapCall('RetrieveHPSMInteractionsFromMosRuList', array($RetrieveHPSMInteractionsFromMosRuListRequest));
    }

    /**
     * @param CreateHPSMInteractionsFromMosRuRequest $CreateHPSMInteractionsFromMosRuRequest
     * @return CreateHPSMInteractionsFromMosRuResponse
     */
    public function CreateHPSMInteractionsFromMosRu(CreateHPSMInteractionsFromMosRuRequest $CreateHPSMInteractionsFromMosRuRequest)
    {
      return $this->__soapCall('CreateHPSMInteractionsFromMosRu', array($CreateHPSMInteractionsFromMosRuRequest));
    }

    /**
     * @param UpdateHPSMInteractionsFromMosRuRequest $UpdateHPSMInteractionsFromMosRuRequest
     * @return UpdateHPSMInteractionsFromMosRuResponse
     */
    public function UpdateHPSMInteractionsFromMosRu(UpdateHPSMInteractionsFromMosRuRequest $UpdateHPSMInteractionsFromMosRuRequest)
    {
      return $this->__soapCall('UpdateHPSMInteractionsFromMosRu', array($UpdateHPSMInteractionsFromMosRuRequest));
    }

}
