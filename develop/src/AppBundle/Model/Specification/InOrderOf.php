<?php
namespace AppBundle\Model\Specification;

use AppBundle\Entity\Post;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\BaseSpecification;

class InOrderOf extends BaseSpecification
{
    const PUBLISHING = 'last_published';
    const PRIORITY_POSITIONED_PUBLISHING = 'priority_positioned_last_published';
    const UPDATED = 'updated_at';
    const VIEWS = 'v.count';
    const TOP_NEWS = 'top_news';

    /**
     * @var string
     */
    private $order;

    protected $dqlAlias;

    public function __construct($order, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);
        $this->order = $order;
        $this->dqlAlias = $dqlAlias;
    }

    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        switch ($this->order) {
            case self::PUBLISHING:
                $qb->orderBy("$dqlAlias.publishStartDate", 'DESC');
                break;
            case self::PRIORITY_POSITIONED_PUBLISHING:
                $rootEntities = $qb->getRootEntities();
                if (1 === count($rootEntities) && Post::class === $rootEntities[0]) {
                    $qb->orderBy("$dqlAlias.publishDate", 'DESC');
                    $qb->addOrderBy("$dqlAlias.priorityPosition", 'ASC');
                    $qb->addOrderBy("$dqlAlias.publishTime", 'DESC');
                } else {
                    $qb->orderBy("$dqlAlias.publishStartDate", 'DESC');
                    $qb->addOrderBy("$dqlAlias.priorityPosition", 'ASC');
                }
                break;
            case self::UPDATED:
                $qb->orderBy("$dqlAlias.updatedAt", 'DESC');
                break;
            case self::VIEWS:
                $qb->leftJoin($dqlAlias . '.views', 'v');
                $qb->orderBy('v.count', 'DESC');
                $qb->addOrderBy("$dqlAlias.publishStartDate", 'DESC');
                break;
            case self::TOP_NEWS:
                $qb->addOrderBy("$dqlAlias.inTop", 'DESC')
                    ->addOrderBy('v.count', 'DESC')
                    ->addOrderBy("$dqlAlias.publishStartDate", 'DESC');
                break;
            default:
                throw new \RuntimeException("Unknown order '{$this->order}'");
        }
    }
}
