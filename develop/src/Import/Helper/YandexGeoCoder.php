<?php
namespace Import\Helper;

use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

class YandexGeoCoder
{
    protected $cache;
    protected $cacheFile;

    protected static $instance;
    public static function getInstance()
    {
        return self::$instance ?: self::$instance = new self();
    }

    public function __construct()
    {
        $this->cacheFile = __DIR__ . '/../Resources/cache/geocode.yml';

        $this->cache = (new Parser())->parse(file_get_contents($this->cacheFile)) ?: [];
    }

    public function __destruct()
    {
        file_put_contents($this->cacheFile, (new Dumper())->dump($this->cache, 8));
    }

    public function getMetroStationPos($station, $strict = false)
    {
        $url = "https://geocode-maps.yandex.ru/1.x/?format=json&kind=metro&geocode=" .
            urlencode('Россия, Москва, метро ' . $station);

        if (!isset($this->cache[$url])) {
            $this->cache[$url] = $this->query($url);
        }
        $response = $this->cache[$url];


        $geoObject = $response['response']['GeoObjectCollection']['featureMember'][0]['GeoObject'];

        if ($strict && 'metro' !== $geoObject['metaDataProperty']['GeocoderMetaData']['kind']) {
            return null;
        }

        return explode(' ', $geoObject['Point']['pos']);
    }

    public function getRoadPos($station, $strict = false)
    {
        $url = "https://geocode-maps.yandex.ru/1.x/?format=json&geocode=" .
            urlencode('Россия, Москва, ' . $station);

        if (!isset($this->cache[$url])) {
            $this->cache[$url] = $this->query($url);
        }
        $response = $this->cache[$url];


        $geoObject = $response['response']['GeoObjectCollection']['featureMember'][0]['GeoObject'];

        if ($strict && 'street' !== $geoObject['metaDataProperty']['GeocoderMetaData']['kind']) {
            return null;
        }

        return explode(' ', $geoObject['Point']['pos']);
    }

    protected function query($url)
    {
        return json_decode(file_get_contents($url), true);
    }
}
