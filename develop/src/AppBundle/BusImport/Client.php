<?php

namespace AppBundle\BusImport;

use InvalidArgumentException;
use function http_build_query;
use function is_array;
use function is_string;
use const PHP_QUERY_RFC3986;

class Client
{
    private $client;
    private $baseUrl;
    private $result;

    public function __construct(array $config = [])
    {
        $this->client = curl_init();
        $this->baseUrl = $config['base_uri'];
    }

    public function request($method, $uri = '', array $options = [])
    {
        if (isset($options['query'])) {
            $value = $options['query'];
            if (is_array($value)) {
                $value = http_build_query($value, '', '&', PHP_QUERY_RFC3986);
            }
            if (!is_string($value)) {
                throw new InvalidArgumentException('query must be a string or array');
            }
        } else {
            $options['query'] = '';
        }

        curl_setopt_array(
            $this->client,
            [
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_URL => $this->baseUrl . $uri . '?' . $value,
                CURLOPT_POSTFIELDS => $options['body'],
                CURLOPT_HTTPHEADER => [
                    'Authorization: Basic '. base64_encode($options['auth'][0] . ':' . $options['auth'][1]),
                    'Content-Type: application/xml'
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 60,

            ]
        );

        $this->result = curl_exec($this->client);
        curl_close($this->client);

        return $this->result;
    }
}
