<?php

namespace AppBundle\Entity;

use Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity;
use Amg\Bundle\AdminBundle\Model\LockableEntityTrait;
use Amg\DataCore\Model\AdministrativeUnit\AdministrativeUnitTrait;
use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Metadata\MetadataTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\RelevantNewsShown\RelevantNewsShownInterface;
use Amg\DataCore\Model\RelevantNewsShown\RelevantNewsShownTrait;
use Amg\DataCore\Model\Searchable\SearchableTrait;
use Amg\DataCore\Model\Teasing\TeasingInterface;
use Amg\DataCore\Model\Teasing\TeasingTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Entity\Embeddable\ConstructionData;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Model\ConstructionObjectInterface;
use AppBundle\Model\CoordinatesInterface;
use AppBundle\Model\EntityReferenceTrait;
use AppBundle\Model\ExtraInformationTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\MediaImageInterface;
use AppBundle\Model\MobileContentfulInterface;
use AppBundle\Model\MobileContentfulTrait;
use AppBundle\Model\OrganizationTrait;
use AppBundle\Model\PanoramaTrait;
use AppBundle\Model\RelatedTrait;
use AppBundle\Model\ValueObject\GeoPoint;
use AppBundle\Model\ValueObject\GeoPolygon;
use AppBundle\Search\SearchDataInterface;
use AppBundle\Soap\BusUgdMosRu\SoapResponse;
use Application\Sonata\MediaBundle\Entity\Media;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use GeoPHP\Geo;
use InvalidArgumentException;
use JMS\Serializer\Annotation as Serializer;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use proj4php\Point as CPoint;
use proj4php\Proj;
use proj4php\Proj4php;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ConstructionRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\EntityListeners({"AppBundle\Entity\Listener\ConstructionListener"})
 *
 * @Serializer\ExclusionPolicy("ALL")
 * @Serializer\AccessorOrder("custom", custom = {"id", "func", "status", "name", "address", "developer", "description", "finance", "functional", "coords", "distance"})
 */
class Construction implements TeasingInterface, PublishableInterface, RelevantNewsShownInterface, MetadataInterface, LockableEntity, ConstructionObjectInterface, SearchDataInterface, MediaImageInterface, CoordinatesInterface, MobileContentfulInterface
{
    use TeasingTrait, ContentfulTrait, ImageTrait, RelatedTrait, PublishableTrait, SearchableTrait, RelevantNewsShownTrait, AdministrativeUnitTrait, MetadataTrait, TimestampableTrait, ORMBehaviors\Blameable\Blameable, LockableEntityTrait, EntityReferenceTrait, PanoramaTrait, OrganizationTrait, ExtraInformationTrait, MobileContentfulTrait;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $areaOfTheTerritory;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $roominess;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $numberOfParkingPlaces;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $startYear;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $endYear;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $projectSeries;
    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     */
    protected $tour3D;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $projectDesigner;
    /**
     * @var ConstructionData Набор данных, пришедших из шины, принятый в качестве базового для отображения на сайте
     *
     * @ORM\Embedded(class="AppBundle\Entity\Embeddable\ConstructionData")
     */
    protected $data;
    /**
     * @var ConstructionData Набор обновлённых данных, пришедших из шины, предназначенный для просмотра пользователем администранивного интерфейса и последующего принятия в качестве базового для отображения на сайте
     *
     * @ORM\Embedded(class="AppBundle\Entity\Embeddable\ConstructionData")
     */
    protected $pendingData;
    /**
     * @var ConstructionData Набор вручную откорректированных данных для отображения на сайте, переопределяющих данные базовго набора
     *
     * @ORM\Embedded(class="AppBundle\Entity\Embeddable\ConstructionData")
     */
    protected $customData;
    /**
     * @var float|null
     */
    protected $distance;
    /**
     * @var Point
     * @ORM\Column(type="point", nullable=true)
     */
    protected $point;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Accessor(getter="getId")
     * @Serializer\SerializedName("id")
     * @Serializer\Groups({"api"})
     * @Serializer\Expose
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    private $objectId;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    private $uniqueId;
    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $objectUpdateDateTime;
    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $objectName;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $objectAddress;
    /**
     * @var ConstructionParameterValue[]|ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\ConstructionParameterValue",
     *     mappedBy="construction",
     *     cascade={"persist","remove"},
     *     orphanRemoval=true
     * )
     */
    private $constructionParameterValues;
    /**
     * @var Date
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $planDateEnd;
    /**
     * @var Date
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $factDateEnd;
    /**
     * @var Date
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $planDateInput;
    /**
     * @var Date
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $factDateInput;
    /**
     * @var Date
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $planDateStart;
    /**
     * @var Date
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $factDateStart;

    /**
     * @var bool
     *
     * @ORM\Column(name="new", type="boolean")
     */
    private $new;

