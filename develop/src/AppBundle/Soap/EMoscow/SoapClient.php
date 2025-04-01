<?php
namespace AppBundle\Soap\EMoscow;

use AppBundle\Soap\EMoscow\Type\CreateHPSMInteractionsFromMosRuRequest;
use AppBundle\Soap\EMoscow\Type\CreateHPSMInteractionsFromMosRuResponse;
use AppBundle\Soap\EMoscow\Type\Description;
use AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType;
use AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuKeysType;
use AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuModelType;
use AppBundle\Soap\EMoscow\Type\MessagesType;
use AppBundle\Soap\EMoscow\Type\StringType;

/**
 * @method CreateHPSMInteractionsFromMosRuResponse CreateHPSMInteractionsFromMosRu() CreateHPSMInteractionsFromMosRu(CreateHPSMInteractionsFromMosRuRequest $request)
 */
class SoapClient extends \SoapClient
{
    const NS_HP = 'http://schemas.hp.com/SM/7';

    private static $options = [
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE,
        'exceptions' => true,
        'classmap' => [
            'CreateHPSMInteractionsFromMosRuResponse' => CreateHPSMInteractionsFromMosRuResponse::class,
            'HPSMInteractionsFromMosRuModelType' => HPSMInteractionsFromMosRuModelType::class,
            'HPSMInteractionsFromMosRuInstanceType' => HPSMInteractionsFromMosRuInstanceType::class,
            'HPSMInteractionsFromMosRuKeysType' => HPSMInteractionsFromMosRuKeysType::class,
            'StringType' => StringType::class,
            'MessagesType' => MessagesType::class,
        ],
    ];

    public function __construct($wsdl, $options, $username, $password)
    {
        $options = array_merge(self::$options, $options, ['login' => $username, 'password' => $password]);

        parent::__construct($wsdl, $options);
    }

    public function callCreatePortalInteraction($problemType, $description, $portal, $email, $title)
    {
        $description = new StringType($description, 'String', null, null);

        $instance = new HPSMInteractionsFromMosRuInstanceType(null, [$description], [], [], [], null, null, null, null);
        $instance->setUser(new StringType('USERNAME', 'String', null, null));
        $instance->setProblemType(new StringType($problemType, 'String', null, null));
        $instance->setPortal(new StringType($portal, 'String', null, null));
        $instance->setEmail($email);
        $instance->setTitle($title);

        $model = new HPSMInteractionsFromMosRuModelType(null, $instance, null, null);

        $request = new CreateHPSMInteractionsFromMosRuRequest($model, null, null, null, null);

        $response = $this->CreateHPSMInteractionsFromMosRu($request);

        return $response;
    }
}
