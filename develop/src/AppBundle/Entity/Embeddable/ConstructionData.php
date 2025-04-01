<?php

namespace AppBundle\Entity\Embeddable;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class ConstructionData
{
    public static $versionedProperties = [
        'ObjectName',
        'ObjectArea',
        'ObjectDistrict',
        'ObjectAddress',
        'ConstructionWorkType',
        'MainFunctional',
        'MainFunctionalCode',
        'SourceOfFinance',
        'Square',
        'Floor',
        'ObjectStatus',
        'DeveloperOrgForm',
        'DeveloperOrgName',
        'GeneralContractorOrgForm',
        'GeneralContractorOrgName',
        'CustomerOrgForm',
        'CustomerOrgName',
        'PointXyGeometryCoordinates',
        'LandGeometryCoordinates',
        'ObjectPolygon',
        ];

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ObjectId;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ObjectName;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $objectPolygon;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ObjectArea;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ObjectDistrict;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $objectAddress;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ConstructionWorkType;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $MainFunctional;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $SourceOfFinance;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $Square;
    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $Floor;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ObjectStatus;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $DeveloperOrgForm;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $DeveloperOrgName;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $GeneralContractorOrgForm;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $GeneralContractorOrgName;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $CustomerOrgForm;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $CustomerOrgName;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $PointXyGeometryCoordinates;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $LandGeometryCoordinates;
    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $Deleted;
    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $UpdateDateTime;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, unique=false)
     */
    private $MainFunctionalCode;

    /**
     * @return string
     */
    public function getObjectId()
    {
        return $this->ObjectId;
    }

    /**
     * @param string $ObjectId
     *
     * @return ConstructionData
     */
    public function setObjectId($ObjectId)
    {
        $this->ObjectId = $ObjectId;

        return $this;
    }

    /**
     * @return string
     */
    public function getObjectPolygon()
    {
        return $this->objectPolygon;
    }

    /**
     * @param string $objectPolygon
     *
     * @return $this
     */
    public function setObjectPolygon($objectPolygon)
    {
        $this->objectPolygon = $objectPolygon;

        return $this;
    }

    /**
     * @return string
     */
    public function getObjectName()
    {
        return $this->ObjectName;
    }

    /**
     * @param string $ObjectName
     *
     * @return $this
     */
    public function setObjectName($ObjectName)
    {
        $this->ObjectName = $ObjectName;

        return $this;
    }

    /**
     * @return string
     */
    public function getObjectAddress()
    {
        return $this->objectAddress;
    }

    /**
     * @param string $objectAddress
     *
     * @return $this
     */
    public function setObjectAddress($objectAddress)
    {
        $this->objectAddress = $objectAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getMainFunctionalCode()
    {
        return $this->MainFunctionalCode;
    }

    /**
     * @param string $MainFunctionalCode
     *
     * @return $this
     */
    public function setMainFunctionalCode($MainFunctionalCode)
    {
        $this->MainFunctionalCode = $MainFunctionalCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getMainFunctional()
    {
        return $this->MainFunctional;
    }

    /**
     * @param string $MainFunctional
     *
     * @return $this
     */
    public function setMainFunctional($MainFunctional)
    {
        $this->MainFunctional = $MainFunctional;

        return $this;
    }

    /**
     * @return string
     */
    public function getConstructionWorkType()
    {
        return $this->ConstructionWorkType;
    }

    /**
     * @param string $ConstructionWorkType
     *
     * @return $this
     */
    public function setConstructionWorkType($ConstructionWorkType)
    {
        $this->ConstructionWorkType = $ConstructionWorkType;

        return $this;
    }

    /**
     * @return string
     */
    public function getObjectStatus()
    {
        return $this->ObjectStatus;
    }

    /**
     * @param string $ObjectStatus
     *
     * @return $this
     */
    public function setObjectStatus($ObjectStatus)
    {
        $this->ObjectStatus = $ObjectStatus;

        return $this;
    }

    /**
     * @return int
     */
    public function getFloor()
    {
        return $this->Floor;
    }

    /**
     * @param int $Floor
     *
     * @return $this
     */
    public function setFloor($Floor)
    {
        $this->Floor = $Floor;

        return $this;
    }

    /**
     * @return int
     */
    public function getSquare()
    {
        return $this->Square;
    }

    /**
     * @param int $Square
     *
     * @return $this
     */
    public function setSquare($Square)
    {
        $this->Square = $Square;

        return $this;
    }

    /**
     * @return string
     */
    public function getObjectDistrict()
    {
        return $this->ObjectDistrict;
    }

    /**
     * @param string $ObjectDistrict
     *
     * @return $this
     */
    public function setObjectDistrict($ObjectDistrict)
    {
        $this->ObjectDistrict = $ObjectDistrict;

        return $this;
    }

    /**
     * @return string
     */
    public function getObjectArea()
    {
        return $this->ObjectArea;
    }

    /**
     * @param string $ObjectArea
     *
     * @return $this
     */
    public function setObjectArea($ObjectArea)
    {
        $this->ObjectArea = $ObjectArea;

        return $this;
    }

    /**
     * @return string
     */
    public function getSourceOfFinance()
    {
        return $this->SourceOfFinance;
    }

    /**
     * @param string $SourceOfFinance
     *
     * @return $this
     */
    public function setSourceOfFinance($SourceOfFinance)
    {
        $this->SourceOfFinance = $SourceOfFinance;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeveloperOrgForm()
    {
        return $this->DeveloperOrgForm;
    }

    /**
     * @param string $DeveloperOrgForm
     *
     * @return $this
     */
    public function setDeveloperOrgForm($DeveloperOrgForm)
    {
        $this->DeveloperOrgForm = $DeveloperOrgForm;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeveloperOrgName()
    {
        return $this->DeveloperOrgName;
    }

    /**
     * @param string $DeveloperOrgName
     *
     * @return ConstructionData
     */
    public function setDeveloperOrgName($DeveloperOrgName)
    {
        $this->DeveloperOrgName = $DeveloperOrgName;

        return $this;
    }

    /**
     * @return string
     */
    public function getGeneralContractorOrgForm()
    {
        return $this->GeneralContractorOrgForm;
    }

    /**
     * @param string $GeneralContractorOrgForm
     *
     * @return $this
     */
    public function setGeneralContractorOrgForm($GeneralContractorOrgForm)
    {
        $this->GeneralContractorOrgForm = $GeneralContractorOrgForm;

        return $this;
    }

    /**
     * @return string
     */
    public function getGeneralContractorOrgName()
    {
        return $this->GeneralContractorOrgName;
    }

    /**
     * @param string $GeneralContractorOrgName
     *
     * @return $this
     */
    public function setGeneralContractorOrgName($GeneralContractorOrgName)
    {
        $this->GeneralContractorOrgName = $GeneralContractorOrgName;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerOrgForm()
    {
        return $this->CustomerOrgForm;
    }

    /**
     * @param string $CustomerOrgForm
     *
     * @return $this
     */
    public function setCustomerOrgForm($CustomerOrgForm)
    {
        $this->CustomerOrgForm = $CustomerOrgForm;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerOrgName()
    {
        return $this->CustomerOrgName;
    }

    /**
     * @param string $CustomerOrgName
     *
     * @return $this
     */
    public function setCustomerOrgName($CustomerOrgName)
    {
        $this->CustomerOrgName = $CustomerOrgName;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->Deleted;
    }

    /**
     * @param boolean $Deleted
     *
     * @return ConstructionData
     */
    public function setDeleted($Deleted)
    {
        $this->Deleted = $Deleted;

        return $this;
    }

    /**
     * @return string
     */
    public function getLandGeometryCoordinates()
    {
        return $this->LandGeometryCoordinates;
    }

    /**
     * @param string $LandGeometryCoordinates
     *
     * @return ConstructionData
     */
    public function setLandGeometryCoordinates($LandGeometryCoordinates)
    {
        $this->LandGeometryCoordinates = $LandGeometryCoordinates;

        return $this;
    }

    /**
     * @return string
     */
    public function getPointXyGeometryCoordinates()
    {
        return $this->PointXyGeometryCoordinates;
    }

    /**
     * @param string $PointXyGeometryCoordinates
     *
     * @return ConstructionData
     */
    public function setPointXyGeometryCoordinates($PointXyGeometryCoordinates)
    {
        $this->PointXyGeometryCoordinates = $PointXyGeometryCoordinates;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdateDateTime()
    {
        return $this->UpdateDateTime;
    }

    /**
     * @param DateTime $UpdateDateTime
     *
     * @return ConstructionData
     */
    public function setUpdateDateTime($UpdateDateTime)
    {
        $this->UpdateDateTime = $UpdateDateTime;

        return $this;
    }
}