    /**
     * @var bool
     *
     * @ORM\Column(name="updated", type="boolean")
     */
    private $updated;

    public function __construct()
    {
        $this->data = new ConstructionData();
        $this->pendingData = new ConstructionData();
        $this->customData = new ConstructionData();
        $this->constructionParameterValues = new ArrayCollection();
    }

    public static function extractDataFromSoapResponse(SoapResponse $soapResponse)
    {
        $constructionData = new ConstructionData();

        //region fields with no conversion required
        $noConversionFields = ['ObjectID', 'ObjectName', 'ObjectArea', 'ObjectDistrict', 'ObjectAddress', 'ConstructionWorkType', 'MainFunctional', 'SourceOfFinance', 'ObjectStatus', 'DeveloperOrgForm', 'DeveloperOrgName',];

        foreach ($noConversionFields as $fieldName) {
            $value = $soapResponse->$fieldName;
            if (null !== $value) {
                $constructionData->{'set' . $fieldName}($value);
            }
        }
        //endregion

        //region fields with conversion required
        if ($floor = filter_var($soapResponse->Floor, FILTER_VALIDATE_INT)) {
            $constructionData->setFloor($floor);
        }

        if ($square = filter_var(str_replace('.', '', str_replace(' ', '', $soapResponse->Square)), FILTER_VALIDATE_INT)) {
            $constructionData->setSquare($square);
        }

        if ($soapResponse->PointXyContourGeometryPointCoordinates) {
            try {
                $geoPoint = GeoPoint::createFromLonLatString($soapResponse->PointXyContourGeometryPointCoordinates);
                $constructionData->setPointXyGeometryCoordinates($geoPoint->getLonLatString());
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage();
            }
        }

        if ($soapResponse->LandContourGeometryPolygonOuterBoundaryIsLinearRingCoordinates) {
            try {
                $geoPolygon = GeoPolygon::createFromGmlCoordinates($soapResponse->LandContourGeometryPolygonOuterBoundaryIsLinearRingCoordinates);
                $constructionData->setLandGeometryCoordinates($geoPolygon->getJsonForYandex());
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage();
            }
        }

        $constructionData->setUpdateDateTime(new DateTime($soapResponse->UpdateDateTime));
        //endregion

        return $constructionData;
    }

    //todo: time to subway station

