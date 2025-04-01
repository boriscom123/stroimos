<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadRubricData extends AbstractFixture implements OrderedFixtureInterface
{
    const NUM_OF_RUBRICS = 10;

    use EntityManagerTrait,
        RubricatorTrait;

    public static $rubrics = [
        'Градостроительная политика',
        'Дорожное строительство',
        'Развитие метрополитена',
        'Развитие ж/д инфраструктуры',
        'Жилье',
        'Новая Москва',
        'Социальные объекты',
        'Дороги, мосты, тоннели',
        'Транспортное строительство',
        'Городские Конкурсы'
    ];

    public static $rubricsTypes = [
        '',
    ];

    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');
    }

    public function load(ObjectManager $manager)
    {
        $this->setManager($manager);

        foreach (self::$rubricsTypes as $type) {
            $this->setCurrentRubricType($type);
            foreach (self::$rubrics as $i => $title) {
                $rubric = $this->createRubric($title);
                $this->setReference($type .'-rubric-' . ($i + 1), $rubric);
            }
        }
    }

    public function getOrder()
    {
        return FixturesOrder::L1;
    }
}
