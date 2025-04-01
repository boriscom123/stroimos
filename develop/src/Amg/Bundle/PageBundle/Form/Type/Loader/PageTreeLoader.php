<?php
namespace Amg\Bundle\PageBundle\Form\Type\Loader;

use Amg\Bundle\PageBundle\Model\PageRepositoryInterface;
use AppBundle\Entity\Owner;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;

class PageTreeLoader implements EntityLoaderInterface
{
    /**
     * @var null
     */
    private $class;
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var Owner|null
     */
    private $owner;

    public function __construct(ObjectManager $em, $owner = null, $class = null)
    {
        $this->class = $class;
        $this->em = $em;
        $this->owner = $owner;
    }

    /**
     * @return PageRepositoryInterface|ObjectRepository
     */
    protected function getPageRepository()
    {
        return $this->em->getRepository($this->class);
    }

    public function getEntities()
    {
        return $this->getPageRepository()->getPageList($this->owner);
    }

    public function getEntitiesByIds($identifier, array $values)
    {
        return $this->getPageRepository()->findBy(
            array($identifier => $values)
        );
    }
}
