<?php
namespace Import;

use AppBundle\Entity\Block;
use AppBundle\Entity\Category;
use AppBundle\Entity\Page;
use AppBundle\Routing\PostCategoryRouteName;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LoadPageData extends BaseImport implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            ImportMetroStationsData::class,
//            ImportVideoData::class
        ];
    }

    public function doLoad()
    {
        $homePage = new Page();
        $homePage->setTitle('Главная');
        $homePage->setSlug('');
        $homePage->setRoute('app_homepage');
        $homePage->setPublishable(true);
        $this->manager->persist($homePage);

        foreach (Category::$categories as $alias => $title) {
            $postPage = (new Page())
                ->setParent($homePage)
                ->setTitle($title)
                ->setSlug($alias)
                ->setRoute(PostCategoryRouteName::generate($alias, PostCategoryRouteName::TYPE_LIST))
                ->addSubRoutes(sprintf('app_%s_show', $alias))
                ->setPublishable(true)
            ;
            $this->manager->persist($postPage);

            if (!empty(Category::$hasPopularPage[$alias])) {
                $postPage = (new Page())
                    ->setParent($homePage)
                    ->setTitle('ТОП ' . $title)
                    ->setSlug($alias)
                    ->setRoute(PostCategoryRouteName::generate($alias, PostCategoryRouteName::TYPE_LIST_POPULAR))
                    ->setPublishable(true);
                $this->manager->persist($postPage);
            }
        }

        $infographicsPage = new Page();
        $infographicsPage
            ->setParent($homePage)
            ->setTitle('Инфографика')
            ->setSlug('infographics')
            ->setRoute('app_infographics_list')
            ->addSubRoutes('app_infographics_show')
            ->setPublishable(true)
        ;
        $this->manager->persist($infographicsPage);

        $videoPage = new Page();
        $videoPage
            ->setParent($homePage)
            ->setTitle('Видео')
            ->setSlug('video')
            ->setRoute('app_video_list')
            ->addSubRoutes('app_video_show')
            ->setPublishable(true)
        ;
        $this->manager->persist($videoPage);

        $galleryPage = new Page();
        $galleryPage
            ->setParent($homePage)
            ->setTitle('Фотогалерея')
            ->setSlug('gallery')
            ->setRoute('app_gallery_list')
            ->addSubRoutes('app_gallery_show')
            ->setPublishable(true)
        ;
        $this->manager->persist($galleryPage);

        $structurePage = new Page();
        $structurePage
            ->setParent($homePage)
            ->setTitle('Структура')
            ->setRoute('app_person_list')
            ->addSubRoutes('app_person_show')
            ->setPublishable(true)
        ;
        $this->manager->persist($structurePage);

        $documentsPage = new Page();
        $documentsPage
            ->setParent($homePage)
            ->setTitle('Документы')
            ->setRoute('app_document_list')
            ->addSubRoutes('app_document_show')
            ->setPublishable(true)
        ;
        $this->manager->persist($documentsPage);
        $documentsLawPage = new Page();
        $documentsLawPage
            ->setParent($documentsPage)
            ->setTitle('Законы, постановления, распоряжения, указы')
            ->setRoute('app_document_law_list')
            ->setPublishable(true)
        ;
        $this->manager->persist($documentsLawPage);
        $documentsDraftsPage = new Page();
        $documentsDraftsPage
            ->setParent($documentsPage)
            ->setTitle('Проекты правовых нормативных актов')
            ->setRoute('app_document_drafts_list')
            ->setPublishable(true)
        ;
        $this->manager->persist($documentsDraftsPage);
        $documentsDecisionPage = new Page();
        $documentsDecisionPage
            ->setParent($documentsPage)
            ->setTitle('Решения об утверждении проектной документации')
            ->setRoute('app_document_decision_list')
            ->setPublishable(true)
        ;
        $this->manager->persist($documentsDecisionPage);

        $constructionPage = new Page();
        $constructionPage
            ->setParent($homePage)
            ->setTitle('Все стройки Москвы')
            ->setRoute('app_construction')
            ->setSlug('construction')
            ->addSubRoutes('app_construction_show')
            ->setPublishable(true)
            ->setDescription('
<p>В разделе «Что за стройка рядом с моим домом?» на карте Москвы публикуется информация об объектах капитального строительства, включая жилые дома, детские сады, школы, здравоохранение, спорт и другие объекты общественного назначения, а также административные объекты, объекты торговли и услуг, гаражи, транспортно-пересадочные узлы. Всего более 3 000 объектов.</p>
<p>В ближайшее время будут опубликованы объекты строительства улично-дорожной сети и метро. В разделе не публикуются сведения об объектах инженерно-коммунальной инфраструктуры и индивидуального жилищного строительства.</p>
            ')
        ;
        $this->manager->persist($constructionPage);

        $organizationsPage = $this->createPage($homePage, 'Организации', 'organizations', 'organizations')
            ->setRoute('app_organization_list')
            ->addSubRoutes('app_organization_show')
        ;
        $this->createPage($organizationsPage, 'Телефонный справочник', 'organization-personalities', 'organization-personalities')
            ->setRoute('app_contact_person_list')
            ->addSubRoutes('app_contact_person_show')
        ;

        $sitemapPage = new Page();
        $sitemapPage
            ->setParent($homePage)
            ->setTitle('Карта сайта')
            ->setRoute('app_sitemap')
            ->setPublishable(true)
        ;
        $this->manager->persist($sitemapPage);

        $this->createPage($homePage, 'Социальные инициативы', 'initiative_list')
            ->setRoute('app_initiative_list')
            ->addSubRoutes('app_initiative_show');

        $this->createPage($homePage, 'Онлайн конференции', 'events')
            ->setRoute('app_event_list')
            ->addSubRoutes('app_event_show');

        $metro = $this->createPage($homePage, 'Метро', 'metro', 'metro')
            ->setRoute('app_metro_list')
            ->addSubRoutes('app_metro_show')
            ->setSection(true)
            ->setPageMenuBackground('/images/metro-themes__img.png')
            ->setCurrently('<h4>Строители приступили к возведению <a href="#">северного вестибюля станции метро "Технопарк".</a></h4><p>С 2011 по 2020 год в столице планируется построить более 160 км линий метро и 78 новых станций, <a href="#">14 из них уже открыты.</a> Это позволит снизить нагрузку на действующую сеть метро, а также обеспечит «шаговую доступность» к станциям для 93% жителей Москвы.</p>')
            ->setDescription('<h4>Вылетные линии метро</h4><p>Протяженность метро Москвы составляет 3600 км, при этом обеспеченность российской столицы сетью метро в два-три раза ниже, чем у любого другого мегаполиса мира. В среднем площадь территории Москвы, которую занимают метро, всего 8%, на периферии показатели снижаются до 2 - 3% при европейской норме 15 - 20%.</p>')
        ;
//        $this->createVideoToruBlock($metro);


        $road = $this->createPage($homePage, 'Дорожное строительство', 'road', 'road')
            ->setRoute('app_road_list')
            ->addSubRoutes('app_road_show')
            ->setSection(true)
            ->setPageMenuBackground('/images/road-themes__img.png')
            ->setCurrently('<h4>Строители приступили к возведению <a href="#">северного вестибюля станции метро "Технопарк".</a></h4><p>С 2011 по 2020 год в столице планируется построить более 160 км линий метро и 78 новых станций, <a href="#">14 из них уже открыты.</a> Это позволит снизить нагрузку на действующую сеть метро, а также обеспечит «шаговую доступность» к станциям для 93% жителей Москвы.</p>')
            ->setDescription('<h4>Вылетные магистрали</h4><p>Протяженность дорог Москвы составляет 3600 км, при этом обеспеченность российской столицы улично-дорожной сетью в два-три раза ниже, чем у любого другого мегаполиса мира. В среднем площадь территории Москвы, которую занимают дороги, всего 8%, на периферии показатели снижаются до 2 - 3% при европейской норме 15 - 20%.</p>')
        ;

        $this->createPage($road, 'Реконструкция вылетных магистралей', 'road-trunk')
            ->setRoute('app_road_trunk_list')
            ->addSubRoutes('app_road_trunk_show')
            ->setDescription('<p><strong>Вылетные магистрали</strong> - шоссе (проспект/улица), которые ведут из центра города за его пределы - &laquo;на вылет&raquo;, затем переходя в скоростную, зачастую бессветофорную трассу.</p><p><strong>В первую очередь реконструкция</strong> магистралей направлена на создание условий для движения общественного транспорта - реконструируя весь основной ход шоссе, строители обустраивают дополнительные полосы в каждом направлении и выделенные полосы для автобусов и троллейбусов.</p><p><strong>Вторая задача реконструкции</strong> - формирование транспортных связей между кварталами, прилегающими к шоссе. Дороги-дублеры, обустроенные вдоль магистралей, позволят значительно разгрузить шоссе, поскольку жителям микрорайонов не придется выезжать на основную магистраль ради того, чтобы проехать 2 - 3 км и вновь съехать на внутриквартальную дорогу.</p><p>Помимо создания на шоссе выделенных полос и дублеров предполагается реконструкция и строительство новых развязок с эстакадами, мостами, тоннелями.</p>')
        ;

        $this->createPage($road, 'Реконструкция клеверных развязок на МКАД', 'road-interchange')
            ->setRoute('app_road_interchange_list')
            ->addSubRoutes('app_road_interchange_show')
        ;

        $dataDir = __DIR__ . '/../AppBundle/DataFixtures/data/page';
        $activities =
        $this->createPage($homePage, 'Activities', 'en-activities', 'en')
            ->setContent(file_get_contents($dataDir . '/en-activities.txt'));

        $this->createPage($activities, 'Leadership', 'en-leadership', 'leadership')
            ->setContent(file_get_contents($dataDir . '/en-leadership.txt'));

        $this->createPage($activities, 'Contacts', 'en-contacts', 'contacts')
            ->setContent(file_get_contents($dataDir . '/en-contacts.txt'));

        $this->createPage($homePage, 'Снос пятиэтажек в Москве', 'destruction', 'destruction')
            ->setContent(file_get_contents($dataDir . '/destruction.html'));

        $this->manager->flush();
    }

    protected function createPage($parent = null, $title, $pageReferenceName = null, $slug = null, callable $callback = null)
    {
        $page = new Page();
        $page->setPublishable(true);
        $page->setParent($parent);
        $page->setTitle($title);
        $page->setSlug($slug);

        if (is_callable($callback)) {
            $callback($page);
        }

        $this->manager->persist($page);

        if ($pageReferenceName) {
            $this->setPageReference($pageReferenceName, $page);
        }

        return $page;
    }

    /**
     * @param $metro
     */
    protected function createVideoToruBlock($metro)
    {
        $videos = [];

        for ($i = 0; $i < 5; $i++) {
            $videoReference = $this->getVideoReference($i);
            $metroReference = $this->getMetroReference($i);

            if (!isset($videoReference, $metroReference)) {
                break;
            }

            $videos[] = [
                'video_id' => $videoReference->getId(),
                'metro_station_id' => $metroReference->getId(),
            ];
        }

        $block = new Block();
        $block->setType('metro_vitdeo_tour');
        $block->setContainer('hidden');
        $block->setSettings([
            'videos' => $videos
        ]);
        $block->setPage($metro);
        $this->manager->persist($block);
    }
}