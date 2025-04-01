<?php
namespace AppBundle\Model\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Query\QueryModifierCollection;
use Happyr\DoctrineSpecification\Spec;

class LastPublished extends BaseSpecification
{
    /**
     * @var null|string
     */
    private $limit;
    /**
     * @var int
     */
    private $offset;
    /**
     * @var string
     */
    private $order;

    public function __construct($limit, $offset = 0, $order = InOrderOf::PUBLISHING, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
    }

    protected function getSpec()
    {
        return new QueryModifierCollection(
            new InOrderOf($this->order),
            Spec::limit($this->limit),
            Spec::offset($this->offset)
        );
    }
}
