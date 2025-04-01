<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTagData extends AbstractFixture implements OrderedFixtureInterface
{
    use EntityManagerTrait,
        TaggerTrait;

    public static $tags = array(
        'Москомэкспертиза',
        'новая Москва',
        'Градостроительно-земельная комиссия',
        'Москомстройинвест',
        'Строительство жилых домов',
        'Поликлиники',
        'Школы',
        'Детские сады',
        'Архсовет',
        'офисы',
        '«Москва-Сити»',
        'ЖК «Западный порт»',
        'Адресная инвестиционная программа',
        'Мосгосстройнадзор',
        'СЗАО',
    );

    public function load(ObjectManager $manager)
    {
        $this->setManager($manager);

        foreach (self::$tags as $tagItem => $tagTitle) {
            $tag = $this->createTag($tagTitle);
            $this->setReference('tag-' . $tagItem, $tag);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return FixturesOrder::L1;
    }
}
