<?php
namespace Import;

use AppBundle\Entity\Category;
use AppBundle\Entity\Menu;
use AppBundle\Entity\MenuNode;
use AppBundle\Routing\PostCategoryRouteName;
use Cocur\Slugify\Slugify;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LoadMenuData extends BaseImport implements DependentFixtureInterface
{
    /**
     * @var Slugify
     */
    protected $slugifier;

    public function getDependencies()
    {
        return [
            LoadPageData::class,
            ImportPageData::class
        ];
    }

    public function doLoad()
    {
        $this->slugifier = Slugify::create();

        $menu = new Menu();
        $menu->setName('header_main');
        $menu->setTitle('Главное меню');

        $mainRootNode = new MenuNode();
        $mainRootNode->setTitle('Главное меню');
        $mainRootNode->setNodeName('main_menu');
        $menu->setRootNode($mainRootNode);

        $aboutNode = $this->createChildNode($mainRootNode, "О Стройкомплексе");
        $this->createChildNode($aboutNode, "Справочник организаций")->setRoute('app_organization_list');
        $this->createChildNode($aboutNode, "Деятельность")->setPage($this->getPageReference('import/deyatelnost'));
        $this->createChildNode($aboutNode, "Структура")->setRoute('app_person_list');
        $this->createChildNode($aboutNode, "Контакты")->setPage($this->getPageReference('import/kontakty'));

        $this->createChildNode($aboutNode, 'Законы, постановления, распоряжения, указы')->setRoute('app_document_law_list');
        $this->createChildNode($aboutNode, "Проекты правовых нормативных актов")->setRoute('app_document_drafts_list');
        $this->createChildNode($aboutNode, "Решения об утверждении проектной документации")->setRoute('app_document_decision_list');

        $peopleNode = $this->createChildNode($mainRootNode, "Жителям");

        $this->createChildNode($peopleNode, "Строительство в округах, районах")->setPage($this->getPageReference('import/stroitelstvo-v-okrugah-raionah'));
        $this->createChildNode($peopleNode, "Все стройки Москвы")->setRoute('app_construction');
        $this->createChildNode($peopleNode, "Карты развития дорожно-транспортной инфраструктуры")->setPage($this->getPageReference('import/razvitie-uds'));
        $this->createChildNode($peopleNode, "Снос пятиэтажек")->setRoute('app_destruction');
        $this->createChildNode($peopleNode, "Дома, которые снесут в 2015 году")->setPage($this->getPageReference('import/doma-kotorye-snesut-v-2015-godu'));
        $this->createChildNode($peopleNode, "Строительство поликлиник в Москве")->setPage($this->getPageReference('import/programma-stroitelstva-novyh-poliklinik-do-2017-goda'));
        $this->createChildNode($peopleNode, "Строительство детских садов")->setPage($this->getPageReference('import/detskie-sady-1'));
        $this->createChildNode($peopleNode, "Строительство школ и БНК")->setPage($this->getPageReference('import/stroitelstvo-shkol-i-bnk'));
        $this->createChildNode($peopleNode, "Стадионы Москвы")->setPage($this->getPageReference('import/stadiony-moskvy'));
        $this->createChildNode($peopleNode, "Реновация промзон")->setPage($this->getPageReference('import/renovaciya-promzon'));
        $this->createChildNode($peopleNode, "Долевое строительство")->setPage($this->getPageReference('import/uchastnikam-dolevogo-stroitelstva-2'));
        $this->createChildNode($peopleNode, "Уникальная архитектура")->setPage($this->getPageReference('import/unikalnaya-arhitektura'));
        $this->createChildNode($peopleNode, "Фотоленты")->setRoute('app_photo_lines_list');
        $this->createChildNode($peopleNode, "Перепланировка квартир")->setPage($this->getPageReference('import/tipovye-varianty-pereplanirovki-kvartir'));
        $this->createChildNode($peopleNode, "Центральный детский магазин на Лубянке")->setPage($this->getPageReference('import/centralnyi-detskii-magazin-na-lubyanke'));
        $this->createChildNode($peopleNode, "Социальные инициативы")->setRoute('app_initiative_list');

        $developersNode = $this->createChildNode($mainRootNode, "Градостроителям");

        $this->createChildNode($developersNode, "Архитектурные конкурсы")->setPage($this->getPageReference('import/arhitekturnye-konkursy'));
        $this->createChildNode($developersNode, "Отраслевые схемы")->setPage($this->getPageReference('import/otraslevye-shemy'));
        $this->createChildNode($developersNode, "ИСОГД")->setPage($this->getPageReference('import/isogd'));
        $this->createChildNode($developersNode, "МТСК")->setPage($this->getPageReference('import/katalog-stroitelnoi-produkcii-i-tehnologii'));
        $this->createChildNode($developersNode, "Генеральный план развития Москвы")->setPage($this->getPageReference('import/generalnyi-plan-razvitiya-moskvy'));
        $this->createChildNode($developersNode, "Строительная наука")->setRoute(PostCategoryRouteName::generate(Category::CATEGORY_BUILDER_SCIENCE, PostCategoryRouteName::TYPE_LIST));
        $this->createChildNode($developersNode, "СРО")->setPage($this->getPageReference('import/sro'));
        $this->createChildNode($developersNode, "Городские конкурсы")->setPage($this->getPageReference('import/gorodskie-konkursy'));
        $this->createChildNode($developersNode, "Новые правила размещения информационных вывесок на улицах Москвы")->setPage($this->getPageReference('import/novye-pravila-razmescheniya-vyvesok-na-ulicah-moskvy'));
        $this->createChildNode($developersNode, "Информационное письмо")->setPage($this->getPageReference('import/informacionnoe-pismo'));
        $this->createChildNode($developersNode, "Совет молодых специалистов")->setPage($this->getPageReference('import/sovet-molodyh-specialistov'));

        $buildersNode = $this->createChildNode($mainRootNode, "Застройщикам");
        $this->createChildNode($buildersNode, "Электронные услуги")->setPage($this->getPageReference('import/elektronnye-uslugi'));
        $this->createChildNode($buildersNode, "Инвестиционный портал москвы")->setUri('http://investmoscow.ru/');
        $this->createChildNode($buildersNode, "Актуальная информация для застройщиков")->setPage($this->getPageReference('import/poslednie-novosti'));

        $mediaBusinesNode = $this->createChildNode($mainRootNode, "СМИ");
        $this->createChildNode($mediaBusinesNode, "Пресс-релизы")->setRoute('app_press_releases_list');
        $this->createChildNode($mediaBusinesNode, "Фотогалерея")->setRoute('app_gallery_list');
        $this->createChildNode($mediaBusinesNode, "Видеогалерея")->setRoute('app_video_list');
        $this->createChildNode($mediaBusinesNode, "Статьи")->setRoute('app_articles_list');
        $this->createChildNode($mediaBusinesNode, "Интервью")->setRoute('app_interviews_list');
        $this->createChildNode($mediaBusinesNode, "Инфографика")->setRoute('app_infographics_list');
        $this->createChildNode($mediaBusinesNode, "Онлайн конференции")->setRoute('app_event_list');


        $enAbout = $this->createChildNode($mainRootNode, "ENG");
        $this->createChildNode($enAbout, 'Activities')->setPage($this->getPageReference('en-activities'));
        $this->createChildNode($enAbout, 'Leadership')->setPage($this->getPageReference('en-leadership'));
        $this->createChildNode($enAbout, 'Contacts')->setPage($this->getPageReference('en-contacts'));


        $this->manager->persist($menu);
        $this->manager->persist($mainRootNode);
        $this->manager->flush();
        $this->manager->clear();
        unset($menu, $mainRootNode);

        $menu = new Menu();
        $menu->setName('main_menu_footer');
        $menu->setTitle('Главное меню футера');

        $mainRootNode = new MenuNode();
        $mainRootNode->setTitle('Главное меню футера');
        $mainRootNode->setNodeName('main_menu_footer');
        $menu->setRootNode($mainRootNode);

        $onlineServicesNode = $this->createChildNode($mainRootNode, "Онлайн-сервисы");
        $this->createChildNode($onlineServicesNode, "Что за стройка рядом с моим домом?")->setRoute('app_construction');
        $this->createChildNode($onlineServicesNode, 'Снос пятиэтажек')->setRoute('app_destruction');

        $peopleNode = $this->createChildNode($mainRootNode, "Жителям");
        $this->createChildNode($peopleNode, "Социальные инициативы")->setRoute('app_initiative_list');
        $this->createChildNode($peopleNode, 'Карты развития дорожно-транспортной инфраструктуры')->setPage($this->getPageReference('import/razvitie-uds'));
        $this->createChildNode($peopleNode, 'Строительство новых поликлиник')->setPage($this->getPageReference('import/programma-stroitelstva-novyh-poliklinik-do-2017-goda'));
        $this->createChildNode($peopleNode, 'Проекты детских садов, школ и БНК')->setPage($this->getPageReference('import/detskie-sady-1'));
        $this->createChildNode($peopleNode, 'Участникам долевого строительства')->setPage($this->getPageReference('import/uchastnikam-dolevogo-stroitelstva-2'));
        $this->createChildNode($peopleNode, 'Реновация промзон')->setPage($this->getPageReference('import/renovaciya-promzon'));
        $this->createChildNode($peopleNode, 'Типовые варианты перепланировки квартир')->setPage($this->getPageReference('import/tipovye-varianty-pereplanirovki-kvartir'));
//        $this->createChildNode($peopleNode, 'Часто задаваемые вопросы')->setPage($this->getPageReference('import/chasto-zadavaemye-voprosy'));

        $programsNode = $this->createChildNode($mainRootNode, 'Программы');
        $this->createChildNode($programsNode, 'Общая информация')->setPage($this->getPageReference('import/obschaya-informaciya'));
        $this->createChildNode($programsNode, 'Градостроительная политика')->setPage($this->getPageReference('import/gradostroitelnaya-politika'));
        $this->createChildNode($programsNode, 'Жилище')->setPage($this->getPageReference('import/zhilische'));
        $this->createChildNode($programsNode, 'Адресная инвестиционная программа')->setPage($this->getPageReference('import/adresnaya-investicionnaya-programma'));

        $buildersNode = $this->createChildNode($mainRootNode, 'Градостроителям');
        $this->createChildNode($buildersNode, 'СРО')->setPage($this->getPageReference('import/sro'));
        $this->createChildNode($buildersNode, "Строительная наука")->setRoute(PostCategoryRouteName::generate(Category::CATEGORY_BUILDER_SCIENCE, PostCategoryRouteName::TYPE_LIST));
        $this->createChildNode($buildersNode, 'Городские конкурсы')->setPage($this->getPageReference('import/gorodskie-konkursy'));
        $this->createChildNode($buildersNode, 'Архитектурные конкурсы')->setPage($this->getPageReference('import/arhitekturnye-konkursy'));
        $this->createChildNode($buildersNode, 'Электронные услуги')->setPage($this->getPageReference('import/elektronnye-uslugi'));

        $documentsNode = $this->createChildNode($mainRootNode, "Документы");
        $this->createChildNode($documentsNode, 'Законы, постановления, распоряжения, указы')->setRoute('app_document_law_list');
        $this->createChildNode($documentsNode, "Проекты правовых нормативных актов")->setRoute('app_document_drafts_list');
        $this->createChildNode($documentsNode, "Решения об утверждении проектной документации")->setRoute('app_document_decision_list');

        $metroNode = $this->createChildNode($mainRootNode, 'Строительство метро');
        $this->createChildNode($metroNode, 'Перспективная карта метро')->setRoute('app_metro_list');

        $roadNode = $this->createChildNode($mainRootNode, 'Дорожное строительство');
        $this->createChildNode($roadNode, 'Реконструкция вылетных магистралей')->setRoute('app_road_trunk_list');
//        $this->createChildNode($roadNode, 'Северо-Западная хорда')->setPage($this->getPageReference('import/severo-zapadnaya-horda'));
//        $this->createChildNode($roadNode, 'Северо-Восточная хорда')->setPage($this->getPageReference('import/severo-vostochnaya-horda'));
//        $this->createChildNode($roadNode, 'Южная рокада')->setPage($this->getPageReference('import/uzhnaya-rokada'));

        $newMoscowNode = $this->createChildNode($mainRootNode, '«Новая Москва»');
        $this->createChildNode($newMoscowNode, 'Виртуальная выставка проектов')->setPage($this->getPageReference('import/virtualnaya-vystavka-proektov'));
        $this->createChildNode($newMoscowNode, '12 точек роста «новой Москвы»')->setPage($this->getPageReference('import/12-tochek-rosta-novoi-moskvy'));
        $this->createChildNode($newMoscowNode, 'Конкурс на концепцию развития')->setPage($this->getPageReference('import/o-konkurse'));
        $this->createChildNode($newMoscowNode, 'Строительство новых социальных объектов')->setPage($this->getPageReference('import/stroitelstvo-novyh-socialnyh-obektov'));
        $this->createChildNode($newMoscowNode, 'Итоги работы за год')->setPage($this->getPageReference('import/itogi-raboty-za-god'));

        $this->manager->persist($menu);
        $this->manager->persist($mainRootNode);
        $this->manager->flush();
        $this->manager->clear();
        unset($menu, $mainRootNode);


        $menu = new Menu();
        $menu->setName('media_menu_footer');
        $menu->setTitle('Меню «СМИ» футера');

        $mainRootNode = new MenuNode();
        $mainRootNode->setTitle('СМИ');
        $mainRootNode->setNodeName('media_menu_footer');
        $menu->setRootNode($mainRootNode);

        $this->createChildNode($mainRootNode, "Новости")->setRoute('app_news_list');
        $this->createChildNode($mainRootNode, "Пресс-релизы")->setRoute('app_press_releases_list');
        $this->createChildNode($mainRootNode, "Фотогалеря")->setRoute('app_gallery_list');
        $this->createChildNode($mainRootNode, "Видеогалерея")->setRoute('app_video_list');
        $this->createChildNode($mainRootNode, "Статьи")->setRoute('app_articles_list');
        $this->createChildNode($mainRootNode, "Интервью")->setRoute('app_interviews_list');
        $this->createChildNode($mainRootNode, "Онлайн конференции")->setRoute('app_event_list');

        $this->manager->persist($menu);
        $this->manager->persist($mainRootNode);
        $this->manager->flush();
        $this->manager->clear();
        unset($menu, $mainRootNode);

        $menu = new Menu();
        $menu->setName('about_menu_footer');
        $menu->setTitle('Меню «О комплексе» футера');

        $mainRootNode = new MenuNode();
        $mainRootNode->setTitle('О комплексе');
        $mainRootNode->setNodeName('about_menu_footer');
        $menu->setRootNode($mainRootNode);

        $this->createChildNode($mainRootNode, "Структура")->setRoute('app_person_list');
        $this->createChildNode($mainRootNode, "Справочник организаций")->setRoute('app_organization_list');
        $this->createChildNode($mainRootNode, "Карта сайта")->setRoute('app_sitemap');
        $this->createChildNode($mainRootNode, "Сообщить об ошибке")->setRoute('app_error_report');


        $this->manager->persist($menu);
        $this->manager->persist($mainRootNode);
        $this->manager->flush();
        $this->manager->clear();
        unset($menu, $mainRootNode);

        $menu = new Menu();
        $menu->setName('top_menu');
        $menu->setTitle('Верхнее меню');

        $mainRootNode = new MenuNode();
        $mainRootNode->setTitle('Верхнее меню');
        $mainRootNode->setNodeName('top_menu');
        $menu->setRootNode($mainRootNode);

        $this->createChildNode($mainRootNode, "Метро")->setRoute('app_metro_list');
        $this->createChildNode($mainRootNode, "Дороги")->setRoute('app_road_list');
        $this->createChildNode($mainRootNode, "Новая Москва")->setPage($this->getPageReference('import/new-moscow'));
        $this->createChildNode($mainRootNode, "ТПУ")->setPage($this->getPageReference('import/TPU-aip'));

        $this->manager->persist($menu);
        $this->manager->persist($mainRootNode);
        $this->manager->flush();
        $this->manager->clear();
        unset($menu, $mainRootNode);
    }

    private function createChildNode(MenuNode $parent, $title)
    {
        $node = new MenuNode();
        $node->setTitle($title);
        $node->setNodeName(substr($this->slugifier->slugify($title), 0, 20));
        $node->setParent($parent);

        $this->manager->persist($node);

        return $node;
    }
}
