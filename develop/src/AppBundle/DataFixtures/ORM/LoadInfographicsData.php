<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Infographics;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadInfographicsData extends AbstractFixture implements OrderedFixtureInterface
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');
    }

    public function load(ObjectManager $manager)
    {
        foreach (range(1, 13) as $i) {
            $infographics = new Infographics();
            $infographics->setPublishable(true);
            $infographics->setPublishStartDate($this->faker->dateTimeBetween('-1 month'));
            if ($this->faker->boolean(50)) {
                $infographics->setAuthor($this->getReference('author-' . rand(1,15)));
            }
            $infographics->setFeedable(true);
            $row = TextSource::getInfographicsRow();
            $infographics->setTitle(html_entity_decode($row['name'], null, 'UTF-8'));
            $infographics->setTeaser(html_entity_decode(strip_tags($row['description']), null, 'UTF-8'));
//            $infographics->setLead(strip_tags($row['description']));
            $infographics->setContent($row['description']);

            if ($i <= 6 and $i % 2) {
                $infographics->setPriorityPosition($i);
            }

            $types = [Infographics::TYPE_STATISTICS, Infographics::TYPE_INFOGRAPHICS];
            $infographics->setType($types[rand(0, 1)]);

            $infographics->setImage($this->getReference('infographics-image-media-id-' . $i));
            $infographics->setInfographics($this->getReference('infographics-media-id-' . $i));

            if ($tagsCount = $this->faker->numberBetween(0, 5)) {
                foreach ((array)array_rand(LoadTagData::$tags, $tagsCount) as $tagItem) {
                    $infographics->getTags()->add($this->getReference('tag-' . $tagItem));
                }
            }

            foreach (range(1, LoadRubricData::NUM_OF_RUBRICS) as $refId) {
                if (!rand(0,4)) {
                    $infographics->addRubric($this->getReference('-rubric-' . $refId));
                }
            }

            $manager->persist($infographics);

            $this->setReference('infographics-pick-' . $i, $infographics);
        }

        $manager->flush();
        $manager->clear();
    }

    public function getOrder()
    {
        return FixturesOrder::L3;
    }
}
