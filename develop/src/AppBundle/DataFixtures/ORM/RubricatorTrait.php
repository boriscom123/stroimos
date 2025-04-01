<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Rubric;
use Doctrine\ORM\EntityManager;

trait RubricatorTrait
{
    protected $currentRubricType;

    /**
     * @return EntityManager
     */
    abstract protected function getManager();

    abstract protected function getReference($name);
    abstract protected function hasReference($name);
    abstract protected function setReference($name, $object);

    /**
     * @param mixed $currentRubricType
     * @return $this
     */
    protected function setCurrentRubricType($type)
    {
        $this->currentRubricType = $type;
        return $this;
    }

    /**
     * @param $type
     * @return Rubric
     */
    protected function createRubricObject()
    {
        $entityClassName = 'AppBundle\Entity\\Rubric';

        return new $entityClassName();
    }

    protected function getRubric($title, $create = true)
    {
        $rubricReferenceName = $this->getRubricTitleReferenceName($title);
        if (!$this->hasReference($rubricReferenceName) && $create) {
            $this->createRubric($title);
        }

        return $this->getReference($rubricReferenceName);
    }

    protected function createRubric($title)
    {
        $rubric = $this->createRubricObject();
        $rubric->setTitle($title);
        $this->setReference($this->getRubricTitleReferenceName($title), $rubric);
        $this->getManager()->persist($rubric);
        return $rubric;
    }

    protected function getRubricTitleReferenceName($title)
    {
        return  '-rubric-' . $title;
    }

    /**
     * @param $rubrics
     * @param $create
     * @param string $delimiter
     * @return Rubric[]
     */
    protected function getRubrics($rubrics, $create = true, $delimiter = '|')
    {
        if (!is_array($rubrics)) {
            $rubrics = TextSource::parseDelimitedString($rubrics, $delimiter);
        }

        $rubricObjects = [];
        foreach ($rubrics as $title) {
            $rubricObjects[] = $this->getRubric($title, $create);
        }
        return $rubricObjects;
    }
}