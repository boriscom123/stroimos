<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\SpotlightItem;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;

class SpotlightItemRepository extends EntityRepository
{
    public function getNextFreePosition()
    {
        return count($this->findAll());
    }

    /**
     * Метод перемещения элементов
     * @param SpotlightItem $currentElement
     * Текущий элемент
     * @param $direction
     * Направление сортировки
     * @param $moveToEdge
     * Перенос вверх/вниз
     * @throws OptimisticLockException
     */
    public function move(SpotlightItem $currentElement, $direction, $moveToEdge)
    {
        $items = $this->findBy([], ['position' => 'ASC']);

        if($direction === 'up' && $moveToEdge) {
            $direction = 'top';
        }

        if($direction === 'down' && $moveToEdge) {
            $direction = 'bottom';
        }

        switch ($direction) {
            case 'up':
                $newPositionCurrentElement = ($currentElement->getPosition() === 1) ? $currentElement->getPosition() : $currentElement->getPosition() - 1;
                $currentElement->setPosition($newPositionCurrentElement);
                $index = $newPositionCurrentElement + 1;
                $items = array_slice($items, $newPositionCurrentElement - 1, $currentElement->getPosition());
                break;
            case 'down':
                $newPositionCurrentElement = ($currentElement->getPosition() > count($items)) ? $currentElement->getPosition() : $currentElement->getPosition() + 1;
                $currentElement->setPosition($newPositionCurrentElement);
                $index = 1;
                $items = array_splice($items, 0, $currentElement->getPosition());
                break;
            case 'top':
                $currentElement->setPosition(1);
                $index = 2;
                break;
            case 'bottom':
                $currentElement->setPosition(count($items));
                $index = 1;
                break;
            default:
                throw new \InvalidArgumentException();
        }

        foreach ($items as $item) {
            if ($item !== $currentElement) {
                $item->setPosition($index++);
            }
        }

        $this->getEntityManager()->flush();
    }

	public function getAll()
	{
        return $this->createQueryBuilder('si')
            ->select(
                'si',
                'construction',
                'gallery',
                'image',
                'infographics',
                'metro',
                'page',
                'post',
                'video',
                'road',
                'post_views'
            )
            ->leftJoin('si.construction', 'construction')
            ->leftJoin('si.gallery', 'gallery')
            ->leftJoin('si.image', 'image')
            ->leftJoin('si.infographics', 'infographics')
            ->leftJoin('si.metro', 'metro')
            ->leftJoin('si.page', 'page')
            ->leftJoin('si.post', 'post')
            ->leftJoin('post.views', 'post_views')
            ->leftJoin('si.video', 'video')
            ->leftJoin('si.road', 'road')
            ->orderBy('si.position', 'ASC')
            ->setMaxResults(18)
            ->getQuery()
            ->getResult();
	}
}
