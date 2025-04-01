<?php
namespace AppBundle\Model\Specification;

use AppBundle\Entity\AdministrativeUnit;
use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class InAdministrativeUnit extends BaseSpecification
{
    /**
     * @var AdministrativeUnit|string
     */
    private $administrativeUnit;

    public function __construct($administrativeUnit, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);

        $this->administrativeUnit = $administrativeUnit;
    }

    public function getSpec()
    {
        if ($this->administrativeUnit instanceof AdministrativeUnit) {
            return Spec::eq('administrativeUnit', $this->administrativeUnit);
        }

        $field = is_numeric($this->administrativeUnit) ? 'id' : 'title';

        return Spec::andX(
            Spec::join('administrativeUnit', 'u'),
            Spec::leftJoin('parent', 'pu', 'u'),
            Spec::orX(
                Spec::eq($field, $this->administrativeUnit, 'u'),
                Spec::eq($field, $this->administrativeUnit, 'pu')
            )
        );
    }
}
