<?php
namespace AppBundle\Form\Type;

use AppBundle\Form\Type\Loader\MenuTreeLoader;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuTreeType extends DoctrineType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $type = $this;

        $loader = function (Options $options) use ($type) {
            $menuTreeLoader = $type->getLoader($options['em'], $options['query_builder'], $options['class']);

            if (!empty($options['menu'])) {
                $menuTreeLoader->setMenu($options['menu']);
            }

            return $menuTreeLoader;
        };

        $resolver->setDefaults([
            'class' => 'AppBundle\Entity\MenuNode',
            'property' => 'title',
            'loader' => $loader,
            'menu' => null,
            'attr' => ['class' => 'input-block-level'],
        ]);

        $resolver->setAllowedTypes([
            'menu' => ['null', 'AppBundle\Entity\Menu'],
        ]);

        $resolver->setRequired(['menu']);
    }

    public function getLoader(ObjectManager $manager, $queryBuilder, $class)
    {
        return new MenuTreeLoader($manager, $queryBuilder, $class);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'menu_tree';
    }
}
