<?php

namespace AppBundle\Soap\EMoscow\Type;

class HPSMInteractionsFromMosRuKeysType
{

    /**
     * @var StringType $ID
     */
    protected $ID = null;

    /**
     * @var string $query
     */
    protected $query = null;

    /**
     * @var int $updatecounter
     */
    protected $updatecounter = null;

    /**
     * @param string $query
     * @param int $updatecounter
     */
    public function __construct($query, $updatecounter)
    {
      $this->query = $query;
      $this->updatecounter = $updatecounter;
    }

    /**
     * @return StringType
     */
    public function getID()
    {
      return $this->ID;
    }

    /**
     * @param StringType $ID
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuKeysType
     */
    public function setID($ID)
    {
      $this->ID = $ID;
      return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
      return $this->query;
    }

    /**
     * @param string $query
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuKeysType
     */
    public function setQuery($query)
    {
      $this->query = $query;
      return $this;
    }

    /**
     * @return int
     */
    public function getUpdatecounter()
    {
      return $this->updatecounter;
    }

    /**
     * @param int $updatecounter
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuKeysType
     */
    public function setUpdatecounter($updatecounter)
    {
      $this->updatecounter = $updatecounter;
      return $this;
    }

}
