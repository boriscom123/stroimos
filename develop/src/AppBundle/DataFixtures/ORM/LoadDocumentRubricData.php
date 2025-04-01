<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\DocumentRubric;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDocumentRubricData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $treeRubrics = array(
            'Основы государства и права' => array(
                'Конституция РФ' => array(),
                'Кодексы' => array(),
                'Статус и решения федеральных структур' => array(),
            ),
            'Градостроительный кодекс города Москвы (2008 г.)' => array(),
            'Генплан города Москвы (до 2025 года)' => array(),
            'Законодательство Москвы (кроме налогообложения)' => array(
                'Статус Москвы' => array(),
                'Структура органов власти, регламенты, реорганизация городских структур' => array(
                    'Кадровые решения' => array(),
                    'Положения об органах власти, организациях и учреждениях' => array(),
                    'Правительство Москвы и Аппарат Мэра Москвы' => array(),
                    'Штабы, комиссии, рабочие группы.' => array(),
                ),
                'Стратегии, концепции и городские программы - разные (целевые, адресные, среднесрочные, срочные и т.д.)' => array(),
                'Градостроительно-земельные отношения' => array(),
                'Законодательство о конкуренции' => array(
                    'Инвестиции. Конкурсы. Поставки и поставщики' => array(),
                    'Законодательство: товары, услуги, продукция для госнужд' => array()
                ),
                'Планировка территорий' => array(),
                'Особо охраняемые территории и объекты, памятники' => array(),
                'Жилищная политика' => array(),
                'Энергосберегающие технологии' => array(),
                'Экология и благоустройство Москвы' => array(),
                'Лучший реализованный проект' => array(),
                'Награждение работников стройкомплекса' => array(),
                'Дорожно-мостовое строительство. Транспортные проблемы' => array(),
            ),
        );

        foreach ($treeRubrics as $title => $item) {
            $this->createRubric(array($title => $item));
        }

        $this->manager->flush();
    }

    protected function createRubric($item, $parent = null)
    {
        static $i = 1;

        $node = new DocumentRubric();
        $node->setTitle(key($item));
        $node->setParent($parent);

        $this->manager->persist($node);

        if ($children = reset($item)) {
            foreach ($children as $title => $child) {
                $this->createRubric(array($title => $child), $node);
            }
        }

        $this->setReference('document-rubric-' . $i++, $node);
    }

    public function getOrder()
    {
        return FixturesOrder::L1;
    }
}
