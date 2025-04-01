<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class UniversalSpec extends BaseSpecification
{
    private $fieldName;
    private $operation;
    private $value;

    public function __construct($fieldName, $operation, $value)
    {
        parent::__construct();
        $this->fieldName = $fieldName;
        $this->operation = $operation;
        $this->value = $value;
    }

    protected function getSpec()
    {
        $operation = $this->operation;
        return Spec::$operation($this->fieldName, $this->value);
    }
}
