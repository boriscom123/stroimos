<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Menu;
use AppBundle\Entity\MenuNode;
use AppBundle\Routing\PostCategoryRouteName;
use Cocur\Slugify\Slugify;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadMenuData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * @var Slugify
     */
    protected $slugifier;

    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');
        $this->slugifier = Slugify::create();
    }

    public function getOrder()
    {
        return FixturesOrder::L6;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $mainRootNode = new MenuNode();
        $mainRootNode->setTitle('Главное меню');
        $mainRootNode->setNodeName('main_menu');
//        $mainRootNode->setUri('/');

        $aboutNode = $this->createChildNode($mainRootNode, "О Стройкомплексе")->setPage($this->getPageReference('deyatelnost'));
//        $this->createChildNode($mainRootNode, "Горячие линии");
//        $this->createChildNode($mainRootNode, "Личный кабинет");
        $this->createChildNode($aboutNode, "Справочник организаций")->setPage($this->getPageReference('organizations'));

        $peopleNode = $this->createChildNode($mainRootNode, "Жителям");

        $this->createChildNode($peopleNode, "Строительство в округах, районах")->setPage($this->getPageReference('stroitelstvo-v-okrugah-raionah'));
        $this->createChildNode($peopleNode, "Что за стройка рядом с моим домом?")->setRoute('app_construction');
        $this->createChildNode($peopleNode, "Карты развития дорожно-транспортной инфраструктуры")->setPage($this->getPageReference('dorozhnoe-stroitelstvo'));
//        $this->createChildNode($peopleNode, "Снос пятиэтажек");
//        $this->createChildNode($peopleNode, "Дома, которые снесут в 2015 году")->setPage($this->getPageReference('doma-kotorye-snesut-v-2015-godu'));;
        $this->createChildNode($peopleNode, "Строительство поликлиник")->setPage($this->getPageReference('programma-stroitelstva-novyh-poliklinik-do-2017-goda'));
        $this->createChildNode($peopleNode, "Строительство детских садов")->setPage($this->getPageReference('detskie-sady-1'));
        $this->createChildNode($peopleNode, "Строительство школ и БНК (блоков начальных классов)")->setPage($this->getPageReference('stroitelstvo-shkol-i-bnk'));
        $this->createChildNode($peopleNode, "Стадионы москвы")->setPage($this->getPageReference('stadiony-moskvy'));
        $this->createChildNode($peopleNode, "Реновация промзон")->setPage($this->getPageReference('renovaciya-promzon'));
        $this->createChildNode($peopleNode, "Долевое строительство")->setPage($this->getPageReference('uchastnikam-dolevogo-stroitelstva-2'));
//        $this->createChildNode($peopleNode, "Уникальная архитектура")->setPage($this->getPageReference('unikalnaya-arhitektura'));;
        $this->createChildNode($peopleNode, "Фотоленты")->setRoute('app_photo_lines_list');
        $this->createChildNode($peopleNode, "Перепланировка квартир")->setPage($this->getPageReference('tipovye-varianty-pereplanirovki-kvartir'));
        $this->createChildNode($peopleNode, "Центральный детский магазин на лубянке")->setPage($this->getPageReference('centralnyi-detskii-magazin-na-lubyanke'));
        $this->createChildNode($peopleNode, "Социальные инициативы")->setPage($this->getPageReference('initiative_list'));

        $developersNode = $this->createChildNode($mainRootNode, "Градостроителям");
//        $this->createChildNode($developersNode, "Архитектурные конкурсы");
        $this->createChildNode($developersNode, "Отраслевые схемы")->setPage($this->getPageReference('otraslevye-shemy'));
        $this->createChildNode($developersNode, "ИСОГД")->setPage($this->getPageReference('isogd'));
        $this->createChildNode($developersNode, "МТСК")->setPage($this->getPageReference('katalog-stroitelnoi-produkcii-i-tehnologii'));
//        $this->createChildNode($developersNode, "Генеральный план развития москвы");
        $this->createChildNode($developersNode, "Строительная наука")->setRoute(PostCategoryRouteName::generate(Category::CATEGORY_BUILDER_SCIENCE, PostCategoryRouteName::TYPE_LIST));
        $this->createChildNode($developersNode, "СРО")->setPage($this->getPageReference('sro'));
//        $this->createChildNode($developersNode, "Городские конкурсы");
        $this->createChildNode($developersNode, "Новые правила размещения информационных вывесок на улицах москвы")->setPage($this->getPageReference('novye-pravila-razmescheniya-vyvesok-na-ulicah-moskvy'));
        $this->createChildNode($developersNode, "Информационное письмо")->setPage($this->getPageReference('informacionnoe-pismo'));

        $buildersNode = $this->createChildNode($mainRootNode, "Застройщикам");
//        $this->createChildNode($buildersNode, "Кабинет застройщика");
        $this->createChildNode($buildersNode, "Электронные услуги")->setPage($this->getPageReference('elektronnye-uslugi'));
        $this->createChildNode($buildersNode, "Инвестиционный портал москвы")->setUri('http://investmoscow.ru/');
//        $this->createChildNode($buildersNode, "Актуальная информация для застройщиков");

        $mediaBusinesNode = $this->createChildNode($mainRootNode, "СМИ");
        $this->createChildNode($mediaBusinesNode, "Пресс-релизы")->setRoute('app_press_releases_list');
//        $this->createChildNode($mediaBusinesNode, "Стенограммы");
//        $this->createChildNode($mediaBusinesNode, "Рабочие видеоматериалы");
        $this->createChildNode($mediaBusinesNode, "Фотогалерея")->setRoute('app_gallery_list');
        $this->createChildNode($mediaBusinesNode, "Видеогалерея")->setRoute('app_video_list');
        $this->createChildNode($mediaBusinesNode, "Статьи")->setRoute('app_articles_list');
        $this->createChildNode($mediaBusinesNode, "Интервью")->setRoute('app_interviews_list');
        $this->createChildNode($mediaBusinesNode, "Инфографика")->setRoute('app_infographics_list');
        $this->createChildNode($mediaBusinesNode, "Пресс-служба")->setPage($this->getPageReference('press-sluzhba'));
        $this->createChildNode($mediaBusinesNode, "Онлайн конференции")->setPage($this->getPageReference('events'));

        $enAbout = $this->createChildNode($mainRootNode, "About");
        $this->createChildNode($enAbout, 'Activities')->setPage($this->getPageReference('en-activities'));
        $this->createChildNode($enAbout, 'Leadership')->setPage($this->getPageReference('en-leadership'));
        $this->createChildNode($enAbout, 'Contacts')->setPage($this->getPageReference('en-contacts'));

        $mainMenu = new Menu();
        $mainMenu->setName('header_main');
        $mainMenu->setTitle('Главное меню');
        $mainMenu->setRootNode($mainRootNode);

        $manager->persist($mainMenu);


        $manager->flush();
        $manager->clear();

        $mainRootNode = new MenuNode();
        $mainRootNode->setTitle('Главное меню футера');
        $mainRootNode->setNodeName('main_menu_footer');
//        $mainRootNode->setUri('/');

        $onlineServicesNode = $this->createChildNode($mainRootNode, "Онлайн-сервисы");
        $this->createChildNode($onlineServicesNode, "Что за стройка рядом с моим домом?")->setRoute('app_construction');
//        $this->createChildNode($onlineServicesNode, "Снос пятиэтажек");
//        $this->createChildNode($onlineServicesNode, "Горячие линии");

        $cityBuildersNode = $this->createChildNode($mainRootNode, "Градостроителям");
        $this->createChildNode($cityBuildersNode, "СРО Строительная наука")->setPage($this->getPageReference('sro'));
//        $this->createChildNode($cityBuildersNode, "Городские конкурсы");
//        $this->createChildNode($cityBuildersNode, "Архитектурные конкурсы");
        $this->createChildNode($cityBuildersNode, "Электронные услуги")->setPage($this->getPageReference('elektronnye-uslugi'));

        $peopleNode = $this->createChildNode($mainRootNode, "Жителям");
        $this->createChildNode($peopleNode, "Карты развития дорожно-транспортной инфраструктуры")->setPage($this->getPageReference('dorozhnoe-stroitelstvo'));
        $this->createChildNode($peopleNode, "Строительство новых поликлиник")->setPage($this->getPageReference('programma-stroitelstva-novyh-poliklinik-do-2017-goda'));;
        $this->createChildNode($peopleNode, "Проекты детских садов, школ и БНК")->setPage($this->getPageReference('stroitelstvo-shkol-i-bnk'));;
        $this->createChildNode($peopleNode, "Участникам долевого строительства")->setPage($this->getPageReference('uchastnikam-dolevogo-stroitelstva-2'));;
        $this->createChildNode($peopleNode, "Реновация промзон")->setPage($this->getPageReference('renovaciya-promzon'));;
        $this->createChildNode($peopleNode, "Типовые варианты перепланировки квартир")->setPage($this->getPageReference('tipovye-varianty-pereplanirovki-kvartir'));
        $this->createChildNode($peopleNode, "Социальные инициативы")->setPage($this->getPageReference('initiative_list'));
//        $this->createChildNode($peopleNode, "Часто задаваемые вопросы");

        /*$undergroundBuildingNode = $this->createChildNode($mainRootNode, "Строительство метро");
        $this->createChildNode($undergroundBuildingNode, "Перспективная карта метро");
        $this->createChildNode($undergroundBuildingNode, "Видеотур по строящимся станциям метро");
        $this->createChildNode($undergroundBuildingNode, "Список строящихся станция");
        $this->createChildNode($undergroundBuildingNode, "Второе кольцо метро");*/

//        $roadBuildingNode = $this->createChildNode($mainRootNode, "Дорожное строительство");
//        $this->createChildNode($roadBuildingNode, "Реконструкция вылетных магистралей");
//        $this->createChildNode($roadBuildingNode, "Северо-Западная хорда");
//        $this->createChildNode($roadBuildingNode, "Северо-Восточная хорда");
//        $this->createChildNode($roadBuildingNode, "Южная хорда");

        $programmsNode = $this->createChildNode($mainRootNode, "Программы");
        $this->createChildNode($programmsNode, "Общая информация")->setPage($this->getPageReference('obschaya-informaciya'));
        $this->createChildNode($programmsNode, "Градостроительная политика")->setPage($this->getPageReference('gradostroitelnaya-politika'));
        $this->createChildNode($programmsNode, "Жилище")->setPage($this->getPageReference('zhilische'));
        $this->createChildNode($programmsNode, "Адресная инвестиционная программа")->setPage($this->getPageReference('adresnaya-investicionnaya-programma'));

//        $roadBuildingNode2 = $this->createChildNode($mainRootNode, "Дорожное строительство");
//        $this->createChildNode($roadBuildingNode2, 'Виртуальная выставка проектов 12 точек роста «новой Москвы»');
//        $this->createChildNode($roadBuildingNode2, "Конкурс на концепцию развития");
//        $this->createChildNode($roadBuildingNode2, "Строительство новых социальных объектов");
//        $this->createChildNode($roadBuildingNode2, "Итоги работы за год");

        $documentsNode = $this->createChildNode($mainRootNode, "Документы");
        $this->createChildNode($documentsNode, 'Законы, постановления, распоряжения, указы')->setRoute('app_document_law_list');
        $this->createChildNode($documentsNode, "Проекты правовых нормативных актов")->setRoute('app_document_drafts_list');
        $this->createChildNode($documentsNode, "Решения об утверждении проектной документации")->setRoute('app_document_decision_list');

        $menu = new Menu();
        $menu->setName('main_menu_footer');
        $menu->setTitle('Главное меню футера');
        $menu->setRootNode($mainRootNode);

        $manager->persist($menu);
        $manager->flush();
        $manager->clear();

        $mainRootNode = new MenuNode();
        $mainRootNode->setTitle('СМИ');
        $mainRootNode->setNodeName('media_menu_footer');
//        $mainRootNode->setUri('/');

        $this->createChildNode($mainRootNode, "Новости")->setRoute('app_news_list');
        $this->createChildNode($mainRootNode, "Пресс-релизы")->setRoute('app_press_releases_list');
//        $this->createChildNode($mainRootNode, "Стенограммы");
//        $this->createChildNode($mainRootNode, "Рабочие видео материалы");
        $this->createChildNode($mainRootNode, "Фотогалеря")->setRoute('app_gallery_list');
        $this->createChildNode($mainRootNode, "Видеогалерея")->setRoute('app_video_list');
        $this->createChildNode($mainRootNode, "Статьи")->setRoute('app_articles_list');
        $this->createChildNode($mainRootNode, "Интервью")->setRoute('app_interviews_list');
        $this->createChildNode($mainRootNode, "Пресс-служба")->setPage($this->getPageReference('press-sluzhba'));
        $this->createChildNode($mainRootNode, "Онлайн конференции")->setPage($this->getPageReference('events'));

        $menu = new Menu();
        $menu->setName('media_menu_footer');
        $menu->setTitle('Меню «СМИ» футера');
        $menu->setRootNode($mainRootNode);

        $manager->persist($menu);
        $manager->flush();
        $manager->clear();

        $mainRootNode = new MenuNode();
        $mainRootNode->setTitle('О комплексе');
        $mainRootNode->setNodeName('about_menu_footer');
//        $mainRootNode->setUri('/');

        $this->createChildNode($mainRootNode, "Деятельность")->setPage($this->getPageReference('deyatelnost'));
        $this->createChildNode($mainRootNode, "Структура")->setRoute('app_person_list');
//        $this->createChildNode($mainRootNode, "Контактная информация")->setPage($this->getPageReference('kontakty'));
        $this->createChildNode($mainRootNode, "Справочник организаций")->setPage($this->getPageReference('organizations'));
        $this->createChildNode($mainRootNode, "Карта сайта")->setRoute('app_sitemap');
        $this->createChildNode($mainRootNode, "Условия использования материалов")->setPage($this->getPageReference('usloviya-ispolzovaniya'));
        $this->createChildNode($mainRootNode, "Сообщить об ошибке")->setRoute('app_error_report');

        $menu = new Menu();
        $menu->setName('about_menu_footer');
        $menu->setTitle('Меню «О комплексе» футера');
        $menu->setRootNode($mainRootNode);

        $manager->persist($menu);
        $manager->flush();
        $manager->clear();

        $mainRootNode = new MenuNode();
        $mainRootNode->setTitle('Верхнее меню');
        $mainRootNode->setNodeName('top_menu');
//        $mainRootNode->setUri('/');

//        $this->createChildNode($mainRootNode, "Метро");
        $this->createChildNode($mainRootNode, "Дороги")->setPage($this->getPageReference('dorozhnoe-stroitelstvo'));;
        $this->createChildNode($mainRootNode, "Новая Москва")->setPage($this->getPageReference('new-moscow'));
//        $this->createChildNode($mainRootNode, "ТПУ")->setPage($this->getPageReference('TPU-aip'));
        $this->createChildNode($mainRootNode, "Метро")->setPage($this->getPageReference('metro'));

        $menu = new Menu();
        $menu->setName('top_menu');
        $menu->setTitle('Верхнее меню');
        $menu->setRootNode($mainRootNode);

        $manager->persist($menu);
        $manager->flush();
        $manager->clear();
    }

    private function createMenuRootNode($title, $alias)
    {
        $menu = new Menu();
        $menu->setTitle($title);
        $menu->setName($alias);

        $this->manager->persist($menu);
        $this->manager->flush();

        $rootNode = $this->createRootNode($menu);
        $menu->setRootNode($rootNode);

        return $rootNode;
    }

    private function createRootNode(Menu $menu)
    {
        $node = new MenuNode();
        $node->setTitle($menu->getTitle());

        $this->manager->persist($node);

        return $node;
    }

    private function createChildNode(MenuNode $parent, $title)
    {
        $node = new MenuNode();
        $node->setTitle($title);
        $node->setNodeName(substr($this->slugifier->slugify($title), 0, 20));
        $node->setParent($parent);
//        $node->setUri('/');

        $this->manager->persist($node);

        return $node;
    }

    /**
     * @param string $title Menu title
     * @param string $code Menu code
     * @param mixed $firstLevelItemsCount Fixed number of 1st level menu items or min and max values for rand()
     * @param mixed|null $secondLevelItemsCount Fixed number of 2nd level menu items or min and max values for rand()
     */
    private function createMenu($title, $code, $firstLevelItemsCount, $secondLevelItemsCount = null)
    {
        $rootNode = $this->createMenuRootNode($title, $code);

        if ($firstLevelItemsCount) {
            if (is_array($firstLevelItemsCount)) {
                list($min, $max) = $firstLevelItemsCount;
            } else {
                $min = 1;
                $max = $firstLevelItemsCount;
            }

            for ($i = $min; $i < $max; $i++) {
                $nodeTitle = $this->faker->realText(20);
                $node = $this->createChildNode($rootNode, $nodeTitle);

                if ($secondLevelItemsCount) {
                    if (is_array($secondLevelItemsCount)) {
                        list($min2, $max2) = $secondLevelItemsCount;
                    } else {
                        $min2 = 1;
                        $max2 = $secondLevelItemsCount;
                    }

                    for ($j = $min2; $j < $max2; $j++) {
                        $nodeTitle = $this->faker->realText(50);
                        $subNode = $this->createChildNode($node, $nodeTitle);
                    }
                }
            }
        }
    }

    protected function getPageReference($name)
    {
        return $this->getReference('page-' . $name);
    }
}
