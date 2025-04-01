<?php

namespace AppBundle\Report;

use Doctrine\DBAL\Connection;

interface ReportInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return int
     */
    public function getYearPlanned();

    /**
     * @param $start string
     * @param $end string
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getTotalByPeriod($start, $end);

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @return int
     */
    public function getTotalThisYear();

    /**
     * @param Connection $connection
     */
    public function setConnection($connection);
} 