    /**
     * @throws \GeoPHP\Exception
     */
    public static function extractDataFromBusResponse($response)
    {
        $constructionData = new ConstructionData();

        $orgList = self::extractDataOrgResponse($response);

        $codeGroupInput = (int)preg_replace('/\s+/', '', $response->docContent->fno->codeObjFuncObj);
        $constructionData->setMainFunctionalCode($codeGroupInput);
        $constructionData->setObjectAddress($response->docContent->basicDataCco->buildingAddress);

        if (!empty($response->docContent->basicDataCco->areas[0])) {
            $constructionData->setObjectArea($response->docContent->basicDataCco->areas[0]);
        }

        if (!empty($response->docContent->basicDataCco->districts[0])) {
            $constructionData->setObjectDistrict($response->docContent->basicDataCco->districts[0]);
        }

        $constructionData->setObjectName($response->docContent->basicDataCco->nameObject);
        $constructionData->setConstructionWorkType($response->docContent->basicDataCco->jobType);
        $constructionData->setObjectStatus($response->docContent->basicDataCco->state);
        $constructionData->setMainFunctional($response->docContent->fno->nameObjFuncObj);
        //$constructionData->setObjectSerias($response->docContent->basicDataCco->state); //todo: допилить базу

        $cords = $response->docContent->basicDataCco->cords;
        if (!empty($cords)) {
            $constructionData->setObjectPolygon($cords);
            $constructionData->setPointXyGeometryCoordinates(implode(',', self::getCordsXY($cords)));
            $constructionData->setLandGeometryCoordinates(json_encode(self::getCordsPolygon($cords)));
        }

        $constructionData->setMainFunctional($response->docContent->fno->nameObjFuncObj);

        if (!empty($orgList['DeveloperForm'])) $constructionData->setDeveloperOrgForm($orgList['DeveloperForm']);
        if (!empty($orgList['DeveloperName'])) $constructionData->setDeveloperOrgName($orgList['DeveloperName']);

        if (!empty($orgList['GeneralContractorForm'])) $constructionData->setGeneralContractorOrgForm($orgList['GeneralContractorForm']);
        if (!empty($orgList['GeneralContractorName'])) $constructionData->setGeneralContractorOrgName($orgList['GeneralContractorName']);

        if (!empty($orgList['CustomerForm'])) $constructionData->setCustomerOrgForm($orgList['CustomerForm']);
        if (!empty($orgList['CustomerName'])) $constructionData->setCustomerOrgName($orgList['CustomerName']);

        $constructionData->setUpdateDateTime(new DateTime($response->docHeader->dateLastUpdate));
        //todo: дополнить метод для данных 11.2.1 Признак объекта реновации

        return $constructionData;
    }

    public static function extractDataOrgResponse($response)
    {
        $resultOrgArray = [];

        if (!is_array($response->docContent->org)) {
            return false;
        }

        foreach ($response->docContent->org as $org) {
            if ($org->orgRole === 'Застройщик') {
                $resultOrgArray['DeveloperName'] = $org->orgNameFull;
                $resultOrgArray['DeveloperForm'] = $org->orgShortName;
            } elseif ($org->orgRole === 'Генеральный подрядчик') {
                $resultOrgArray['GeneralContractorName'] = $org->orgNameFull;
                $resultOrgArray['GeneralContractorForm'] = $org->orgShortName;
            } elseif ($org->orgRole === 'Технический заказчик') {
                $resultOrgArray['CustomerName'] = $org->orgNameFull;
                $resultOrgArray['CustomerForm'] = $org->orgShortName;
            }
        }

        return $resultOrgArray;
    }

    /**
     * @throws \GeoPHP\Exception
     */
    public static function getCordsXY($geometryCollection)
    {
        $centroid_cords = Geo::load($geometryCollection)->getCentroid()->coords;
        if($centroid_cords) {
            return self::convertToLatLong($centroid_cords[0], $centroid_cords[1]);
        }

        return [];
    }

    /**
     * @throws \GeoPHP\Exception
     */
    private static function getCordsPolygon($geometryCollection)
    {
        $Geo = Geo::load($geometryCollection);
        $arrGeo = $Geo->asArray();
        $typeGeo = $Geo->geometryType();

        foreach ($arrGeo as $item) {
            if (isset($item['components'], $item['type'])) {
                switch ($item['type']) {
                    case 'MultiPolygon':
                        $result[] = $item['components'][0][0];
                        break;
                    case 'Polygon':
                        $result[] = $item['components'][0];
                        break;
                    default:
                        $result[] = $item['components'][0];
                        break;
                }
            }
            else {
                $result[] = $item;
            }
        }



        foreach ($result as &$polygon) {
            foreach ($polygon as &$point) {
                $point = self::convertCoords($point);
            }
        }

        return isset($result) ? $result : false;
    }

