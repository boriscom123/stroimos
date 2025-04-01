<?php
namespace AppBundle\Model\Doctrine;

class ClassAndProperty extends OnlyClass
{
    /**
     * @var string
     */
    protected $property;

    /**
     * ClassAndProperty constructor.
     * @param string $class
     * @param string $property
     */
    protected function __construct($class, $property)
    {
        parent::__construct($class);
        $this->property = $property;
    }

    public static function create($class, $property)
    {
        return new self($class, $property);
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }

}