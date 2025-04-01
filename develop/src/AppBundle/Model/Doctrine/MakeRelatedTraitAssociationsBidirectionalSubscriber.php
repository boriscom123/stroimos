<?php
namespace AppBundle\Model\Doctrine;

use AppBundle\Model\RelatedTrait;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\Builder\AssociationBuilder;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\Builder\ManyToManyAssociationBuilder;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Mapping\ManyToMany;
use FOS\ElasticaBundle\Index\MappingBuilder;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\ConsoleOutput;

class MakeRelatedTraitAssociationsBidirectionalSubscriber implements EventSubscriber
{
    /**
     * @var Reader
     */
    private $annotationReader;

    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var ClassMetadataInfo $classMetadata */
        $classMetadata = $eventArgs->getClassMetadata();

        if (!isset($classMetadata->reflClass) || !$this->isRelatedTraitUsed($classMetadata->reflClass)) {
            return;
        }

        /** @var \ReflectionProperty $sourceProperty */
        /** @var AutoBidirectionalManyToMany $annotation */
        foreach ($this->getPropertiesToMakeBidirectionalAssociations() as list($sourceProperty, $annotation)) {
            $source = ClassAndProperty::create($classMetadata->getName(), $sourceProperty->getName());
            if ($target = $this->chooseOtherSideProperty($source, $annotation)) {
                $this->createBidirectionalMapping($classMetadata, $source, $target);
                continue;
            }


            $this->createOwnerSideMapping($classMetadata, $source, $annotation->targetEntity);
        }
    }

    private function chooseOtherSideProperty(ClassAndProperty $sourceEntity, AutoBidirectionalManyToMany $targetRelatedMapping)
    {
        if (!$this->isRelatedTraitUsed(new \ReflectionClass($targetRelatedMapping->targetEntity), true)) {
            return null;
        }

        $possibleTargets = [];

        /** @var \ReflectionProperty $targetProperty */
        /** @var AutoBidirectionalManyToMany $annotation */
        foreach ($this->relatedTraitPropertiesGenerator() as list($targetProperty, $annotation)) {
            if ($annotation->targetEntity === $sourceEntity->getClass()) {
                $possibleTargets[] = ClassAndProperty::create($targetRelatedMapping->targetEntity, $targetProperty->getName());
            }
        }
        if (count($possibleTargets) === 0) {
            return null;
        }
        if (count($possibleTargets) > 1) {
            throw new \RuntimeException("Only one relation per class is supported");
        }

        $target = reset($possibleTargets);

        if ($sourceEntity->getClass() === $target->getClass()) {
            return null;
        }

        return $target;
    }

    private function getPropertiesToMakeBidirectionalAssociations()
    {
        static $properties;

        if (!isset($properties)) {
            $properties = [];
            foreach ($this->relatedTraitPropertiesGenerator() as $property) {
                $properties[] = $property;
            }
        }

        return $properties;
    }

    private function relatedTraitPropertiesGenerator()
    {
        $reflection = new \ReflectionClass(RelatedTrait::class);
        foreach ($reflection->getProperties() as $property) {
            if ($annotation = $this->annotationReader->getPropertyAnnotation($property, AutoBidirectionalManyToMany::class)) {
                yield [$property, $annotation];
            }
        }
    }

    private function isRelatedTraitUsed(\ReflectionClass $class, $isRecursive = false)
    {
        if (in_array(RelatedTrait::class, $class->getTraitNames())) {
            return true;
        }

        $parentClass = $class->getParentClass();

        if ((false === $isRecursive) || (false === $parentClass) || (null === $parentClass)) {
            return false;
        }

        return $this->isRelatedTraitUsed($parentClass, RelatedTrait::class, $isRecursive);
    }

    private function createBidirectionalMapping(ClassMetadataInfo $classMetadata, ClassAndProperty $firstClass, ClassAndProperty $secondClass)
    {
        /** @var ClassAndProperty $owningSide */
        /** @var ClassAndProperty $inverseSide */
        list($owningSide, $inverseSide) = $secondClass->returnSelfAnOtherWithOwnerFirst($firstClass);
        $isThisOwningSide = $owningSide->getClass() === $classMetadata->getName();

        $builder = new ClassMetadataBuilder($classMetadata);

        /** @var ManyToManyAssociationBuilder $mapping */
        if ($isThisOwningSide) {
            $mapping = $builder->createManyToMany($owningSide->getProperty(), $inverseSide->getClass())
                ->inversedBy($inverseSide->getProperty());
        } else {
            $mapping = $builder->createManyToMany($inverseSide->getProperty(), $owningSide->getClass())
                ->mappedBy($owningSide->getProperty());
        }

        $mapping->setJoinTable($this->joinTableName(
            $owningSide->getClass(),
            $owningSide->getProperty(),
            $inverseSide->getClass(),
            $inverseSide->getProperty()
        ));

        $mapping->build();
    }

    private function createOwnerSideMapping(ClassMetadataInfo $classMetadata, ClassAndProperty $owningSide, $targetEntity)
    {
        $builder = new ClassMetadataBuilder($classMetadata);
        $builder->createManyToMany($owningSide->getProperty(), $targetEntity)
            ->setJoinTable($this->joinTableName(
                    $owningSide->getClass(),
                    $owningSide->getProperty(),
                    $targetEntity
                ))
            ->build();
    }


    public function joinTableName($sourceEntity, $sourcePropertyName, $targetEntity, $targetPropertyName = null)
    {
        return
            'related_' . ($targetPropertyName ? 'i_' : '') .
            $this->classToTableName($sourceEntity) . '_' .
            $this->propertyToColumnName($sourcePropertyName) . '_' .
            $this->classToTableName($targetEntity) .
            ($targetPropertyName ? '_' . $this->propertyToColumnName($targetPropertyName) : '');
    }


    /**
     * {@inheritdoc}
     */
    public function classToTableName($className)
    {
        if (strpos($className, '\\') !== false) {
            $className = substr($className, strrpos($className, '\\') + 1);
        }

        return $this->underscore($className);
    }


    public function propertyToColumnName($propertyName, $className = null)
    {
        $propertyName = str_replace('related', '', $propertyName);

        return $this->underscore($propertyName);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    private function underscore($string)
    {
        $string = preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $string);

        return strtolower($string);
    }
}