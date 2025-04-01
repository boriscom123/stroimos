<?php
namespace AppBundle\Form\Type;

use AppBundle\Form\Type\Loader\MediaCategoryTreeLoader;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MediaCategoryTreeType extends DoctrineType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $type = $this;

        $loader = function (Options $options) use ($type) {
            return $type->getLoader($options['em'], $options['query_builder'], $options['class']);
        };

        $resolver->setDefaults(array(
            'loader'    => $loader,
            'attr'      => array('class' => 'input-block-level'),
        ));
    }

    public function getLoader(ObjectManager $manager, $queryBuilder, $class)
    {
        return new MediaCategoryTreeLoader($manager, $queryBuilder, $class);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'media_category_tree';
    }
}
