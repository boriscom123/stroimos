<?php
namespace AppBundle\Form\DataTransformer;

use Amg\DataCore\ValueObject\EntityReference;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ReferenceToEntityTransformer implements DataTransformerInterface
{
    /**
     * @var ModelManagerInterface
     */
    private $modelManager;

    public function __construct(ModelManagerInterface $modelManager)
    {
        $this->modelManager = $modelManager;
    }

    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        $value = EntityReference::createFromString($value);

//        if (!is_object($value)) {
//            throw new TransformationFailedException(sprintf('Instance of EntityReference expected, got "%s"', gettype($value)));
//        }
//
//        if (!$value instanceof EntityReference) {
//            throw new TransformationFailedException(sprintf('Instance of EntityReference expected, got "%s"', get_class($value)));
//        }

        return $this->modelManager->find($value->getClass(), $value->getId());
    }

    public function reverseTransform($value)
    {
        if (empty($value)) {
            return null;
        }

        if (!is_object($value)) {
            throw new TransformationFailedException(sprintf('An entity expected, got "%s"', gettype($value)));
        }

        return (string)EntityReference::createFromEntity($value);
    }
}
