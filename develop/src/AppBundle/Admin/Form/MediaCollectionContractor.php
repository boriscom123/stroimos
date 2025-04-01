<?php
namespace AppBundle\Admin\Form;

use Application\Sonata\MediaBundle\Entity\Media;
use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\DoctrineORMAdminBundle\Builder\FormContractor;

class MediaCollectionContractor extends FormContractor
{
    public function getDefaultOptions($type, FieldDescriptionInterface $fieldDescription)
    {
        if ('media_collection' === $type) {
            $type = 'sonata_type_collection';
        }

        if ('media_list' === $type) {
            $type = 'sonata_type_model_list';
        }

        $options = parent::getDefaultOptions($type, $fieldDescription);

        if ('gif_generator' === $type) {
            $options['class']         = Media::class;
            $options['model_manager'] = $fieldDescription->getAdmin()->getModelManager();
        }

        return $options;
    }
}