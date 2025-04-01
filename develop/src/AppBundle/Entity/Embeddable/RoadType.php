<?php
namespace AppBundle\Entity\Embeddable;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable */
class RoadType
{
    const TYPE_INTERCHANGE = 'interchange';
    const TYPE_SPAN = 'span';
    const TYPE_TRUNK = 'trunk';
    const TYPE_OVERPASS = 'overpass';
    const TYPE_REGIONAL = 'regional';
    const TYPE_EMBANKMENT = 'embankment';

    public static $labels = [
        self::TYPE_INTERCHANGE => 'Транспортная развязка',
        self::TYPE_SPAN => 'Хорда',
        self::TYPE_TRUNK => 'Вылетная магистраль',
        self::TYPE_OVERPASS => 'Путепровод',
        self::TYPE_REGIONAL => 'Дорога районного значения',
        self::TYPE_EMBANKMENT => 'Набережная'
    ];

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function create($alias)
    {
        if (!array_key_exists($alias, self::$labels)) {
            throw new \InvalidArgumentException();
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
