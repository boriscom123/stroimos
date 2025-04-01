<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\AdministrativeUnit\AdministrativeUnitInterface;
use CrEOF\Spatial\PHP\Types\Geometry\MultiPolygon;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CityDistrictRepository")
 */
class CityDistrict extends AdministrativeUnit implements AdministrativeUnitInterface
{
    /**
     * @var boolean
     *
     * @Doctrine\ORM\Mapping\Column(name="publishable", type="boolean", options={"default" : 1})
     */
    protected $publishable = true;
    public static $availableDistricts = [
        'Центральный' => [
            'Арбат',
            'Басманный',
            'Замоскворечье',
            'Красносельский',
            'Мещанский',
            'Пресненский',
            'Таганский',
            'Тверской',
            'Хамовники',
            'Якиманка',
        ],
        'Северный' => [
            'Аэропорт',
            'Беговой',
            'Бескудниковский',
            'Войковский',
            'Восточное Дегунино',
            'Головинский',
            'Дмитровский',
            'Западное Дегунино',
            'Коптево',
            'Левобережный',
            'Молжаниновский',
            'Савёловский',
            'Сокол',
            'Тимирязевский',
            'Ховрино',
            'Хорошёвский',
        ],
        'Северо-Восточный' => [
            'Алексеевский',
            'Алтуфьевский',
            'Бабушкинский',
            'Бибирево',
            'Бутырский',
            'Лианозово',
            'Лосиноостровский',
            'Марфино',
            'Марьина Роща',
            'Останкинский',
            'Отрадное',
            'Ростокино',
            'Свиблово',
            'Северный',
            'Северное Медведково',
            'Южное Медведково',
            'Ярославский',
        ],
        'Восточный' => [
            'Богородское',
            'Вешняки',
            'Восточный',
            'Восточное Измайлово',
            'Гольяново',
            'Ивановское',
            'Измайлово',
            'Косино-Ухтомский',
            'Метрогородок',
            'Новогиреево',
            'Новокосино',
            'Перово',
            'Преображенское',
            'Северное Измайлово',
            'Соколиная Гора',
            'Сокольники',
        ],
        'Юго-Восточный' => [
            'Выхино-Жулебино',
            'Капотня',
            'Кузьминки',
            'Лефортово',
            'Люблино',
            'Марьино',
            'Некрасовка',
            'Нижегородский',
            'Печатники',
            'Рязанский',
            'Текстильщики',
            'Южнопортовый',
        ],
        'Южный' => [
            'Бирюлёво Восточное',
            'Бирюлёво Западное',
            'Братеево',
            'Даниловский',
            'Донской',
            'Зябликово',
            'Москворечье-Сабурово',
            'Нагатино-Садовники',
            'Нагатинский Затон',
            'Нагорный',
            'Орехово-Борисово Северное',
            'Орехово-Борисово Южное',
            'Царицыно',
            'Чертаново Северное',
            'Чертаново Центральное',
            'Чертаново Южное',
        ],
        'Юго-Западный' => [
            'Академический',
            'Гагаринский',
            'Зюзино',
            'Коньково',
            'Котловка',
            'Ломоносовский',
            'Обручевский',
            'Северное Бутово',
            'Тёплый Стан',
            'Черёмушки',
            'Южное Бутово',
            'Ясенево',
        ],
        'Западный' => [
            'Внуково',
            'Дорогомилово',
            'Крылатское',
            'Кунцево',
            'Можайский',
            'Ново-Переделкино',
            'Очаково-Матвеевское',
            'Проспект Вернадского',
            'Раменки',
            'Солнцево',
            'Тропарёво-Никулино',
            'Филёвский Парк',
            'Фили-Давыдково',
        ],
        'Северо-Западный' => [
            'Куркино',
            'Митино',
            'Покровское-Стрешнево',
            'Северное Тушино',
            'Строгино',
            'Хорошёво-Мнёвники',
            'Щукино',
            'Южное Тушино',
            'Зеленоградский',
            'Матушкино',
            'Савёлки',
            'Старое Крюково',
            'Силино',
            'Крюково',
        ],
        'Новомосковский' => [
            'поселение Воскресенское',
            'поселение Внуковское',
            'поселение Десёновское',
            'поселение Кокошкино',
            'поселение Марушкинское',
            'поселение Московский',
            'поселение «Мосрентген»',
            'поселение Рязановское',
            'поселение Сосенское',
            'поселение Филимонковское',
            'поселение Щербинка',
        ],
        'Троицкий' => [
            'поселение Вороновское',
            'поселение Киевский',
            'поселение Клёновское',
            'поселение Краснопахорское',
            'поселение Михайлово-Ярцевское',
            'поселение Новофёдоровское',
            'поселение Первомайское',
            'поселение Роговское',
            'поселение Троицк',
            'поселение Щаповское',
        ],
        'Зеленоградский' => [
            'Матушкино',
            'Савёлки',
            'Старое Крюково',
            'Силино',
            'Крюково',
        ],
    ];

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $square;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $population;

    /**
     * @var MultiPolygon
     * @ORM\Column(type="multipolygon", nullable=true)
     */
    private $polygon;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $areaOfTheTerritory;

    public function getFullTitle()
    {
        return $this->getParent()->getTitle() . ', ' . $this->getTitle();
    }

    public function __toString()
    {
        return $this->getTitle() ?: '(неназванный район)';
    }

    /**
     * @return AdministrativeArea
     */
    public function getAdministrativeArea()
    {
        return $this->getParent();
    }

    /**
     * @return CityDistrict
     */
    public function getCityDistrict()
    {
        return $this;
    }

    public function getDisplayTitle()
    {
        return $this->getTitle() . ', ' . $this->getParent()->getAbbreviation();
    }

    /**
     * @return int
     */
    public function getSquare()
    {
        return $this->square;
    }

    /**
     * @param int $square
     */
    public function setSquare($square)
    {
        $this->square = $square;
    }

    /**
     * @return int
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * @param int $population
     */
    public function setPopulation($population)
    {
        $this->population = $population;
    }

    /**
     * @return MultiPolygon
     */
    public function getPolygon()
    {
        return $this->polygon;
    }

    /**
     * @param MultiPolygon $polygon
     */
    public function setPolygon($polygon)
    {
        $this->polygon = $polygon;
    }

    /**
     * @return bool
     */
    public function isPublishable()
    {
        return $this->publishable;
    }

    /**
     * @return bool
     */
    public function setPublishable($publishable)
    {
        $this->publishable = $publishable;
    }
}
