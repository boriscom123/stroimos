<?php
namespace AppBundle\Model\Doctrine;

use AppBundle\Entity\Construction;
use AppBundle\Entity\Document;
use AppBundle\Entity\Gallery;
use AppBundle\Entity\Infographics;
use AppBundle\Entity\Post;
use AppBundle\Entity\Video;

class OnlyClass
{
    /**
     * @var string
     */
    protected $class;

    //To not break mapping when new entities added
    protected static $relationHierarchy = [
        Construction::class,
        Document::class,
        Gallery::class,
        Infographics::class,
        Post::class,
        Video::class,
    ];
    protected static $flippedRelationHierarchy;

    /**
     * ClassAndProperty constructor.
     * @param string $class
     */
    protected function __construct($class)
    {
        $this->class = $class;
    }

    public static function createIfInHierarchy($class, $tryParent = true)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        if (!in_array($class, self::$relationHierarchy)) {
            if ($tryParent) {
                return self::createIfInHierarchy(get_parent_class($class), false);
            }

            throw new \RuntimeException("Class '$class' must present in ClassAndProperty::\$relationHierarchy");
        }

        return new self($class);
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param OnlyClass $otherClass
     * @return $this[]
     */
    public function returnSelfAnOtherWithOwnerFirst(OnlyClass $otherClass)
    {
        return $this->isImOwnerOfRelationWith($otherClass)
            ? [$this, $otherClass]
            : [$otherClass, $this];
    }

    public function isImOwnerOfRelationWith(OnlyClass $otherClass)
    {
        self::initHierarchyFlip();

        if (!isset(self::$flippedRelationHierarchy[$this->class])) {
            throw new \RuntimeException("Class '$this->class' must present in ClassAndProperty::\$relationHierarchy");
        }
        if (!isset(self::$flippedRelationHierarchy[$otherClass->class])) {
            throw new \RuntimeException("Class '$otherClass->class' must present in ClassAndProperty::\$relationHierarchy");
        }

        return self::$flippedRelationHierarchy[$this->class] < self::$flippedRelationHierarchy[$otherClass->class];
    }

    protected static function initHierarchyFlip()
    {
        if (!isset(self::$flippedRelationHierarchy)) {
            self::$flippedRelationHierarchy = array_flip(self::$relationHierarchy);
        }
    }
}
