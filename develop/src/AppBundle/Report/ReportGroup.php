<?php

namespace AppBundle\Report;


use Doctrine\DBAL\Connection;

class ReportGroup implements ReportInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ReportItem[]
     */
    private $items;

    /**
     * @var int
     */
    private $yearPlanned;

    /**
     * @var int
     */
    private $totalThisYear;

    /**
     * @var int
     */
    private $totalByPeriod;

    /**
     * @param $name string
     * @param $items ReportItem[]
     * @param $yearPlanned int
     */
    public function __construct($name, $items, $yearPlanned)
    {
        $this->name = $name;
        $this->items = $items;
        $this->yearPlanned = $yearPlanned;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getYearPlanned()
    {
        return $this->yearPlanned;
    }

    /**
     * @param $start string
     * @param $end string
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getTotalByPeriod($start, $end)
    {
        if($this->totalByPeriod === null) {
            foreach($this->items as $item) {
                $this->totalByPeriod += $item->getTotalByPeriod($start, $end);
            }
        }

        return $this->totalByPeriod;
    }

    /**
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getTotalThisYear()
    {
        if($this->totalThisYear === null) {
            foreach($this->items as $item) {
                $this->totalThisYear += $item->getTotalThisYear();
            }
        }

        return $this->totalThisYear;
    }

    /**
     * @param Connection $connection
     */
    public function setConnection($connection)
    {
        foreach($this->items as $item) {
            $item->setConnection($connection);
        }
    }

    /**
     * @return ReportItem[]
     */
    public function getItems()
    {
        return $this->items;
    }
} 