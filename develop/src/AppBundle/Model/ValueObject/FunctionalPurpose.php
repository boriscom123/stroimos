<?php
namespace AppBundle\Model\ValueObject;

class FunctionalPurpose
{
    const OBJ_FUNC__TRADE = 'trade';
    const OBJ_FUNC__HOUSE = 'house';
    const OBJ_FUNC__HEALTH = 'health';
    const OBJ_FUNC__IRONROAD = 'ironroad';
    const OBJ_FUNC__METRO = 'metro';
    const OBJ_FUNC__CULTURE = 'culture';
    const OBJ_FUNC__SPORT = 'sport';
    const OBJ_FUNC__PLAYSCHOOL = 'playschool';
    const OBJ_FUNC__ADMIN_CENTER = 'admin-center';
    const OBJ_FUNC__GARAGE = 'garage';
    const OBJ_FUNC__INDUSTRIAL = 'industrial';
    const OBJ_FUNC__STAY = 'stay';
    const OBJ_FUNC__ROAD = 'road';
    const OBJ_FUNC__HOTELS = 'hotels';
    const OBJ_FUNC__SCHOOL = 'school';
    const OBJ_FUNC__EDUCATIONAL = 'educational';
    const OBJ_FUNC__RELIGION = 'religion';
    const OBJ_FUNC__ENTERTAINMENT = 'entertainment';
    const OBJ_FUNC__OTHER = 'other';
    const OBJ_FUNC__TPU = 'tpu';
    const OBJ_FUNC__RENOV_1719 = 'renov-1719';
    const OBJ_FUNC__RENOV_2023 = 'renov-2023';
    const OBJ_FUNC__RENOV_22PLUS = 'renov-22plus';
    const OBJ_FUNC__RENOVBLD = 'renov-bld';
    const OBJ_FUNC__RENOV_INDUSTRIAL = 'renov-industrial';
    const OBJ_FUNC__CINEMA = 'cinema';
    const OBJ_FUNC__PARK = 'park';

    public static $labels = [
        self::OBJ_FUNC__TRADE => 'Торговля и услуги',
        self::OBJ_FUNC__HOUSE => 'Жилые дома',
        self::OBJ_FUNC__HEALTH => 'Здравоохранение',
        self::OBJ_FUNC__IRONROAD => 'Малое кольцо железной дороги',
        self::OBJ_FUNC__METRO => 'Метро',
        self::OBJ_FUNC__CULTURE => 'Объекты культуры',
        self::OBJ_FUNC__SPORT => 'Спортивные объекты',
        self::OBJ_FUNC__PLAYSCHOOL => 'Детские сады',
        self::OBJ_FUNC__ADMIN_CENTER => 'Административно деловые центры',
        self::OBJ_FUNC__GARAGE => 'Гаражи',
        self::OBJ_FUNC__INDUSTRIAL => 'Промышленность',
        self::OBJ_FUNC__STAY => 'Остановки',
        self::OBJ_FUNC__ROAD => 'Дороги',
        self::OBJ_FUNC__HOTELS => 'Отели',
        self::OBJ_FUNC__SCHOOL => 'Школы',
        self::OBJ_FUNC__EDUCATIONAL => 'Образование и наука',
        self::OBJ_FUNC__RELIGION => 'Религия',
        self::OBJ_FUNC__ENTERTAINMENT => 'Развлечение и отдых',
        self::OBJ_FUNC__OTHER => 'Другое',
        self::OBJ_FUNC__TPU => 'Транспортно-пересадочные узлы',
        self::OBJ_FUNC__RENOV_1719 => 'Стартовые площадки реновации 2017-19 гг.',
        self::OBJ_FUNC__RENOV_2023 => 'Стартовые площадки реновации 2020-21 гг.',
        self::OBJ_FUNC__RENOV_22PLUS => 'Стартовые площадки реновации после 2022 г.',
        self::OBJ_FUNC__RENOVBLD => 'Стартовые дома реновации',
        self::OBJ_FUNC__RENOV_INDUSTRIAL => 'Промзоны',
        self::OBJ_FUNC__CINEMA => 'Кинотеатры',
        self::OBJ_FUNC__PARK => 'Парки',
    ];

    public static $MainFunctionalTranslationMap = [
        'Административные объекты' => FunctionalPurpose::OBJ_FUNC__ADMIN_CENTER,
        'Гаражи и автостоянки' => FunctionalPurpose::OBJ_FUNC__GARAGE,
        'Физкультура и спорт' => FunctionalPurpose::OBJ_FUNC__SPORT,
        'Жилые дома' => FunctionalPurpose::OBJ_FUNC__HOUSE,
        'Производство' => FunctionalPurpose::OBJ_FUNC__INDUSTRIAL,
        'Гостиницы' => FunctionalPurpose::OBJ_FUNC__HOTELS,
        'Культура и просвещение' => FunctionalPurpose::OBJ_FUNC__CULTURE,
        'ДОУ' => FunctionalPurpose::OBJ_FUNC__PLAYSCHOOL,
    ];

    /** @var string */
    private $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function create($alias)
    {
        if (!array_key_exists($alias, self::$labels)) {
            return new self(self::OBJ_FUNC__OTHER);
        }

        return new self($alias);
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->getValue();
    }

    public function getLabel()
    {
        return self::$labels[$this->getValue()];
    }
}
