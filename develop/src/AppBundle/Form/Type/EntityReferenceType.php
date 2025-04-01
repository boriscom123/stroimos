<?php
namespace AppBundle\Form\Type;

use AppBundle\Form\DataTransformer\ReferenceToEntityTransformer;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EntityReferenceType extends AbstractType
{
    /**
     * @var ModelManagerInterface
     */
    private $modelManager;

    public function __construct(ModelManagerInterface $modelManager)
    {
        $this->modelManager = $modelManager;
    }

    public function getParent()
    {
        return 'sonata_type_model';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $referenceToEntityTransformer = new ReferenceToEntityTransformer($this->modelManager);
        $builder->addModelTransformer($referenceToEntityTransformer);
    }

    public function getName()
    {
        return 'entity_reference';
    }
}
