<?php

namespace AppBundle\BusImport;

use AppBundle\BusImport\Client;
use AppBundle\Model\ValueObject\XmlConstructor;

/**
 * @property BusUgd $objects
 */
class BusUgd
{
    const OBJECTS_URL = '/sg/app/ugd/ps/openApi/findObjectsUsingXmlFilter';
    const PROJECTS_URL = '/sg/app/ugd/ps/openApi/findProjectsUsingXmlFilter';

    const DEFAULT_PAGE = 0;
    const DEFAULT_LIMIT = 50;

    private $endpoint_url;
    private $login;
    private $password;

    private $client;
    private $filter;

    public function __construct($base_app_url, $login, $password)
    {
        $this->login = $login;
        $this->password = $password;
        $this->client = new Client(['base_uri' => trim($base_app_url, '/'), 'timeout' => 20.0]);
    }

    public function getFilters()
    {
        return $this->filter;
    }

    public function __get($name)
    {
        switch ($name):
            case 'objects':
                $this->endpoint_url = self::OBJECTS_URL;
                break;
            case 'projects':
                $this->endpoint_url = self::PROJECTS_URL;
                break;
            default:
                throw new \InvalidArgumentException('Нет такого свойства: ' . $name);
        endswitch;

        return $this;
    }

    public function __set($name, $arg)
    {
    }

    public function __isset($name)
    {
    }

    public function from($date)
    {
        $this->filter[] = ['filter_name' => 'dateLastUpdate', 'filter_type' => 1, 'filter_value' => self::dateFormat($date)];

        return $this;
    }

    private static function dateFormat($date)
    {
        $date = new \DateTime(trim($date, '%'));
        return $date->format('Y-m-d\TH:i:s');
    }

    public function where($condition = [])
    {
        foreach ($condition as $column => $value) {

            if (strpos($column, 'date') !== false) {
                $this->filter[] = ['filter_name' => $column, 'filter_type' => $this->getFilterType($value), 'filter_value' => self::dateFormat($value)];
            } else if (is_array($value)) {
                foreach ($value as $type => $data) {
                    $this->filter[] = ['filter_name' => $column, 'filter_type' => $this->getFilterType($data), 'filter_value' => $data, 'filter_dataType' => $type];
                }
            } else {
                $this->filter[] = ['filter_name' => $column, 'filter_type' => $this->getFilterType($value), 'filter_value' => $value];
            }
        }

        return $this;
    }

    private function getFilterType($value = '')
    {
        $filter_types = ['1' => "@\%(.*)\%$@", '2' => "@^(.*)\%$@", '3' => "@^\%(.*)$@"];

        foreach ($filter_types as $type => $regExp) {
            if (preg_match($regExp, $value)) {
                return $type;
            }
        }

        if (!empty($value)) {
            return 4;
        }

        return 5;
    }

    public function first($page = self::DEFAULT_PAGE, $limit = self::DEFAULT_LIMIT)
    {
        $json = $this->get($page, $limit);

        return $json[0];
    }

    public function get($page = self::DEFAULT_PAGE, $limit = self::DEFAULT_LIMIT)
    {
        $response = $this->client->request(
            'POST',
            $this->endpoint_url,
            [
                'auth' => [$this->login, $this->password],
                'query' => ['skip' => $page, 'top' => $limit],
                'body' => (is_array($this->filter)) ? self::makeXml($this->filter) : '',
            ]
        );


        return json_decode($response, false);
    }

    private static function makeXml($params)
    {
        $xml = new XmlConstructor();

        $filter = [];

        foreach ($params as $param) {
            $filter[] = [
                'tag' => 'filter',
                'attributes' => [
                    'attr_name' => $param['filter_name'],
                    'filt_type' => $param['filter_type'],
//                    'filt_value' => isset($param['filter_dataType']) ? $param['filter_dataType'] : '',
                ],
                'content' => trim($param['filter_value'], '%')
            ];
        }

        $data = [
            [
                'tag' => 'filters',
                'elements' => $filter,
            ],
        ];

        return $xml->fromArray($data)->toOutput();
    }
}
