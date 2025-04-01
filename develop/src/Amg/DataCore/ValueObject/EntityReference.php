<?php
namespace Amg\DataCore\ValueObject;

use Amg\DataCore\Model\EntityMap;
use Doctrine\Common\Util\ClassUtils;

class EntityReference
{
    /**
     * NB: be aware that the delimiter will be used in URL, so it may be escaped,
     * also "~" is already used by Sonata Admin
     */
    const STRING_DELIMITER = '-';

    /**
     * @var string
     */
    private $class;

    /**
     * @var integer
     */
    private $id;

    /**
     * @param $class
     * @param $id
     */
    public function __construct($class, $id)
    {
        $this->class = $class;
        $this->id = $id;
    }

    public static function createFromString($string)
    {
        list($classAlias, $id) = explode(self::STRING_DELIMITER, $string);

        return new self(EntityMap::getClassByAlias($classAlias), (int)$id);
    }

    public static function createFromEntity($entity)
    {
        return new self(ClassUtils::getRealClass(get_class($entity)), $entity->getId());
    }

    public function __toString()
    {
        return implode(self::STRING_DELIMITER, [EntityMap::getAlias($this->getClass()), $this->getId()]);
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
