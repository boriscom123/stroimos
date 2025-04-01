<?php
namespace AppBundle\Twig;

use Amg\DataCore\Model\EntityMap;
use Amg\DataCore\ValueObject\EntityReference;
use AppBundle\Model\ShowLastNewsInterface;
use AppBundle\Routing\EntityUrlGenerator;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EntityTwigExtension extends \Twig_Extension
{
    // fixme
    private static $instanceOfTestClasses = [
        'AppBundle\Entity\Page',
        'AppBundle\Entity\Post',
        'AppBundle\Entity\Video',
        'AppBundle\Entity\Gallery',
        'AppBundle\Entity\MetroLine',
        'AppBundle\Entity\MetroStation',
        'AppBundle\Entity\Infographics',
        'AppBundle\Entity\Document',
        'AppBundle\Entity\DecisionDocument',
        'AppBundle\Entity\DraftDocument',
        'AppBundle\Entity\LawDocument',
        'AppBundle\Entity\Construction',
    ];

    /**
     * @var EntityUrlGenerator
     */
    private $entityUrlGenerator;

    public function __construct(EntityUrlGenerator $entityUrlGenerator)
    {
        $this->entityUrlGenerator = $entityUrlGenerator;
    }

    public function getName()
    {
        return 'entity';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('entity_alias', [$this, 'getEntityAlias']),
            new \Twig_SimpleFunction('entity_reference', [$this, 'getEntityReference']),
            new \Twig_SimpleFunction('entity_path', [$this->entityUrlGenerator, 'generate']),
            new \Twig_SimpleFunction('entity_absolute_url', [$this, 'generateAbsoluteUrl']),
            new \Twig_SimpleFunction('entity_list_path', [$this->entityUrlGenerator, 'generateList']),
            new \Twig_SimpleFunction('entity_class', [$this, 'getEntityClass']),
            new \Twig_SimpleFunction('subordinate_entity_path', [$this, 'getSubordinateEntityPath'])
        ];
    }

    public function getTests()
    {
        $tests = [];

        foreach (self::$instanceOfTestClasses as $class) {
            $tests[] = new \Twig_SimpleTest(
                EntityMap::getAlias($class),
                function ($object) use ($class) { return $object instanceof $class; }
            );
        }

        $tests[] = new \Twig_SimpleTest('with_last_news', function ($object) {
            return $object instanceof ShowLastNewsInterface && $object->getShowLastNews();
        });

        return $tests;
    }

    public function getEntityAlias($entity)
    {
        return EntityMap::getAlias($entity);
    }

    public function getEntityReference($entity)
    {
        return (string)EntityReference::createFromEntity($entity);
    }

    public function getEntityClass($entity)
    {
        return ClassUtils::getClass($entity);
    }

    public function generateAbsoluteUrl($entity)
    {
        return $this->entityUrlGenerator->generate($entity, [], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function getSubordinateEntityPath($entity)
    {
        return $this->entityUrlGenerator->generateSubordinateEntityPath($entity);
    }
}
