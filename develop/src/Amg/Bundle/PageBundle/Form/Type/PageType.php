<?php
namespace Amg\Bundle\PageBundle\Form\Type;

use Amg\Bundle\PageBundle\Form\Type\Loader\PageTreeLoader;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends DoctrineType
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
        return new PageTreeLoader($manager, $queryBuilder, $class);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'page_tree';
    }
}
