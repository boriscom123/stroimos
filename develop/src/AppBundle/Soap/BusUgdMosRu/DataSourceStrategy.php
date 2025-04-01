<?php
namespace AppBundle\Soap\BusUgdMosRu;

interface DataSourceStrategy
{
    public function getNext();

    public function confirm();
}
