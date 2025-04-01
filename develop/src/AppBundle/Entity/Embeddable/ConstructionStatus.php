<?php
namespace AppBundle\Entity\Embeddable;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable */
class ConstructionStatus
{
    const OBJ_STATUS__CONSTRUCTION = 'construction';
    const OBJ_STATUS__DOCUMENTATION = 'documentation';
    const OBJ_STATUS__DOCUMENTATION_UNDERDEVELOPED = 'documentation_underdeveloped';
    const OBJ_STATUS__OPERATION = 'operation';
    const OBJ_STATUS__DESIGNED = 'designed';
    const OBJ_STATUS__TERRAIN = 'terrain';
    const OBJ_STATUS__DOOPERATION = 'dooperation';

    public static $labels = [
        self::OBJ_STATUS__TERRAIN => 'Подобран земельный участок',
        self::OBJ_STATUS__DESIGNED => 'Ведется проектирование',
        self::OBJ_STATUS__DOCUMENTATION_UNDERDEVELOPED => 'Разрабатывается документация',
        self::OBJ_STATUS__DOCUMENTATION => 'Утверждена документация',
        self::OBJ_STATUS__CONSTRUCTION => 'Строится',
        self::OBJ_STATUS__DOOPERATION => 'Подготовка к вводу в эксплуатацию',
        self::OBJ_STATUS__OPERATION => 'Объект введен в эксплуатацию',
    ];

    public static $ObjectStatusTranslationMap = [
        'В строительстве' => ConstructionStatus::OBJ_STATUS__CONSTRUCTION,
        'Подготовка к вводу в эксплуатацию' => ConstructionStatus::OBJ_STATUS__DOOPERATION,
        'Сдан' => ConstructionStatus::OBJ_STATUS__OPERATION,
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
            //throw new \InvalidArgumentException();
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