    private static function convertCoords($coords)
    {
        $proj4 = new Proj4php();
        $proj4->addDef("EPSG:6335000", '+proj=tmerc +lat_0=55.66666666667 +lon_0=37.5 +k=1 +x_0=16.098 +y_0=14.512 +ellps=bessel +towgs84=316.151,78.924,589.65,-1.57273,2.69209,2.34693,8.45069999999559 +units=m +no_defs +type=crs');

        $projEPSG = new Proj('EPSG:6335000', $proj4);
        $projEPSGq = new Proj('EPSG:4326', $proj4);

        $pointSrc = new CPoint($coords[0], $coords[1], $projEPSG);
        $result = $proj4->transform($projEPSGq, $pointSrc)->toArray();
        return [$result[0], $result[1]];
    }

    /**
     * @param $xCords
     * @param $yCords
     * @return array
     */
    public static function convertToLatLong($xCords, $yCords)
    {
        $proj4 = new Proj4php();
        $proj4->addDef("EPSG:6335000", '+proj=tmerc +lat_0=55.66666666667 +lon_0=37.5 +k=1 +x_0=16.098 +y_0=14.512 +ellps=bessel +towgs84=316.151,78.924,589.65,-1.57273,2.69209,2.34693,8.45069999999559 +units=m +no_defs +type=crs');
        //$proj4->addDef("EPSG:6335000", '+proj=tmerc +lat_0=55.6666666666667 +lon_0=37.5 +k=1 +x_0=113 +y_0=-38 +ellps=bessel +units=m +no_defs');

        $projEPSG = new Proj('EPSG:6335000', $proj4);
        $projEPSGq = new Proj('EPSG:4326', $proj4);

        $pointSrc = new CPoint($xCords, $yCords, $projEPSG);
        $pointDest = $proj4->transform($projEPSGq, $pointSrc);

        $cords = $pointDest->toArray();
        return [$cords[0], $cords[1]];
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("distance")
     * @Serializer\Groups({"api"})
     * @return float|null
     */
    public function getDistance()
    {
        return $this->distance;
    }

    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    public function getAddress()
    {
        return $this->getDataField('ObjectAddress');
    }

    public function getDataField($field, $fallback = null)
    {
        static $propertyAccessor;
        if (!isset($propertyAccessor)) {
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        if ($value = $propertyAccessor->getValue($this->getCustomData(), $field)) {
            return $value;
        }

        if ($value = $propertyAccessor->getValue($this->getData(), $field)) {
            return $value;
        }

        return $fallback;
    }

    /**
     * @return ConstructionData
     */
    public function getCustomData()
    {
        return $this->customData;
    }

    /**
     * @param ConstructionData $customData
     * @return $this
     */
    public function setCustomData($customData)
    {
        $this->customData = $customData;
        return $this;
    }

    /**
     * @return ConstructionData
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param ConstructionData $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAreaOfTheTerritory()
    {
        return $this->areaOfTheTerritory;
    }

    /**
     * @param int $areaOfTheTerritory
     * @return $this
     */
    public function setAreaOfTheTerritory($areaOfTheTerritory)
    {
        $this->areaOfTheTerritory = $areaOfTheTerritory;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoominess()
    {
        return $this->roominess;
    }

    /**
     * @param string $roominess
     * @return $this
     */
    public function setRoominess($roominess)
    {
        $this->roominess = $roominess;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfParkingPlaces()
    {
        return $this->numberOfParkingPlaces;
    }

    /**
     * @param int $numberOfParkingPlaces
     * @return $this
     */
    public function setNumberOfParkingPlaces($numberOfParkingPlaces)
    {
        $this->numberOfParkingPlaces = $numberOfParkingPlaces;
        return $this;
    }

    public function setEndYearFromSoapResponse(SoapResponse $response)
    {
        $endYear = (int)substr($response->ExpireDate, 0, 4);
        if ($endYear && $endYear > 0) {
            $this->setEndYear($endYear);
        }
    }

    public function setEndYearFromBusResponse($response)
    {
        $endYear = (int)substr($response->docContent->datesCco->factDateEnd, 0, 4);
        if ($endYear && $endYear > 0) {
            $this->setEndYear($endYear);
        }
    }
    public function setStartYearFromBusResponse($response)
    {
        $startYear = (int)substr($response->docContent->datesCco->factDateStart, 0, 4);
        if ($startYear && $startYear > 0) {
            $this->setStartYear($startYear);
        }
    }

    /**
     * @throws Exception
     */
    public function parsePlanDateFromBusResponse($response, $resource)
    {
        $dateArray = $response->docContent->datesCco->{$resource};

        if (is_null($dateArray)) {
            return false;
        }

        if (strpos($resource, 'fact') !== false) {
            return new \DateTime($dateArray);
        }

        if($dateArray->date !== NULL) {
            return new \DateTime($dateArray->date);
        }

        return false;
    }

    /**
     * @return string
     */
    public function getProjectSeries()
    {
        return $this->projectSeries;
    }

    /**
     * @param string $projectSeries
     *
     * @return ConstructionData
     */
    public function setProjectSeries($projectSeries)
    {
        $this->projectSeries = $projectSeries;

        return $this;
    }

    /**
     * @return Media
     */
    public function getTour3D()
    {
        return $this->tour3D;
    }

    /**
     * @param Media $tour3D
     * @return $this
     */
    public function setTour3D(Media $tour3D = null)
    {
        $this->tour3D = $tour3D;
        return $this;
    }

    /**
     * @return string
     */
    public function getProjectDesigner()
    {
        return $this->projectDesigner;
    }

    /**
     * @param string $projectDesigner
     *
     * @return Construction
     */
    public function setProjectDesigner($projectDesigner)
    {
        $this->projectDesigner = $projectDesigner;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getObjectUpdateDateTime()
    {
        return $this->objectUpdateDateTime;
    }

    public function __get($name)
    {
        return $this->getDataField($name);
    }

    public function __toString()
    {
        $string = $this->getTitle() ?: '(объект строительства без названия)';
        $string .= ' ';

        if ($address = $this->getDataField('objectAddress')) {
            $string .= '(' . $address . ')';
        }

        return $string;
    }

    public function getTitle()
    {
        $pendingData = $this->getPendingData();
        $fallbackTitle = null !== $pendingData ? $pendingData->getObjectName() : null;

        return $this->getDataField('ObjectName', $fallbackTitle);
    }

    /**
     * @return ConstructionData
     */
    public function getPendingData()
    {
        return $this->pendingData;
    }

    /**
     * @param ConstructionData $pendingData
     *
     * @return Construction
     */
    public function setPendingData($pendingData)
    {
        $this->pendingData = $pendingData;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("name")
     * @Serializer\Groups({"api"})
     * @return string
     */
    public function getObjectName()
    {
        return $this->objectName;
    }

    /**
     * @ORM\PrePersist
     */
    public function assignObjectId()
    {
        $data = $this->isNewDataPending() ? $this->getPendingData() : $this->getData();

//        $objectId = $data->getObjectId();
//        $uniqueId = $data->getUniqueId();
//
//        $this->objectId = $objectId;
//        $this->uniqueId = $uniqueId;
    }

    public function isNewDataPending() // данные обновлены
    {
        $pendingData = $this->getPendingData();

        return null !== $pendingData && null !== $pendingData->getUpdateDateTime();
        //return null !== $pendingData;
    }

    /**
     * @return string
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateObjectName()
    {
        $this->objectName = $this->getTitle();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateObjectAddress()
    {
        $this->objectAddress = $this->getDataField('ObjectAddress');
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateUpdateDateTime()
    {
        $data = $this->isNewDataPending() ? $this->getPendingData() : $this->getData();

        $dateTime = $data->getUpdateDateTime();

        if ($dateTime instanceof DateTime) {
            $this->objectUpdateDateTime = $dateTime;
        }
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateDeletedStatus()
    {
        $data = $this->isNewDataPending() ? $this->getPendingData() : $this->getData();

        $isDeleted = $data->isDeleted();
        if (isset($isDeleted)) {
            $this->deleted = $isDeleted;
        }
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     *
     * @return Construction
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function acceptPendingData()
    {
        if ($this->isNewDataPending()) {
            $this->setData($this->getPendingData());

            $this->setPendingData(null);
        }
    }

    public function getSearchData()
    {
        return $this->getAddressText() . ' ' . $this->getData()->getDeveloperOrgName() . ' ' . $this->getData()->getMainFunctional() . ' ' . $this->getData()->getObjectName();
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("address")
     * @Serializer\Groups({"api"})
     * @return string
     */
    public function getAddressText()
    {
        return $this->objectAddress;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("coords")
     * @Serializer\Groups({"api"})
     * @return GeoPoint
     */
    public function getGeoPointCoordinatesInGeoJson()
    {
        $geoPoint = GeoPoint::createFromLonLatString($this->getDataField('PointXyGeometryCoordinates'));

        return json_encode($geoPoint->getLonLatArray());
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("polygon")
     * @Serializer\Groups({"api"})
     * @return GeoPoint
     */
    public function getGeoPolygonInGeoJson()
    {
        return $this->getDataField('LandGeometryCoordinates');
    }

    public function getGeoPointAsLonLatArray()
    {
        $lonLatString = $this->getDataField('PointXyGeometryCoordinates');
        if (empty($lonLatString)) {
            return null;
        }
        $geoPoint = GeoPoint::createFromLonLatString($lonLatString);

        return $geoPoint->getLonLatArray();
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("func")
     * @Serializer\Groups({"api"})
     * @Serializer\Type("string")
     *
     * @return string
     */
    public function getFunctionalPurpose()
    {
        return $this->getCustomData()->getMainFunctional();
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("developer")
     * @Serializer\Groups({"api"})
     * @Serializer\Type("string")
     *
     * @return string
     */
    public function getDeveloper()
    {
        if ($this->getData()->getDeveloperOrgName()) {
            return $this->getData()->getDeveloperOrgForm() . ' «' . $this->getData()->getDeveloperOrgName() . '»';
        }
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("finance")
     * @Serializer\Groups({"api"})
     * @Serializer\Type("string")
     *
     * @return string
     */
    public function getSourceOfFinance()
    {
        return $this->getData()->getSourceOfFinance();
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("status")
     * @Serializer\Groups({"api"})
     * @Serializer\Type("string")
     *
     * @return ConstructionStatus
     */
    public function getConstructionStatus()
    {
        return ConstructionStatus::create($this->getCustomData()->getObjectStatus());
    }

    /** @return int|null */
    public function getConstructionStartYear()
    {
        return $this->getStartYear();
    }

    /**
     * @return int
     */
    public function getStartYear()
    {
        return $this->startYear;
    }

    /**
     * @param int $startYear
     * @return $this
     */
    public function setStartYear($startYear)
    {
        $this->startYear = $startYear;
        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("end_year")
     * @Serializer\Groups({"api"})
     * @Serializer\Type("string")
     *
     * @return string
     */
    public function getConstructionEndYear()
    {
        return $this->getEndYear();
    }

    /**
     * @return int
     */
    public function getEndYear()
    {
        return $this->endYear;
    }

    /**
     * @param int $endYear
     * @return $this
     */
    public function setEndYear($endYear)
    {
        $this->endYear = $endYear;
        return $this;
    }

    /**
     * @return Date
     */
    public function getPlanDateEnd()
    {
        return $this->planDateEnd;
    }

    /**
     * @param datetime $planDateEnd
     * @return $this
     */
    public function setPlanDateEnd($planDateEnd)
    {
        $this->planDateEnd = $planDateEnd;
        return $this;
    }
    /**
     * @return Date
     */
    public function getFactDateEnd()
    {
        return $this->factDateEnd;
    }

    /**
     * @param datetime $factDateEnd
     * @return $this
     */
    public function setFactDateEnd($factDateEnd)
    {
        $this->factDateEnd = $factDateEnd;
        return $this;
    }
    /**
     * @return Date
     */
    public function getPlanDateInput()
    {
        return $this->planDateInput;
    }

    /**
     * @param datetime $planDateInput
     * @return $this
     */
    public function setPlanDateInput($planDateInput)
    {
        $this->planDateInput = $planDateInput;
        return $this;
    }
    /**
     * @return Date
     */
    public function getFactDateInput()
    {
        return $this->factDateInput;
    }

    /**
     * @param datetime $factDateInput
     * @return $this
     */
    public function setFactDateInput($factDateInput)
    {
        $this->factDateInput = $factDateInput;
        return $this;
    }

    /**
     * @return Date
     */
    public function getPlanDateStart()
    {
        return $this->planDateStart;
    }

    /**
     * @param datetime $planDateStart
     * @return $this
     */
    public function setPlanDateStart($planDateStart)
    {
        $this->planDateStart = $planDateStart;
        return $this;
    }
    /**
     * @return Date
     */
    public function getFactDateStart()
    {
        return $this->factDateStart;
    }

    /**
     * @param datetime $factDateStart
     * @return $this
     */
    public function setFactDateStart($factDateStart)
    {
        $this->factDateStart = $factDateStart;
        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("district")
     * @Serializer\Groups({"api"})
     * @Serializer\Type("string")
     *
     * @return string
     */
    public function getCustomDataDistrict()
    {
        return $this->getCustomData()->getObjectDistrict();
    }

    public function getConstructionStatusTranslations()
    {
        return ConstructionStatus::$labels;
    }

    /**
     * @return string|null
     */
    public function getCoordinates()
    {
        return $this->getDataField('PointXyGeometryCoordinates', null);
    }

    /**
     * @param ConstructionParameterValue $value
     * @return $this
     */
    public function addConstructionParameterValue(ConstructionParameterValue $value)
    {
        $value->setConstruction($this);
        $this->getConstructionParameterValues()->add($value);

        return $this;
    }

    /**
     * @return ConstructionParameterValue[]|ArrayCollection
     */
    public function getConstructionParameterValues()
    {
        return $this->constructionParameterValues;
    }

    /**
     * @param ConstructionParameterValue[]|ArrayCollection $constructionParameterValues
     */
    public function setConstructionParameterValues($constructionParameterValues)
    {
        $this->constructionParameterValues = $constructionParameterValues;
    }

    /**
     * @param ConstructionParameterValue $value
     * @return $this
     */
    public function removeConstructionParameterValue(ConstructionParameterValue $value)
    {
        $this->getConstructionParameterValues()->removeElement($value);

        return $this;
    }

    /**
     * @return Point
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * @param Point $point
     */
    public function setPoint($point)
    {
        $this->point = $point;
    }

    public function isImported()
    {
        return $this->createdBy === null && $this->updatedBy === null;
    }

    /*public function isUpdated()
    {
        $customData = $this->getCustomData();
        $pendingData = $this->getPendingData();
        $mainData = $this->getData();

        $versionedInput = ConstructionData::$versionedProperties;

        foreach ($versionedInput as $input) {
            if($input === 'MainFunctional' || $input === 'ObjectStatus' ) {
                continue;
            }

            $getter = 'get' . $input;
            $control= [];
            $control2= [];

            if($pendingData->$getter() !== null && $mainData->$getter() !== null && $customData->$getter() !== null) {
                $control[$getter] = $customData->$getter();
                $control2[$getter] = $pendingData->$getter();
            }
        }

        if (count($control) > 0 && $this->updatedBy !== null) {
            var_dump($control);
            var_dump($control2);
            return false;
        }

        return true;

        //return $this->createdBy === null && $this->updatedBy !== null;
    }*/

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * @param bool $new
     */
    public function setNew($new)
    {
        $this->new = $new;
    }

    /**
     * @return bool
     */
    public function isUpdated()
    {
        return $this->updated;
    }

    /**
     * @param bool $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return string
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * @param string $uniqueId
     */
    public function setUniqueId($uniqueId)
    {
        $this->uniqueId = $uniqueId;
    }
}
