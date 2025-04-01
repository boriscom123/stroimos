<?php

namespace AppBundle\Form\Extension;

class YandexCaptcha
{
    private $secret; //Ключ сервера

    public function __construct($secret)
    {
        if (empty($secret)) {
            throw new \RuntimeException('No secret provided');
        }

        if (!is_string($secret)) {
            throw new \RuntimeException('The provided secret must be a string');
        }

        $this->secret = $secret;
    }

    public function verify($token, $remoteIp = null)
    {
        $ch = curl_init();

        $args = http_build_query([
            "secret" => $this->secret,
            "token" => $token,
            "ip" => $remoteIp,
        ]);

        curl_setopt($ch, CURLOPT_URL, 'https://captcha-api.yandex.ru/validate?' . $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);

        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode !== 200) {
            echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
            return false;
        }

        $resp = json_decode($server_output);
        return $resp->status === "ok";
    }
}
