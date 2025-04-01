<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Block;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class BlockRepository extends EntityRepository
{
	/**
	 * @return Block[]
	 */
	public function getHomePageBanners()
	{
		return $this->createQueryBuilder('b')
			->innerJoin('b.page', 'page', Query\Expr\Join::WITH, 'page.id = page.root')
			->andWhere('b.type = :type')
			->setParameter('type', Block::TYPE_HOT_NEWS_BLOCK)
			->andWhere('b.enabled = true')
			->orderBy('b.position', 'DESC')
			->getQuery()->getArrayResult();
	}
}
