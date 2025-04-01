<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Person;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Finder\Finder;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Yaml\Yaml;

class LoadPersonData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait,
        MediaHelperTrait;

    public function load(ObjectManager $manager)
    {
        $personFiles = Finder::create()->name('*.yml')->in(__DIR__ . '/../data/person')->sortByName();

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $position = 1;
        foreach ($personFiles as $personFile) {
            $personData = Yaml::parse($personFile, false, true);

            $person = new Person();

            $person->setPublishable(true);
            $person->setPriorityPosition($position++);

            foreach ($personData as $property => $value) {
                if ('image' === $property) {
                    $value = $this->createImage($value, 'person');
                }

                if ('topImage' === $property) {
                    if (empty($value)) {
                        continue;
                    }

                    $value = $this->createImage($value, 'person_top');
                }

                $propertyAccessor->setValue($person, $property, $value);
            }

            $manager->persist($person);
            $manager->flush();
        }
    }

    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    public function getMediaManager()
    {
        return $this->container->get('sonata.media.manager.media');
    }

    public function getOrder()
    {
        return FixturesOrder::L2;
    }
}
