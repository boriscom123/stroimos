<?php
namespace AppBundle\Form\Type\Loader;

use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;

class MediaCategoryTreeLoader implements EntityLoaderInterface
{
    /**
     * @var null
     */
    private $class;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em, $manager = null, $class = null)
    {
        $this->class = $class;
        $this->em = $em;
    }

    /**
     * @return NestedTreeRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository($this->class);
    }

    public function getEntities()
    {
        return $this->getRepository()->findAll();
    }

    public function getEntitiesByIds($identifier, array $values)
    {
        return $this->getRepository()->findBy(
            array($identifier => $values)
        );
    }
}
