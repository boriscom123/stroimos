<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class PropertyEquals extends BaseSpecification
{
    /**
     * @var string
     */
    protected $property;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * PropertyEquals constructor.
     * @param null|string $property
     * @param $value
     */
    public function __construct($property, $value)
    {
        $this->property = $property;
        $this->value = $value;
        parent::__construct();
    }

    protected function getSpec()
    {
        return Spec::eq($this->property, $this->value);
    }
}
