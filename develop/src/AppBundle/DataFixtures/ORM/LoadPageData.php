<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Block;
use AppBundle\Entity\Category;
use AppBundle\Entity\Page;
use AppBundle\Routing\PostCategoryRouteName;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class LoadPageData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $homePage = new Page();
        $homePage->setTitle('Главная');
        $homePage->setSlug('');
        $homePage->setRoute('app_homepage');
        $homePage->setPublishable(true);
        $this->addBlock($manager, $homePage, 'content', 'post_list');

        /*$getEntityReferences = function ($refNameBase, $refId) {
            $entity = $this->getReference($refNameBase . $refId);

            return (string)(new EntityReference(ClassUtils::getRealClass(get_class($entity)), $entity->getId()));
        };

        $this->addBlock($manager, $homePage, 'media_picks', 'gallery_pick', [
            'item' => $getEntityReferences('gallery-pick', ''),
        ]);

        $this->addBlock($manager, $homePage, 'media_picks', 'video_picks', [
            'item1' => $getEntityReferences('video-pick-', 1),
            'item2' => $getEntityReferences('video-pick-', 2),
            'item3' => $getEntityReferences('video-pick-', 3),
            'item4' => $getEntityReferences('video-pick-', 4),
        ]);

        $this->addBlock($manager, $homePage, 'infographics_picks', 'infographics_picks', [
            'item1' => $getEntityReferences('infographics-pick-', 1),
            'item2' => $getEntityReferences('infographics-pick-', 2),
            'item3' => $getEntityReferences('infographics-pick-', 3),
            'item4' => $getEntityReferences('infographics-pick-', 4),
            'item5' => $getEntityReferences('infographics-pick-', 5),
        ]);*/
        $manager->persist($homePage);

        foreach (Category::$categories as $alias => $title) {
            $postPage = (new Page())
                ->setParent($homePage)
                ->setTitle($title)
                ->setSlug($alias)
                ->setRoute(PostCategoryRouteName::generate($alias, PostCategoryRouteName::TYPE_LIST))
                ->addSubRoutes(sprintf('app_%s_show', $alias))
                ->setPublishable(true)
            ;
            $manager->persist($postPage);

            if (!empty(Category::$hasPopularPage[$alias])) {
                $postPage = (new Page())
                    ->setParent($homePage)
                    ->setTitle('ТОП ' . $title)
                    ->setSlug($alias)
                    ->setRoute(PostCategoryRouteName::generate($alias, PostCategoryRouteName::TYPE_LIST_POPULAR))
                    ->setPublishable(true);
                $manager->persist($postPage);
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
        $manager->persist($infographicsPage);

        $videoPage = new Page();
        $videoPage
            ->setParent($homePage)
            ->setTitle('Видео')
            ->setSlug('video')
            ->setRoute('app_video_list')
            ->addSubRoutes('app_video_show')
            ->setPublishable(true)
        ;
        $manager->persist($videoPage);

        $galleryPage = new Page();
        $galleryPage
            ->setParent($homePage)
            ->setTitle('Фотогалерея')
            ->setSlug('gallery')
            ->setRoute('app_gallery_list')
            ->addSubRoutes('app_gallery_show')
            ->setPublishable(true)
        ;
        $manager->persist($galleryPage);

        $structurePage = new Page();
        $structurePage
            ->setParent($homePage)
            ->setTitle('Структура')
            ->setRoute('app_person_list')
            ->addSubRoutes('app_person_show')
            ->setPublishable(true)
        ;
        $manager->persist($structurePage);

        $documentsPage = new Page();
        $documentsPage
            ->setParent($homePage)
            ->setTitle('Документы')
            ->setRoute('app_document_list')
            ->addSubRoutes('app_document_show')
            ->setPublishable(true)
        ;
        $manager->persist($documentsPage);
        $documentsLawPage = new Page();
        $documentsLawPage
            ->setParent($documentsPage)
            ->setTitle('Законы, постановления, распоряжения, указы')
            ->setRoute('app_document_law_list')
            ->setPublishable(true)
        ;
        $manager->persist($documentsLawPage);
        $documentsDraftsPage = new Page();
        $documentsDraftsPage
            ->setParent($documentsPage)
            ->setTitle('Проекты правовых нормативных актов')
            ->setRoute('app_document_drafts_list')
            ->setPublishable(true)
        ;
        $manager->persist($documentsDraftsPage);
        $documentsDecisionPage = new Page();
        $documentsDecisionPage
            ->setParent($documentsPage)
            ->setTitle('Решения об утверждении проектной документации')
            ->setRoute('app_document_decision_list')
            ->setPublishable(true)
        ;
        $manager->persist($documentsDecisionPage);

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
        $manager->persist($constructionPage);

        $metroPage = new Page();
        $metroPage
            ->setParent($homePage)
            ->setTitle('Метро')
            ->setRoute('app_metro_list')
            ->setSlug('metro')
            ->addSubRoutes('app_metro_show')
            ->setPublishable(true)
        ;
        $manager->persist($metroPage);
        $this->setPageReference('metro', $metroPage);

        $roadPage = new Page();
        $roadPage
            ->setParent($homePage)
            ->setTitle('Дорожное строительство')
            ->setRoute('app_road_list')
            ->setSlug('road')
            ->setPublishable(true)
            ->addSubRoutes('app_road_show')
        ;
        $manager->persist($roadPage);
        $this->setPageReference('road', $roadPage);

        $roadTrunkPage = new Page();
        $roadTrunkPage
            ->setParent($roadPage)
            ->setTitle('Реконструкция вылетных магистралей')
            ->setRoute('app_road_trunk_list')
            ->setSlug('road/trunk')
            ->addSubRoutes('app_road_trunk_show')
            ->setPublishable(true)
        ;
        $manager->persist($roadTrunkPage);
        $this->setPageReference('road-trunk', $roadTrunkPage);

        $roadInterchangePage = new Page();
        $roadInterchangePage
            ->setParent($roadPage)
            ->setTitle('Реконструкция клеверных развязок на МКАД')
            ->setRoute('app_road_interchange_list')
            ->setSlug('road/interchange')
            ->addSubRoutes('app_road_interchange_show')
            ->setPublishable(true)
        ;
        $manager->persist($roadInterchangePage);
        $this->setPageReference('road-interchange', $roadInterchangePage);

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
        $manager->persist($sitemapPage);

        $this->createPage($homePage, 'Социальные инициативы', 'initiative_list')
            ->setRoute('app_initiative_list')
            ->addSubRoutes('app_initiative_show');

        $this->createPage($homePage, 'Онлайн конференции', 'events')
            ->setRoute('app_event_list')
            ->addSubRoutes('app_event_show');


        //stub content pages

        $this->createPageFromData($homePage, 'deyatelnost', 'О Стройкомплексе');
        $this->createPageFromData($homePage, 'stroitelstvo-v-okrugah-raionah');
        $ds = $this->createPageFromData($homePage, 'dorozhnoe-stroitelstvo');
        $ds->setSection(true);
        $this->createPageFromData($ds, 'rekonstrukciya-vyletnyh-magistralei-1');
        $this->createPageFromData($ds, 'hordy');
        $this->createPageFromData($ds, 'rekonstrukciya-klevernyh-razvyazok-na-mkad');

        $pt = $this->createPageFromData($ds, 'stroitelstvo-puteprovodov');
        $this->createPageFromData($pt, 'kak-vozvodyat-estakady');

        $this->createPageFromData($ds, 'dorogi-raionnogo-znacheniya');
        $this->createPageFromData($ds, 'kak-stroyat-dorogi-1');

        $this->createPageFromData($homePage, 'razvitie-uds');
        $this->createPageFromData($homePage, 'doma-kotorye-snesut-v-2015-godu');
        $this->createPageFromData($homePage, 'programma-stroitelstva-novyh-poliklinik-do-2017-goda');
        $this->createPageFromData($homePage, 'detskie-sady-1');
        $this->createPageFromData($homePage, 'stroitelstvo-shkol-i-bnk');
        $this->createPageFromData($homePage, 'stadiony-moskvy');
        $this->createPageFromData($homePage, 'renovaciya-promzon');
        $this->createPageFromData($homePage, 'uchastnikam-dolevogo-stroitelstva-2');
        $this->createPageFromData($homePage, 'unikalnaya-arhitektura');
        $this->createPageFromData($homePage, 'tipovye-varianty-pereplanirovki-kvartir');
        $this->createPageFromData($homePage, 'centralnyi-detskii-magazin-na-lubyanke');

        $this->createPageFromData($homePage, 'otraslevye-shemy');
        $this->createPageFromData($homePage, 'isogd');
        $this->createPageFromData($homePage, 'katalog-stroitelnoi-produkcii-i-tehnologii');
        $this->createPageFromData($homePage, 'sro');
        $this->createPageFromData($homePage, 'osnovnye-zadachi-i-funkcii-koordinacionnogo-soveta');
        $this->createPageFromData($homePage, 'novye-pravila-razmescheniya-vyvesok-na-ulicah-moskvy');
        $this->createPageFromData($homePage, 'informacionnoe-pismo');

        $this->createPageFromData($homePage, 'elektronnye-uslugi');

        $this->createPageFromData($homePage, 'press-sluzhba');

        $this->createPageFromData($homePage, 'new-moscow');
        $this->createPageFromData($homePage, 'TPU-aip');


        $this->createPageFromData($homePage, 'obschaya-informaciya');
        $this->createPageFromData($homePage, 'gradostroitelnaya-politika');
        $this->createPageFromData($homePage, 'zhilische');
        $this->createPageFromData($homePage, 'adresnaya-investicionnaya-programma');

//        $this->createPageFromData($homePage, 'kontakty');
        $this->createPageFromData($homePage, 'usloviya-ispolzovaniya');

//        $emailSubscriptionControlPage = (new Page())
//            ->setParent($homePage)
//            ->setTitle('Управление рассылками')
//            ->setSlug('newsletters')
//            ->setRoute('email_subscription_control')
//            ->setPublishable(true)
//        ;
//        $manager->persist($emailSubscriptionControlPage);


        //en content

        $activities =
        $this->createPage($homePage, 'Activities', 'en-activities', 'en')
            ->setContent(file_get_contents(__DIR__ . '/../data/page/en-activities.txt'));

        $this->createPage($activities, 'Leadership', 'en-leadership', 'leadership')
            ->setContent(file_get_contents(__DIR__ . '/../data/page/en-leadership.txt'));

        $this->createPage($activities, 'Contacts', 'en-contacts', 'contacts')
            ->setContent(file_get_contents(__DIR__ . '/../data/page/en-contacts.txt'));

        $this->createPage($homePage, 'Снос пятиэтажек в Москве', 'destruction', 'destruction')
            ->setContent(file_get_contents(__DIR__ . '/../data/page/destruction.html'));

        $manager->flush();
    }

    protected function addBlock(ObjectManager $manager, Page $page, $container, $type, array $settings = [])
    {
        $block = new Block();
        $block->setEnabled(true);
        $block->setPage($page);
        $block->setContainer($container);
        $block->setType($type);
        $block->setSettings($settings);

        $manager->persist($block);
    }

    protected function loadPageData($pageSlug)
    {
        static $allPages;
        if (!isset($allPages)) {
            require(__DIR__ . '/../data/page/all.php');
            foreach($st_structure_item as $pageData) {
                $allPages[$pageData['slug']] = $pageData;
            }
        }

        return $allPages[$pageSlug];

        /*$fileName = __DIR__ . '/../data/page/' . $pageName . '.php';
        require($fileName);

        $pageData = $st_structure_item[0];

        return $pageData;*/
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

    protected function createPageFromData($parent, $pageName, $titleOverride = null)
    {
        $pageData = $this->loadPageData($pageName);

        $page = $this->createPage($parent, $titleOverride ?: $pageData['name'], $pageName, $pageData['slug'], function (Page $page) use ($pageData) {
            $text = $pageData['page_text'];
            $text = str_replace('"/images/', '"http://stroi.mos.ru/images/', $text);
            $text = str_replace('"/uploads/', '"http://stroi.mos.ru/uploads/', $text);
            $text = str_replace('" /uploads/', '"http://stroi.mos.ru/uploads/', $text);
            $text = nl2br($text);

            $text = str_replace(
                ['\n', '\r', '\t', ],
                ["\n", "\r", "\t", ],
                $text
            );

            $page->setContent($text);
        });

        return $page;
    }

    protected function setPageReference($name, Page $page)
    {
        $this->setReference('page-' . $name, $page);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return FixturesOrder::L4;
    }
}
