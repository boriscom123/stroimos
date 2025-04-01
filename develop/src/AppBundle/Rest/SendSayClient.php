<?php

namespace AppBundle\Rest;

use http\Exception\InvalidArgumentException;

class SendSayClient
{
    protected $baseUrl = 'https://api.sendsay.ru/general/api/v100/json/';
//    protected $baseUrl = 'https://requestinspector.com/inspect/01g8dvnjj5vje0gv1j5hsqsa65';

    public $lastHttpCode = 0;
    public $data = [];
    public $group = '';
    public $endpoints = [
        'issueSend' => 'makeIssueSend',
        'groupList' => 'makeGroupList'
    ];

    /**
     * Client constructor.
     * @param $account
     * @param $key
     * @param string $baseUrl
     * @param array $endpoints
     */
    public function __construct($account, $key, $group = '',  $baseUrl = '', $endpoints = [])
    {
        if (!$account) {
            throw new \InvalidArgumentException('Account argument is required');
        }
        if (!$key) {
            throw new \InvalidArgumentException('Key argument is required');
        }
        $this->endpoints = array_merge($this->endpoints, $endpoints);
        if ($baseUrl) {
            $this->baseUrl = $baseUrl;
        }
        $this->group = $group;
        $this->baseUrl = trim($this->baseUrl, '/') . '/' . strip_tags($account);
        $this->data['apikey'] = strip_tags($key);
    }

    public function makeIssueSend($data)
    {
        if (!isset($data['subject'], $data['url'], $data['message'])) {
            throw new \InvalidArgumentException('"Subject", "Url" and "Message" data is required!');
        }
        return [
            'action' => 'issue.send',
            'issue.format' => 'push',
            'group' => $this->group,
            'sendwhen' => 'now',
            'letter' => [
                'subject' => $data['subject'],
                'click.url' => $data['url'],
                'icon.url' => 'https://image.sendsay.ru/image/x_1682426891713939/sites/icons/1715068923829.png',
                'message' => [
                    'push' => $data['message']
                ]
            ]
        ];
    }

    public function makeGroupList()
    {
        return [
            'action' => 'group.list'
        ];
    }

    /**
     * @param $endpoint
     * @param array $data
     * @return string
     */
    public function __call($endpoint, $data = [])
    {
        if (is_array($data)) {
            $data = array_shift($data);
        }

        $endpoint = strip_tags(trim($endpoint));
        if (!isset($this->endpoints[$endpoint]) || !method_exists($this, $this->endpoints[$endpoint])) {
            throw new \InvalidArgumentException("Endpoint {$endpoint} is not found");
        }

        $this->data = array_merge($this->data, $this->{$this->endpoints[$endpoint]}($data));

        $response = $this->getData($this->baseUrl, $this->data);

        return $response['data'];
    }

    /**
     * @param $url
     * @param array $data
     * @return string[]
     */
    protected static function getData($url, $data = [])
    {
        print_r($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $data = curl_exec($ch);
        $curlInfo = curl_getinfo($ch);
        curl_close($ch);
        return ['data' => $data, 'lastHttpCode' => $curlInfo['http_code']];
    }
}
