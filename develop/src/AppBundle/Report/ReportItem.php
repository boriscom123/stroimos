<?php

namespace AppBundle\Report;

use Doctrine\DBAL\Connection;
use PDO;

class ReportItem implements ReportInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $condition = '';

    /**
     * @var string
     */
    private $tableName;

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
     * @var Connection
     */
    private $connection;
    /**
     * @var string
     */
    private $fieldNameWithCreationDate;

    /**
     * @param $name string
     * @param $tableName string
     * @param string $condition string
     * @param null $yearPlanned int
     */
    public function __construct($name, $tableName, $condition = '', $yearPlanned = null, $fieldNameWithCreationDate = 'created_at' )
    {
        $this->name = $name;
        $this->tableName = $tableName;
        $this->condition = $condition;
        $this->yearPlanned = $yearPlanned;
        $this->fieldNameWithCreationDate = $fieldNameWithCreationDate;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
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
            $this->totalByPeriod = $this->getResult($start, $end);
        }

        return $this->totalByPeriod ;
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @return int
     */
    public function getTotalThisYear()
    {
        if($this->totalThisYear === null) {
            $now = (new \DateTime());
            $start = (new \DateTime('first day of January ' . $now->format('Y')))->format('Y-m-d') . ' 00:00:00';
            $end = (new \DateTime())->format('Y-m-d') . ' 00:00:00';
            $this->totalThisYear = $this->getResult($start, $end);
        }

        return $this->totalThisYear;
    }

    /**
     * @param $start string
     * @param $end string
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    private function getResult($start, $end)
    {
        $statement = $this->connection->prepare($this->getQuery());
        $statement->bindValue('start', $start);
        $statement->bindValue('end', $end);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_NUM);

        return is_array($result) ? $result[0] : $result;
    }

    private function getQuery()
    {

        $q = sprintf(
            'select count(*) from %s where %s between :start and :end',
            $this->getTableName(),
            $this->fieldNameWithCreationDate
        );
        if(!empty($this->getCondition())) {
            $q .= ' and ' . $this->getCondition();
        }

        return $q;
    }

    /**
     * @param Connection $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}
