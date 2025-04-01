<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/mobile')) {
            // app_mobile_home_page
            if (rtrim($pathinfo, '/') === '/mobile') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'app_mobile_home_page');
                }

                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::indexAction',  '_route' => 'app_mobile_home_page',);
            }

            // app_mobile_promenade
            if ($pathinfo === '/mobile/road/riekonstruktsiia-nabieriezhnykh-moskvy-rieki') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::promenadeAction',  '_route' => 'app_mobile_promenade',);
            }

            if (0 === strpos($pathinfo, '/mobile/construction')) {
                // construction_mobile_page
                if ($pathinfo === '/mobile/construction') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::constructionAction',  '_route' => 'construction_mobile_page',);
                }

                // app_mobile_construction_list_ajax
                if ($pathinfo === '/mobile/construction/ajax') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\ConstructionController::listAjaxAction',  '_route' => 'app_mobile_construction_list_ajax',);
                }

                // app_mobile_construction_show
                if (preg_match('#^/mobile/construction/(?P<id>\\d+)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_construction_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\ConstructionController::showAction',));
                }

            }

            // mobile_infographics_list
            if ($pathinfo === '/mobile/infographics') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::listInfograficsAction',  '_route' => 'mobile_infographics_list',);
            }

            // mobile_news_list
            if ($pathinfo === '/mobile/news') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::newsListAction',  '_route' => 'mobile_news_list',);
            }

            if (0 === strpos($pathinfo, '/mobile/ajax')) {
                // mobile_infographics_ajax_list
                if ($pathinfo === '/mobile/ajax/infographics') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::listInfograficsAjaxAction',  '_route' => 'mobile_infographics_ajax_list',);
                }

                // news_mobile_ajax
                if ($pathinfo === '/mobile/ajax/news') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::newsListAjaxAction',  '_route' => 'news_mobile_ajax',);
                }

            }

            // app_mobile_stroitelstvo_v_okrugah_raionah
            if ($pathinfo === '/mobile/stroitelstvo-v-okrugah-raionah') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::constructionShowAction',  '_route' => 'app_mobile_stroitelstvo_v_okrugah_raionah',);
            }

            // api_mobile_construction_list
            if ($pathinfo === '/mobile/api/construction') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::apiAction',  '_route' => 'api_mobile_construction_list',);
            }

            // metro_mobile_page
            if ($pathinfo === '/mobile/metro') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::metroAction',  '_route' => 'metro_mobile_page',);
            }

            // app_mobile_call
            if ($pathinfo === '/mobile/call') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::callAction',  '_route' => 'app_mobile_call',);
            }

            // app_mobile_road
            if ($pathinfo === '/mobile/road') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::roadAction',  '_route' => 'app_mobile_road',);
            }

            if (0 === strpos($pathinfo, '/mobile/video')) {
                // app_mobile_video_list_ajax
                if ($pathinfo === '/mobile/video/ajax/list') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\VideoController::listAjaxVideoAction',  '_route' => 'app_mobile_video_list_ajax',);
                }

                // app_mobile_video_show
                if (preg_match('#^/mobile/video/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_video_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\VideoController::showVideoAction',));
                }

            }

            // app_mobile_renovation
            if ($pathinfo === '/mobile/novaia-proghramma-rienovatsii-piatietazhiek') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::renovationAction',  '_route' => 'app_mobile_renovation',);
            }

            if (0 === strpos($pathinfo, '/mobile/snos-piatietazhiek')) {
                // app_mobile_snos_page
                if (preg_match('#^/mobile/snos\\-piatietazhiek/(?P<slug>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_snos_page')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::pageSnosSlugAction',));
                }

                // app_mobile_snos_page_no_slug
                if ($pathinfo === '/mobile/snos-piatietazhiek') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::pageSnosAction',  '_route' => 'app_mobile_snos_page_no_slug',);
                }

            }

            // app_mobile_destruction_page_slug
            if (0 === strpos($pathinfo, '/mobile/destruction') && preg_match('#^/mobile/destruction/(?P<slug>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_destruction_page_slug')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::pageDestructionAction',));
            }

            if (0 === strpos($pathinfo, '/mobile/n')) {
                // app_mobile_renovation_slug
                if (0 === strpos($pathinfo, '/mobile/novaia-proghramma-rienovatsii-piatietazhiek') && preg_match('#^/mobile/novaia\\-proghramma\\-rienovatsii\\-piatietazhiek/(?P<slug>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_renovation_slug')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::renovationPageAction',));
                }

                // app_mobile_new_moscow
                if ($pathinfo === '/mobile/new-moscow') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::newMoscowAction',  '_route' => 'app_mobile_new_moscow',);
                }

            }

            // app_mobile_video_list
            if ($pathinfo === '/mobile/list/video') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\VideoController::listAction',  '_route' => 'app_mobile_video_list',);
            }

            // app_mobile_gallery_list
            if ($pathinfo === '/mobile/gallery') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\GalleryController::listAction',  '_route' => 'app_mobile_gallery_list',);
            }

            if (0 === strpos($pathinfo, '/mobile/a')) {
                // app_mobile_search
                if ($pathinfo === '/mobile/article/search') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\SearchController::searchAction',  '_route' => 'app_mobile_search',);
                }

                // app_mobile_ajax_gallery_list
                if ($pathinfo === '/mobile/ajax/gallery') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\GalleryController::ajaxLiastAction',  '_route' => 'app_mobile_ajax_gallery_list',);
                }

                // app_mobile_search_ajax
                if ($pathinfo === '/mobile/article/search/ajax') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\SearchController::searchAjaxAction',  '_route' => 'app_mobile_search_ajax',);
                }

            }

            // app_mobile_metro_station
            if (0 === strpos($pathinfo, '/mobile/metro/station') && preg_match('#^/mobile/metro/station/(?P<id>\\d+)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_metro_station')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MetroController::showMetroAction',));
            }

            // app_mobile_gallery_show
            if (0 === strpos($pathinfo, '/mobile/gallery') && preg_match('#^/mobile/gallery/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_gallery_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\GalleryController::showAction',));
            }

            // app_mobile_show_infografics
            if (0 === strpos($pathinfo, '/mobile/infographics') && preg_match('#^/mobile/infographics/(?P<slug>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_show_infografics')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\InfograficsController::showInfograficAction',));
            }

            // app_mobile_metro_news
            if (0 === strpos($pathinfo, '/mobile/metro') && preg_match('#^/mobile/metro/(?P<newsSlug>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_metro_news')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MetroController::pageNewsAction',));
            }

            if (0 === strpos($pathinfo, '/mobile/road')) {
                // app_mobile_trunks_road
                if ($pathinfo === '/mobile/road/trunk') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\RoadController::trunkListAction',  '_route' => 'app_mobile_trunks_road',);
                }

                // app_mobile_road_interchange_list
                if ($pathinfo === '/mobile/road/interchange') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\RoadController::listInterchangesAction',  '_route' => 'app_mobile_road_interchange_list',);
                }

                // app_mobile_span_road
                if (0 === strpos($pathinfo, '/mobile/road/road') && preg_match('#^/mobile/road/road/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_span_road')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\RoadController::showAction',));
                }

                // app_mobile_trunk_road
                if (0 === strpos($pathinfo, '/mobile/road/trunk') && preg_match('#^/mobile/road/trunk/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_trunk_road')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\RoadController::trunkAction',));
                }

                // app_mobile_interchange_road
                if (0 === strpos($pathinfo, '/mobile/road/interchange') && preg_match('#^/mobile/road/interchange/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_interchange_road')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\RoadController::interchangeAction',));
                }

                if (0 === strpos($pathinfo, '/mobile/road/regional')) {
                    // road_page_regional
                    if (preg_match('#^/mobile/road/regional/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'road_page_regional')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\RoadController::roadRegionalShowAction',));
                    }

                    // app_mobile_road_regional_list
                    if ($pathinfo === '/mobile/road/regional') {
                        return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\RoadController::listRegionalAction',  '_route' => 'app_mobile_road_regional_list',);
                    }

                }

                // road_news_page
                if (preg_match('#^/mobile/road/(?P<slug>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'road_news_page')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\RoadController::roadNewsAction',));
                }

                // road_news_page_slug
                if (preg_match('#^/mobile/road/(?P<slug>[^/]++)/(?P<newsSlug>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'road_news_page_slug')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\RoadController::roadNewsSlugAction',));
                }

            }

            // app_mobile_metro_news_news_metro
            if (0 === strpos($pathinfo, '/mobile/metro') && preg_match('#^/mobile/metro/(?P<newsSlug>[^/]++)/(?P<slug>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_metro_news_news_metro')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MetroController::pageNewsMetroAction',));
            }

            if (0 === strpos($pathinfo, '/mobile/new')) {
                if (0 === strpos($pathinfo, '/mobile/new-moscow')) {
                    // app_mobile_new_moscwa_show
                    if (preg_match('#^/mobile/new\\-moscow/(?P<slug>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_new_moscwa_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\NewMoscwaController::newMoscwaSLugAction',));
                    }

                    // app_mobile_new_moscwa_show_slug
                    if (preg_match('#^/mobile/new\\-moscow/(?P<slug>[^/]++)/(?P<newsSlug>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_new_moscwa_show_slug')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\NewMoscwaController::newMoscwaSLugNewsAction',));
                    }

                }

                // news_post_page
                if (0 === strpos($pathinfo, '/mobile/news') && preg_match('#^/mobile/news/(?P<slug>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'news_post_page')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::newsAction',));
                }

            }

            if (0 === strpos($pathinfo, '/mobile/a')) {
                // app_mobile_pages_article
                if (0 === strpos($pathinfo, '/mobile/articles') && preg_match('#^/mobile/articles/(?P<slug>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_pages_article')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::newsAction',));
                }

                // app_mobile_posts_ajax_list
                if ($pathinfo === '/mobile/ajax_post_list') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::listAjaxPostAction',  '_route' => 'app_mobile_posts_ajax_list',);
                }

            }

            if (0 === strpos($pathinfo, '/mobile/organizations')) {
                // app_mobile_organizations_ajax_list
                if ($pathinfo === '/mobile/organizations/ajax_list') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\OrganizationController::listAjaxPostAction',  '_route' => 'app_mobile_organizations_ajax_list',);
                }

                // app_mobile_organizations_show
                if (preg_match('#^/mobile/organizations/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_organizations_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\OrganizationController::showAction',));
                }

                // app_mobile_organizations_list
                if ($pathinfo === '/mobile/organizations') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\OrganizationController::listAction',  '_route' => 'app_mobile_organizations_list',);
                }

            }

            // app_mobile_zhd_list
            if ($pathinfo === '/mobile/zhd') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::zhdAction',  '_route' => 'app_mobile_zhd_list',);
            }

            // app_mobile_procedure_calc
            if ($pathinfo === '/mobile/kalkulyator-procedur') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::procedureCalcAction',  '_route' => 'app_mobile_procedure_calc',);
            }

            if (0 === strpos($pathinfo, '/mobile/document')) {
                // app_mobile_document_law_list
                if ($pathinfo === '/mobile/document-law') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\DocumentController::lawDocumentListAction',  '_route' => 'app_mobile_document_law_list',);
                }

                // app_mobile_document_list
                if ($pathinfo === '/mobile/documents') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\DocumentController::listAction',  '_route' => 'app_mobile_document_list',);
                }

                if (0 === strpos($pathinfo, '/mobile/document-d')) {
                    // app_mobile_document_decision_list
                    if ($pathinfo === '/mobile/document-decision') {
                        return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\DocumentController::decisionDocumentListAction',  '_route' => 'app_mobile_document_decision_list',);
                    }

                    // app_mobile_document_drafts_list
                    if ($pathinfo === '/mobile/document-drafts') {
                        return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\DocumentController::draftDocumentListAction',  '_route' => 'app_mobile_document_drafts_list',);
                    }

                }

                // app_mobile_document_list_ajax
                if ($pathinfo === '/mobile/document/ajax_list') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\DocumentController::listAjaxAction',  '_route' => 'app_mobile_document_list_ajax',);
                }

                // app_mobile_document_show
                if (preg_match('#^/mobile/document/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_document_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\DocumentController::showAction',));
                }

            }

            if (0 === strpos($pathinfo, '/mobile/structure')) {
                // app_mobile_person_list
                if ($pathinfo === '/mobile/structure') {
                    return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PersonController::listAction',  '_route' => 'app_mobile_person_list',);
                }

                // app_mobile_person_show
                if (0 === strpos($pathinfo, '/mobile/structure/person') && preg_match('#^/mobile/structure/person/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_person_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PersonController::showAction',));
                }

            }

            // app_mobile_renovation_industrial
            if ($pathinfo === '/mobile/renovaciya-promzon') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::renovationIndustrialPageAction',  '_route' => 'app_mobile_renovation_industrial',);
            }

            // app_mobile_news_list
            if ($pathinfo === '/mobile/news') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'news',  '_route' => 'app_mobile_news_list',);
            }

            // app_mobile_news_show
            if (preg_match('#^/mobile/(?P<categoryAlias>news)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_news_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::showAction',));
            }

            // app_mobile_city_news_list
            if ($pathinfo === '/mobile/city_news') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'city_news',  '_route' => 'app_mobile_city_news_list',);
            }

            // app_mobile_city_news_show
            if (preg_match('#^/mobile/(?P<categoryAlias>city_news)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_city_news_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::showAction',));
            }

            // app_mobile_articles_list
            if ($pathinfo === '/mobile/articles') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'articles',  '_route' => 'app_mobile_articles_list',);
            }

            // app_mobile_articles_show
            if (preg_match('#^/mobile/(?P<categoryAlias>articles)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_articles_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::showAction',));
            }

            // app_mobile_builder_science_list
            if ($pathinfo === '/mobile/builder_science') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'builder_science',  '_route' => 'app_mobile_builder_science_list',);
            }

            // app_mobile_builder_science_show
            if (preg_match('#^/mobile/(?P<categoryAlias>builder_science)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_builder_science_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::showAction',));
            }

            // app_mobile_interviews_list
            if ($pathinfo === '/mobile/interviews') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'interviews',  '_route' => 'app_mobile_interviews_list',);
            }

            // app_mobile_interviews_show
            if (preg_match('#^/mobile/(?P<categoryAlias>interviews)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_interviews_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::showAction',));
            }

            // app_mobile_photo_lines_list
            if ($pathinfo === '/mobile/photo_lines') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'photo_lines',  '_route' => 'app_mobile_photo_lines_list',);
            }

            // app_mobile_photo_lines_show
            if (preg_match('#^/mobile/(?P<categoryAlias>photo_lines)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_photo_lines_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::showAction',));
            }

            // app_mobile_press_releases_list
            if ($pathinfo === '/mobile/press_releases') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'press_releases',  '_route' => 'app_mobile_press_releases_list',);
            }

            // app_mobile_press_releases_show
            if (preg_match('#^/mobile/(?P<categoryAlias>press_releases)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_press_releases_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::showAction',));
            }

            // app_mobile_shorthand-reports_list
            if ($pathinfo === '/mobile/shorthand-reports') {
                return array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'shorthand-reports',  '_route' => 'app_mobile_shorthand-reports_list',);
            }

            // app_mobile_shorthand-reports_show
            if (preg_match('#^/mobile/(?P<categoryAlias>shorthand-reports)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_shorthand-reports_show')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\PostController::showAction',));
            }

            // app_mobile_article_category
            if (preg_match('#^/mobile/(?P<category>[^/]++)/(?P<slug>[^/]++)/(?P<newsSlug>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_article_category')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::categoryPageAction',));
            }

            // app_mobile_pages
            if (preg_match('#^/mobile/(?P<slug>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_pages')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::pagesAction',));
            }

            // app_mobile_404
            if (preg_match('#^/mobile/(?P<path>.*)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_mobile_404')), array (  '_controller' => 'Stroi\\MobileBundle\\Controller\\MobileController::page404NotFoundAction',));
            }

        }

        // rss
        if (0 === strpos($pathinfo, '/news') && preg_match('#^/news/(?P<type>rss|yarss|googlexml|ramrss|mailru|ya_geo_rss|ya_zen_rss|wifi_rss|world_is_small_rss)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'rss')), array (  '_controller' => 'AppBundle\\Controller\\RssController::showAction',));
        }

        if (0 === strpos($pathinfo, '/admin/u')) {
            // amg_update_lock
            if (0 === strpos($pathinfo, '/admin/update_lock') && preg_match('#^/admin/update_lock/(?P<code>[^/]++)/(?P<id>\\d+)(?:/(?P<_sonata_admin>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'amg_update_lock')), array (  '_controller' => 'Amg\\Bundle\\AdminBundle\\Controller\\LockingController::updateLockAction',  '_sonata_admin' => true,));
            }

            // amg_unlock
            if (0 === strpos($pathinfo, '/admin/unlock') && preg_match('#^/admin/unlock/(?P<code>[^/]++)/(?P<id>\\d+)(?:/(?P<_sonata_admin>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'amg_unlock')), array (  '_controller' => 'Amg\\Bundle\\AdminBundle\\Controller\\LockingController::unlockAction',  '_sonata_admin' => true,));
            }

        }

        // app_administrative_area_show
        if (0 === strpos($pathinfo, '/stroitelstvo-v-okrugah-raionah') && preg_match('#^/stroitelstvo\\-v\\-okrugah\\-raionah/(?P<slug>[a-zA-z_0-9-]+)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_administrative_area_show')), array (  '_controller' => 'AppBundle\\Controller\\AdministrativeAreaController::showAction',));
        }

        if (0 === strpos($pathinfo, '/a')) {
            // app_appeal_submit
            if ($pathinfo === '/appeal/submit') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_app_appeal_submit;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\AppealController::submitAction',  '_route' => 'app_appeal_submit',);
            }
            not_app_appeal_submit:

            // app_admin_appeal_retry_send
            if (0 === strpos($pathinfo, '/admin/app/appeal') && preg_match('#^/admin/app/appeal/(?P<id>[^/]++)/retry\\-send$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_admin_appeal_retry_send')), array (  '_controller' => 'AppBundle\\Controller\\AppealController::retrySendAction',));
            }

        }

        // app_city_district_show
        if (0 === strpos($pathinfo, '/stroitelstvo-v-okrugah-raionah') && preg_match('#^/stroitelstvo\\-v\\-okrugah\\-raionah/(?P<areaSlug>[a-zA-z_0-9-]+)/(?P<districtSlug>[a-zA-z_0-9-]+)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_city_district_show')), array (  '_controller' => 'AppBundle\\Controller\\CityDistrictController::showAction',));
        }

        if (0 === strpos($pathinfo, '/construction')) {
            // app_construction
            if ($pathinfo === '/construction') {
                return array (  '_controller' => 'AppBundle\\Controller\\ConstructionController::mapAction',  '_route' => 'app_construction',);
            }

            // app_construction_show
            if (preg_match('#^/construction/(?P<id>\\d+)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_construction_show')), array (  '_controller' => 'AppBundle\\Controller\\ConstructionController::showAction',));
            }

        }

        // api_construction_list
        if ($pathinfo === '/api/construction') {
            return array (  '_controller' => 'AppBundle\\Controller\\ConstructionController::apiAction',  '_route' => 'api_construction_list',);
        }

        // app_construction_map
        if ($pathinfo === '/export/map/roads') {
            return array (  '_controller' => 'AppBundle\\Controller\\ConstructionController::mapRoardAction',  '_route' => 'app_construction_map',);
        }

        if (0 === strpos($pathinfo, '/organization-personalities')) {
            // app_contact_person_list
            if ($pathinfo === '/organization-personalities') {
                return array (  '_controller' => 'AppBundle\\Controller\\ContactPersonController::listAction',  '_route' => 'app_contact_person_list',);
            }

            // app_contact_person_show
            if (preg_match('#^/organization\\-personalities/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_contact_person_show')), array (  '_controller' => 'AppBundle\\Controller\\ContactPersonController::showAction',));
            }

        }

        if (0 === strpos($pathinfo, '/d')) {
            // app_destruction
            if ($pathinfo === '/destruction') {
                return array (  '_controller' => 'AppBundle\\Controller\\DestructionController::indexAction',  '_route' => 'app_destruction',);
            }

            if (0 === strpos($pathinfo, '/document')) {
                // app_document_list
                if ($pathinfo === '/documents') {
                    return array (  '_controller' => 'AppBundle\\Controller\\DocumentController::listAction',  '_route' => 'app_document_list',);
                }

                if (0 === strpos($pathinfo, '/document-')) {
                    // app_document_law_list
                    if ($pathinfo === '/document-law') {
                        return array (  '_controller' => 'AppBundle\\Controller\\DocumentController::lawDocumentListAction',  '_route' => 'app_document_law_list',);
                    }

                    if (0 === strpos($pathinfo, '/document-d')) {
                        // app_document_decision_list
                        if ($pathinfo === '/document-decision') {
                            return array (  '_controller' => 'AppBundle\\Controller\\DocumentController::decisionDocumentListAction',  '_route' => 'app_document_decision_list',);
                        }

                        // app_document_drafts_list
                        if ($pathinfo === '/document-drafts') {
                            return array (  '_controller' => 'AppBundle\\Controller\\DocumentController::draftDocumentListAction',  '_route' => 'app_document_drafts_list',);
                        }

                    }

                }

                // app_document_show
                if (preg_match('#^/document/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_document_show')), array (  '_controller' => 'AppBundle\\Controller\\DocumentController::showAction',));
                }

            }

        }

        // app_error_report
        if ($pathinfo === '/error-report') {
            return array (  '_controller' => 'AppBundle\\Controller\\ErrorReportController::createAction',  '_route' => 'app_error_report',);
        }

        if (0 === strpos($pathinfo, '/gallery')) {
            // app_gallery_list
            if ($pathinfo === '/gallery') {
                return array (  '_controller' => 'AppBundle\\Controller\\GalleryController::listAction',  '_route' => 'app_gallery_list',);
            }

            // app_gallery_show
            if (preg_match('#^/gallery/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_gallery_show')), array (  '_controller' => 'AppBundle\\Controller\\GalleryController::showAction',));
            }

        }

        // app_geocode
        if ($pathinfo === '/api/geocode') {
            return array (  '_controller' => 'AppBundle\\Controller\\GeocodeController::geocodeAction',  '_route' => 'app_geocode',);
        }

        if (0 === strpos($pathinfo, '/infographics')) {
            // app_infographics_list
            if ($pathinfo === '/infographics') {
                return array (  '_controller' => 'AppBundle\\Controller\\InfographicsController::listAction',  '_route' => 'app_infographics_list',);
            }

            // app_infographics_show
            if (preg_match('#^/infographics/(?P<slug>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_infographics_show')), array (  '_controller' => 'AppBundle\\Controller\\InfographicsController::showAction',));
            }

        }

        if (0 === strpos($pathinfo, '/metro')) {
            // app_metro_list
            if ($pathinfo === '/metro') {
                return array (  '_controller' => 'AppBundle\\Controller\\MetroController::listAction',  '_route' => 'app_metro_list',);
            }

            // app_metro_show
            if (0 === strpos($pathinfo, '/metro/station') && preg_match('#^/metro/station/(?P<id>\\d+)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_metro_show')), array (  '_controller' => 'AppBundle\\Controller\\MetroController::showAction',));
            }

        }

        if (0 === strpos($pathinfo, '/organizations')) {
            // app_organization_list
            if ($pathinfo === '/organizations') {
                return array (  '_controller' => 'AppBundle\\Controller\\OrganizationController::listAction',  '_route' => 'app_organization_list',);
            }

            // app_organization_show
            if (preg_match('#^/organizations/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_organization_show')), array (  '_controller' => 'AppBundle\\Controller\\OrganizationController::showAction',));
            }

        }

        // app_hotline
        if ($pathinfo === '/hotline') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::hotlineAction',  '_route' => 'app_hotline',);
        }

        // app_zhd_list
        if ($pathinfo === '/zhd') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::listZhdAction',  '_route' => 'app_zhd_list',);
        }

        // app_new_moscow
        if ($pathinfo === '/new-moscow') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::newMoscowAction',  '_route' => 'app_new_moscow',);
        }

        // app_problem_construction
        if ($pathinfo === '/dostroika-probliemnykh-obiektov') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::problemConstructionPageAction',  '_route' => 'app_problem_construction',);
        }

        // app_renovation
        if ($pathinfo === '/novaia-proghramma-rienovatsii-piatietazhiek') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::renovationPageAction',  '_route' => 'app_renovation',);
        }

        // app_industrial_zil
        if ($pathinfo === '/renovaciya-promzon/proekt-planirovki') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::industrialZilPageAction',  '_route' => 'app_industrial_zil',);
        }

        // app_stadiums
        if ($pathinfo === '/stadiony-moskvy') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::moscowStadiumsPageAction',  '_route' => 'app_stadiums',);
        }

        // app_diametry
        if ($pathinfo === '/moskovskiie-tsientral-nyie-diamietry-stroi_mos') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::diametryPageAction',  '_route' => 'app_diametry',);
        }

        // app_renovation_industrial
        if ($pathinfo === '/renovaciya-promzon') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::renovationIndustrialPageAction',  '_route' => 'app_renovation_industrial',);
        }

        // app_covid_vaccine
        if ($pathinfo === '/covid-vaccine') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::covidVaccinePageAction',  '_route' => 'app_covid_vaccine',);
        }

        // app_contact_center
        if ($pathinfo === '/goriachiie-linii') {
            return array (  '_controller' => 'AppBundle\\Controller\\PageController::contactCenterAction',  '_route' => 'app_contact_center',);
        }

        if (0 === strpos($pathinfo, '/structure')) {
            // app_person_list
            if ($pathinfo === '/structure') {
                return array (  '_controller' => 'AppBundle\\Controller\\PersonController::listAction',  '_route' => 'app_person_list',);
            }

            // app_person_show
            if (0 === strpos($pathinfo, '/structure/person') && preg_match('#^/structure/person/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_person_show')), array (  '_controller' => 'AppBundle\\Controller\\PersonController::showAction',));
            }

        }

        if (0 === strpos($pathinfo, '/r')) {
            if (0 === strpos($pathinfo, '/road')) {
                // app_road_list
                if ($pathinfo === '/road') {
                    return array (  '_controller' => 'AppBundle\\Controller\\RoadController::listAction',  '_route' => 'app_road_list',);
                }

                // app_roads_mkad
                if ($pathinfo === '/road/riekonstruktsiia-mkad') {
                    return array (  '_controller' => 'AppBundle\\Controller\\RoadController::roadsMkadPageAction',  '_route' => 'app_roads_mkad',);
                }

                // app_road_interchange_list
                if ($pathinfo === '/road/interchange') {
                    return array (  '_controller' => 'AppBundle\\Controller\\RoadController::listInterchangesAction',  '_route' => 'app_road_interchange_list',);
                }

            }

            if (0 === strpos($pathinfo, '/riekonstruktsiia-zhielieznodorozhnykh-pierieiezdov')) {
                // app_putieprovody
                if ($pathinfo === '/riekonstruktsiia-zhielieznodorozhnykh-pierieiezdov') {
                    return array (  '_controller' => 'AppBundle\\Controller\\RoadController::putieprovodyPageAction',  '_route' => 'app_putieprovody',);
                }

                if (0 === strpos($pathinfo, '/riekonstruktsiia-zhielieznodorozhnykh-pierieiezdov/list')) {
                    // app_putieprovody_list
                    if ($pathinfo === '/riekonstruktsiia-zhielieznodorozhnykh-pierieiezdov/list') {
                        return array (  '_controller' => 'AppBundle\\Controller\\RoadController::putieprovodyListPageAction',  '_route' => 'app_putieprovody_list',);
                    }

                    // app_putieprovody_list_complete
                    if ($pathinfo === '/riekonstruktsiia-zhielieznodorozhnykh-pierieiezdov/list_complete') {
                        return array (  '_controller' => 'AppBundle\\Controller\\RoadController::putieprovodyListCompletePageAction',  '_route' => 'app_putieprovody_list_complete',);
                    }

                }

            }

            if (0 === strpos($pathinfo, '/road')) {
                if (0 === strpos($pathinfo, '/road/trunk')) {
                    // app_road_trunk_list
                    if ($pathinfo === '/road/trunk') {
                        return array (  '_controller' => 'AppBundle\\Controller\\RoadController::listTrunksAction',  '_route' => 'app_road_trunk_list',);
                    }

                    // app_road_trunk_show
                    if (preg_match('#^/road/trunk/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_road_trunk_show')), array (  '_controller' => 'AppBundle\\Controller\\RoadController::showTrunkAction',));
                    }

                }

                // app_road_interchange_show
                if (0 === strpos($pathinfo, '/road/interchange') && preg_match('#^/road/interchange/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_road_interchange_show')), array (  '_controller' => 'AppBundle\\Controller\\RoadController::showInterchangeAction',));
                }

                if (0 === strpos($pathinfo, '/road/r')) {
                    // app_road_show
                    if (0 === strpos($pathinfo, '/road/road') && preg_match('#^/road/road/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_road_show')), array (  '_controller' => 'AppBundle\\Controller\\RoadController::showAction',));
                    }

                    if (0 === strpos($pathinfo, '/road/regional')) {
                        // app_road_regional_list
                        if ($pathinfo === '/road/regional') {
                            return array (  '_controller' => 'AppBundle\\Controller\\RoadController::listRegionalAction',  '_route' => 'app_road_regional_list',);
                        }

                        // app_road_regional_show
                        if (preg_match('#^/road/regional/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_road_regional_show')), array (  '_controller' => 'AppBundle\\Controller\\RoadController::showRegionalAction',));
                        }

                    }

                }

            }

        }

        if (0 === strpos($pathinfo, '/search')) {
            // app_search
            if ($pathinfo === '/search') {
                return array (  '_controller' => 'AppBundle\\Controller\\SearchController::searchAction',  '_route' => 'app_search',);
            }

            // app_search_query_suggest
            if ($pathinfo === '/search/suggest') {
                return array (  '_controller' => 'AppBundle\\Controller\\SearchController::suggestAction',  '_route' => 'app_search_query_suggest',);
            }

        }

        if (0 === strpos($pathinfo, '/video')) {
            // app_video_list
            if ($pathinfo === '/video') {
                return array (  '_controller' => 'AppBundle\\Controller\\VideoController::listAction',  '_route' => 'app_video_list',);
            }

            // app_video_show
            if (preg_match('#^/video/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_video_show')), array (  '_controller' => 'AppBundle\\Controller\\VideoController::showAction',));
            }

        }

        if (0 === strpos($pathinfo, '/a')) {
            if (0 === strpos($pathinfo, '/api')) {
                if (0 === strpos($pathinfo, '/api/v2')) {
                    // api_v2_problem_constructions_collection
                    if ($pathinfo === '/api/v2/problem-constructions') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_v2_problem_constructions_collection;
                        }

                        return array (  '_controller' => 'ApiBundle\\Controller\\ConstructionController::getProblemConstructions',  '_route' => 'api_v2_problem_constructions_collection',);
                    }
                    not_api_v2_problem_constructions_collection:

                    if (0 === strpos($pathinfo, '/api/v2/constructions')) {
                        // api_v2_constructions_collection_by_type
                        if ($pathinfo === '/api/v2/constructions') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_api_v2_constructions_collection_by_type;
                            }

                            return array (  '_controller' => 'ApiBundle\\Controller\\ConstructionController::getConstructions',  '_route' => 'api_v2_constructions_collection_by_type',);
                        }
                        not_api_v2_constructions_collection_by_type:

                        // api_v2_get_construction_entity
                        if (preg_match('#^/api/v2/constructions/(?P<id>\\d+)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_api_v2_get_construction_entity;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_v2_get_construction_entity')), array (  '_controller' => 'ApiBundle\\Controller\\ConstructionController::getConstruction',));
                        }
                        not_api_v2_get_construction_entity:

                        // api_v2_get_construction_galleries
                        if (preg_match('#^/api/v2/constructions/(?P<id>[^/]++)/galleries$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_api_v2_get_construction_galleries;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_v2_get_construction_galleries')), array (  '_controller' => 'ApiBundle\\Controller\\ConstructionController::getGalleriesAction',));
                        }
                        not_api_v2_get_construction_galleries:

                    }

                }

                if (0 === strpos($pathinfo, '/api/metro')) {
                    // api_metrolines
                    if ($pathinfo === '/api/metrolines') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_metrolines;
                        }

                        return array (  '_controller' => 'ApiBundle\\Controller\\MetroLineAndStationController::listAction',  '_route' => 'api_metrolines',);
                    }
                    not_api_metrolines:

                    // api_metrostations_gallery
                    if (0 === strpos($pathinfo, '/api/metrostations') && preg_match('#^/api/metrostations/(?P<id>[^/]++)/galleries$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_metrostations_gallery;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_metrostations_gallery')), array (  '_controller' => 'ApiBundle\\Controller\\MetroLineAndStationController::metrostationsGalleryAction',));
                    }
                    not_api_metrostations_gallery:

                    // api_metrolines_gallery
                    if (0 === strpos($pathinfo, '/api/metrolines') && preg_match('#^/api/metrolines/(?P<id>[^/]++)/galleries$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_metrolines_gallery;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_metrolines_gallery')), array (  '_controller' => 'ApiBundle\\Controller\\MetroLineAndStationController::metrolinesGalleryAction',));
                    }
                    not_api_metrolines_gallery:

                    // api_metrostations_extrainfo
                    if (0 === strpos($pathinfo, '/api/metrostations') && preg_match('#^/api/metrostations/(?P<id>[^/]++)/extrainfo$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_metrostations_extrainfo;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_metrostations_extrainfo')), array (  '_controller' => 'ApiBundle\\Controller\\MetroLineAndStationController::metrostationsExtrainfoAction',));
                    }
                    not_api_metrostations_extrainfo:

                    // api_metrolines_extrainfo
                    if (0 === strpos($pathinfo, '/api/metrolines') && preg_match('#^/api/metrolines/(?P<id>[^/]++)/extrainfo$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_metrolines_extrainfo;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_metrolines_extrainfo')), array (  '_controller' => 'ApiBundle\\Controller\\MetroLineAndStationController::metrolinesExtrainfoAction',));
                    }
                    not_api_metrolines_extrainfo:

                    // api_metrotimelines
                    if ($pathinfo === '/api/metrotimelines') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_metrotimelines;
                        }

                        return array (  '_controller' => 'ApiBundle\\Controller\\MetroTimelineYearController::listAction',  '_route' => 'api_metrotimelines',);
                    }
                    not_api_metrotimelines:

                }

                if (0 === strpos($pathinfo, '/api/road')) {
                    // api_get_road_types
                    if ($pathinfo === '/api/road-types') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_get_road_types;
                        }

                        return array (  '_controller' => 'ApiBundle\\Controller\\RoadController::getRoadTypesAction',  '_route' => 'api_get_road_types',);
                    }
                    not_api_get_road_types:

                    // api_get_road
                    if (preg_match('#^/api/road/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_get_road;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_get_road')), array (  '_controller' => 'ApiBundle\\Controller\\RoadController::getRoadAction',));
                    }
                    not_api_get_road:

                    // api_get_road_galleries
                    if (preg_match('#^/api/road/(?P<id>[^/]++)/galleries$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_get_road_galleries;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_get_road_galleries')), array (  '_controller' => 'ApiBundle\\Controller\\RoadController::getRoadGalleriesAction',));
                    }
                    not_api_get_road_galleries:

                }

            }

            // admin_api_create_animated_gif
            if ($pathinfo === '/admin/api/medias/animated-gif') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_admin_api_create_animated_gif;
                }

                return array (  '_controller' => 'ApiBundle\\PresentationLayer\\HttpController\\AnimatedGifGeneratorController:createAnimatedGif',  '_route' => 'admin_api_create_animated_gif',);
            }
            not_admin_api_create_animated_gif:

            if (0 === strpos($pathinfo, '/api')) {
                if (0 === strpos($pathinfo, '/api/email-subscription')) {
                    // save _subscription_options
                    if ($pathinfo === '/api/email-subscription/options') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_save_subscription_options;
                        }

                        return array (  '_controller' => 'ApiBundle\\PresentationLayer\\HttpController\\EmailSubscriptionController:saveSubscriptionOptionsAction',  '_route' => 'save _subscription_options',);
                    }
                    not_save_subscription_options:

                    // delete_email_subscription_administrative_units
                    if ($pathinfo === '/api/email-subscription') {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_delete_email_subscription_administrative_units;
                        }

                        return array (  '_controller' => 'ApiBundle\\PresentationLayer\\HttpController\\EmailSubscriptionController:unsubscribeAction',  '_route' => 'delete_email_subscription_administrative_units',);
                    }
                    not_delete_email_subscription_administrative_units:

                }

                if (0 === strpos($pathinfo, '/api/galleries')) {
                    // api_galleries
                    if (preg_match('#^/api/galleries/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_galleries;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_galleries')), array (  '_controller' => 'ApiBundle\\PresentationLayer\\HttpController\\GalleryController:getGalleryAction',));
                    }
                    not_api_galleries:

                    // api_gallery_photos
                    if (preg_match('#^/api/galleries/(?P<id>[^/]++)/photos$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_gallery_photos;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_gallery_photos')), array (  '_controller' => 'ApiBundle\\PresentationLayer\\HttpController\\GalleryController:getGalleryPhotosAction',));
                    }
                    not_api_gallery_photos:

                }

            }

            if (0 === strpos($pathinfo, '/admin/api/posts')) {
                // admin_api_set_post_priority
                if (preg_match('#^/admin/api/posts/(?P<postId>[^/]++)/priority$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_admin_api_set_post_priority;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_api_set_post_priority')), array (  '_controller' => 'ApiBundle\\PresentationLayer\\HttpController\\PostChangePriorityController:setPropertyAction',));
                }
                not_admin_api_set_post_priority:

                // admin_api_posts
                if ($pathinfo === '/admin/api/posts') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_api_posts;
                    }

                    return array (  '_controller' => 'ApiBundle\\PresentationLayer\\HttpController\\PostController:getDataAction',  '_route' => 'admin_api_posts',);
                }
                not_admin_api_posts:

            }

            if (0 === strpos($pathinfo, '/api')) {
                // api_reports
                if (0 === strpos($pathinfo, '/api/reports') && preg_match('#^/api/reports/(?P<reportId>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_api_reports;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_reports')), array (  '_controller' => 'ApiBundle\\PresentationLayer\\HttpController\\ReportController:getDataAction',));
                }
                not_api_reports:

                // create_and_send_service_email
                if ($pathinfo === '/api/service-email') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_create_and_send_service_email;
                    }

                    return array (  '_controller' => 'ApiBundle\\PresentationLayer\\HttpController\\ServiceEmailSenderController:createAndSendServiceEmailAction',  '_route' => 'create_and_send_service_email',);
                }
                not_create_and_send_service_email:

            }

        }

        // app_homepage
        if (preg_match('#^/(?P<date>\\d{4}-\\d{2}-\\d{2})?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_homepage')), array (  '_controller' => 'AppBundle\\Controller\\PageController::homePageAction',  'date' => NULL,));
        }

        if (0 === strpos($pathinfo, '/ka')) {
            // app_developer_cabinet
            if ($pathinfo === '/kabiniet-zastroishchika') {
                return array (  '_controller' => 'AppBundle\\Controller\\PageController::developerCabinetAction',  '_route' => 'app_developer_cabinet',);
            }

            // app_procedure_calc
            if ($pathinfo === '/kalkulyator-procedur') {
                return array (  '_controller' => 'AppBundle\\Controller\\PageController::procedureCalcAction',  '_route' => 'app_procedure_calc',);
            }

        }

        if (0 === strpos($pathinfo, '/news')) {
            // app_news_list
            if ($pathinfo === '/news') {
                return array (  '_controller' => 'AppBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'news',  '_route' => 'app_news_list',);
            }

            // app_news_list_popular
            if ($pathinfo === '/news/popular') {
                return array (  '_controller' => 'AppBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'news',  'popular' => true,  '_route' => 'app_news_list_popular',);
            }

        }

        // app_news_show
        if (preg_match('#^/(?P<categoryAlias>news)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_news_show')), array (  '_controller' => 'AppBundle\\Controller\\PostController::showAction',));
        }

        // app_city_news_list
        if ($pathinfo === '/city_news') {
            return array (  '_controller' => 'AppBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'city_news',  '_route' => 'app_city_news_list',);
        }

        // app_city_news_show
        if (preg_match('#^/(?P<categoryAlias>city_news)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_city_news_show')), array (  '_controller' => 'AppBundle\\Controller\\PostController::showAction',));
        }

        // app_articles_list
        if ($pathinfo === '/articles') {
            return array (  '_controller' => 'AppBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'articles',  '_route' => 'app_articles_list',);
        }

        // app_articles_show
        if (preg_match('#^/(?P<categoryAlias>articles)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_articles_show')), array (  '_controller' => 'AppBundle\\Controller\\PostController::showAction',));
        }

        // app_builder_science_list
        if ($pathinfo === '/builder_science') {
            return array (  '_controller' => 'AppBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'builder_science',  '_route' => 'app_builder_science_list',);
        }

        // app_builder_science_show
        if (preg_match('#^/(?P<categoryAlias>builder_science)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_builder_science_show')), array (  '_controller' => 'AppBundle\\Controller\\PostController::showAction',));
        }

        // app_interviews_list
        if ($pathinfo === '/interviews') {
            return array (  '_controller' => 'AppBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'interviews',  '_route' => 'app_interviews_list',);
        }

        // app_interviews_show
        if (preg_match('#^/(?P<categoryAlias>interviews)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_interviews_show')), array (  '_controller' => 'AppBundle\\Controller\\PostController::showAction',));
        }

        // app_photo_lines_list
        if ($pathinfo === '/photo_lines') {
            return array (  '_controller' => 'AppBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'photo_lines',  '_route' => 'app_photo_lines_list',);
        }

        // app_photo_lines_show
        if (preg_match('#^/(?P<categoryAlias>photo_lines)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_photo_lines_show')), array (  '_controller' => 'AppBundle\\Controller\\PostController::showAction',));
        }

        // app_press_releases_list
        if ($pathinfo === '/press_releases') {
            return array (  '_controller' => 'AppBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'press_releases',  '_route' => 'app_press_releases_list',);
        }

        // app_press_releases_show
        if (preg_match('#^/(?P<categoryAlias>press_releases)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_press_releases_show')), array (  '_controller' => 'AppBundle\\Controller\\PostController::showAction',));
        }

        // app_shorthand-reports_list
        if ($pathinfo === '/shorthand-reports') {
            return array (  '_controller' => 'AppBundle\\Controller\\PostController::listAction',  'categoryAlias' => 'shorthand-reports',  '_route' => 'app_shorthand-reports_list',);
        }

        // app_shorthand-reports_show
        if (preg_match('#^/(?P<categoryAlias>shorthand-reports)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_shorthand-reports_show')), array (  '_controller' => 'AppBundle\\Controller\\PostController::showAction',));
        }

        // app_post_list
        if (preg_match('#^/(?P<categoryAlias>news|city_news|articles|builder_science|interviews|photo_lines|press_releases|shorthand-reports)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_post_list')), array (  '_controller' => 'AppBundle\\Controller\\PostController::listAction',));
        }

        // app_post_show
        if (preg_match('#^/(?P<categoryAlias>news|city_news|articles|builder_science|interviews|photo_lines|press_releases|shorthand-reports)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_post_show')), array (  '_controller' => 'AppBundle\\Controller\\PostController::showAction',));
        }

        if (0 === strpos($pathinfo, '/s')) {
            if (0 === strpos($pathinfo, '/structure')) {
                if (0 === strpos($pathinfo, '/structure/stroi_mos')) {
                    // app_subordinate_stroi_mos_news
                    if ($pathinfo === '/structure/stroi_mos/news') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'news',  '_route' => 'app_subordinate_stroi_mos_news',);
                    }

                    // app_subordinate_stroi_mos_press_releases
                    if ($pathinfo === '/structure/stroi_mos/press_releases') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'press_releases',  '_route' => 'app_subordinate_stroi_mos_press_releases',);
                    }

                    // app_subordinate_stroi_mos_documents
                    if ($pathinfo === '/structure/stroi_mos/documents') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::documentsListAction',  '_route' => 'app_subordinate_stroi_mos_documents',);
                    }

                    // app_subordinate_stroi_mos_publications
                    if ($pathinfo === '/structure/stroi_mos/publications') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::publicationsListAction',  '_route' => 'app_subordinate_stroi_mos_publications',);
                    }

                    // app_subordinate_stroi_mos_shorthand-reports
                    if ($pathinfo === '/structure/stroi_mos/shorthand-reports') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::shorthandReportsListAction',  '_route' => 'app_subordinate_stroi_mos_shorthand-reports',);
                    }

                    // app_subordinate_stroi_mos_homepage
                    if ($pathinfo === '/structure/stroi_mos') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::homePageAction',  '_route' => 'app_subordinate_stroi_mos_homepage',);
                    }

                }

                if (0 === strpos($pathinfo, '/structure/d')) {
                    if (0 === strpos($pathinfo, '/structure/dg')) {
                        if (0 === strpos($pathinfo, '/structure/dgp')) {
                            // app_subordinate_dgp_news
                            if ($pathinfo === '/structure/dgp/news') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'news',  '_route' => 'app_subordinate_dgp_news',);
                            }

                            // app_subordinate_dgp_press_releases
                            if ($pathinfo === '/structure/dgp/press_releases') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'press_releases',  '_route' => 'app_subordinate_dgp_press_releases',);
                            }

                            // app_subordinate_dgp_documents
                            if ($pathinfo === '/structure/dgp/documents') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::documentsListAction',  '_route' => 'app_subordinate_dgp_documents',);
                            }

                            // app_subordinate_dgp_publications
                            if ($pathinfo === '/structure/dgp/publications') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::publicationsListAction',  '_route' => 'app_subordinate_dgp_publications',);
                            }

                            // app_subordinate_dgp_shorthand-reports
                            if ($pathinfo === '/structure/dgp/shorthand-reports') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::shorthandReportsListAction',  '_route' => 'app_subordinate_dgp_shorthand-reports',);
                            }

                            // app_subordinate_dgp_homepage
                            if ($pathinfo === '/structure/dgp') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::homePageAction',  '_route' => 'app_subordinate_dgp_homepage',);
                            }

                        }

                        if (0 === strpos($pathinfo, '/structure/dgi')) {
                            // app_subordinate_dgi_news
                            if ($pathinfo === '/structure/dgi/news') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'news',  '_route' => 'app_subordinate_dgi_news',);
                            }

                            // app_subordinate_dgi_press_releases
                            if ($pathinfo === '/structure/dgi/press_releases') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'press_releases',  '_route' => 'app_subordinate_dgi_press_releases',);
                            }

                            // app_subordinate_dgi_documents
                            if ($pathinfo === '/structure/dgi/documents') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::documentsListAction',  '_route' => 'app_subordinate_dgi_documents',);
                            }

                            // app_subordinate_dgi_publications
                            if ($pathinfo === '/structure/dgi/publications') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::publicationsListAction',  '_route' => 'app_subordinate_dgi_publications',);
                            }

                            // app_subordinate_dgi_shorthand-reports
                            if ($pathinfo === '/structure/dgi/shorthand-reports') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::shorthandReportsListAction',  '_route' => 'app_subordinate_dgi_shorthand-reports',);
                            }

                            // app_subordinate_dgi_homepage
                            if ($pathinfo === '/structure/dgi') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::homePageAction',  '_route' => 'app_subordinate_dgi_homepage',);
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/structure/ds')) {
                        if (0 === strpos($pathinfo, '/structure/dsti')) {
                            // app_subordinate_dsti_news
                            if ($pathinfo === '/structure/dsti/news') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'news',  '_route' => 'app_subordinate_dsti_news',);
                            }

                            // app_subordinate_dsti_press_releases
                            if ($pathinfo === '/structure/dsti/press_releases') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'press_releases',  '_route' => 'app_subordinate_dsti_press_releases',);
                            }

                            // app_subordinate_dsti_documents
                            if ($pathinfo === '/structure/dsti/documents') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::documentsListAction',  '_route' => 'app_subordinate_dsti_documents',);
                            }

                            // app_subordinate_dsti_publications
                            if ($pathinfo === '/structure/dsti/publications') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::publicationsListAction',  '_route' => 'app_subordinate_dsti_publications',);
                            }

                            // app_subordinate_dsti_shorthand-reports
                            if ($pathinfo === '/structure/dsti/shorthand-reports') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::shorthandReportsListAction',  '_route' => 'app_subordinate_dsti_shorthand-reports',);
                            }

                            // app_subordinate_dsti_homepage
                            if ($pathinfo === '/structure/dsti') {
                                return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::homePageAction',  '_route' => 'app_subordinate_dsti_homepage',);
                            }

                        }

                        // app_subordinate_ds_news
                        if ($pathinfo === '/structure/ds/news') {
                            return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'news',  '_route' => 'app_subordinate_ds_news',);
                        }

                        // app_subordinate_ds_press_releases
                        if ($pathinfo === '/structure/ds/press_releases') {
                            return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'press_releases',  '_route' => 'app_subordinate_ds_press_releases',);
                        }

                        // app_subordinate_ds_documents
                        if ($pathinfo === '/structure/ds/documents') {
                            return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::documentsListAction',  '_route' => 'app_subordinate_ds_documents',);
                        }

                        // app_subordinate_ds_publications
                        if ($pathinfo === '/structure/ds/publications') {
                            return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::publicationsListAction',  '_route' => 'app_subordinate_ds_publications',);
                        }

                        // app_subordinate_ds_shorthand-reports
                        if ($pathinfo === '/structure/ds/shorthand-reports') {
                            return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::shorthandReportsListAction',  '_route' => 'app_subordinate_ds_shorthand-reports',);
                        }

                        // app_subordinate_ds_homepage
                        if ($pathinfo === '/structure/ds') {
                            return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::homePageAction',  '_route' => 'app_subordinate_ds_homepage',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/structure/drnt')) {
                        // app_subordinate_drnt_news
                        if ($pathinfo === '/structure/drnt/news') {
                            return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'news',  '_route' => 'app_subordinate_drnt_news',);
                        }

                        // app_subordinate_drnt_press_releases
                        if ($pathinfo === '/structure/drnt/press_releases') {
                            return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'press_releases',  '_route' => 'app_subordinate_drnt_press_releases',);
                        }

                        // app_subordinate_drnt_documents
                        if ($pathinfo === '/structure/drnt/documents') {
                            return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::documentsListAction',  '_route' => 'app_subordinate_drnt_documents',);
                        }

                        // app_subordinate_drnt_publications
                        if ($pathinfo === '/structure/drnt/publications') {
                            return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::publicationsListAction',  '_route' => 'app_subordinate_drnt_publications',);
                        }

                        // app_subordinate_drnt_shorthand-reports
                        if ($pathinfo === '/structure/drnt/shorthand-reports') {
                            return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::shorthandReportsListAction',  '_route' => 'app_subordinate_drnt_shorthand-reports',);
                        }

                        // app_subordinate_drnt_homepage
                        if ($pathinfo === '/structure/drnt') {
                            return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::homePageAction',  '_route' => 'app_subordinate_drnt_homepage',);
                        }

                    }

                }

                if (0 === strpos($pathinfo, '/structure/stroinadzor')) {
                    // app_subordinate_stroinadzor_news
                    if ($pathinfo === '/structure/stroinadzor/news') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'news',  '_route' => 'app_subordinate_stroinadzor_news',);
                    }

                    // app_subordinate_stroinadzor_press_releases
                    if ($pathinfo === '/structure/stroinadzor/press_releases') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'press_releases',  '_route' => 'app_subordinate_stroinadzor_press_releases',);
                    }

                    // app_subordinate_stroinadzor_documents
                    if ($pathinfo === '/structure/stroinadzor/documents') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::documentsListAction',  '_route' => 'app_subordinate_stroinadzor_documents',);
                    }

                    // app_subordinate_stroinadzor_publications
                    if ($pathinfo === '/structure/stroinadzor/publications') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::publicationsListAction',  '_route' => 'app_subordinate_stroinadzor_publications',);
                    }

                    // app_subordinate_stroinadzor_shorthand-reports
                    if ($pathinfo === '/structure/stroinadzor/shorthand-reports') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::shorthandReportsListAction',  '_route' => 'app_subordinate_stroinadzor_shorthand-reports',);
                    }

                    // app_subordinate_stroinadzor_homepage
                    if ($pathinfo === '/structure/stroinadzor') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::homePageAction',  '_route' => 'app_subordinate_stroinadzor_homepage',);
                    }

                }

                if (0 === strpos($pathinfo, '/structure/mka')) {
                    // app_subordinate_mka_news
                    if ($pathinfo === '/structure/mka/news') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'news',  '_route' => 'app_subordinate_mka_news',);
                    }

                    // app_subordinate_mka_press_releases
                    if ($pathinfo === '/structure/mka/press_releases') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'press_releases',  '_route' => 'app_subordinate_mka_press_releases',);
                    }

                    // app_subordinate_mka_documents
                    if ($pathinfo === '/structure/mka/documents') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::documentsListAction',  '_route' => 'app_subordinate_mka_documents',);
                    }

                    // app_subordinate_mka_publications
                    if ($pathinfo === '/structure/mka/publications') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::publicationsListAction',  '_route' => 'app_subordinate_mka_publications',);
                    }

                    // app_subordinate_mka_shorthand-reports
                    if ($pathinfo === '/structure/mka/shorthand-reports') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::shorthandReportsListAction',  '_route' => 'app_subordinate_mka_shorthand-reports',);
                    }

                    // app_subordinate_mka_homepage
                    if ($pathinfo === '/structure/mka') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::homePageAction',  '_route' => 'app_subordinate_mka_homepage',);
                    }

                }

                if (0 === strpos($pathinfo, '/structure/invest')) {
                    // app_subordinate_invest_news
                    if ($pathinfo === '/structure/invest/news') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'news',  '_route' => 'app_subordinate_invest_news',);
                    }

                    // app_subordinate_invest_press_releases
                    if ($pathinfo === '/structure/invest/press_releases') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'press_releases',  '_route' => 'app_subordinate_invest_press_releases',);
                    }

                    // app_subordinate_invest_documents
                    if ($pathinfo === '/structure/invest/documents') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::documentsListAction',  '_route' => 'app_subordinate_invest_documents',);
                    }

                    // app_subordinate_invest_publications
                    if ($pathinfo === '/structure/invest/publications') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::publicationsListAction',  '_route' => 'app_subordinate_invest_publications',);
                    }

                    // app_subordinate_invest_shorthand-reports
                    if ($pathinfo === '/structure/invest/shorthand-reports') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::shorthandReportsListAction',  '_route' => 'app_subordinate_invest_shorthand-reports',);
                    }

                    // app_subordinate_invest_homepage
                    if ($pathinfo === '/structure/invest') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::homePageAction',  '_route' => 'app_subordinate_invest_homepage',);
                    }

                }

                if (0 === strpos($pathinfo, '/structure/mke')) {
                    // app_subordinate_mke_news
                    if ($pathinfo === '/structure/mke/news') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'news',  '_route' => 'app_subordinate_mke_news',);
                    }

                    // app_subordinate_mke_press_releases
                    if ($pathinfo === '/structure/mke/press_releases') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postsListAction',  'categoryAlias' => 'press_releases',  '_route' => 'app_subordinate_mke_press_releases',);
                    }

                    // app_subordinate_mke_documents
                    if ($pathinfo === '/structure/mke/documents') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::documentsListAction',  '_route' => 'app_subordinate_mke_documents',);
                    }

                    // app_subordinate_mke_publications
                    if ($pathinfo === '/structure/mke/publications') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::publicationsListAction',  '_route' => 'app_subordinate_mke_publications',);
                    }

                    // app_subordinate_mke_shorthand-reports
                    if ($pathinfo === '/structure/mke/shorthand-reports') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::shorthandReportsListAction',  '_route' => 'app_subordinate_mke_shorthand-reports',);
                    }

                    // app_subordinate_mke_homepage
                    if ($pathinfo === '/structure/mke') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::homePageAction',  '_route' => 'app_subordinate_mke_homepage',);
                    }

                }

                // app_subordinate_post_show
                if (preg_match('#^/structure/(?P<organization>stroi_mos|dgp|dgi|dsti|ds|drnt|stroinadzor|mka|invest|mke)/(?P<categoryAlias>city_news|articles|builder_science|interviews|photo_lines|press_releases|shorthand-reports)/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_subordinate_post_show')), array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postShowAction',));
                }

                // app_subordinate_news_show
                if (preg_match('#^/structure/(?P<organization>stroi_mos|dgp|dgi|dsti|ds|drnt|stroinadzor|mka|invest|mke)/news/(?P<slug>[a-zA-z_\\/0-9-]+)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_subordinate_news_show')), array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::postShowAction',));
                }

                // app_subordinate_video_show
                if (preg_match('#^/structure/(?P<organization>stroi_mos|dgp|dgi|dsti|ds|drnt|stroinadzor|mka|invest|mke)/video/(?P<id>\\d+)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_subordinate_video_show')), array (  '_controller' => 'AppBundle\\Controller\\SubordinateController::videoShowAction',));
                }

            }

            // app_sitemap
            if ($pathinfo === '/sitemap') {
                return array (  '_controller' => 'AppBundle\\Controller\\PageController::sitemapAction',  '_route' => 'app_sitemap',);
            }

        }

        if (0 === strpos($pathinfo, '/a')) {
            if (0 === strpos($pathinfo, '/api/v1')) {
                // api_block_render
                if (0 === strpos($pathinfo, '/api/v1/block/render') && preg_match('#^/api/v1/block/render/(?P<type>\\w+)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_block_render')), array (  '_controller' => 'AppBundle\\Controller\\Api\\BlockController::blockRenderAction',));
                }

                // api_resource_administrative_areas
                if ($pathinfo === '/api/v1/administrative_areas') {
                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\AdministrativeAreaController::getCollectionAction',  '_route' => 'api_resource_administrative_areas',);
                }

            }

            if (0 === strpos($pathinfo, '/admin')) {
                if (0 === strpos($pathinfo, '/admin/log')) {
                    if (0 === strpos($pathinfo, '/admin/login')) {
                        // sonata_user_admin_security_login
                        if ($pathinfo === '/admin/login') {
                            return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\AdminSecurityController::loginAction',  '_route' => 'sonata_user_admin_security_login',);
                        }

                        // sonata_user_admin_security_check
                        if ($pathinfo === '/admin/login_check') {
                            return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\AdminSecurityController::checkAction',  '_route' => 'sonata_user_admin_security_check',);
                        }

                    }

                    // sonata_user_admin_security_logout
                    if ($pathinfo === '/admin/logout') {
                        return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\AdminSecurityController::logoutAction',  '_route' => 'sonata_user_admin_security_logout',);
                    }

                }

                // sonata_admin_redirect
                if (rtrim($pathinfo, '/') === '/admin') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'sonata_admin_redirect');
                    }

                    return array (  '_controller' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\RedirectController::redirectAction',  'route' => 'sonata_admin_dashboard',  'permanent' => 'true',  '_route' => 'sonata_admin_redirect',);
                }

                // sonata_admin_dashboard
                if ($pathinfo === '/admin/dashboard') {
                    return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CoreController::dashboardAction',  '_route' => 'sonata_admin_dashboard',);
                }

                if (0 === strpos($pathinfo, '/admin/core')) {
                    // sonata_admin_retrieve_form_element
                    if ($pathinfo === '/admin/core/get-form-field-element') {
                        return array (  '_controller' => 'sonata.admin.controller.admin:retrieveFormFieldElementAction',  '_route' => 'sonata_admin_retrieve_form_element',);
                    }

                    // sonata_admin_append_form_element
                    if ($pathinfo === '/admin/core/append-form-field-element') {
                        return array (  '_controller' => 'sonata.admin.controller.admin:appendFormFieldElementAction',  '_route' => 'sonata_admin_append_form_element',);
                    }

                    // sonata_admin_short_object_information
                    if (0 === strpos($pathinfo, '/admin/core/get-short-object-description') && preg_match('#^/admin/core/get\\-short\\-object\\-description(?:\\.(?P<_format>html|json))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'sonata_admin_short_object_information')), array (  '_controller' => 'sonata.admin.controller.admin:getShortObjectDescriptionAction',  '_format' => 'html',));
                    }

                    // sonata_admin_set_object_field_value
                    if ($pathinfo === '/admin/core/set-object-field-value') {
                        return array (  '_controller' => 'sonata.admin.controller.admin:setObjectFieldValueAction',  '_route' => 'sonata_admin_set_object_field_value',);
                    }

                }

                // sonata_admin_search
                if ($pathinfo === '/admin/search') {
                    return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CoreController::searchAction',  '_route' => 'sonata_admin_search',);
                }

                // sonata_admin_retrieve_autocomplete_items
                if ($pathinfo === '/admin/core/get-autocomplete-items') {
                    return array (  '_controller' => 'sonata.admin.controller.admin:retrieveAutocompleteItemsAction',  '_route' => 'sonata_admin_retrieve_autocomplete_items',);
                }

                // sonata_user_profile_show
                if ($pathinfo === '/admin') {
                    return array('_route' => 'sonata_user_profile_show');
                }

                if (0 === strpos($pathinfo, '/admin/app')) {
                    if (0 === strpos($pathinfo, '/admin/app/post')) {
                        // admin_app_post_list
                        if ($pathinfo === '/admin/app/post/list') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::listAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_list',  '_route' => 'admin_app_post_list',);
                        }

                        // admin_app_post_create
                        if ($pathinfo === '/admin/app/post/create') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::createAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_create',  '_route' => 'admin_app_post_create',);
                        }

                        // admin_app_post_batch
                        if ($pathinfo === '/admin/app/post/batch') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::batchAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_batch',  '_route' => 'admin_app_post_batch',);
                        }

                        // admin_app_post_edit
                        if (preg_match('#^/admin/app/post/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_post_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::editAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_edit',));
                        }

                        // admin_app_post_delete
                        if (preg_match('#^/admin/app/post/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_post_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::deleteAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_delete',));
                        }

                        // admin_app_post_show
                        if (preg_match('#^/admin/app/post/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_post_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::showAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_show',));
                        }

                        // admin_app_post_export
                        if ($pathinfo === '/admin/app/post/export') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::exportAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_export',  '_route' => 'admin_app_post_export',);
                        }

                        // admin_app_post_history
                        if (preg_match('#^/admin/app/post/(?P<id>[^/]++)/history$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_post_history')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::historyAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_history',));
                        }

                        // admin_app_post_history_view_revision
                        if (preg_match('#^/admin/app/post/(?P<id>[^/]++)/history/(?P<revision>[^/]++)/view$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_post_history_view_revision')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::historyViewRevisionAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_history_view_revision',));
                        }

                        // admin_app_post_history_compare_revisions
                        if (preg_match('#^/admin/app/post/(?P<id>[^/]++)/history/(?P<base_revision>[^/]++)/(?P<compare_revision>[^/]++)/compare$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_post_history_compare_revisions')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::historyCompareRevisionsAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_history_compare_revisions',));
                        }

                        // admin_app_post_link
                        if (preg_match('#^/admin/app/post/(?P<id>[^/]++)/link$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_post_link')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::linkAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_link',));
                        }

                        // admin_app_post_unlink
                        if (preg_match('#^/admin/app/post/(?P<id>[^/]++)/unlink$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_post_unlink')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::unlinkAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_unlink',));
                        }

                        // admin_app_post_sendNotification
                        if (preg_match('#^/admin/app/post/(?P<id>[^/]++)/sendNotification$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_post_sendNotification')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::sendNotificationAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_sendNotification',));
                        }

                        // admin_app_post_revert_revision
                        if (preg_match('#^/admin/app/post/(?P<id>[^/]++)/history/(?P<base_rev_id>[^/]++)/(?P<compare_rev_id>[^/]++)/revert/(?P<field_name>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_post_revert_revision')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::revertRevisionAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_revert_revision',));
                        }

                        // admin_app_post_toggleInTop
                        if (preg_match('#^/admin/app/post/(?P<id>[^/]++)/toggleInTop$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_post_toggleInTop')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::toggleInTopAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_toggleInTop',));
                        }

                        // admin_app_post_restore
                        if (preg_match('#^/admin/app/post/(?P<id>[^/]++)/restore$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_post_restore')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\PostCRUDController::restoreAction',  '_sonata_admin' => 'admin.post',  '_sonata_name' => 'admin_app_post_restore',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/embeddedcontent-')) {
                        if (0 === strpos($pathinfo, '/admin/app/embeddedcontent-banner')) {
                            // admin_app_embeddedcontent_banner_list
                            if ($pathinfo === '/admin/app/embeddedcontent-banner/list') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::listAction',  '_sonata_admin' => 'admin.embedded_content.banner',  '_sonata_name' => 'admin_app_embeddedcontent_banner_list',  '_route' => 'admin_app_embeddedcontent_banner_list',);
                            }

                            // admin_app_embeddedcontent_banner_create
                            if ($pathinfo === '/admin/app/embeddedcontent-banner/create') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::createAction',  '_sonata_admin' => 'admin.embedded_content.banner',  '_sonata_name' => 'admin_app_embeddedcontent_banner_create',  '_route' => 'admin_app_embeddedcontent_banner_create',);
                            }

                            // admin_app_embeddedcontent_banner_batch
                            if ($pathinfo === '/admin/app/embeddedcontent-banner/batch') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::batchAction',  '_sonata_admin' => 'admin.embedded_content.banner',  '_sonata_name' => 'admin_app_embeddedcontent_banner_batch',  '_route' => 'admin_app_embeddedcontent_banner_batch',);
                            }

                            // admin_app_embeddedcontent_banner_edit
                            if (preg_match('#^/admin/app/embeddedcontent\\-banner/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_banner_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::editAction',  '_sonata_admin' => 'admin.embedded_content.banner',  '_sonata_name' => 'admin_app_embeddedcontent_banner_edit',));
                            }

                            // admin_app_embeddedcontent_banner_delete
                            if (preg_match('#^/admin/app/embeddedcontent\\-banner/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_banner_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::deleteAction',  '_sonata_admin' => 'admin.embedded_content.banner',  '_sonata_name' => 'admin_app_embeddedcontent_banner_delete',));
                            }

                            // admin_app_embeddedcontent_banner_show
                            if (preg_match('#^/admin/app/embeddedcontent\\-banner/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_banner_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::showAction',  '_sonata_admin' => 'admin.embedded_content.banner',  '_sonata_name' => 'admin_app_embeddedcontent_banner_show',));
                            }

                            // admin_app_embeddedcontent_banner_export
                            if ($pathinfo === '/admin/app/embeddedcontent-banner/export') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::exportAction',  '_sonata_admin' => 'admin.embedded_content.banner',  '_sonata_name' => 'admin_app_embeddedcontent_banner_export',  '_route' => 'admin_app_embeddedcontent_banner_export',);
                            }

                            // admin_app_embeddedcontent_banner_browse
                            if ($pathinfo === '/admin/app/embeddedcontent-banner/browse') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::browseAction',  '_sonata_admin' => 'admin.embedded_content.banner',  '_sonata_name' => 'admin_app_embeddedcontent_banner_browse',  '_route' => 'admin_app_embeddedcontent_banner_browse',);
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/embeddedcontent-textblock-textblock')) {
                            // admin_app_embeddedcontent_textblock_textblock_list
                            if ($pathinfo === '/admin/app/embeddedcontent-textblock-textblock/list') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::listAction',  '_sonata_admin' => 'admin.embedded_content.text_block',  '_sonata_name' => 'admin_app_embeddedcontent_textblock_textblock_list',  '_route' => 'admin_app_embeddedcontent_textblock_textblock_list',);
                            }

                            // admin_app_embeddedcontent_textblock_textblock_create
                            if ($pathinfo === '/admin/app/embeddedcontent-textblock-textblock/create') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::createAction',  '_sonata_admin' => 'admin.embedded_content.text_block',  '_sonata_name' => 'admin_app_embeddedcontent_textblock_textblock_create',  '_route' => 'admin_app_embeddedcontent_textblock_textblock_create',);
                            }

                            // admin_app_embeddedcontent_textblock_textblock_batch
                            if ($pathinfo === '/admin/app/embeddedcontent-textblock-textblock/batch') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::batchAction',  '_sonata_admin' => 'admin.embedded_content.text_block',  '_sonata_name' => 'admin_app_embeddedcontent_textblock_textblock_batch',  '_route' => 'admin_app_embeddedcontent_textblock_textblock_batch',);
                            }

                            // admin_app_embeddedcontent_textblock_textblock_edit
                            if (preg_match('#^/admin/app/embeddedcontent\\-textblock\\-textblock/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_textblock_textblock_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::editAction',  '_sonata_admin' => 'admin.embedded_content.text_block',  '_sonata_name' => 'admin_app_embeddedcontent_textblock_textblock_edit',));
                            }

                            // admin_app_embeddedcontent_textblock_textblock_delete
                            if (preg_match('#^/admin/app/embeddedcontent\\-textblock\\-textblock/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_textblock_textblock_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::deleteAction',  '_sonata_admin' => 'admin.embedded_content.text_block',  '_sonata_name' => 'admin_app_embeddedcontent_textblock_textblock_delete',));
                            }

                            // admin_app_embeddedcontent_textblock_textblock_show
                            if (preg_match('#^/admin/app/embeddedcontent\\-textblock\\-textblock/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_textblock_textblock_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::showAction',  '_sonata_admin' => 'admin.embedded_content.text_block',  '_sonata_name' => 'admin_app_embeddedcontent_textblock_textblock_show',));
                            }

                            // admin_app_embeddedcontent_textblock_textblock_export
                            if ($pathinfo === '/admin/app/embeddedcontent-textblock-textblock/export') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::exportAction',  '_sonata_admin' => 'admin.embedded_content.text_block',  '_sonata_name' => 'admin_app_embeddedcontent_textblock_textblock_export',  '_route' => 'admin_app_embeddedcontent_textblock_textblock_export',);
                            }

                            // admin_app_embeddedcontent_textblock_textblock_history
                            if (preg_match('#^/admin/app/embeddedcontent\\-textblock\\-textblock/(?P<id>[^/]++)/history$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_textblock_textblock_history')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::historyAction',  '_sonata_admin' => 'admin.embedded_content.text_block',  '_sonata_name' => 'admin_app_embeddedcontent_textblock_textblock_history',));
                            }

                            // admin_app_embeddedcontent_textblock_textblock_history_view_revision
                            if (preg_match('#^/admin/app/embeddedcontent\\-textblock\\-textblock/(?P<id>[^/]++)/history/(?P<revision>[^/]++)/view$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_textblock_textblock_history_view_revision')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::historyViewRevisionAction',  '_sonata_admin' => 'admin.embedded_content.text_block',  '_sonata_name' => 'admin_app_embeddedcontent_textblock_textblock_history_view_revision',));
                            }

                            // admin_app_embeddedcontent_textblock_textblock_history_compare_revisions
                            if (preg_match('#^/admin/app/embeddedcontent\\-textblock\\-textblock/(?P<id>[^/]++)/history/(?P<base_revision>[^/]++)/(?P<compare_revision>[^/]++)/compare$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_textblock_textblock_history_compare_revisions')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::historyCompareRevisionsAction',  '_sonata_admin' => 'admin.embedded_content.text_block',  '_sonata_name' => 'admin_app_embeddedcontent_textblock_textblock_history_compare_revisions',));
                            }

                            // admin_app_embeddedcontent_textblock_textblock_browse
                            if ($pathinfo === '/admin/app/embeddedcontent-textblock-textblock/browse') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::browseAction',  '_sonata_admin' => 'admin.embedded_content.text_block',  '_sonata_name' => 'admin_app_embeddedcontent_textblock_textblock_browse',  '_route' => 'admin_app_embeddedcontent_textblock_textblock_browse',);
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/embeddedcontent-quote')) {
                            // admin_app_embeddedcontent_quote_list
                            if ($pathinfo === '/admin/app/embeddedcontent-quote/list') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::listAction',  '_sonata_admin' => 'admin.embedded_content.quote',  '_sonata_name' => 'admin_app_embeddedcontent_quote_list',  '_route' => 'admin_app_embeddedcontent_quote_list',);
                            }

                            // admin_app_embeddedcontent_quote_create
                            if ($pathinfo === '/admin/app/embeddedcontent-quote/create') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::createAction',  '_sonata_admin' => 'admin.embedded_content.quote',  '_sonata_name' => 'admin_app_embeddedcontent_quote_create',  '_route' => 'admin_app_embeddedcontent_quote_create',);
                            }

                            // admin_app_embeddedcontent_quote_batch
                            if ($pathinfo === '/admin/app/embeddedcontent-quote/batch') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::batchAction',  '_sonata_admin' => 'admin.embedded_content.quote',  '_sonata_name' => 'admin_app_embeddedcontent_quote_batch',  '_route' => 'admin_app_embeddedcontent_quote_batch',);
                            }

                            // admin_app_embeddedcontent_quote_edit
                            if (preg_match('#^/admin/app/embeddedcontent\\-quote/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_quote_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::editAction',  '_sonata_admin' => 'admin.embedded_content.quote',  '_sonata_name' => 'admin_app_embeddedcontent_quote_edit',));
                            }

                            // admin_app_embeddedcontent_quote_delete
                            if (preg_match('#^/admin/app/embeddedcontent\\-quote/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_quote_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::deleteAction',  '_sonata_admin' => 'admin.embedded_content.quote',  '_sonata_name' => 'admin_app_embeddedcontent_quote_delete',));
                            }

                            // admin_app_embeddedcontent_quote_show
                            if (preg_match('#^/admin/app/embeddedcontent\\-quote/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_quote_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::showAction',  '_sonata_admin' => 'admin.embedded_content.quote',  '_sonata_name' => 'admin_app_embeddedcontent_quote_show',));
                            }

                            // admin_app_embeddedcontent_quote_export
                            if ($pathinfo === '/admin/app/embeddedcontent-quote/export') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::exportAction',  '_sonata_admin' => 'admin.embedded_content.quote',  '_sonata_name' => 'admin_app_embeddedcontent_quote_export',  '_route' => 'admin_app_embeddedcontent_quote_export',);
                            }

                            // admin_app_embeddedcontent_quote_browse
                            if ($pathinfo === '/admin/app/embeddedcontent-quote/browse') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::browseAction',  '_sonata_admin' => 'admin.embedded_content.quote',  '_sonata_name' => 'admin_app_embeddedcontent_quote_browse',  '_route' => 'admin_app_embeddedcontent_quote_browse',);
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/embeddedcontent-faq-faqblock')) {
                            // admin_app_embeddedcontent_faq_faqblock_list
                            if ($pathinfo === '/admin/app/embeddedcontent-faq-faqblock/list') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::listAction',  '_sonata_admin' => 'admin.embedded_content.faq',  '_sonata_name' => 'admin_app_embeddedcontent_faq_faqblock_list',  '_route' => 'admin_app_embeddedcontent_faq_faqblock_list',);
                            }

                            // admin_app_embeddedcontent_faq_faqblock_create
                            if ($pathinfo === '/admin/app/embeddedcontent-faq-faqblock/create') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::createAction',  '_sonata_admin' => 'admin.embedded_content.faq',  '_sonata_name' => 'admin_app_embeddedcontent_faq_faqblock_create',  '_route' => 'admin_app_embeddedcontent_faq_faqblock_create',);
                            }

                            // admin_app_embeddedcontent_faq_faqblock_batch
                            if ($pathinfo === '/admin/app/embeddedcontent-faq-faqblock/batch') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::batchAction',  '_sonata_admin' => 'admin.embedded_content.faq',  '_sonata_name' => 'admin_app_embeddedcontent_faq_faqblock_batch',  '_route' => 'admin_app_embeddedcontent_faq_faqblock_batch',);
                            }

                            // admin_app_embeddedcontent_faq_faqblock_edit
                            if (preg_match('#^/admin/app/embeddedcontent\\-faq\\-faqblock/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_faq_faqblock_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::editAction',  '_sonata_admin' => 'admin.embedded_content.faq',  '_sonata_name' => 'admin_app_embeddedcontent_faq_faqblock_edit',));
                            }

                            // admin_app_embeddedcontent_faq_faqblock_delete
                            if (preg_match('#^/admin/app/embeddedcontent\\-faq\\-faqblock/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_faq_faqblock_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::deleteAction',  '_sonata_admin' => 'admin.embedded_content.faq',  '_sonata_name' => 'admin_app_embeddedcontent_faq_faqblock_delete',));
                            }

                            // admin_app_embeddedcontent_faq_faqblock_show
                            if (preg_match('#^/admin/app/embeddedcontent\\-faq\\-faqblock/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_faq_faqblock_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::showAction',  '_sonata_admin' => 'admin.embedded_content.faq',  '_sonata_name' => 'admin_app_embeddedcontent_faq_faqblock_show',));
                            }

                            // admin_app_embeddedcontent_faq_faqblock_export
                            if ($pathinfo === '/admin/app/embeddedcontent-faq-faqblock/export') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::exportAction',  '_sonata_admin' => 'admin.embedded_content.faq',  '_sonata_name' => 'admin_app_embeddedcontent_faq_faqblock_export',  '_route' => 'admin_app_embeddedcontent_faq_faqblock_export',);
                            }

                            // admin_app_embeddedcontent_faq_faqblock_browse
                            if ($pathinfo === '/admin/app/embeddedcontent-faq-faqblock/browse') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\EmbeddableContentAdminController::browseAction',  '_sonata_admin' => 'admin.embedded_content.faq',  '_sonata_name' => 'admin_app_embeddedcontent_faq_faqblock_browse',  '_route' => 'admin_app_embeddedcontent_faq_faqblock_browse',);
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/administrativearea')) {
                        // admin_app_administrativearea_list
                        if ($pathinfo === '/admin/app/administrativearea/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.administrative_area',  '_sonata_name' => 'admin_app_administrativearea_list',  '_route' => 'admin_app_administrativearea_list',);
                        }

                        // admin_app_administrativearea_create
                        if ($pathinfo === '/admin/app/administrativearea/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.administrative_area',  '_sonata_name' => 'admin_app_administrativearea_create',  '_route' => 'admin_app_administrativearea_create',);
                        }

                        // admin_app_administrativearea_batch
                        if ($pathinfo === '/admin/app/administrativearea/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.administrative_area',  '_sonata_name' => 'admin_app_administrativearea_batch',  '_route' => 'admin_app_administrativearea_batch',);
                        }

                        // admin_app_administrativearea_edit
                        if (preg_match('#^/admin/app/administrativearea/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_administrativearea_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.administrative_area',  '_sonata_name' => 'admin_app_administrativearea_edit',));
                        }

                        // admin_app_administrativearea_delete
                        if (preg_match('#^/admin/app/administrativearea/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_administrativearea_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.administrative_area',  '_sonata_name' => 'admin_app_administrativearea_delete',));
                        }

                        // admin_app_administrativearea_show
                        if (preg_match('#^/admin/app/administrativearea/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_administrativearea_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.administrative_area',  '_sonata_name' => 'admin_app_administrativearea_show',));
                        }

                        // admin_app_administrativearea_export
                        if ($pathinfo === '/admin/app/administrativearea/export') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.administrative_area',  '_sonata_name' => 'admin_app_administrativearea_export',  '_route' => 'admin_app_administrativearea_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/c')) {
                        if (0 === strpos($pathinfo, '/admin/app/citydistrict')) {
                            // admin_app_citydistrict_list
                            if ($pathinfo === '/admin/app/citydistrict/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.city_district',  '_sonata_name' => 'admin_app_citydistrict_list',  '_route' => 'admin_app_citydistrict_list',);
                            }

                            // admin_app_citydistrict_create
                            if ($pathinfo === '/admin/app/citydistrict/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.city_district',  '_sonata_name' => 'admin_app_citydistrict_create',  '_route' => 'admin_app_citydistrict_create',);
                            }

                            // admin_app_citydistrict_batch
                            if ($pathinfo === '/admin/app/citydistrict/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.city_district',  '_sonata_name' => 'admin_app_citydistrict_batch',  '_route' => 'admin_app_citydistrict_batch',);
                            }

                            // admin_app_citydistrict_edit
                            if (preg_match('#^/admin/app/citydistrict/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_citydistrict_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.city_district',  '_sonata_name' => 'admin_app_citydistrict_edit',));
                            }

                            // admin_app_citydistrict_delete
                            if (preg_match('#^/admin/app/citydistrict/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_citydistrict_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.city_district',  '_sonata_name' => 'admin_app_citydistrict_delete',));
                            }

                            // admin_app_citydistrict_show
                            if (preg_match('#^/admin/app/citydistrict/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_citydistrict_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.city_district',  '_sonata_name' => 'admin_app_citydistrict_show',));
                            }

                            // admin_app_citydistrict_export
                            if ($pathinfo === '/admin/app/citydistrict/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.city_district',  '_sonata_name' => 'admin_app_citydistrict_export',  '_route' => 'admin_app_citydistrict_export',);
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/category')) {
                            // admin_app_category_list
                            if ($pathinfo === '/admin/app/category/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.category',  '_sonata_name' => 'admin_app_category_list',  '_route' => 'admin_app_category_list',);
                            }

                            // admin_app_category_create
                            if ($pathinfo === '/admin/app/category/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.category',  '_sonata_name' => 'admin_app_category_create',  '_route' => 'admin_app_category_create',);
                            }

                            // admin_app_category_batch
                            if ($pathinfo === '/admin/app/category/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.category',  '_sonata_name' => 'admin_app_category_batch',  '_route' => 'admin_app_category_batch',);
                            }

                            // admin_app_category_edit
                            if (preg_match('#^/admin/app/category/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_category_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.category',  '_sonata_name' => 'admin_app_category_edit',));
                            }

                            // admin_app_category_delete
                            if (preg_match('#^/admin/app/category/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_category_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.category',  '_sonata_name' => 'admin_app_category_delete',));
                            }

                            // admin_app_category_show
                            if (preg_match('#^/admin/app/category/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_category_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.category',  '_sonata_name' => 'admin_app_category_show',));
                            }

                            // admin_app_category_export
                            if ($pathinfo === '/admin/app/category/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.category',  '_sonata_name' => 'admin_app_category_export',  '_route' => 'admin_app_category_export',);
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/gallery')) {
                        // admin_app_gallery_list
                        if ($pathinfo === '/admin/app/gallery/list') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\CKeditorGalleryAdminController::listAction',  '_sonata_admin' => 'admin.gallery',  '_sonata_name' => 'admin_app_gallery_list',  '_route' => 'admin_app_gallery_list',);
                        }

                        // admin_app_gallery_create
                        if ($pathinfo === '/admin/app/gallery/create') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\CKeditorGalleryAdminController::createAction',  '_sonata_admin' => 'admin.gallery',  '_sonata_name' => 'admin_app_gallery_create',  '_route' => 'admin_app_gallery_create',);
                        }

                        // admin_app_gallery_batch
                        if ($pathinfo === '/admin/app/gallery/batch') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\CKeditorGalleryAdminController::batchAction',  '_sonata_admin' => 'admin.gallery',  '_sonata_name' => 'admin_app_gallery_batch',  '_route' => 'admin_app_gallery_batch',);
                        }

                        // admin_app_gallery_edit
                        if (preg_match('#^/admin/app/gallery/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_gallery_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\CKeditorGalleryAdminController::editAction',  '_sonata_admin' => 'admin.gallery',  '_sonata_name' => 'admin_app_gallery_edit',));
                        }

                        // admin_app_gallery_delete
                        if (preg_match('#^/admin/app/gallery/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_gallery_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\CKeditorGalleryAdminController::deleteAction',  '_sonata_admin' => 'admin.gallery',  '_sonata_name' => 'admin_app_gallery_delete',));
                        }

                        // admin_app_gallery_show
                        if (preg_match('#^/admin/app/gallery/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_gallery_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\CKeditorGalleryAdminController::showAction',  '_sonata_admin' => 'admin.gallery',  '_sonata_name' => 'admin_app_gallery_show',));
                        }

                        // admin_app_gallery_export
                        if ($pathinfo === '/admin/app/gallery/export') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\CKeditorGalleryAdminController::exportAction',  '_sonata_admin' => 'admin.gallery',  '_sonata_name' => 'admin_app_gallery_export',  '_route' => 'admin_app_gallery_export',);
                        }

                        // admin_app_gallery_link
                        if (preg_match('#^/admin/app/gallery/(?P<id>[^/]++)/link$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_gallery_link')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\CKeditorGalleryAdminController::linkAction',  '_sonata_admin' => 'admin.gallery',  '_sonata_name' => 'admin_app_gallery_link',));
                        }

                        // admin_app_gallery_unlink
                        if (preg_match('#^/admin/app/gallery/(?P<id>[^/]++)/unlink$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_gallery_unlink')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\CKeditorGalleryAdminController::unlinkAction',  '_sonata_admin' => 'admin.gallery',  '_sonata_name' => 'admin_app_gallery_unlink',));
                        }

                        // admin_app_gallery_browse
                        if ($pathinfo === '/admin/app/gallery/browse') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\CKeditorGalleryAdminController::browseAction',  '_sonata_admin' => 'admin.gallery',  '_sonata_name' => 'admin_app_gallery_browse',  '_route' => 'admin_app_gallery_browse',);
                        }

                        if (0 === strpos($pathinfo, '/admin/app/gallerymedia')) {
                            // admin_app_gallerymedia_list
                            if ($pathinfo === '/admin/app/gallerymedia/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.gallery_media',  '_sonata_name' => 'admin_app_gallerymedia_list',  '_route' => 'admin_app_gallerymedia_list',);
                            }

                            // admin_app_gallerymedia_create
                            if ($pathinfo === '/admin/app/gallerymedia/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.gallery_media',  '_sonata_name' => 'admin_app_gallerymedia_create',  '_route' => 'admin_app_gallerymedia_create',);
                            }

                            // admin_app_gallerymedia_batch
                            if ($pathinfo === '/admin/app/gallerymedia/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.gallery_media',  '_sonata_name' => 'admin_app_gallerymedia_batch',  '_route' => 'admin_app_gallerymedia_batch',);
                            }

                            // admin_app_gallerymedia_edit
                            if (preg_match('#^/admin/app/gallerymedia/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_gallerymedia_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.gallery_media',  '_sonata_name' => 'admin_app_gallerymedia_edit',));
                            }

                            // admin_app_gallerymedia_delete
                            if (preg_match('#^/admin/app/gallerymedia/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_gallerymedia_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.gallery_media',  '_sonata_name' => 'admin_app_gallerymedia_delete',));
                            }

                            // admin_app_gallerymedia_show
                            if (preg_match('#^/admin/app/gallerymedia/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_gallerymedia_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.gallery_media',  '_sonata_name' => 'admin_app_gallerymedia_show',));
                            }

                            // admin_app_gallerymedia_export
                            if ($pathinfo === '/admin/app/gallerymedia/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.gallery_media',  '_sonata_name' => 'admin_app_gallerymedia_export',  '_route' => 'admin_app_gallerymedia_export',);
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/postattachment')) {
                        // admin_app_postattachment_list
                        if ($pathinfo === '/admin/app/postattachment/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.post_attachment',  '_sonata_name' => 'admin_app_postattachment_list',  '_route' => 'admin_app_postattachment_list',);
                        }

                        // admin_app_postattachment_create
                        if ($pathinfo === '/admin/app/postattachment/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.post_attachment',  '_sonata_name' => 'admin_app_postattachment_create',  '_route' => 'admin_app_postattachment_create',);
                        }

                        // admin_app_postattachment_batch
                        if ($pathinfo === '/admin/app/postattachment/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.post_attachment',  '_sonata_name' => 'admin_app_postattachment_batch',  '_route' => 'admin_app_postattachment_batch',);
                        }

                        // admin_app_postattachment_edit
                        if (preg_match('#^/admin/app/postattachment/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_postattachment_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.post_attachment',  '_sonata_name' => 'admin_app_postattachment_edit',));
                        }

                        // admin_app_postattachment_delete
                        if (preg_match('#^/admin/app/postattachment/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_postattachment_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.post_attachment',  '_sonata_name' => 'admin_app_postattachment_delete',));
                        }

                        // admin_app_postattachment_show
                        if (preg_match('#^/admin/app/postattachment/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_postattachment_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.post_attachment',  '_sonata_name' => 'admin_app_postattachment_show',));
                        }

                        // admin_app_postattachment_export
                        if ($pathinfo === '/admin/app/postattachment/export') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.post_attachment',  '_sonata_name' => 'admin_app_postattachment_export',  '_route' => 'admin_app_postattachment_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/video')) {
                        // admin_app_video_list
                        if ($pathinfo === '/admin/app/video/list') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::listAction',  '_sonata_admin' => 'admin.video',  '_sonata_name' => 'admin_app_video_list',  '_route' => 'admin_app_video_list',);
                        }

                        // admin_app_video_create
                        if ($pathinfo === '/admin/app/video/create') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::createAction',  '_sonata_admin' => 'admin.video',  '_sonata_name' => 'admin_app_video_create',  '_route' => 'admin_app_video_create',);
                        }

                        // admin_app_video_batch
                        if ($pathinfo === '/admin/app/video/batch') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::batchAction',  '_sonata_admin' => 'admin.video',  '_sonata_name' => 'admin_app_video_batch',  '_route' => 'admin_app_video_batch',);
                        }

                        // admin_app_video_edit
                        if (preg_match('#^/admin/app/video/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_video_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::editAction',  '_sonata_admin' => 'admin.video',  '_sonata_name' => 'admin_app_video_edit',));
                        }

                        // admin_app_video_delete
                        if (preg_match('#^/admin/app/video/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_video_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::deleteAction',  '_sonata_admin' => 'admin.video',  '_sonata_name' => 'admin_app_video_delete',));
                        }

                        // admin_app_video_show
                        if (preg_match('#^/admin/app/video/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_video_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::showAction',  '_sonata_admin' => 'admin.video',  '_sonata_name' => 'admin_app_video_show',));
                        }

                        // admin_app_video_export
                        if ($pathinfo === '/admin/app/video/export') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::exportAction',  '_sonata_admin' => 'admin.video',  '_sonata_name' => 'admin_app_video_export',  '_route' => 'admin_app_video_export',);
                        }

                        // admin_app_video_link
                        if (preg_match('#^/admin/app/video/(?P<id>[^/]++)/link$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_video_link')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::linkAction',  '_sonata_admin' => 'admin.video',  '_sonata_name' => 'admin_app_video_link',));
                        }

                        // admin_app_video_unlink
                        if (preg_match('#^/admin/app/video/(?P<id>[^/]++)/unlink$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_video_unlink')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::unlinkAction',  '_sonata_admin' => 'admin.video',  '_sonata_name' => 'admin_app_video_unlink',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/infographics')) {
                        // admin_app_infographics_list
                        if ($pathinfo === '/admin/app/infographics/list') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\CRUDController::listAction',  '_sonata_admin' => 'admin.infographics',  '_sonata_name' => 'admin_app_infographics_list',  '_route' => 'admin_app_infographics_list',);
                        }

                        // admin_app_infographics_create
                        if ($pathinfo === '/admin/app/infographics/create') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\CRUDController::createAction',  '_sonata_admin' => 'admin.infographics',  '_sonata_name' => 'admin_app_infographics_create',  '_route' => 'admin_app_infographics_create',);
                        }

                        // admin_app_infographics_batch
                        if ($pathinfo === '/admin/app/infographics/batch') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\CRUDController::batchAction',  '_sonata_admin' => 'admin.infographics',  '_sonata_name' => 'admin_app_infographics_batch',  '_route' => 'admin_app_infographics_batch',);
                        }

                        // admin_app_infographics_edit
                        if (preg_match('#^/admin/app/infographics/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_infographics_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\CRUDController::editAction',  '_sonata_admin' => 'admin.infographics',  '_sonata_name' => 'admin_app_infographics_edit',));
                        }

                        // admin_app_infographics_delete
                        if (preg_match('#^/admin/app/infographics/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_infographics_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.infographics',  '_sonata_name' => 'admin_app_infographics_delete',));
                        }

                        // admin_app_infographics_show
                        if (preg_match('#^/admin/app/infographics/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_infographics_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\CRUDController::showAction',  '_sonata_admin' => 'admin.infographics',  '_sonata_name' => 'admin_app_infographics_show',));
                        }

                        // admin_app_infographics_export
                        if ($pathinfo === '/admin/app/infographics/export') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\CRUDController::exportAction',  '_sonata_admin' => 'admin.infographics',  '_sonata_name' => 'admin_app_infographics_export',  '_route' => 'admin_app_infographics_export',);
                        }

                        // admin_app_infographics_history
                        if (preg_match('#^/admin/app/infographics/(?P<id>[^/]++)/history$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_infographics_history')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\CRUDController::historyAction',  '_sonata_admin' => 'admin.infographics',  '_sonata_name' => 'admin_app_infographics_history',));
                        }

                        // admin_app_infographics_history_view_revision
                        if (preg_match('#^/admin/app/infographics/(?P<id>[^/]++)/history/(?P<revision>[^/]++)/view$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_infographics_history_view_revision')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\CRUDController::historyViewRevisionAction',  '_sonata_admin' => 'admin.infographics',  '_sonata_name' => 'admin_app_infographics_history_view_revision',));
                        }

                        // admin_app_infographics_history_compare_revisions
                        if (preg_match('#^/admin/app/infographics/(?P<id>[^/]++)/history/(?P<base_revision>[^/]++)/(?P<compare_revision>[^/]++)/compare$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_infographics_history_compare_revisions')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\CRUDController::historyCompareRevisionsAction',  '_sonata_admin' => 'admin.infographics',  '_sonata_name' => 'admin_app_infographics_history_compare_revisions',));
                        }

                        // admin_app_infographics_revert_revision
                        if (preg_match('#^/admin/app/infographics/(?P<id>[^/]++)/history/(?P<base_rev_id>[^/]++)/(?P<compare_rev_id>[^/]++)/revert/(?P<field_name>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_infographics_revert_revision')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\CRUDController::revertRevisionAction',  '_sonata_admin' => 'admin.infographics',  '_sonata_name' => 'admin_app_infographics_revert_revision',));
                        }

                        // admin_app_infographics_browse
                        if ($pathinfo === '/admin/app/infographics/browse') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\CRUDController::browseAction',  '_sonata_admin' => 'admin.infographics',  '_sonata_name' => 'admin_app_infographics_browse',  '_route' => 'admin_app_infographics_browse',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/construction')) {
                        // admin_app_construction_list
                        if ($pathinfo === '/admin/app/construction/list') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ConstructionCRUDController::listAction',  '_sonata_admin' => 'admin.construction',  '_sonata_name' => 'admin_app_construction_list',  '_route' => 'admin_app_construction_list',);
                        }

                        // admin_app_construction_create
                        if ($pathinfo === '/admin/app/construction/create') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ConstructionCRUDController::createAction',  '_sonata_admin' => 'admin.construction',  '_sonata_name' => 'admin_app_construction_create',  '_route' => 'admin_app_construction_create',);
                        }

                        // admin_app_construction_batch
                        if ($pathinfo === '/admin/app/construction/batch') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ConstructionCRUDController::batchAction',  '_sonata_admin' => 'admin.construction',  '_sonata_name' => 'admin_app_construction_batch',  '_route' => 'admin_app_construction_batch',);
                        }

                        // admin_app_construction_edit
                        if (preg_match('#^/admin/app/construction/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_construction_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ConstructionCRUDController::editAction',  '_sonata_admin' => 'admin.construction',  '_sonata_name' => 'admin_app_construction_edit',));
                        }

                        // admin_app_construction_delete
                        if (preg_match('#^/admin/app/construction/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_construction_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ConstructionCRUDController::deleteAction',  '_sonata_admin' => 'admin.construction',  '_sonata_name' => 'admin_app_construction_delete',));
                        }

                        // admin_app_construction_export
                        if ($pathinfo === '/admin/app/construction/export') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ConstructionCRUDController::exportAction',  '_sonata_admin' => 'admin.construction',  '_sonata_name' => 'admin_app_construction_export',  '_route' => 'admin_app_construction_export',);
                        }

                        if (0 === strpos($pathinfo, '/admin/app/constructiontype')) {
                            // admin_app_constructiontype_list
                            if ($pathinfo === '/admin/app/constructiontype/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.construction_type',  '_sonata_name' => 'admin_app_constructiontype_list',  '_route' => 'admin_app_constructiontype_list',);
                            }

                            // admin_app_constructiontype_create
                            if ($pathinfo === '/admin/app/constructiontype/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.construction_type',  '_sonata_name' => 'admin_app_constructiontype_create',  '_route' => 'admin_app_constructiontype_create',);
                            }

                            // admin_app_constructiontype_batch
                            if ($pathinfo === '/admin/app/constructiontype/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.construction_type',  '_sonata_name' => 'admin_app_constructiontype_batch',  '_route' => 'admin_app_constructiontype_batch',);
                            }

                            // admin_app_constructiontype_edit
                            if (preg_match('#^/admin/app/constructiontype/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_constructiontype_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.construction_type',  '_sonata_name' => 'admin_app_constructiontype_edit',));
                            }

                            // admin_app_constructiontype_delete
                            if (preg_match('#^/admin/app/constructiontype/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_constructiontype_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.construction_type',  '_sonata_name' => 'admin_app_constructiontype_delete',));
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/menunode')) {
                        // admin_app_menunode_list
                        if ($pathinfo === '/admin/app/menunode/list') {
                            return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::listAction',  '_sonata_admin' => 'admin.menu_nodes',  '_sonata_name' => 'admin_app_menunode_list',  '_route' => 'admin_app_menunode_list',);
                        }

                        // admin_app_menunode_create
                        if ($pathinfo === '/admin/app/menunode/create') {
                            return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::createAction',  '_sonata_admin' => 'admin.menu_nodes',  '_sonata_name' => 'admin_app_menunode_create',  '_route' => 'admin_app_menunode_create',);
                        }

                        // admin_app_menunode_batch
                        if ($pathinfo === '/admin/app/menunode/batch') {
                            return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::batchAction',  '_sonata_admin' => 'admin.menu_nodes',  '_sonata_name' => 'admin_app_menunode_batch',  '_route' => 'admin_app_menunode_batch',);
                        }

                        // admin_app_menunode_edit
                        if (preg_match('#^/admin/app/menunode/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menunode_edit')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::editAction',  '_sonata_admin' => 'admin.menu_nodes',  '_sonata_name' => 'admin_app_menunode_edit',));
                        }

                        // admin_app_menunode_delete
                        if (preg_match('#^/admin/app/menunode/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menunode_delete')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::deleteAction',  '_sonata_admin' => 'admin.menu_nodes',  '_sonata_name' => 'admin_app_menunode_delete',));
                        }

                        // admin_app_menunode_show
                        if (preg_match('#^/admin/app/menunode/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menunode_show')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::showAction',  '_sonata_admin' => 'admin.menu_nodes',  '_sonata_name' => 'admin_app_menunode_show',));
                        }

                        // admin_app_menunode_export
                        if ($pathinfo === '/admin/app/menunode/export') {
                            return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::exportAction',  '_sonata_admin' => 'admin.menu_nodes',  '_sonata_name' => 'admin_app_menunode_export',  '_route' => 'admin_app_menunode_export',);
                        }

                        // admin_app_menunode_move
                        if (preg_match('#^/admin/app/menunode/(?P<id>[^/]++)/move/(?P<direction>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menunode_move')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::moveAction',  '_sonata_admin' => 'admin.menu_nodes',  '_sonata_name' => 'admin_app_menunode_move',));
                        }

                    }

                }

                if (0 === strpos($pathinfo, '/admin/menu')) {
                    // admin_app_menu_list
                    if ($pathinfo === '/admin/menu/list') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.menu',  '_sonata_name' => 'admin_app_menu_list',  '_route' => 'admin_app_menu_list',);
                    }

                    // admin_app_menu_create
                    if ($pathinfo === '/admin/menu/create') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.menu',  '_sonata_name' => 'admin_app_menu_create',  '_route' => 'admin_app_menu_create',);
                    }

                    // admin_app_menu_batch
                    if ($pathinfo === '/admin/menu/batch') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.menu',  '_sonata_name' => 'admin_app_menu_batch',  '_route' => 'admin_app_menu_batch',);
                    }

                    // admin_app_menu_edit
                    if (preg_match('#^/admin/menu/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menu_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.menu',  '_sonata_name' => 'admin_app_menu_edit',));
                    }

                    // admin_app_menu_delete
                    if (preg_match('#^/admin/menu/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menu_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.menu',  '_sonata_name' => 'admin_app_menu_delete',));
                    }

                    // admin_app_menu_show
                    if (preg_match('#^/admin/menu/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menu_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.menu',  '_sonata_name' => 'admin_app_menu_show',));
                    }

                    // admin_app_menu_export
                    if ($pathinfo === '/admin/menu/export') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.menu',  '_sonata_name' => 'admin_app_menu_export',  '_route' => 'admin_app_menu_export',);
                    }

                    // admin_app_menu_menunode_list
                    if (preg_match('#^/admin/menu/(?P<id>[^/]++)/menunode/list$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menu_menunode_list')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::listAction',  '_sonata_admin' => 'admin.menu|admin.menu_nodes',  '_sonata_name' => 'admin_app_menu_menunode_list',));
                    }

                    // admin_app_menu_menunode_create
                    if (preg_match('#^/admin/menu/(?P<id>[^/]++)/menunode/create$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menu_menunode_create')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::createAction',  '_sonata_admin' => 'admin.menu|admin.menu_nodes',  '_sonata_name' => 'admin_app_menu_menunode_create',));
                    }

                    // admin_app_menu_menunode_batch
                    if (preg_match('#^/admin/menu/(?P<id>[^/]++)/menunode/batch$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menu_menunode_batch')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::batchAction',  '_sonata_admin' => 'admin.menu|admin.menu_nodes',  '_sonata_name' => 'admin_app_menu_menunode_batch',));
                    }

                    // admin_app_menu_menunode_edit
                    if (preg_match('#^/admin/menu/(?P<id>[^/]++)/menunode/(?P<childId>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menu_menunode_edit')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::editAction',  '_sonata_admin' => 'admin.menu|admin.menu_nodes',  '_sonata_name' => 'admin_app_menu_menunode_edit',));
                    }

                    // admin_app_menu_menunode_delete
                    if (preg_match('#^/admin/menu/(?P<id>[^/]++)/menunode/(?P<childId>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menu_menunode_delete')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::deleteAction',  '_sonata_admin' => 'admin.menu|admin.menu_nodes',  '_sonata_name' => 'admin_app_menu_menunode_delete',));
                    }

                    // admin_app_menu_menunode_show
                    if (preg_match('#^/admin/menu/(?P<id>[^/]++)/menunode/(?P<childId>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menu_menunode_show')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::showAction',  '_sonata_admin' => 'admin.menu|admin.menu_nodes',  '_sonata_name' => 'admin_app_menu_menunode_show',));
                    }

                    // admin_app_menu_menunode_export
                    if (preg_match('#^/admin/menu/(?P<id>[^/]++)/menunode/export$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menu_menunode_export')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::exportAction',  '_sonata_admin' => 'admin.menu|admin.menu_nodes',  '_sonata_name' => 'admin_app_menu_menunode_export',));
                    }

                    // admin_app_menu_menunode_move
                    if (preg_match('#^/admin/menu/(?P<id>[^/]++)/menunode/(?P<childId>[^/]++)/move/(?P<direction>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_menu_menunode_move')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::moveAction',  '_sonata_admin' => 'admin.menu|admin.menu_nodes',  '_sonata_name' => 'admin_app_menu_menunode_move',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/app')) {
                    if (0 === strpos($pathinfo, '/admin/app/spotlightitem')) {
                        // admin_app_spotlightitem_list
                        if ($pathinfo === '/admin/app/spotlightitem/list') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\SpotlightItemCRUDController::listAction',  '_sonata_admin' => 'admin.spotlight_item',  '_sonata_name' => 'admin_app_spotlightitem_list',  '_route' => 'admin_app_spotlightitem_list',);
                        }

                        // admin_app_spotlightitem_create
                        if ($pathinfo === '/admin/app/spotlightitem/create') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\SpotlightItemCRUDController::createAction',  '_sonata_admin' => 'admin.spotlight_item',  '_sonata_name' => 'admin_app_spotlightitem_create',  '_route' => 'admin_app_spotlightitem_create',);
                        }

                        // admin_app_spotlightitem_edit
                        if (preg_match('#^/admin/app/spotlightitem/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_spotlightitem_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\SpotlightItemCRUDController::editAction',  '_sonata_admin' => 'admin.spotlight_item',  '_sonata_name' => 'admin_app_spotlightitem_edit',));
                        }

                        // admin_app_spotlightitem_delete
                        if (preg_match('#^/admin/app/spotlightitem/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_spotlightitem_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\SpotlightItemCRUDController::deleteAction',  '_sonata_admin' => 'admin.spotlight_item',  '_sonata_name' => 'admin_app_spotlightitem_delete',));
                        }

                        // admin_app_spotlightitem_move
                        if (preg_match('#^/admin/app/spotlightitem/(?P<id>[^/]++)/move/(?P<direction>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_spotlightitem_move')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\SpotlightItemCRUDController::moveAction',  '_sonata_admin' => 'admin.spotlight_item',  '_sonata_name' => 'admin_app_spotlightitem_move',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/d')) {
                        if (0 === strpos($pathinfo, '/admin/app/document')) {
                            // admin_app_document_list
                            if ($pathinfo === '/admin/app/document/list') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::listAction',  '_sonata_admin' => 'admin.document',  '_sonata_name' => 'admin_app_document_list',  '_route' => 'admin_app_document_list',);
                            }

                            // admin_app_document_create
                            if ($pathinfo === '/admin/app/document/create') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::createAction',  '_sonata_admin' => 'admin.document',  '_sonata_name' => 'admin_app_document_create',  '_route' => 'admin_app_document_create',);
                            }

                            // admin_app_document_batch
                            if ($pathinfo === '/admin/app/document/batch') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::batchAction',  '_sonata_admin' => 'admin.document',  '_sonata_name' => 'admin_app_document_batch',  '_route' => 'admin_app_document_batch',);
                            }

                            // admin_app_document_edit
                            if (preg_match('#^/admin/app/document/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_document_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::editAction',  '_sonata_admin' => 'admin.document',  '_sonata_name' => 'admin_app_document_edit',));
                            }

                            // admin_app_document_delete
                            if (preg_match('#^/admin/app/document/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_document_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::deleteAction',  '_sonata_admin' => 'admin.document',  '_sonata_name' => 'admin_app_document_delete',));
                            }

                            // admin_app_document_show
                            if (preg_match('#^/admin/app/document/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_document_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::showAction',  '_sonata_admin' => 'admin.document',  '_sonata_name' => 'admin_app_document_show',));
                            }

                            // admin_app_document_export
                            if ($pathinfo === '/admin/app/document/export') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::exportAction',  '_sonata_admin' => 'admin.document',  '_sonata_name' => 'admin_app_document_export',  '_route' => 'admin_app_document_export',);
                            }

                            // admin_app_document_link
                            if (preg_match('#^/admin/app/document/(?P<id>[^/]++)/link$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_document_link')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::linkAction',  '_sonata_admin' => 'admin.document',  '_sonata_name' => 'admin_app_document_link',));
                            }

                            // admin_app_document_unlink
                            if (preg_match('#^/admin/app/document/(?P<id>[^/]++)/unlink$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_document_unlink')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::unlinkAction',  '_sonata_admin' => 'admin.document',  '_sonata_name' => 'admin_app_document_unlink',));
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/decisiondocument')) {
                            // admin_app_decisiondocument_list
                            if ($pathinfo === '/admin/app/decisiondocument/list') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::listAction',  '_sonata_admin' => 'admin.decision_document',  '_sonata_name' => 'admin_app_decisiondocument_list',  '_route' => 'admin_app_decisiondocument_list',);
                            }

                            // admin_app_decisiondocument_create
                            if ($pathinfo === '/admin/app/decisiondocument/create') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::createAction',  '_sonata_admin' => 'admin.decision_document',  '_sonata_name' => 'admin_app_decisiondocument_create',  '_route' => 'admin_app_decisiondocument_create',);
                            }

                            // admin_app_decisiondocument_batch
                            if ($pathinfo === '/admin/app/decisiondocument/batch') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::batchAction',  '_sonata_admin' => 'admin.decision_document',  '_sonata_name' => 'admin_app_decisiondocument_batch',  '_route' => 'admin_app_decisiondocument_batch',);
                            }

                            // admin_app_decisiondocument_edit
                            if (preg_match('#^/admin/app/decisiondocument/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_decisiondocument_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::editAction',  '_sonata_admin' => 'admin.decision_document',  '_sonata_name' => 'admin_app_decisiondocument_edit',));
                            }

                            // admin_app_decisiondocument_delete
                            if (preg_match('#^/admin/app/decisiondocument/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_decisiondocument_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::deleteAction',  '_sonata_admin' => 'admin.decision_document',  '_sonata_name' => 'admin_app_decisiondocument_delete',));
                            }

                            // admin_app_decisiondocument_show
                            if (preg_match('#^/admin/app/decisiondocument/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_decisiondocument_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::showAction',  '_sonata_admin' => 'admin.decision_document',  '_sonata_name' => 'admin_app_decisiondocument_show',));
                            }

                            // admin_app_decisiondocument_export
                            if ($pathinfo === '/admin/app/decisiondocument/export') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::exportAction',  '_sonata_admin' => 'admin.decision_document',  '_sonata_name' => 'admin_app_decisiondocument_export',  '_route' => 'admin_app_decisiondocument_export',);
                            }

                            // admin_app_decisiondocument_link
                            if (preg_match('#^/admin/app/decisiondocument/(?P<id>[^/]++)/link$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_decisiondocument_link')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::linkAction',  '_sonata_admin' => 'admin.decision_document',  '_sonata_name' => 'admin_app_decisiondocument_link',));
                            }

                            // admin_app_decisiondocument_unlink
                            if (preg_match('#^/admin/app/decisiondocument/(?P<id>[^/]++)/unlink$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_decisiondocument_unlink')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::unlinkAction',  '_sonata_admin' => 'admin.decision_document',  '_sonata_name' => 'admin_app_decisiondocument_unlink',));
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/lawdocument')) {
                        // admin_app_lawdocument_list
                        if ($pathinfo === '/admin/app/lawdocument/list') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::listAction',  '_sonata_admin' => 'admin.law_document',  '_sonata_name' => 'admin_app_lawdocument_list',  '_route' => 'admin_app_lawdocument_list',);
                        }

                        // admin_app_lawdocument_create
                        if ($pathinfo === '/admin/app/lawdocument/create') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::createAction',  '_sonata_admin' => 'admin.law_document',  '_sonata_name' => 'admin_app_lawdocument_create',  '_route' => 'admin_app_lawdocument_create',);
                        }

                        // admin_app_lawdocument_batch
                        if ($pathinfo === '/admin/app/lawdocument/batch') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::batchAction',  '_sonata_admin' => 'admin.law_document',  '_sonata_name' => 'admin_app_lawdocument_batch',  '_route' => 'admin_app_lawdocument_batch',);
                        }

                        // admin_app_lawdocument_edit
                        if (preg_match('#^/admin/app/lawdocument/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_lawdocument_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::editAction',  '_sonata_admin' => 'admin.law_document',  '_sonata_name' => 'admin_app_lawdocument_edit',));
                        }

                        // admin_app_lawdocument_delete
                        if (preg_match('#^/admin/app/lawdocument/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_lawdocument_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::deleteAction',  '_sonata_admin' => 'admin.law_document',  '_sonata_name' => 'admin_app_lawdocument_delete',));
                        }

                        // admin_app_lawdocument_show
                        if (preg_match('#^/admin/app/lawdocument/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_lawdocument_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::showAction',  '_sonata_admin' => 'admin.law_document',  '_sonata_name' => 'admin_app_lawdocument_show',));
                        }

                        // admin_app_lawdocument_export
                        if ($pathinfo === '/admin/app/lawdocument/export') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::exportAction',  '_sonata_admin' => 'admin.law_document',  '_sonata_name' => 'admin_app_lawdocument_export',  '_route' => 'admin_app_lawdocument_export',);
                        }

                        // admin_app_lawdocument_link
                        if (preg_match('#^/admin/app/lawdocument/(?P<id>[^/]++)/link$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_lawdocument_link')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::linkAction',  '_sonata_admin' => 'admin.law_document',  '_sonata_name' => 'admin_app_lawdocument_link',));
                        }

                        // admin_app_lawdocument_unlink
                        if (preg_match('#^/admin/app/lawdocument/(?P<id>[^/]++)/unlink$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_lawdocument_unlink')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::unlinkAction',  '_sonata_admin' => 'admin.law_document',  '_sonata_name' => 'admin_app_lawdocument_unlink',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/d')) {
                        if (0 === strpos($pathinfo, '/admin/app/draftdocument')) {
                            // admin_app_draftdocument_list
                            if ($pathinfo === '/admin/app/draftdocument/list') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::listAction',  '_sonata_admin' => 'admin.draft_document',  '_sonata_name' => 'admin_app_draftdocument_list',  '_route' => 'admin_app_draftdocument_list',);
                            }

                            // admin_app_draftdocument_create
                            if ($pathinfo === '/admin/app/draftdocument/create') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::createAction',  '_sonata_admin' => 'admin.draft_document',  '_sonata_name' => 'admin_app_draftdocument_create',  '_route' => 'admin_app_draftdocument_create',);
                            }

                            // admin_app_draftdocument_batch
                            if ($pathinfo === '/admin/app/draftdocument/batch') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::batchAction',  '_sonata_admin' => 'admin.draft_document',  '_sonata_name' => 'admin_app_draftdocument_batch',  '_route' => 'admin_app_draftdocument_batch',);
                            }

                            // admin_app_draftdocument_edit
                            if (preg_match('#^/admin/app/draftdocument/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_draftdocument_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::editAction',  '_sonata_admin' => 'admin.draft_document',  '_sonata_name' => 'admin_app_draftdocument_edit',));
                            }

                            // admin_app_draftdocument_delete
                            if (preg_match('#^/admin/app/draftdocument/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_draftdocument_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::deleteAction',  '_sonata_admin' => 'admin.draft_document',  '_sonata_name' => 'admin_app_draftdocument_delete',));
                            }

                            // admin_app_draftdocument_show
                            if (preg_match('#^/admin/app/draftdocument/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_draftdocument_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::showAction',  '_sonata_admin' => 'admin.draft_document',  '_sonata_name' => 'admin_app_draftdocument_show',));
                            }

                            // admin_app_draftdocument_export
                            if ($pathinfo === '/admin/app/draftdocument/export') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::exportAction',  '_sonata_admin' => 'admin.draft_document',  '_sonata_name' => 'admin_app_draftdocument_export',  '_route' => 'admin_app_draftdocument_export',);
                            }

                            // admin_app_draftdocument_link
                            if (preg_match('#^/admin/app/draftdocument/(?P<id>[^/]++)/link$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_draftdocument_link')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::linkAction',  '_sonata_admin' => 'admin.draft_document',  '_sonata_name' => 'admin_app_draftdocument_link',));
                            }

                            // admin_app_draftdocument_unlink
                            if (preg_match('#^/admin/app/draftdocument/(?P<id>[^/]++)/unlink$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_draftdocument_unlink')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::unlinkAction',  '_sonata_admin' => 'admin.draft_document',  '_sonata_name' => 'admin_app_draftdocument_unlink',));
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/documenthasmedia')) {
                            // admin_app_documenthasmedia_list
                            if ($pathinfo === '/admin/app/documenthasmedia/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.document_has_media',  '_sonata_name' => 'admin_app_documenthasmedia_list',  '_route' => 'admin_app_documenthasmedia_list',);
                            }

                            // admin_app_documenthasmedia_create
                            if ($pathinfo === '/admin/app/documenthasmedia/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.document_has_media',  '_sonata_name' => 'admin_app_documenthasmedia_create',  '_route' => 'admin_app_documenthasmedia_create',);
                            }

                            // admin_app_documenthasmedia_batch
                            if ($pathinfo === '/admin/app/documenthasmedia/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.document_has_media',  '_sonata_name' => 'admin_app_documenthasmedia_batch',  '_route' => 'admin_app_documenthasmedia_batch',);
                            }

                            // admin_app_documenthasmedia_edit
                            if (preg_match('#^/admin/app/documenthasmedia/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_documenthasmedia_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.document_has_media',  '_sonata_name' => 'admin_app_documenthasmedia_edit',));
                            }

                            // admin_app_documenthasmedia_delete
                            if (preg_match('#^/admin/app/documenthasmedia/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_documenthasmedia_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.document_has_media',  '_sonata_name' => 'admin_app_documenthasmedia_delete',));
                            }

                            // admin_app_documenthasmedia_show
                            if (preg_match('#^/admin/app/documenthasmedia/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_documenthasmedia_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.document_has_media',  '_sonata_name' => 'admin_app_documenthasmedia_show',));
                            }

                            // admin_app_documenthasmedia_export
                            if ($pathinfo === '/admin/app/documenthasmedia/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.document_has_media',  '_sonata_name' => 'admin_app_documenthasmedia_export',  '_route' => 'admin_app_documenthasmedia_export',);
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/outgoingagency')) {
                        // admin_app_outgoingagency_list
                        if ($pathinfo === '/admin/app/outgoingagency/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.outgoing_agency',  '_sonata_name' => 'admin_app_outgoingagency_list',  '_route' => 'admin_app_outgoingagency_list',);
                        }

                        // admin_app_outgoingagency_create
                        if ($pathinfo === '/admin/app/outgoingagency/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.outgoing_agency',  '_sonata_name' => 'admin_app_outgoingagency_create',  '_route' => 'admin_app_outgoingagency_create',);
                        }

                        // admin_app_outgoingagency_batch
                        if ($pathinfo === '/admin/app/outgoingagency/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.outgoing_agency',  '_sonata_name' => 'admin_app_outgoingagency_batch',  '_route' => 'admin_app_outgoingagency_batch',);
                        }

                        // admin_app_outgoingagency_edit
                        if (preg_match('#^/admin/app/outgoingagency/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_outgoingagency_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.outgoing_agency',  '_sonata_name' => 'admin_app_outgoingagency_edit',));
                        }

                        // admin_app_outgoingagency_delete
                        if (preg_match('#^/admin/app/outgoingagency/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_outgoingagency_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.outgoing_agency',  '_sonata_name' => 'admin_app_outgoingagency_delete',));
                        }

                        // admin_app_outgoingagency_show
                        if (preg_match('#^/admin/app/outgoingagency/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_outgoingagency_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.outgoing_agency',  '_sonata_name' => 'admin_app_outgoingagency_show',));
                        }

                        // admin_app_outgoingagency_export
                        if ($pathinfo === '/admin/app/outgoingagency/export') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.outgoing_agency',  '_sonata_name' => 'admin_app_outgoingagency_export',  '_route' => 'admin_app_outgoingagency_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/person')) {
                        // admin_app_person_list
                        if ($pathinfo === '/admin/app/person/list') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::listAction',  '_sonata_admin' => 'admin.person',  '_sonata_name' => 'admin_app_person_list',  '_route' => 'admin_app_person_list',);
                        }

                        // admin_app_person_create
                        if ($pathinfo === '/admin/app/person/create') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::createAction',  '_sonata_admin' => 'admin.person',  '_sonata_name' => 'admin_app_person_create',  '_route' => 'admin_app_person_create',);
                        }

                        // admin_app_person_batch
                        if ($pathinfo === '/admin/app/person/batch') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::batchAction',  '_sonata_admin' => 'admin.person',  '_sonata_name' => 'admin_app_person_batch',  '_route' => 'admin_app_person_batch',);
                        }

                        // admin_app_person_edit
                        if (preg_match('#^/admin/app/person/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_person_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::editAction',  '_sonata_admin' => 'admin.person',  '_sonata_name' => 'admin_app_person_edit',));
                        }

                        // admin_app_person_delete
                        if (preg_match('#^/admin/app/person/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_person_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::deleteAction',  '_sonata_admin' => 'admin.person',  '_sonata_name' => 'admin_app_person_delete',));
                        }

                        // admin_app_person_show
                        if (preg_match('#^/admin/app/person/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_person_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::showAction',  '_sonata_admin' => 'admin.person',  '_sonata_name' => 'admin_app_person_show',));
                        }

                        // admin_app_person_export
                        if ($pathinfo === '/admin/app/person/export') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BaseAdminController::exportAction',  '_sonata_admin' => 'admin.person',  '_sonata_name' => 'admin_app_person_export',  '_route' => 'admin_app_person_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/newsletter')) {
                        // admin_app_newsletter_list
                        if ($pathinfo === '/admin/app/newsletter/list') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\NewsletterCRUDController::listAction',  '_sonata_admin' => 'admin.newsletter',  '_sonata_name' => 'admin_app_newsletter_list',  '_route' => 'admin_app_newsletter_list',);
                        }

                        // admin_app_newsletter_create
                        if ($pathinfo === '/admin/app/newsletter/create') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\NewsletterCRUDController::createAction',  '_sonata_admin' => 'admin.newsletter',  '_sonata_name' => 'admin_app_newsletter_create',  '_route' => 'admin_app_newsletter_create',);
                        }

                        // admin_app_newsletter_batch
                        if ($pathinfo === '/admin/app/newsletter/batch') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\NewsletterCRUDController::batchAction',  '_sonata_admin' => 'admin.newsletter',  '_sonata_name' => 'admin_app_newsletter_batch',  '_route' => 'admin_app_newsletter_batch',);
                        }

                        // admin_app_newsletter_edit
                        if (preg_match('#^/admin/app/newsletter/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletter_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\NewsletterCRUDController::editAction',  '_sonata_admin' => 'admin.newsletter',  '_sonata_name' => 'admin_app_newsletter_edit',));
                        }

                        // admin_app_newsletter_delete
                        if (preg_match('#^/admin/app/newsletter/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletter_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\NewsletterCRUDController::deleteAction',  '_sonata_admin' => 'admin.newsletter',  '_sonata_name' => 'admin_app_newsletter_delete',));
                        }

                        // admin_app_newsletter_send
                        if (preg_match('#^/admin/app/newsletter/(?P<id>[^/]++)/send$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletter_send')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\NewsletterCRUDController::sendAction',  '_sonata_admin' => 'admin.newsletter',  '_sonata_name' => 'admin_app_newsletter_send',));
                        }

                        // admin_app_newsletter_test
                        if (preg_match('#^/admin/app/newsletter/(?P<id>[^/]++)/test$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletter_test')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\NewsletterCRUDController::testAction',  '_sonata_admin' => 'admin.newsletter',  '_sonata_name' => 'admin_app_newsletter_test',));
                        }

                        // admin_app_newsletter_preview_with_general_posts
                        if (preg_match('#^/admin/app/newsletter/(?P<id>[^/]++)/preview\\-with\\-general\\-posts$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletter_preview_with_general_posts')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\NewsletterCRUDController::previewWithGeneralPostsAction',  '_sonata_admin' => 'admin.newsletter',  '_sonata_name' => 'admin_app_newsletter_preview_with_general_posts',));
                        }

                        // admin_app_newsletter_preview_with_custom_posts
                        if (preg_match('#^/admin/app/newsletter/(?P<id>[^/]++)/preview\\-with\\-custom\\-posts$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletter_preview_with_custom_posts')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\NewsletterCRUDController::previewWithCustomPostsAction',  '_sonata_admin' => 'admin.newsletter',  '_sonata_name' => 'admin_app_newsletter_preview_with_custom_posts',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/unsubscribereason')) {
                        // admin_app_unsubscribereason_list
                        if ($pathinfo === '/admin/app/unsubscribereason/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.newsletter.unsubscribe_reason',  '_sonata_name' => 'admin_app_unsubscribereason_list',  '_route' => 'admin_app_unsubscribereason_list',);
                        }

                        // admin_app_unsubscribereason_batch
                        if ($pathinfo === '/admin/app/unsubscribereason/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.newsletter.unsubscribe_reason',  '_sonata_name' => 'admin_app_unsubscribereason_batch',  '_route' => 'admin_app_unsubscribereason_batch',);
                        }

                        // admin_app_unsubscribereason_edit
                        if (preg_match('#^/admin/app/unsubscribereason/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_unsubscribereason_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.newsletter.unsubscribe_reason',  '_sonata_name' => 'admin_app_unsubscribereason_edit',));
                        }

                        // admin_app_unsubscribereason_show
                        if (preg_match('#^/admin/app/unsubscribereason/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_unsubscribereason_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.newsletter.unsubscribe_reason',  '_sonata_name' => 'admin_app_unsubscribereason_show',));
                        }

                        // admin_app_unsubscribereason_export
                        if ($pathinfo === '/admin/app/unsubscribereason/export') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.newsletter.unsubscribe_reason',  '_sonata_name' => 'admin_app_unsubscribereason_export',  '_route' => 'admin_app_unsubscribereason_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/emailsubscription')) {
                        // admin_app_emailsubscription_list
                        if ($pathinfo === '/admin/app/emailsubscription/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.emai_subscription',  '_sonata_name' => 'admin_app_emailsubscription_list',  '_route' => 'admin_app_emailsubscription_list',);
                        }

                        // admin_app_emailsubscription_create
                        if ($pathinfo === '/admin/app/emailsubscription/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.emai_subscription',  '_sonata_name' => 'admin_app_emailsubscription_create',  '_route' => 'admin_app_emailsubscription_create',);
                        }

                        // admin_app_emailsubscription_batch
                        if ($pathinfo === '/admin/app/emailsubscription/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.emai_subscription',  '_sonata_name' => 'admin_app_emailsubscription_batch',  '_route' => 'admin_app_emailsubscription_batch',);
                        }

                        // admin_app_emailsubscription_edit
                        if (preg_match('#^/admin/app/emailsubscription/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_emailsubscription_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.emai_subscription',  '_sonata_name' => 'admin_app_emailsubscription_edit',));
                        }

                        // admin_app_emailsubscription_delete
                        if (preg_match('#^/admin/app/emailsubscription/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_emailsubscription_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.emai_subscription',  '_sonata_name' => 'admin_app_emailsubscription_delete',));
                        }

                        // admin_app_emailsubscription_show
                        if (preg_match('#^/admin/app/emailsubscription/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_emailsubscription_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.emai_subscription',  '_sonata_name' => 'admin_app_emailsubscription_show',));
                        }

                        // admin_app_emailsubscription_export
                        if ($pathinfo === '/admin/app/emailsubscription/export') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.emai_subscription',  '_sonata_name' => 'admin_app_emailsubscription_export',  '_route' => 'admin_app_emailsubscription_export',);
                        }

                    }

                }

                if (0 === strpos($pathinfo, '/admin/fos/comment/thread')) {
                    // admin_fos_comment_thread_list
                    if ($pathinfo === '/admin/fos/comment/thread/list') {
                        return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ThreadCRUDController::listAction',  '_sonata_admin' => 'admin.thread',  '_sonata_name' => 'admin_fos_comment_thread_list',  '_route' => 'admin_fos_comment_thread_list',);
                    }

                    // admin_fos_comment_thread_batch
                    if ($pathinfo === '/admin/fos/comment/thread/batch') {
                        return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ThreadCRUDController::batchAction',  '_sonata_admin' => 'admin.thread',  '_sonata_name' => 'admin_fos_comment_thread_batch',  '_route' => 'admin_fos_comment_thread_batch',);
                    }

                    // admin_fos_comment_thread_edit
                    if (preg_match('#^/admin/fos/comment/thread/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_thread_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ThreadCRUDController::editAction',  '_sonata_admin' => 'admin.thread',  '_sonata_name' => 'admin_fos_comment_thread_edit',));
                    }

                    // admin_fos_comment_thread_delete
                    if (preg_match('#^/admin/fos/comment/thread/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_thread_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ThreadCRUDController::deleteAction',  '_sonata_admin' => 'admin.thread',  '_sonata_name' => 'admin_fos_comment_thread_delete',));
                    }

                    // admin_fos_comment_thread_show
                    if (preg_match('#^/admin/fos/comment/thread/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_thread_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ThreadCRUDController::showAction',  '_sonata_admin' => 'admin.thread',  '_sonata_name' => 'admin_fos_comment_thread_show',));
                    }

                    // admin_fos_comment_thread_comment_list
                    if (preg_match('#^/admin/fos/comment/thread/(?P<id>[^/]++)/comment/list$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_thread_comment_list')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.thread|admin.comment',  '_sonata_name' => 'admin_fos_comment_thread_comment_list',));
                    }

                    // admin_fos_comment_thread_comment_create
                    if (preg_match('#^/admin/fos/comment/thread/(?P<id>[^/]++)/comment/create$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_thread_comment_create')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.thread|admin.comment',  '_sonata_name' => 'admin_fos_comment_thread_comment_create',));
                    }

                    // admin_fos_comment_thread_comment_batch
                    if (preg_match('#^/admin/fos/comment/thread/(?P<id>[^/]++)/comment/batch$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_thread_comment_batch')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.thread|admin.comment',  '_sonata_name' => 'admin_fos_comment_thread_comment_batch',));
                    }

                    // admin_fos_comment_thread_comment_edit
                    if (preg_match('#^/admin/fos/comment/thread/(?P<id>[^/]++)/comment/(?P<childId>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_thread_comment_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.thread|admin.comment',  '_sonata_name' => 'admin_fos_comment_thread_comment_edit',));
                    }

                    // admin_fos_comment_thread_comment_delete
                    if (preg_match('#^/admin/fos/comment/thread/(?P<id>[^/]++)/comment/(?P<childId>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_thread_comment_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.thread|admin.comment',  '_sonata_name' => 'admin_fos_comment_thread_comment_delete',));
                    }

                    // admin_fos_comment_thread_comment_show
                    if (preg_match('#^/admin/fos/comment/thread/(?P<id>[^/]++)/comment/(?P<childId>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_thread_comment_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.thread|admin.comment',  '_sonata_name' => 'admin_fos_comment_thread_comment_show',));
                    }

                    // admin_fos_comment_thread_comment_export
                    if (preg_match('#^/admin/fos/comment/thread/(?P<id>[^/]++)/comment/export$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_thread_comment_export')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.thread|admin.comment',  '_sonata_name' => 'admin_fos_comment_thread_comment_export',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/app/appeal')) {
                    // admin_app_appeal_list
                    if ($pathinfo === '/admin/app/appeal/list') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'app.admin.appeal',  '_sonata_name' => 'admin_app_appeal_list',  '_route' => 'admin_app_appeal_list',);
                    }

                    // admin_app_appeal_create
                    if ($pathinfo === '/admin/app/appeal/create') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'app.admin.appeal',  '_sonata_name' => 'admin_app_appeal_create',  '_route' => 'admin_app_appeal_create',);
                    }

                    // admin_app_appeal_batch
                    if ($pathinfo === '/admin/app/appeal/batch') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'app.admin.appeal',  '_sonata_name' => 'admin_app_appeal_batch',  '_route' => 'admin_app_appeal_batch',);
                    }

                    // admin_app_appeal_edit
                    if (preg_match('#^/admin/app/appeal/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_appeal_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'app.admin.appeal',  '_sonata_name' => 'admin_app_appeal_edit',));
                    }

                    // admin_app_appeal_delete
                    if (preg_match('#^/admin/app/appeal/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_appeal_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'app.admin.appeal',  '_sonata_name' => 'admin_app_appeal_delete',));
                    }

                    // admin_app_appeal_show
                    if (preg_match('#^/admin/app/appeal/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_appeal_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'app.admin.appeal',  '_sonata_name' => 'admin_app_appeal_show',));
                    }

                    // admin_app_appeal_export
                    if ($pathinfo === '/admin/app/appeal/export') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'app.admin.appeal',  '_sonata_name' => 'admin_app_appeal_export',  '_route' => 'admin_app_appeal_export',);
                    }

                }

                if (0 === strpos($pathinfo, '/admin/fos/comment/comment')) {
                    // admin_fos_comment_comment_list
                    if ($pathinfo === '/admin/fos/comment/comment/list') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.comment',  '_sonata_name' => 'admin_fos_comment_comment_list',  '_route' => 'admin_fos_comment_comment_list',);
                    }

                    // admin_fos_comment_comment_create
                    if ($pathinfo === '/admin/fos/comment/comment/create') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.comment',  '_sonata_name' => 'admin_fos_comment_comment_create',  '_route' => 'admin_fos_comment_comment_create',);
                    }

                    // admin_fos_comment_comment_batch
                    if ($pathinfo === '/admin/fos/comment/comment/batch') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.comment',  '_sonata_name' => 'admin_fos_comment_comment_batch',  '_route' => 'admin_fos_comment_comment_batch',);
                    }

                    // admin_fos_comment_comment_edit
                    if (preg_match('#^/admin/fos/comment/comment/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_comment_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.comment',  '_sonata_name' => 'admin_fos_comment_comment_edit',));
                    }

                    // admin_fos_comment_comment_delete
                    if (preg_match('#^/admin/fos/comment/comment/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_comment_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.comment',  '_sonata_name' => 'admin_fos_comment_comment_delete',));
                    }

                    // admin_fos_comment_comment_show
                    if (preg_match('#^/admin/fos/comment/comment/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_fos_comment_comment_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.comment',  '_sonata_name' => 'admin_fos_comment_comment_show',));
                    }

                    // admin_fos_comment_comment_export
                    if ($pathinfo === '/admin/fos/comment/comment/export') {
                        return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.comment',  '_sonata_name' => 'admin_fos_comment_comment_export',  '_route' => 'admin_fos_comment_comment_export',);
                    }

                }

                if (0 === strpos($pathinfo, '/admin/app')) {
                    if (0 === strpos($pathinfo, '/admin/app/gallerypicks')) {
                        // admin_app_gallerypicks_list
                        if ($pathinfo === '/admin/app/gallerypicks/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.gallery_picks',  '_sonata_name' => 'admin_app_gallerypicks_list',  '_route' => 'admin_app_gallerypicks_list',);
                        }

                        // admin_app_gallerypicks_edit
                        if (preg_match('#^/admin/app/gallerypicks/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_gallerypicks_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.gallery_picks',  '_sonata_name' => 'admin_app_gallerypicks_edit',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/videopicks')) {
                        // admin_app_videopicks_list
                        if ($pathinfo === '/admin/app/videopicks/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.video_picks',  '_sonata_name' => 'admin_app_videopicks_list',  '_route' => 'admin_app_videopicks_list',);
                        }

                        // admin_app_videopicks_edit
                        if (preg_match('#^/admin/app/videopicks/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_videopicks_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.video_picks',  '_sonata_name' => 'admin_app_videopicks_edit',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/draft')) {
                        // admin_app_draft_list
                        if ($pathinfo === '/admin/app/draft/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.draft',  '_sonata_name' => 'admin_app_draft_list',  '_route' => 'admin_app_draft_list',);
                        }

                        // admin_app_draft_batch
                        if ($pathinfo === '/admin/app/draft/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.draft',  '_sonata_name' => 'admin_app_draft_batch',  '_route' => 'admin_app_draft_batch',);
                        }

                        // admin_app_draft_edit
                        if (preg_match('#^/admin/app/draft/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_draft_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.draft',  '_sonata_name' => 'admin_app_draft_edit',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/rubric')) {
                        // admin_app_rubric_list
                        if ($pathinfo === '/admin/app/rubric/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.article_rubrics',  '_sonata_name' => 'admin_app_rubric_list',  '_route' => 'admin_app_rubric_list',);
                        }

                        // admin_app_rubric_create
                        if ($pathinfo === '/admin/app/rubric/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.article_rubrics',  '_sonata_name' => 'admin_app_rubric_create',  '_route' => 'admin_app_rubric_create',);
                        }

                        // admin_app_rubric_batch
                        if ($pathinfo === '/admin/app/rubric/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.article_rubrics',  '_sonata_name' => 'admin_app_rubric_batch',  '_route' => 'admin_app_rubric_batch',);
                        }

                        // admin_app_rubric_edit
                        if (preg_match('#^/admin/app/rubric/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_rubric_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.article_rubrics',  '_sonata_name' => 'admin_app_rubric_edit',));
                        }

                        // admin_app_rubric_delete
                        if (preg_match('#^/admin/app/rubric/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_rubric_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.article_rubrics',  '_sonata_name' => 'admin_app_rubric_delete',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/organizationdirectory')) {
                        // admin_app_organizationdirectory_list
                        if ($pathinfo === '/admin/app/organizationdirectory/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.organization_directory',  '_sonata_name' => 'admin_app_organizationdirectory_list',  '_route' => 'admin_app_organizationdirectory_list',);
                        }

                        // admin_app_organizationdirectory_create
                        if ($pathinfo === '/admin/app/organizationdirectory/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.organization_directory',  '_sonata_name' => 'admin_app_organizationdirectory_create',  '_route' => 'admin_app_organizationdirectory_create',);
                        }

                        // admin_app_organizationdirectory_batch
                        if ($pathinfo === '/admin/app/organizationdirectory/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.organization_directory',  '_sonata_name' => 'admin_app_organizationdirectory_batch',  '_route' => 'admin_app_organizationdirectory_batch',);
                        }

                        // admin_app_organizationdirectory_edit
                        if (preg_match('#^/admin/app/organizationdirectory/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_organizationdirectory_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.organization_directory',  '_sonata_name' => 'admin_app_organizationdirectory_edit',));
                        }

                        // admin_app_organizationdirectory_delete
                        if (preg_match('#^/admin/app/organizationdirectory/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_organizationdirectory_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.organization_directory',  '_sonata_name' => 'admin_app_organizationdirectory_delete',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/contactperson')) {
                        // admin_app_contactperson_list
                        if ($pathinfo === '/admin/app/contactperson/list') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::listAction',  '_sonata_admin' => 'admin.contact_person',  '_sonata_name' => 'admin_app_contactperson_list',  '_route' => 'admin_app_contactperson_list',);
                        }

                        // admin_app_contactperson_create
                        if ($pathinfo === '/admin/app/contactperson/create') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::createAction',  '_sonata_admin' => 'admin.contact_person',  '_sonata_name' => 'admin_app_contactperson_create',  '_route' => 'admin_app_contactperson_create',);
                        }

                        // admin_app_contactperson_batch
                        if ($pathinfo === '/admin/app/contactperson/batch') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::batchAction',  '_sonata_admin' => 'admin.contact_person',  '_sonata_name' => 'admin_app_contactperson_batch',  '_route' => 'admin_app_contactperson_batch',);
                        }

                        // admin_app_contactperson_edit
                        if (preg_match('#^/admin/app/contactperson/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_contactperson_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::editAction',  '_sonata_admin' => 'admin.contact_person',  '_sonata_name' => 'admin_app_contactperson_edit',));
                        }

                        // admin_app_contactperson_delete
                        if (preg_match('#^/admin/app/contactperson/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_contactperson_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::deleteAction',  '_sonata_admin' => 'admin.contact_person',  '_sonata_name' => 'admin_app_contactperson_delete',));
                        }

                        // admin_app_contactperson_show
                        if (preg_match('#^/admin/app/contactperson/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_contactperson_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::showAction',  '_sonata_admin' => 'admin.contact_person',  '_sonata_name' => 'admin_app_contactperson_show',));
                        }

                        // admin_app_contactperson_export
                        if ($pathinfo === '/admin/app/contactperson/export') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::exportAction',  '_sonata_admin' => 'admin.contact_person',  '_sonata_name' => 'admin_app_contactperson_export',  '_route' => 'admin_app_contactperson_export',);
                        }

                        // admin_app_contactperson_browse
                        if ($pathinfo === '/admin/app/contactperson/browse') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::browseAction',  '_sonata_admin' => 'admin.contact_person',  '_sonata_name' => 'admin_app_contactperson_browse',  '_route' => 'admin_app_contactperson_browse',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/organization')) {
                        // admin_app_organization_list
                        if ($pathinfo === '/admin/app/organization/list') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::listAction',  '_sonata_admin' => 'admin.organization',  '_sonata_name' => 'admin_app_organization_list',  '_route' => 'admin_app_organization_list',);
                        }

                        // admin_app_organization_create
                        if ($pathinfo === '/admin/app/organization/create') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::createAction',  '_sonata_admin' => 'admin.organization',  '_sonata_name' => 'admin_app_organization_create',  '_route' => 'admin_app_organization_create',);
                        }

                        // admin_app_organization_batch
                        if ($pathinfo === '/admin/app/organization/batch') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::batchAction',  '_sonata_admin' => 'admin.organization',  '_sonata_name' => 'admin_app_organization_batch',  '_route' => 'admin_app_organization_batch',);
                        }

                        // admin_app_organization_edit
                        if (preg_match('#^/admin/app/organization/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_organization_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::editAction',  '_sonata_admin' => 'admin.organization',  '_sonata_name' => 'admin_app_organization_edit',));
                        }

                        // admin_app_organization_delete
                        if (preg_match('#^/admin/app/organization/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_organization_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::deleteAction',  '_sonata_admin' => 'admin.organization',  '_sonata_name' => 'admin_app_organization_delete',));
                        }

                        // admin_app_organization_show
                        if (preg_match('#^/admin/app/organization/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_organization_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::showAction',  '_sonata_admin' => 'admin.organization',  '_sonata_name' => 'admin_app_organization_show',));
                        }

                        // admin_app_organization_export
                        if ($pathinfo === '/admin/app/organization/export') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::exportAction',  '_sonata_admin' => 'admin.organization',  '_sonata_name' => 'admin_app_organization_export',  '_route' => 'admin_app_organization_export',);
                        }

                        // admin_app_organization_browse
                        if ($pathinfo === '/admin/app/organization/browse') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BrowsableController::browseAction',  '_sonata_admin' => 'admin.organization',  '_sonata_name' => 'admin_app_organization_browse',  '_route' => 'admin_app_organization_browse',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/actionlog')) {
                        // admin_app_actionlog_list
                        if ($pathinfo === '/admin/app/actionlog/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.action_log',  '_sonata_name' => 'admin_app_actionlog_list',  '_route' => 'admin_app_actionlog_list',);
                        }

                        // admin_app_actionlog_create
                        if ($pathinfo === '/admin/app/actionlog/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.action_log',  '_sonata_name' => 'admin_app_actionlog_create',  '_route' => 'admin_app_actionlog_create',);
                        }

                        // admin_app_actionlog_batch
                        if ($pathinfo === '/admin/app/actionlog/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.action_log',  '_sonata_name' => 'admin_app_actionlog_batch',  '_route' => 'admin_app_actionlog_batch',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/documentrubric')) {
                        // admin_app_documentrubric_list
                        if ($pathinfo === '/admin/app/documentrubric/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.document_rubric',  '_sonata_name' => 'admin_app_documentrubric_list',  '_route' => 'admin_app_documentrubric_list',);
                        }

                        // admin_app_documentrubric_create
                        if ($pathinfo === '/admin/app/documentrubric/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.document_rubric',  '_sonata_name' => 'admin_app_documentrubric_create',  '_route' => 'admin_app_documentrubric_create',);
                        }

                        // admin_app_documentrubric_batch
                        if ($pathinfo === '/admin/app/documentrubric/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.document_rubric',  '_sonata_name' => 'admin_app_documentrubric_batch',  '_route' => 'admin_app_documentrubric_batch',);
                        }

                        // admin_app_documentrubric_edit
                        if (preg_match('#^/admin/app/documentrubric/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_documentrubric_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.document_rubric',  '_sonata_name' => 'admin_app_documentrubric_edit',));
                        }

                        // admin_app_documentrubric_delete
                        if (preg_match('#^/admin/app/documentrubric/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_documentrubric_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.document_rubric',  '_sonata_name' => 'admin_app_documentrubric_delete',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/errorreport')) {
                        // admin_app_errorreport_list
                        if ($pathinfo === '/admin/app/errorreport/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.error_report',  '_sonata_name' => 'admin_app_errorreport_list',  '_route' => 'admin_app_errorreport_list',);
                        }

                        // admin_app_errorreport_create
                        if ($pathinfo === '/admin/app/errorreport/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.error_report',  '_sonata_name' => 'admin_app_errorreport_create',  '_route' => 'admin_app_errorreport_create',);
                        }

                        // admin_app_errorreport_batch
                        if ($pathinfo === '/admin/app/errorreport/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.error_report',  '_sonata_name' => 'admin_app_errorreport_batch',  '_route' => 'admin_app_errorreport_batch',);
                        }

                        // admin_app_errorreport_edit
                        if (preg_match('#^/admin/app/errorreport/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_errorreport_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.error_report',  '_sonata_name' => 'admin_app_errorreport_edit',));
                        }

                        // admin_app_errorreport_delete
                        if (preg_match('#^/admin/app/errorreport/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_errorreport_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.error_report',  '_sonata_name' => 'admin_app_errorreport_delete',));
                        }

                        // admin_app_errorreport_show
                        if (preg_match('#^/admin/app/errorreport/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_errorreport_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.error_report',  '_sonata_name' => 'admin_app_errorreport_show',));
                        }

                        // admin_app_errorreport_export
                        if ($pathinfo === '/admin/app/errorreport/export') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.error_report',  '_sonata_name' => 'admin_app_errorreport_export',  '_route' => 'admin_app_errorreport_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/a')) {
                        if (0 === strpos($pathinfo, '/admin/app/author')) {
                            // admin_app_author_list
                            if ($pathinfo === '/admin/app/author/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.author',  '_sonata_name' => 'admin_app_author_list',  '_route' => 'admin_app_author_list',);
                            }

                            // admin_app_author_create
                            if ($pathinfo === '/admin/app/author/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.author',  '_sonata_name' => 'admin_app_author_create',  '_route' => 'admin_app_author_create',);
                            }

                            // admin_app_author_batch
                            if ($pathinfo === '/admin/app/author/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.author',  '_sonata_name' => 'admin_app_author_batch',  '_route' => 'admin_app_author_batch',);
                            }

                            // admin_app_author_edit
                            if (preg_match('#^/admin/app/author/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_author_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.author',  '_sonata_name' => 'admin_app_author_edit',));
                            }

                            // admin_app_author_delete
                            if (preg_match('#^/admin/app/author/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_author_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.author',  '_sonata_name' => 'admin_app_author_delete',));
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/articlesource')) {
                            // admin_app_articlesource_list
                            if ($pathinfo === '/admin/app/articlesource/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.article_source',  '_sonata_name' => 'admin_app_articlesource_list',  '_route' => 'admin_app_articlesource_list',);
                            }

                            // admin_app_articlesource_create
                            if ($pathinfo === '/admin/app/articlesource/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.article_source',  '_sonata_name' => 'admin_app_articlesource_create',  '_route' => 'admin_app_articlesource_create',);
                            }

                            // admin_app_articlesource_batch
                            if ($pathinfo === '/admin/app/articlesource/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.article_source',  '_sonata_name' => 'admin_app_articlesource_batch',  '_route' => 'admin_app_articlesource_batch',);
                            }

                            // admin_app_articlesource_edit
                            if (preg_match('#^/admin/app/articlesource/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_articlesource_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.article_source',  '_sonata_name' => 'admin_app_articlesource_edit',));
                            }

                            // admin_app_articlesource_delete
                            if (preg_match('#^/admin/app/articlesource/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_articlesource_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.article_source',  '_sonata_name' => 'admin_app_articlesource_delete',));
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/userrole')) {
                        // admin_app_userrole_list
                        if ($pathinfo === '/admin/app/userrole/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.user_role',  '_sonata_name' => 'admin_app_userrole_list',  '_route' => 'admin_app_userrole_list',);
                        }

                        // admin_app_userrole_edit
                        if (preg_match('#^/admin/app/userrole/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_userrole_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.user_role',  '_sonata_name' => 'admin_app_userrole_edit',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/metro')) {
                        if (0 === strpos($pathinfo, '/admin/app/metroline')) {
                            // admin_app_metroline_list
                            if ($pathinfo === '/admin/app/metroline/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.metro_line',  '_sonata_name' => 'admin_app_metroline_list',  '_route' => 'admin_app_metroline_list',);
                            }

                            // admin_app_metroline_create
                            if ($pathinfo === '/admin/app/metroline/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.metro_line',  '_sonata_name' => 'admin_app_metroline_create',  '_route' => 'admin_app_metroline_create',);
                            }

                            // admin_app_metroline_batch
                            if ($pathinfo === '/admin/app/metroline/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.metro_line',  '_sonata_name' => 'admin_app_metroline_batch',  '_route' => 'admin_app_metroline_batch',);
                            }

                            // admin_app_metroline_edit
                            if (preg_match('#^/admin/app/metroline/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_metroline_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.metro_line',  '_sonata_name' => 'admin_app_metroline_edit',));
                            }

                            // admin_app_metroline_delete
                            if (preg_match('#^/admin/app/metroline/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_metroline_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.metro_line',  '_sonata_name' => 'admin_app_metroline_delete',));
                            }

                            // admin_app_metroline_show
                            if (preg_match('#^/admin/app/metroline/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_metroline_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.metro_line',  '_sonata_name' => 'admin_app_metroline_show',));
                            }

                            // admin_app_metroline_export
                            if ($pathinfo === '/admin/app/metroline/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.metro_line',  '_sonata_name' => 'admin_app_metroline_export',  '_route' => 'admin_app_metroline_export',);
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/metrostation')) {
                            // admin_app_metrostation_list
                            if ($pathinfo === '/admin/app/metrostation/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.metro_station',  '_sonata_name' => 'admin_app_metrostation_list',  '_route' => 'admin_app_metrostation_list',);
                            }

                            // admin_app_metrostation_create
                            if ($pathinfo === '/admin/app/metrostation/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.metro_station',  '_sonata_name' => 'admin_app_metrostation_create',  '_route' => 'admin_app_metrostation_create',);
                            }

                            // admin_app_metrostation_batch
                            if ($pathinfo === '/admin/app/metrostation/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.metro_station',  '_sonata_name' => 'admin_app_metrostation_batch',  '_route' => 'admin_app_metrostation_batch',);
                            }

                            // admin_app_metrostation_edit
                            if (preg_match('#^/admin/app/metrostation/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_metrostation_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.metro_station',  '_sonata_name' => 'admin_app_metrostation_edit',));
                            }

                            // admin_app_metrostation_delete
                            if (preg_match('#^/admin/app/metrostation/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_metrostation_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.metro_station',  '_sonata_name' => 'admin_app_metrostation_delete',));
                            }

                            // admin_app_metrostation_show
                            if (preg_match('#^/admin/app/metrostation/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_metrostation_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.metro_station',  '_sonata_name' => 'admin_app_metrostation_show',));
                            }

                            // admin_app_metrostation_export
                            if ($pathinfo === '/admin/app/metrostation/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.metro_station',  '_sonata_name' => 'admin_app_metrostation_export',  '_route' => 'admin_app_metrostation_export',);
                            }

                            if (0 === strpos($pathinfo, '/admin/app/metrostationimage')) {
                                // admin_app_metrostationimage_list
                                if ($pathinfo === '/admin/app/metrostationimage/list') {
                                    return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.metro_station_image',  '_sonata_name' => 'admin_app_metrostationimage_list',  '_route' => 'admin_app_metrostationimage_list',);
                                }

                                // admin_app_metrostationimage_create
                                if ($pathinfo === '/admin/app/metrostationimage/create') {
                                    return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.metro_station_image',  '_sonata_name' => 'admin_app_metrostationimage_create',  '_route' => 'admin_app_metrostationimage_create',);
                                }

                                // admin_app_metrostationimage_batch
                                if ($pathinfo === '/admin/app/metrostationimage/batch') {
                                    return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.metro_station_image',  '_sonata_name' => 'admin_app_metrostationimage_batch',  '_route' => 'admin_app_metrostationimage_batch',);
                                }

                                // admin_app_metrostationimage_edit
                                if (preg_match('#^/admin/app/metrostationimage/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_metrostationimage_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.metro_station_image',  '_sonata_name' => 'admin_app_metrostationimage_edit',));
                                }

                                // admin_app_metrostationimage_delete
                                if (preg_match('#^/admin/app/metrostationimage/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_metrostationimage_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.metro_station_image',  '_sonata_name' => 'admin_app_metrostationimage_delete',));
                                }

                                // admin_app_metrostationimage_show
                                if (preg_match('#^/admin/app/metrostationimage/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_metrostationimage_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.metro_station_image',  '_sonata_name' => 'admin_app_metrostationimage_show',));
                                }

                                // admin_app_metrostationimage_export
                                if ($pathinfo === '/admin/app/metrostationimage/export') {
                                    return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.metro_station_image',  '_sonata_name' => 'admin_app_metrostationimage_export',  '_route' => 'admin_app_metrostationimage_export',);
                                }

                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/metrotimelineyear')) {
                            // admin_app_metrotimelineyear_list
                            if ($pathinfo === '/admin/app/metrotimelineyear/list') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\MetroTimelineYearCRUDController::listAction',  '_sonata_admin' => 'admin.metro_timeline_year',  '_sonata_name' => 'admin_app_metrotimelineyear_list',  '_route' => 'admin_app_metrotimelineyear_list',);
                            }

                            // admin_app_metrotimelineyear_create
                            if ($pathinfo === '/admin/app/metrotimelineyear/create') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\MetroTimelineYearCRUDController::createAction',  '_sonata_admin' => 'admin.metro_timeline_year',  '_sonata_name' => 'admin_app_metrotimelineyear_create',  '_route' => 'admin_app_metrotimelineyear_create',);
                            }

                            // admin_app_metrotimelineyear_batch
                            if ($pathinfo === '/admin/app/metrotimelineyear/batch') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\MetroTimelineYearCRUDController::batchAction',  '_sonata_admin' => 'admin.metro_timeline_year',  '_sonata_name' => 'admin_app_metrotimelineyear_batch',  '_route' => 'admin_app_metrotimelineyear_batch',);
                            }

                            // admin_app_metrotimelineyear_edit
                            if (preg_match('#^/admin/app/metrotimelineyear/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_metrotimelineyear_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\MetroTimelineYearCRUDController::editAction',  '_sonata_admin' => 'admin.metro_timeline_year',  '_sonata_name' => 'admin_app_metrotimelineyear_edit',));
                            }

                            // admin_app_metrotimelineyear_delete
                            if (preg_match('#^/admin/app/metrotimelineyear/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_metrotimelineyear_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\MetroTimelineYearCRUDController::deleteAction',  '_sonata_admin' => 'admin.metro_timeline_year',  '_sonata_name' => 'admin_app_metrotimelineyear_delete',));
                            }

                            // admin_app_metrotimelineyear_show
                            if (preg_match('#^/admin/app/metrotimelineyear/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_metrotimelineyear_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\MetroTimelineYearCRUDController::showAction',  '_sonata_admin' => 'admin.metro_timeline_year',  '_sonata_name' => 'admin_app_metrotimelineyear_show',));
                            }

                            // admin_app_metrotimelineyear_export
                            if ($pathinfo === '/admin/app/metrotimelineyear/export') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\MetroTimelineYearCRUDController::exportAction',  '_sonata_admin' => 'admin.metro_timeline_year',  '_sonata_name' => 'admin_app_metrotimelineyear_export',  '_route' => 'admin_app_metrotimelineyear_export',);
                            }

                            // admin_app_metrotimelineyear_batch_upload
                            if ($pathinfo === '/admin/app/metrotimelineyear/batch_upload') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\MetroTimelineYearCRUDController::batchUploadAction',  '_sonata_admin' => 'admin.metro_timeline_year',  '_sonata_name' => 'admin_app_metrotimelineyear_batch_upload',  '_route' => 'admin_app_metrotimelineyear_batch_upload',);
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/road')) {
                        // admin_app_road_list
                        if ($pathinfo === '/admin/app/road/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.road',  '_sonata_name' => 'admin_app_road_list',  '_route' => 'admin_app_road_list',);
                        }

                        // admin_app_road_create
                        if ($pathinfo === '/admin/app/road/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.road',  '_sonata_name' => 'admin_app_road_create',  '_route' => 'admin_app_road_create',);
                        }

                        // admin_app_road_batch
                        if ($pathinfo === '/admin/app/road/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.road',  '_sonata_name' => 'admin_app_road_batch',  '_route' => 'admin_app_road_batch',);
                        }

                        // admin_app_road_edit
                        if (preg_match('#^/admin/app/road/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_road_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.road',  '_sonata_name' => 'admin_app_road_edit',));
                        }

                        // admin_app_road_delete
                        if (preg_match('#^/admin/app/road/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_road_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.road',  '_sonata_name' => 'admin_app_road_delete',));
                        }

                        // admin_app_road_show
                        if (preg_match('#^/admin/app/road/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_road_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.road',  '_sonata_name' => 'admin_app_road_show',));
                        }

                        // admin_app_road_export
                        if ($pathinfo === '/admin/app/road/export') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.road',  '_sonata_name' => 'admin_app_road_export',  '_route' => 'admin_app_road_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/destruction')) {
                        // admin_app_destruction_list
                        if ($pathinfo === '/admin/app/destruction/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.destruction',  '_sonata_name' => 'admin_app_destruction_list',  '_route' => 'admin_app_destruction_list',);
                        }

                        // admin_app_destruction_create
                        if ($pathinfo === '/admin/app/destruction/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.destruction',  '_sonata_name' => 'admin_app_destruction_create',  '_route' => 'admin_app_destruction_create',);
                        }

                        // admin_app_destruction_batch
                        if ($pathinfo === '/admin/app/destruction/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.destruction',  '_sonata_name' => 'admin_app_destruction_batch',  '_route' => 'admin_app_destruction_batch',);
                        }

                        // admin_app_destruction_edit
                        if (preg_match('#^/admin/app/destruction/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_destruction_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.destruction',  '_sonata_name' => 'admin_app_destruction_edit',));
                        }

                        // admin_app_destruction_delete
                        if (preg_match('#^/admin/app/destruction/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_destruction_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.destruction',  '_sonata_name' => 'admin_app_destruction_delete',));
                        }

                        // admin_app_destruction_show
                        if (preg_match('#^/admin/app/destruction/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_destruction_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.destruction',  '_sonata_name' => 'admin_app_destruction_show',));
                        }

                        // admin_app_destruction_export
                        if ($pathinfo === '/admin/app/destruction/export') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.destruction',  '_sonata_name' => 'admin_app_destruction_export',  '_route' => 'admin_app_destruction_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/redirect')) {
                        // admin_app_redirect_list
                        if ($pathinfo === '/admin/app/redirect/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.redirect',  '_sonata_name' => 'admin_app_redirect_list',  '_route' => 'admin_app_redirect_list',);
                        }

                        // admin_app_redirect_create
                        if ($pathinfo === '/admin/app/redirect/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.redirect',  '_sonata_name' => 'admin_app_redirect_create',  '_route' => 'admin_app_redirect_create',);
                        }

                        // admin_app_redirect_batch
                        if ($pathinfo === '/admin/app/redirect/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.redirect',  '_sonata_name' => 'admin_app_redirect_batch',  '_route' => 'admin_app_redirect_batch',);
                        }

                        // admin_app_redirect_edit
                        if (preg_match('#^/admin/app/redirect/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_redirect_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.redirect',  '_sonata_name' => 'admin_app_redirect_edit',));
                        }

                        // admin_app_redirect_delete
                        if (preg_match('#^/admin/app/redirect/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_redirect_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.redirect',  '_sonata_name' => 'admin_app_redirect_delete',));
                        }

                        // admin_app_redirect_show
                        if (preg_match('#^/admin/app/redirect/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_redirect_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.redirect',  '_sonata_name' => 'admin_app_redirect_show',));
                        }

                        // admin_app_redirect_export
                        if ($pathinfo === '/admin/app/redirect/export') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.redirect',  '_sonata_name' => 'admin_app_redirect_export',  '_route' => 'admin_app_redirect_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/mediacategory')) {
                        // admin_app_mediacategory_list
                        if ($pathinfo === '/admin/app/mediacategory/list') {
                            return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::listAction',  '_sonata_admin' => 'admin.media_category',  '_sonata_name' => 'admin_app_mediacategory_list',  '_route' => 'admin_app_mediacategory_list',);
                        }

                        // admin_app_mediacategory_create
                        if ($pathinfo === '/admin/app/mediacategory/create') {
                            return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::createAction',  '_sonata_admin' => 'admin.media_category',  '_sonata_name' => 'admin_app_mediacategory_create',  '_route' => 'admin_app_mediacategory_create',);
                        }

                        // admin_app_mediacategory_batch
                        if ($pathinfo === '/admin/app/mediacategory/batch') {
                            return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::batchAction',  '_sonata_admin' => 'admin.media_category',  '_sonata_name' => 'admin_app_mediacategory_batch',  '_route' => 'admin_app_mediacategory_batch',);
                        }

                        // admin_app_mediacategory_edit
                        if (preg_match('#^/admin/app/mediacategory/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_mediacategory_edit')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::editAction',  '_sonata_admin' => 'admin.media_category',  '_sonata_name' => 'admin_app_mediacategory_edit',));
                        }

                        // admin_app_mediacategory_delete
                        if (preg_match('#^/admin/app/mediacategory/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_mediacategory_delete')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::deleteAction',  '_sonata_admin' => 'admin.media_category',  '_sonata_name' => 'admin_app_mediacategory_delete',));
                        }

                        // admin_app_mediacategory_show
                        if (preg_match('#^/admin/app/mediacategory/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_mediacategory_show')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::showAction',  '_sonata_admin' => 'admin.media_category',  '_sonata_name' => 'admin_app_mediacategory_show',));
                        }

                        // admin_app_mediacategory_export
                        if ($pathinfo === '/admin/app/mediacategory/export') {
                            return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::exportAction',  '_sonata_admin' => 'admin.media_category',  '_sonata_name' => 'admin_app_mediacategory_export',  '_route' => 'admin_app_mediacategory_export',);
                        }

                        // admin_app_mediacategory_move
                        if (preg_match('#^/admin/app/mediacategory/(?P<id>[^/]++)/move/(?P<direction>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_mediacategory_move')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::moveAction',  '_sonata_admin' => 'admin.media_category',  '_sonata_name' => 'admin_app_mediacategory_move',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/newsletteritem-')) {
                        if (0 === strpos($pathinfo, '/admin/app/newsletteritem-postnewsletter')) {
                            // admin_app_newsletteritem_postnewsletter_list
                            if ($pathinfo === '/admin/app/newsletteritem-postnewsletter/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.post_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_postnewsletter_list',  '_route' => 'admin_app_newsletteritem_postnewsletter_list',);
                            }

                            // admin_app_newsletteritem_postnewsletter_create
                            if ($pathinfo === '/admin/app/newsletteritem-postnewsletter/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.post_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_postnewsletter_create',  '_route' => 'admin_app_newsletteritem_postnewsletter_create',);
                            }

                            // admin_app_newsletteritem_postnewsletter_batch
                            if ($pathinfo === '/admin/app/newsletteritem-postnewsletter/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.post_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_postnewsletter_batch',  '_route' => 'admin_app_newsletteritem_postnewsletter_batch',);
                            }

                            // admin_app_newsletteritem_postnewsletter_edit
                            if (preg_match('#^/admin/app/newsletteritem\\-postnewsletter/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_postnewsletter_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.post_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_postnewsletter_edit',));
                            }

                            // admin_app_newsletteritem_postnewsletter_delete
                            if (preg_match('#^/admin/app/newsletteritem\\-postnewsletter/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_postnewsletter_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.post_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_postnewsletter_delete',));
                            }

                            // admin_app_newsletteritem_postnewsletter_show
                            if (preg_match('#^/admin/app/newsletteritem\\-postnewsletter/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_postnewsletter_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.post_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_postnewsletter_show',));
                            }

                            // admin_app_newsletteritem_postnewsletter_export
                            if ($pathinfo === '/admin/app/newsletteritem-postnewsletter/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.post_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_postnewsletter_export',  '_route' => 'admin_app_newsletteritem_postnewsletter_export',);
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/newsletteritem-gallerynewsletter')) {
                            // admin_app_newsletteritem_gallerynewsletter_list
                            if ($pathinfo === '/admin/app/newsletteritem-gallerynewsletter/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.gallery_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_gallerynewsletter_list',  '_route' => 'admin_app_newsletteritem_gallerynewsletter_list',);
                            }

                            // admin_app_newsletteritem_gallerynewsletter_create
                            if ($pathinfo === '/admin/app/newsletteritem-gallerynewsletter/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.gallery_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_gallerynewsletter_create',  '_route' => 'admin_app_newsletteritem_gallerynewsletter_create',);
                            }

                            // admin_app_newsletteritem_gallerynewsletter_batch
                            if ($pathinfo === '/admin/app/newsletteritem-gallerynewsletter/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.gallery_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_gallerynewsletter_batch',  '_route' => 'admin_app_newsletteritem_gallerynewsletter_batch',);
                            }

                            // admin_app_newsletteritem_gallerynewsletter_edit
                            if (preg_match('#^/admin/app/newsletteritem\\-gallerynewsletter/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_gallerynewsletter_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.gallery_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_gallerynewsletter_edit',));
                            }

                            // admin_app_newsletteritem_gallerynewsletter_delete
                            if (preg_match('#^/admin/app/newsletteritem\\-gallerynewsletter/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_gallerynewsletter_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.gallery_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_gallerynewsletter_delete',));
                            }

                            // admin_app_newsletteritem_gallerynewsletter_show
                            if (preg_match('#^/admin/app/newsletteritem\\-gallerynewsletter/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_gallerynewsletter_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.gallery_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_gallerynewsletter_show',));
                            }

                            // admin_app_newsletteritem_gallerynewsletter_export
                            if ($pathinfo === '/admin/app/newsletteritem-gallerynewsletter/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.gallery_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_gallerynewsletter_export',  '_route' => 'admin_app_newsletteritem_gallerynewsletter_export',);
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/newsletteritem-videonewsletter')) {
                            // admin_app_newsletteritem_videonewsletter_list
                            if ($pathinfo === '/admin/app/newsletteritem-videonewsletter/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.video_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_videonewsletter_list',  '_route' => 'admin_app_newsletteritem_videonewsletter_list',);
                            }

                            // admin_app_newsletteritem_videonewsletter_create
                            if ($pathinfo === '/admin/app/newsletteritem-videonewsletter/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.video_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_videonewsletter_create',  '_route' => 'admin_app_newsletteritem_videonewsletter_create',);
                            }

                            // admin_app_newsletteritem_videonewsletter_batch
                            if ($pathinfo === '/admin/app/newsletteritem-videonewsletter/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.video_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_videonewsletter_batch',  '_route' => 'admin_app_newsletteritem_videonewsletter_batch',);
                            }

                            // admin_app_newsletteritem_videonewsletter_edit
                            if (preg_match('#^/admin/app/newsletteritem\\-videonewsletter/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_videonewsletter_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.video_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_videonewsletter_edit',));
                            }

                            // admin_app_newsletteritem_videonewsletter_delete
                            if (preg_match('#^/admin/app/newsletteritem\\-videonewsletter/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_videonewsletter_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.video_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_videonewsletter_delete',));
                            }

                            // admin_app_newsletteritem_videonewsletter_show
                            if (preg_match('#^/admin/app/newsletteritem\\-videonewsletter/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_videonewsletter_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.video_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_videonewsletter_show',));
                            }

                            // admin_app_newsletteritem_videonewsletter_export
                            if ($pathinfo === '/admin/app/newsletteritem-videonewsletter/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.video_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_videonewsletter_export',  '_route' => 'admin_app_newsletteritem_videonewsletter_export',);
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/newsletteritem-infographicsnewsletter')) {
                            // admin_app_newsletteritem_infographicsnewsletter_list
                            if ($pathinfo === '/admin/app/newsletteritem-infographicsnewsletter/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.infographoics_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_infographicsnewsletter_list',  '_route' => 'admin_app_newsletteritem_infographicsnewsletter_list',);
                            }

                            // admin_app_newsletteritem_infographicsnewsletter_create
                            if ($pathinfo === '/admin/app/newsletteritem-infographicsnewsletter/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.infographoics_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_infographicsnewsletter_create',  '_route' => 'admin_app_newsletteritem_infographicsnewsletter_create',);
                            }

                            // admin_app_newsletteritem_infographicsnewsletter_batch
                            if ($pathinfo === '/admin/app/newsletteritem-infographicsnewsletter/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.infographoics_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_infographicsnewsletter_batch',  '_route' => 'admin_app_newsletteritem_infographicsnewsletter_batch',);
                            }

                            // admin_app_newsletteritem_infographicsnewsletter_edit
                            if (preg_match('#^/admin/app/newsletteritem\\-infographicsnewsletter/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_infographicsnewsletter_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.infographoics_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_infographicsnewsletter_edit',));
                            }

                            // admin_app_newsletteritem_infographicsnewsletter_delete
                            if (preg_match('#^/admin/app/newsletteritem\\-infographicsnewsletter/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_infographicsnewsletter_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.infographoics_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_infographicsnewsletter_delete',));
                            }

                            // admin_app_newsletteritem_infographicsnewsletter_show
                            if (preg_match('#^/admin/app/newsletteritem\\-infographicsnewsletter/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_infographicsnewsletter_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.infographoics_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_infographicsnewsletter_show',));
                            }

                            // admin_app_newsletteritem_infographicsnewsletter_export
                            if ($pathinfo === '/admin/app/newsletteritem-infographicsnewsletter/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.infographoics_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_infographicsnewsletter_export',  '_route' => 'admin_app_newsletteritem_infographicsnewsletter_export',);
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/newsletteritem-highlightnewsletter')) {
                            // admin_app_newsletteritem_highlightnewsletter_list
                            if ($pathinfo === '/admin/app/newsletteritem-highlightnewsletter/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.hightlight_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_highlightnewsletter_list',  '_route' => 'admin_app_newsletteritem_highlightnewsletter_list',);
                            }

                            // admin_app_newsletteritem_highlightnewsletter_create
                            if ($pathinfo === '/admin/app/newsletteritem-highlightnewsletter/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.hightlight_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_highlightnewsletter_create',  '_route' => 'admin_app_newsletteritem_highlightnewsletter_create',);
                            }

                            // admin_app_newsletteritem_highlightnewsletter_batch
                            if ($pathinfo === '/admin/app/newsletteritem-highlightnewsletter/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.hightlight_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_highlightnewsletter_batch',  '_route' => 'admin_app_newsletteritem_highlightnewsletter_batch',);
                            }

                            // admin_app_newsletteritem_highlightnewsletter_edit
                            if (preg_match('#^/admin/app/newsletteritem\\-highlightnewsletter/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_highlightnewsletter_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.hightlight_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_highlightnewsletter_edit',));
                            }

                            // admin_app_newsletteritem_highlightnewsletter_delete
                            if (preg_match('#^/admin/app/newsletteritem\\-highlightnewsletter/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_highlightnewsletter_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.hightlight_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_highlightnewsletter_delete',));
                            }

                            // admin_app_newsletteritem_highlightnewsletter_show
                            if (preg_match('#^/admin/app/newsletteritem\\-highlightnewsletter/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_newsletteritem_highlightnewsletter_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.hightlight_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_highlightnewsletter_show',));
                            }

                            // admin_app_newsletteritem_highlightnewsletter_export
                            if ($pathinfo === '/admin/app/newsletteritem-highlightnewsletter/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.hightlight_newsletter',  '_sonata_name' => 'admin_app_newsletteritem_highlightnewsletter_export',  '_route' => 'admin_app_newsletteritem_highlightnewsletter_export',);
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/announcement')) {
                        // admin_app_announcement_list
                        if ($pathinfo === '/admin/app/announcement/list') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\AnnouncementAdminCRUDController::listAction',  '_sonata_admin' => 'admin.announcement',  '_sonata_name' => 'admin_app_announcement_list',  '_route' => 'admin_app_announcement_list',);
                        }

                        // admin_app_announcement_create
                        if ($pathinfo === '/admin/app/announcement/create') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\AnnouncementAdminCRUDController::createAction',  '_sonata_admin' => 'admin.announcement',  '_sonata_name' => 'admin_app_announcement_create',  '_route' => 'admin_app_announcement_create',);
                        }

                        // admin_app_announcement_batch
                        if ($pathinfo === '/admin/app/announcement/batch') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\AnnouncementAdminCRUDController::batchAction',  '_sonata_admin' => 'admin.announcement',  '_sonata_name' => 'admin_app_announcement_batch',  '_route' => 'admin_app_announcement_batch',);
                        }

                        // admin_app_announcement_edit
                        if (preg_match('#^/admin/app/announcement/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_announcement_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\AnnouncementAdminCRUDController::editAction',  '_sonata_admin' => 'admin.announcement',  '_sonata_name' => 'admin_app_announcement_edit',));
                        }

                        // admin_app_announcement_delete
                        if (preg_match('#^/admin/app/announcement/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_announcement_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\AnnouncementAdminCRUDController::deleteAction',  '_sonata_admin' => 'admin.announcement',  '_sonata_name' => 'admin_app_announcement_delete',));
                        }

                        // admin_app_announcement_show
                        if (preg_match('#^/admin/app/announcement/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_announcement_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\AnnouncementAdminCRUDController::showAction',  '_sonata_admin' => 'admin.announcement',  '_sonata_name' => 'admin_app_announcement_show',));
                        }

                        // admin_app_announcement_export
                        if ($pathinfo === '/admin/app/announcement/export') {
                            return array (  '_controller' => 'AppBundle\\Controller\\Admin\\AnnouncementAdminCRUDController::exportAction',  '_sonata_admin' => 'admin.announcement',  '_sonata_name' => 'admin_app_announcement_export',  '_route' => 'admin_app_announcement_export',);
                        }

                        // admin_app_announcement_togglePublishable
                        if (preg_match('#^/admin/app/announcement/(?P<id>[^/]++)/togglePublishable$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_announcement_togglePublishable')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\AnnouncementAdminCRUDController::togglePublishableAction',  '_sonata_admin' => 'admin.announcement',  '_sonata_name' => 'admin_app_announcement_togglePublishable',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/owner')) {
                        // admin_app_owner_list
                        if ($pathinfo === '/admin/app/owner/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.owner',  '_sonata_name' => 'admin_app_owner_list',  '_route' => 'admin_app_owner_list',);
                        }

                        // admin_app_owner_create
                        if ($pathinfo === '/admin/app/owner/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.owner',  '_sonata_name' => 'admin_app_owner_create',  '_route' => 'admin_app_owner_create',);
                        }

                        // admin_app_owner_batch
                        if ($pathinfo === '/admin/app/owner/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.owner',  '_sonata_name' => 'admin_app_owner_batch',  '_route' => 'admin_app_owner_batch',);
                        }

                        // admin_app_owner_edit
                        if (preg_match('#^/admin/app/owner/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_owner_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.owner',  '_sonata_name' => 'admin_app_owner_edit',));
                        }

                        // admin_app_owner_delete
                        if (preg_match('#^/admin/app/owner/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_owner_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.owner',  '_sonata_name' => 'admin_app_owner_delete',));
                        }

                        // admin_app_owner_show
                        if (preg_match('#^/admin/app/owner/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_owner_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.owner',  '_sonata_name' => 'admin_app_owner_show',));
                        }

                        // admin_app_owner_export
                        if ($pathinfo === '/admin/app/owner/export') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.owner',  '_sonata_name' => 'admin_app_owner_export',  '_route' => 'admin_app_owner_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/subordinatesocials')) {
                        // admin_app_subordinatesocials_list
                        if ($pathinfo === '/admin/app/subordinatesocials/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.subordinate_socials',  '_sonata_name' => 'admin_app_subordinatesocials_list',  '_route' => 'admin_app_subordinatesocials_list',);
                        }

                        // admin_app_subordinatesocials_create
                        if ($pathinfo === '/admin/app/subordinatesocials/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.subordinate_socials',  '_sonata_name' => 'admin_app_subordinatesocials_create',  '_route' => 'admin_app_subordinatesocials_create',);
                        }

                        // admin_app_subordinatesocials_batch
                        if ($pathinfo === '/admin/app/subordinatesocials/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.subordinate_socials',  '_sonata_name' => 'admin_app_subordinatesocials_batch',  '_route' => 'admin_app_subordinatesocials_batch',);
                        }

                        // admin_app_subordinatesocials_edit
                        if (preg_match('#^/admin/app/subordinatesocials/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_subordinatesocials_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.subordinate_socials',  '_sonata_name' => 'admin_app_subordinatesocials_edit',));
                        }

                        // admin_app_subordinatesocials_delete
                        if (preg_match('#^/admin/app/subordinatesocials/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_subordinatesocials_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.subordinate_socials',  '_sonata_name' => 'admin_app_subordinatesocials_delete',));
                        }

                        // admin_app_subordinatesocials_show
                        if (preg_match('#^/admin/app/subordinatesocials/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_subordinatesocials_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.subordinate_socials',  '_sonata_name' => 'admin_app_subordinatesocials_show',));
                        }

                        // admin_app_subordinatesocials_export
                        if ($pathinfo === '/admin/app/subordinatesocials/export') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.subordinate_socials',  '_sonata_name' => 'admin_app_subordinatesocials_export',  '_route' => 'admin_app_subordinatesocials_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/importfilter')) {
                        // admin_app_importfilter_list
                        if ($pathinfo === '/admin/app/importfilter/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.construction_filter',  '_sonata_name' => 'admin_app_importfilter_list',  '_route' => 'admin_app_importfilter_list',);
                        }

                        // admin_app_importfilter_create
                        if ($pathinfo === '/admin/app/importfilter/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.construction_filter',  '_sonata_name' => 'admin_app_importfilter_create',  '_route' => 'admin_app_importfilter_create',);
                        }

                        // admin_app_importfilter_edit
                        if (preg_match('#^/admin/app/importfilter/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_importfilter_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.construction_filter',  '_sonata_name' => 'admin_app_importfilter_edit',));
                        }

                        // admin_app_importfilter_delete
                        if (preg_match('#^/admin/app/importfilter/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_importfilter_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.construction_filter',  '_sonata_name' => 'admin_app_importfilter_delete',));
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/constructionparameter')) {
                        // admin_app_constructionparameter_list
                        if ($pathinfo === '/admin/app/constructionparameter/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.construction_parameter',  '_sonata_name' => 'admin_app_constructionparameter_list',  '_route' => 'admin_app_constructionparameter_list',);
                        }

                        // admin_app_constructionparameter_create
                        if ($pathinfo === '/admin/app/constructionparameter/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.construction_parameter',  '_sonata_name' => 'admin_app_constructionparameter_create',  '_route' => 'admin_app_constructionparameter_create',);
                        }

                        // admin_app_constructionparameter_edit
                        if (preg_match('#^/admin/app/constructionparameter/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_constructionparameter_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.construction_parameter',  '_sonata_name' => 'admin_app_constructionparameter_edit',));
                        }

                        // admin_app_constructionparameter_delete
                        if (preg_match('#^/admin/app/constructionparameter/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_constructionparameter_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.construction_parameter',  '_sonata_name' => 'admin_app_constructionparameter_delete',));
                        }

                        if (0 === strpos($pathinfo, '/admin/app/constructionparametervalue')) {
                            // admin_app_constructionparametervalue_list
                            if ($pathinfo === '/admin/app/constructionparametervalue/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.construction_parameter_value',  '_sonata_name' => 'admin_app_constructionparametervalue_list',  '_route' => 'admin_app_constructionparametervalue_list',);
                            }

                            // admin_app_constructionparametervalue_create
                            if ($pathinfo === '/admin/app/constructionparametervalue/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.construction_parameter_value',  '_sonata_name' => 'admin_app_constructionparametervalue_create',  '_route' => 'admin_app_constructionparametervalue_create',);
                            }

                            // admin_app_constructionparametervalue_batch
                            if ($pathinfo === '/admin/app/constructionparametervalue/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.construction_parameter_value',  '_sonata_name' => 'admin_app_constructionparametervalue_batch',  '_route' => 'admin_app_constructionparametervalue_batch',);
                            }

                            // admin_app_constructionparametervalue_edit
                            if (preg_match('#^/admin/app/constructionparametervalue/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_constructionparametervalue_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.construction_parameter_value',  '_sonata_name' => 'admin_app_constructionparametervalue_edit',));
                            }

                            // admin_app_constructionparametervalue_delete
                            if (preg_match('#^/admin/app/constructionparametervalue/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_constructionparametervalue_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.construction_parameter_value',  '_sonata_name' => 'admin_app_constructionparametervalue_delete',));
                            }

                            // admin_app_constructionparametervalue_show
                            if (preg_match('#^/admin/app/constructionparametervalue/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_constructionparametervalue_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.construction_parameter_value',  '_sonata_name' => 'admin_app_constructionparametervalue_show',));
                            }

                            // admin_app_constructionparametervalue_export
                            if ($pathinfo === '/admin/app/constructionparametervalue/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.construction_parameter_value',  '_sonata_name' => 'admin_app_constructionparametervalue_export',  '_route' => 'admin_app_constructionparametervalue_export',);
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/roadparametervalue')) {
                        // admin_app_roadparametervalue_list
                        if ($pathinfo === '/admin/app/roadparametervalue/list') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.road_parameter_value',  '_sonata_name' => 'admin_app_roadparametervalue_list',  '_route' => 'admin_app_roadparametervalue_list',);
                        }

                        // admin_app_roadparametervalue_create
                        if ($pathinfo === '/admin/app/roadparametervalue/create') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.road_parameter_value',  '_sonata_name' => 'admin_app_roadparametervalue_create',  '_route' => 'admin_app_roadparametervalue_create',);
                        }

                        // admin_app_roadparametervalue_batch
                        if ($pathinfo === '/admin/app/roadparametervalue/batch') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.road_parameter_value',  '_sonata_name' => 'admin_app_roadparametervalue_batch',  '_route' => 'admin_app_roadparametervalue_batch',);
                        }

                        // admin_app_roadparametervalue_edit
                        if (preg_match('#^/admin/app/roadparametervalue/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_roadparametervalue_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.road_parameter_value',  '_sonata_name' => 'admin_app_roadparametervalue_edit',));
                        }

                        // admin_app_roadparametervalue_delete
                        if (preg_match('#^/admin/app/roadparametervalue/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_roadparametervalue_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.road_parameter_value',  '_sonata_name' => 'admin_app_roadparametervalue_delete',));
                        }

                        // admin_app_roadparametervalue_show
                        if (preg_match('#^/admin/app/roadparametervalue/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_roadparametervalue_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.road_parameter_value',  '_sonata_name' => 'admin_app_roadparametervalue_show',));
                        }

                        // admin_app_roadparametervalue_export
                        if ($pathinfo === '/admin/app/roadparametervalue/export') {
                            return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.road_parameter_value',  '_sonata_name' => 'admin_app_roadparametervalue_export',  '_route' => 'admin_app_roadparametervalue_export',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/app/e')) {
                        if (0 === strpos($pathinfo, '/admin/app/embeddedcontent-faq-questionanswer')) {
                            // admin_app_embeddedcontent_faq_questionanswer_list
                            if ($pathinfo === '/admin/app/embeddedcontent-faq-questionanswer/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.questions_and_answers',  '_sonata_name' => 'admin_app_embeddedcontent_faq_questionanswer_list',  '_route' => 'admin_app_embeddedcontent_faq_questionanswer_list',);
                            }

                            // admin_app_embeddedcontent_faq_questionanswer_create
                            if ($pathinfo === '/admin/app/embeddedcontent-faq-questionanswer/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.questions_and_answers',  '_sonata_name' => 'admin_app_embeddedcontent_faq_questionanswer_create',  '_route' => 'admin_app_embeddedcontent_faq_questionanswer_create',);
                            }

                            // admin_app_embeddedcontent_faq_questionanswer_batch
                            if ($pathinfo === '/admin/app/embeddedcontent-faq-questionanswer/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.questions_and_answers',  '_sonata_name' => 'admin_app_embeddedcontent_faq_questionanswer_batch',  '_route' => 'admin_app_embeddedcontent_faq_questionanswer_batch',);
                            }

                            // admin_app_embeddedcontent_faq_questionanswer_edit
                            if (preg_match('#^/admin/app/embeddedcontent\\-faq\\-questionanswer/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_faq_questionanswer_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.questions_and_answers',  '_sonata_name' => 'admin_app_embeddedcontent_faq_questionanswer_edit',));
                            }

                            // admin_app_embeddedcontent_faq_questionanswer_delete
                            if (preg_match('#^/admin/app/embeddedcontent\\-faq\\-questionanswer/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_faq_questionanswer_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.questions_and_answers',  '_sonata_name' => 'admin_app_embeddedcontent_faq_questionanswer_delete',));
                            }

                            // admin_app_embeddedcontent_faq_questionanswer_show
                            if (preg_match('#^/admin/app/embeddedcontent\\-faq\\-questionanswer/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_embeddedcontent_faq_questionanswer_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.questions_and_answers',  '_sonata_name' => 'admin_app_embeddedcontent_faq_questionanswer_show',));
                            }

                            // admin_app_embeddedcontent_faq_questionanswer_export
                            if ($pathinfo === '/admin/app/embeddedcontent-faq-questionanswer/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.questions_and_answers',  '_sonata_name' => 'admin_app_embeddedcontent_faq_questionanswer_export',  '_route' => 'admin_app_embeddedcontent_faq_questionanswer_export',);
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/extrainformation')) {
                            // admin_app_extrainformation_list
                            if ($pathinfo === '/admin/app/extrainformation/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'admin.extra_information',  '_sonata_name' => 'admin_app_extrainformation_list',  '_route' => 'admin_app_extrainformation_list',);
                            }

                            // admin_app_extrainformation_create
                            if ($pathinfo === '/admin/app/extrainformation/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'admin.extra_information',  '_sonata_name' => 'admin_app_extrainformation_create',  '_route' => 'admin_app_extrainformation_create',);
                            }

                            // admin_app_extrainformation_batch
                            if ($pathinfo === '/admin/app/extrainformation/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'admin.extra_information',  '_sonata_name' => 'admin_app_extrainformation_batch',  '_route' => 'admin_app_extrainformation_batch',);
                            }

                            // admin_app_extrainformation_edit
                            if (preg_match('#^/admin/app/extrainformation/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_extrainformation_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'admin.extra_information',  '_sonata_name' => 'admin_app_extrainformation_edit',));
                            }

                            // admin_app_extrainformation_delete
                            if (preg_match('#^/admin/app/extrainformation/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_extrainformation_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'admin.extra_information',  '_sonata_name' => 'admin_app_extrainformation_delete',));
                            }

                            // admin_app_extrainformation_show
                            if (preg_match('#^/admin/app/extrainformation/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_extrainformation_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'admin.extra_information',  '_sonata_name' => 'admin_app_extrainformation_show',));
                            }

                            // admin_app_extrainformation_export
                            if ($pathinfo === '/admin/app/extrainformation/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'admin.extra_information',  '_sonata_name' => 'admin_app_extrainformation_export',  '_route' => 'admin_app_extrainformation_export',);
                            }

                        }

                    }

                }

                if (0 === strpos($pathinfo, '/admin/sonata')) {
                    if (0 === strpos($pathinfo, '/admin/sonata/user')) {
                        if (0 === strpos($pathinfo, '/admin/sonata/user/user')) {
                            // admin_sonata_user_user_list
                            if ($pathinfo === '/admin/sonata/user/user/list') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserCRUDController::listAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_sonata_user_user_list',  '_route' => 'admin_sonata_user_user_list',);
                            }

                            // admin_sonata_user_user_create
                            if ($pathinfo === '/admin/sonata/user/user/create') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserCRUDController::createAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_sonata_user_user_create',  '_route' => 'admin_sonata_user_user_create',);
                            }

                            // admin_sonata_user_user_batch
                            if ($pathinfo === '/admin/sonata/user/user/batch') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserCRUDController::batchAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_sonata_user_user_batch',  '_route' => 'admin_sonata_user_user_batch',);
                            }

                            // admin_sonata_user_user_edit
                            if (preg_match('#^/admin/sonata/user/user/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_user_user_edit')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserCRUDController::editAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_sonata_user_user_edit',));
                            }

                            // admin_sonata_user_user_delete
                            if (preg_match('#^/admin/sonata/user/user/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_user_user_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserCRUDController::deleteAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_sonata_user_user_delete',));
                            }

                            // admin_sonata_user_user_show
                            if (preg_match('#^/admin/sonata/user/user/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_user_user_show')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserCRUDController::showAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_sonata_user_user_show',));
                            }

                            // admin_sonata_user_user_export
                            if ($pathinfo === '/admin/sonata/user/user/export') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserCRUDController::exportAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_sonata_user_user_export',  '_route' => 'admin_sonata_user_user_export',);
                            }

                            // admin_sonata_user_user_activity
                            if (preg_match('#^/admin/sonata/user/user/(?P<id>[^/]++)/activity$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_user_user_activity')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserCRUDController::activityAction',  '_sonata_admin' => 'sonata.user.admin.user',  '_sonata_name' => 'admin_sonata_user_user_activity',));
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/sonata/user/group')) {
                            // admin_sonata_user_group_list
                            if ($pathinfo === '/admin/sonata/user/group/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'sonata.user.admin.group',  '_sonata_name' => 'admin_sonata_user_group_list',  '_route' => 'admin_sonata_user_group_list',);
                            }

                            // admin_sonata_user_group_create
                            if ($pathinfo === '/admin/sonata/user/group/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'sonata.user.admin.group',  '_sonata_name' => 'admin_sonata_user_group_create',  '_route' => 'admin_sonata_user_group_create',);
                            }

                            // admin_sonata_user_group_batch
                            if ($pathinfo === '/admin/sonata/user/group/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'sonata.user.admin.group',  '_sonata_name' => 'admin_sonata_user_group_batch',  '_route' => 'admin_sonata_user_group_batch',);
                            }

                            // admin_sonata_user_group_edit
                            if (preg_match('#^/admin/sonata/user/group/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_user_group_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'sonata.user.admin.group',  '_sonata_name' => 'admin_sonata_user_group_edit',));
                            }

                            // admin_sonata_user_group_delete
                            if (preg_match('#^/admin/sonata/user/group/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_user_group_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'sonata.user.admin.group',  '_sonata_name' => 'admin_sonata_user_group_delete',));
                            }

                            // admin_sonata_user_group_show
                            if (preg_match('#^/admin/sonata/user/group/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_user_group_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'sonata.user.admin.group',  '_sonata_name' => 'admin_sonata_user_group_show',));
                            }

                            // admin_sonata_user_group_export
                            if ($pathinfo === '/admin/sonata/user/group/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'sonata.user.admin.group',  '_sonata_name' => 'admin_sonata_user_group_export',  '_route' => 'admin_sonata_user_group_export',);
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/sonata/media')) {
                        if (0 === strpos($pathinfo, '/admin/sonata/media/media')) {
                            // admin_sonata_media_media_list
                            if ($pathinfo === '/admin/sonata/media/media/list') {
                                return array (  '_controller' => 'Application\\Sonata\\MediaBundle\\Controller\\MediaAdminController::listAction',  '_sonata_admin' => 'sonata.media.admin.media',  '_sonata_name' => 'admin_sonata_media_media_list',  '_route' => 'admin_sonata_media_media_list',);
                            }

                            // admin_sonata_media_media_create
                            if ($pathinfo === '/admin/sonata/media/media/create') {
                                return array (  '_controller' => 'Application\\Sonata\\MediaBundle\\Controller\\MediaAdminController::createAction',  '_sonata_admin' => 'sonata.media.admin.media',  '_sonata_name' => 'admin_sonata_media_media_create',  '_route' => 'admin_sonata_media_media_create',);
                            }

                            // admin_sonata_media_media_batch
                            if ($pathinfo === '/admin/sonata/media/media/batch') {
                                return array (  '_controller' => 'Application\\Sonata\\MediaBundle\\Controller\\MediaAdminController::batchAction',  '_sonata_admin' => 'sonata.media.admin.media',  '_sonata_name' => 'admin_sonata_media_media_batch',  '_route' => 'admin_sonata_media_media_batch',);
                            }

                            // admin_sonata_media_media_edit
                            if (preg_match('#^/admin/sonata/media/media/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_media_media_edit')), array (  '_controller' => 'Application\\Sonata\\MediaBundle\\Controller\\MediaAdminController::editAction',  '_sonata_admin' => 'sonata.media.admin.media',  '_sonata_name' => 'admin_sonata_media_media_edit',));
                            }

                            // admin_sonata_media_media_delete
                            if (preg_match('#^/admin/sonata/media/media/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_media_media_delete')), array (  '_controller' => 'Application\\Sonata\\MediaBundle\\Controller\\MediaAdminController::deleteAction',  '_sonata_admin' => 'sonata.media.admin.media',  '_sonata_name' => 'admin_sonata_media_media_delete',));
                            }

                            // admin_sonata_media_media_show
                            if (preg_match('#^/admin/sonata/media/media/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_media_media_show')), array (  '_controller' => 'Application\\Sonata\\MediaBundle\\Controller\\MediaAdminController::showAction',  '_sonata_admin' => 'sonata.media.admin.media',  '_sonata_name' => 'admin_sonata_media_media_show',));
                            }

                            // admin_sonata_media_media_export
                            if ($pathinfo === '/admin/sonata/media/media/export') {
                                return array (  '_controller' => 'Application\\Sonata\\MediaBundle\\Controller\\MediaAdminController::exportAction',  '_sonata_admin' => 'sonata.media.admin.media',  '_sonata_name' => 'admin_sonata_media_media_export',  '_route' => 'admin_sonata_media_media_export',);
                            }

                            // admin_sonata_media_media_edit_image_format
                            if (preg_match('#^/admin/sonata/media/media/(?P<id>[^/]++)/edit\\-image\\-format$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_media_media_edit_image_format')), array (  '_controller' => 'Application\\Sonata\\MediaBundle\\Controller\\MediaAdminController::editImageFormatAction',  '_sonata_admin' => 'sonata.media.admin.media',  '_sonata_name' => 'admin_sonata_media_media_edit_image_format',));
                            }

                            // admin_sonata_media_media_batch_upload
                            if ($pathinfo === '/admin/sonata/media/media/batch_upload') {
                                return array (  '_controller' => 'Application\\Sonata\\MediaBundle\\Controller\\MediaAdminController::batchUploadAction',  '_sonata_admin' => 'sonata.media.admin.media',  '_sonata_name' => 'admin_sonata_media_media_batch_upload',  '_route' => 'admin_sonata_media_media_batch_upload',);
                            }

                            // admin_sonata_media_media_image_list
                            if ($pathinfo === '/admin/sonata/media/media/image_list') {
                                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\CKeditorPhotoLineAdminController::browserAction',  '_sonata_admin' => 'sonata.media.admin.media',  '_sonata_name' => 'admin_sonata_media_media_image_list',  '_route' => 'admin_sonata_media_media_image_list',);
                            }

                            if (0 === strpos($pathinfo, '/admin/sonata/media/media/ckeditor_')) {
                                // admin_sonata_media_media_ckeditor_browser
                                if ($pathinfo === '/admin/sonata/media/media/ckeditor_browser') {
                                    return array (  '_controller' => 'Application\\Sonata\\FormatterBundle\\Controller\\CkeditorAdminController::browserAction',  '_sonata_admin' => 'sonata.media.admin.media',  '_sonata_name' => 'admin_sonata_media_media_ckeditor_browser',  '_route' => 'admin_sonata_media_media_ckeditor_browser',);
                                }

                                // admin_sonata_media_media_ckeditor_upload
                                if ($pathinfo === '/admin/sonata/media/media/ckeditor_upload') {
                                    return array (  '_controller' => 'Application\\Sonata\\FormatterBundle\\Controller\\CkeditorAdminController::uploadAction',  '_sonata_admin' => 'sonata.media.admin.media',  '_sonata_name' => 'admin_sonata_media_media_ckeditor_upload',  '_route' => 'admin_sonata_media_media_ckeditor_upload',);
                                }

                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/sonata/media/galleryhasmedia')) {
                            // admin_sonata_media_galleryhasmedia_list
                            if ($pathinfo === '/admin/sonata/media/galleryhasmedia/list') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::listAction',  '_sonata_admin' => 'sonata.media.admin.gallery_has_media',  '_sonata_name' => 'admin_sonata_media_galleryhasmedia_list',  '_route' => 'admin_sonata_media_galleryhasmedia_list',);
                            }

                            // admin_sonata_media_galleryhasmedia_create
                            if ($pathinfo === '/admin/sonata/media/galleryhasmedia/create') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::createAction',  '_sonata_admin' => 'sonata.media.admin.gallery_has_media',  '_sonata_name' => 'admin_sonata_media_galleryhasmedia_create',  '_route' => 'admin_sonata_media_galleryhasmedia_create',);
                            }

                            // admin_sonata_media_galleryhasmedia_batch
                            if ($pathinfo === '/admin/sonata/media/galleryhasmedia/batch') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::batchAction',  '_sonata_admin' => 'sonata.media.admin.gallery_has_media',  '_sonata_name' => 'admin_sonata_media_galleryhasmedia_batch',  '_route' => 'admin_sonata_media_galleryhasmedia_batch',);
                            }

                            // admin_sonata_media_galleryhasmedia_edit
                            if (preg_match('#^/admin/sonata/media/galleryhasmedia/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_media_galleryhasmedia_edit')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::editAction',  '_sonata_admin' => 'sonata.media.admin.gallery_has_media',  '_sonata_name' => 'admin_sonata_media_galleryhasmedia_edit',));
                            }

                            // admin_sonata_media_galleryhasmedia_delete
                            if (preg_match('#^/admin/sonata/media/galleryhasmedia/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_media_galleryhasmedia_delete')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::deleteAction',  '_sonata_admin' => 'sonata.media.admin.gallery_has_media',  '_sonata_name' => 'admin_sonata_media_galleryhasmedia_delete',));
                            }

                            // admin_sonata_media_galleryhasmedia_show
                            if (preg_match('#^/admin/sonata/media/galleryhasmedia/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_sonata_media_galleryhasmedia_show')), array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::showAction',  '_sonata_admin' => 'sonata.media.admin.gallery_has_media',  '_sonata_name' => 'admin_sonata_media_galleryhasmedia_show',));
                            }

                            // admin_sonata_media_galleryhasmedia_export
                            if ($pathinfo === '/admin/sonata/media/galleryhasmedia/export') {
                                return array (  '_controller' => 'Sonata\\AdminBundle\\Controller\\CRUDController::exportAction',  '_sonata_admin' => 'sonata.media.admin.gallery_has_media',  '_sonata_name' => 'admin_sonata_media_galleryhasmedia_export',  '_route' => 'admin_sonata_media_galleryhasmedia_export',);
                            }

                        }

                    }

                }

                if (0 === strpos($pathinfo, '/admin/a')) {
                    if (0 === strpos($pathinfo, '/admin/app')) {
                        if (0 === strpos($pathinfo, '/admin/app/page')) {
                            // admin_app_page_list
                            if ($pathinfo === '/admin/app/page/list') {
                                return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::listAction',  '_sonata_admin' => 'amg_page.admin.page',  '_sonata_name' => 'admin_app_page_list',  '_route' => 'admin_app_page_list',);
                            }

                            // admin_app_page_create
                            if ($pathinfo === '/admin/app/page/create') {
                                return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::createAction',  '_sonata_admin' => 'amg_page.admin.page',  '_sonata_name' => 'admin_app_page_create',  '_route' => 'admin_app_page_create',);
                            }

                            // admin_app_page_batch
                            if ($pathinfo === '/admin/app/page/batch') {
                                return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::batchAction',  '_sonata_admin' => 'amg_page.admin.page',  '_sonata_name' => 'admin_app_page_batch',  '_route' => 'admin_app_page_batch',);
                            }

                            // admin_app_page_edit
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_edit')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::editAction',  '_sonata_admin' => 'amg_page.admin.page',  '_sonata_name' => 'admin_app_page_edit',));
                            }

                            // admin_app_page_delete
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_delete')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::deleteAction',  '_sonata_admin' => 'amg_page.admin.page',  '_sonata_name' => 'admin_app_page_delete',));
                            }

                            // admin_app_page_show
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_show')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::showAction',  '_sonata_admin' => 'amg_page.admin.page',  '_sonata_name' => 'admin_app_page_show',));
                            }

                            // admin_app_page_export
                            if ($pathinfo === '/admin/app/page/export') {
                                return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::exportAction',  '_sonata_admin' => 'amg_page.admin.page',  '_sonata_name' => 'admin_app_page_export',  '_route' => 'admin_app_page_export',);
                            }

                            // admin_app_page_history
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/history$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_history')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::historyAction',  '_sonata_admin' => 'amg_page.admin.page',  '_sonata_name' => 'admin_app_page_history',));
                            }

                            // admin_app_page_history_view_revision
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/history/(?P<revision>[^/]++)/view$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_history_view_revision')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::historyViewRevisionAction',  '_sonata_admin' => 'amg_page.admin.page',  '_sonata_name' => 'admin_app_page_history_view_revision',));
                            }

                            // admin_app_page_history_compare_revisions
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/history/(?P<base_revision>[^/]++)/(?P<compare_revision>[^/]++)/compare$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_history_compare_revisions')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::historyCompareRevisionsAction',  '_sonata_admin' => 'amg_page.admin.page',  '_sonata_name' => 'admin_app_page_history_compare_revisions',));
                            }

                            // admin_app_page_block_list
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/block/list$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_block_list')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::listAction',  '_sonata_admin' => 'amg_page.admin.page|amg_page.admin.block',  '_sonata_name' => 'admin_app_page_block_list',));
                            }

                            // admin_app_page_block_create
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/block/create$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_block_create')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::createAction',  '_sonata_admin' => 'amg_page.admin.page|amg_page.admin.block',  '_sonata_name' => 'admin_app_page_block_create',));
                            }

                            // admin_app_page_block_batch
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/block/batch$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_block_batch')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::batchAction',  '_sonata_admin' => 'amg_page.admin.page|amg_page.admin.block',  '_sonata_name' => 'admin_app_page_block_batch',));
                            }

                            // admin_app_page_block_edit
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/block/(?P<childId>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_block_edit')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::editAction',  '_sonata_admin' => 'amg_page.admin.page|amg_page.admin.block',  '_sonata_name' => 'admin_app_page_block_edit',));
                            }

                            // admin_app_page_block_delete
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/block/(?P<childId>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_block_delete')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::deleteAction',  '_sonata_admin' => 'amg_page.admin.page|amg_page.admin.block',  '_sonata_name' => 'admin_app_page_block_delete',));
                            }

                            // admin_app_page_block_show
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/block/(?P<childId>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_block_show')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::showAction',  '_sonata_admin' => 'amg_page.admin.page|amg_page.admin.block',  '_sonata_name' => 'admin_app_page_block_show',));
                            }

                            // admin_app_page_block_export
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/block/export$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_block_export')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::exportAction',  '_sonata_admin' => 'amg_page.admin.page|amg_page.admin.block',  '_sonata_name' => 'admin_app_page_block_export',));
                            }

                            // admin_app_page_block_toggleEnable
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/block/(?P<childId>[^/]++)/toggleEnable$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_block_toggleEnable')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::toggleEnableAction',  '_sonata_admin' => 'amg_page.admin.page|amg_page.admin.block',  '_sonata_name' => 'admin_app_page_block_toggleEnable',));
                            }

                            // admin_app_page_revert_revision
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/history/(?P<base_rev_id>[^/]++)/(?P<compare_rev_id>[^/]++)/revert/(?P<field_name>[^/]++)$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_revert_revision')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::revertRevisionAction',  '_sonata_admin' => 'amg_page.admin.page',  '_sonata_name' => 'admin_app_page_revert_revision',));
                            }

                            // admin_app_page_move
                            if (preg_match('#^/admin/app/page/(?P<id>[^/]++)/move/(?P<direction>[^/]++)$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_page_move')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\PageController::moveAction',  '_sonata_admin' => 'amg_page.admin.page',  '_sonata_name' => 'admin_app_page_move',));
                            }

                        }

                        if (0 === strpos($pathinfo, '/admin/app/block')) {
                            // admin_app_block_list
                            if ($pathinfo === '/admin/app/block/list') {
                                return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::listAction',  '_sonata_admin' => 'amg_page.admin.block',  '_sonata_name' => 'admin_app_block_list',  '_route' => 'admin_app_block_list',);
                            }

                            // admin_app_block_create
                            if ($pathinfo === '/admin/app/block/create') {
                                return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::createAction',  '_sonata_admin' => 'amg_page.admin.block',  '_sonata_name' => 'admin_app_block_create',  '_route' => 'admin_app_block_create',);
                            }

                            // admin_app_block_batch
                            if ($pathinfo === '/admin/app/block/batch') {
                                return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::batchAction',  '_sonata_admin' => 'amg_page.admin.block',  '_sonata_name' => 'admin_app_block_batch',  '_route' => 'admin_app_block_batch',);
                            }

                            // admin_app_block_edit
                            if (preg_match('#^/admin/app/block/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_block_edit')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::editAction',  '_sonata_admin' => 'amg_page.admin.block',  '_sonata_name' => 'admin_app_block_edit',));
                            }

                            // admin_app_block_delete
                            if (preg_match('#^/admin/app/block/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_block_delete')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::deleteAction',  '_sonata_admin' => 'amg_page.admin.block',  '_sonata_name' => 'admin_app_block_delete',));
                            }

                            // admin_app_block_show
                            if (preg_match('#^/admin/app/block/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_block_show')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::showAction',  '_sonata_admin' => 'amg_page.admin.block',  '_sonata_name' => 'admin_app_block_show',));
                            }

                            // admin_app_block_export
                            if ($pathinfo === '/admin/app/block/export') {
                                return array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::exportAction',  '_sonata_admin' => 'amg_page.admin.block',  '_sonata_name' => 'admin_app_block_export',  '_route' => 'admin_app_block_export',);
                            }

                            // admin_app_block_toggleEnable
                            if (preg_match('#^/admin/app/block/(?P<id>[^/]++)/toggleEnable$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_app_block_toggleEnable')), array (  '_controller' => 'Amg\\Bundle\\PageBundle\\Controller\\Admin\\BlockController::toggleEnableAction',  '_sonata_admin' => 'amg_page.admin.block',  '_sonata_name' => 'admin_app_block_toggleEnable',));
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/admin/amg/tag/tag')) {
                        // admin_amg_tag_tag_list
                        if ($pathinfo === '/admin/amg/tag/tag/list') {
                            return array (  '_controller' => 'Amg\\Bundle\\TagBundle\\Controller\\Admin\\TagController::listAction',  '_sonata_admin' => 'amg_tag.admin.tag',  '_sonata_name' => 'admin_amg_tag_tag_list',  '_route' => 'admin_amg_tag_tag_list',);
                        }

                        // admin_amg_tag_tag_create
                        if ($pathinfo === '/admin/amg/tag/tag/create') {
                            return array (  '_controller' => 'Amg\\Bundle\\TagBundle\\Controller\\Admin\\TagController::createAction',  '_sonata_admin' => 'amg_tag.admin.tag',  '_sonata_name' => 'admin_amg_tag_tag_create',  '_route' => 'admin_amg_tag_tag_create',);
                        }

                        // admin_amg_tag_tag_batch
                        if ($pathinfo === '/admin/amg/tag/tag/batch') {
                            return array (  '_controller' => 'Amg\\Bundle\\TagBundle\\Controller\\Admin\\TagController::batchAction',  '_sonata_admin' => 'amg_tag.admin.tag',  '_sonata_name' => 'admin_amg_tag_tag_batch',  '_route' => 'admin_amg_tag_tag_batch',);
                        }

                        // admin_amg_tag_tag_edit
                        if (preg_match('#^/admin/amg/tag/tag/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_amg_tag_tag_edit')), array (  '_controller' => 'Amg\\Bundle\\TagBundle\\Controller\\Admin\\TagController::editAction',  '_sonata_admin' => 'amg_tag.admin.tag',  '_sonata_name' => 'admin_amg_tag_tag_edit',));
                        }

                        // admin_amg_tag_tag_delete
                        if (preg_match('#^/admin/amg/tag/tag/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_amg_tag_tag_delete')), array (  '_controller' => 'Amg\\Bundle\\TagBundle\\Controller\\Admin\\TagController::deleteAction',  '_sonata_admin' => 'amg_tag.admin.tag',  '_sonata_name' => 'admin_amg_tag_tag_delete',));
                        }

                        // admin_amg_tag_tag_show
                        if (preg_match('#^/admin/amg/tag/tag/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_amg_tag_tag_show')), array (  '_controller' => 'Amg\\Bundle\\TagBundle\\Controller\\Admin\\TagController::showAction',  '_sonata_admin' => 'amg_tag.admin.tag',  '_sonata_name' => 'admin_amg_tag_tag_show',));
                        }

                        // admin_amg_tag_tag_export
                        if ($pathinfo === '/admin/amg/tag/tag/export') {
                            return array (  '_controller' => 'Amg\\Bundle\\TagBundle\\Controller\\Admin\\TagController::exportAction',  '_sonata_admin' => 'amg_tag.admin.tag',  '_sonata_name' => 'admin_amg_tag_tag_export',  '_route' => 'admin_amg_tag_tag_export',);
                        }

                    }

                }

                if (0 === strpos($pathinfo, '/admin/report')) {
                    // admin_report
                    if ($pathinfo === '/admin/report') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_admin_report;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ReportController::indexAction',  '_route' => 'admin_report',);
                    }
                    not_admin_report:

                    // admin_report_by_content
                    if ($pathinfo === '/admin/report-by-content') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_admin_report_by_content;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ReportController::reportByContentAction',  '_route' => 'admin_report_by_content',);
                    }
                    not_admin_report_by_content:

                }

                // admin_animated_media
                if ($pathinfo === '/admin/animated-media') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_admin_animated_media;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ReportController::reportByContentAction',  '_route' => 'admin_animated_media',);
                }
                not_admin_animated_media:

            }

        }

        if (0 === strpos($pathinfo, '/media')) {
            if (0 === strpos($pathinfo, '/media/gallery')) {
                // sonata_media_gallery_index
                if (rtrim($pathinfo, '/') === '/media/gallery') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'sonata_media_gallery_index');
                    }

                    return array (  '_controller' => 'Sonata\\MediaBundle\\Controller\\GalleryController::indexAction',  '_route' => 'sonata_media_gallery_index',);
                }

                // sonata_media_gallery_view
                if (0 === strpos($pathinfo, '/media/gallery/view') && preg_match('#^/media/gallery/view/(?P<id>.*)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'sonata_media_gallery_view')), array (  '_controller' => 'Sonata\\MediaBundle\\Controller\\GalleryController::viewAction',));
                }

            }

            // sonata_media_view
            if (0 === strpos($pathinfo, '/media/view') && preg_match('#^/media/view/(?P<id>[^/]++)(?:/(?P<format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'sonata_media_view')), array (  '_controller' => 'Sonata\\MediaBundle\\Controller\\MediaController::viewAction',  'format' => 'reference',));
            }

            // sonata_media_download
            if (0 === strpos($pathinfo, '/media/download') && preg_match('#^/media/download/(?P<id>.*)(?:/(?P<format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'sonata_media_download')), array (  '_controller' => 'Sonata\\MediaBundle\\Controller\\MediaController::downloadAction',  'format' => 'reference',));
            }

        }

        if (0 === strpos($pathinfo, '/newsletters')) {
            if (0 === strpos($pathinfo, '/newsletters/subscribe')) {
                // email_subscription_subscribe
                if ($pathinfo === '/newsletters/subscribe') {
                    return array (  '_controller' => 'AppBundle\\Controller\\EmailSubscriptionController::subscribeAction',  '_route' => 'email_subscription_subscribe',);
                }

                // email_subscription_subscribe_success
                if ($pathinfo === '/newsletters/subscribe_success') {
                    return array (  '_controller' => 'AppBundle\\Controller\\EmailSubscriptionController::subscribeSuccessAction',  'action' => NULL,  '_route' => 'email_subscription_subscribe_success',);
                }

            }

            // email_subscription_control
            if ($pathinfo === '/newsletters') {
                return array (  '_controller' => 'AppBundle\\Controller\\EmailSubscriptionController::controlAction',  '_route' => 'email_subscription_control',);
            }

            // email_subscription_manage_control
            if ($pathinfo === '/newsletters/manage') {
                return array (  '_controller' => 'AppBundle\\Controller\\EmailSubscriptionController::manageAction',  '_route' => 'email_subscription_manage_control',);
            }

            // email_subscription_unsubscribe_success
            if ($pathinfo === '/newsletters/unsubscribe_success') {
                return array (  '_controller' => 'AppBundle\\Controller\\EmailSubscriptionController::unsubscribeSuccessAction',  '_route' => 'email_subscription_unsubscribe_success',);
            }

        }

        if (0 === strpos($pathinfo, '/media/cache/resolve')) {
            // liip_imagine_filter_runtime
            if (preg_match('#^/media/cache/resolve/(?P<filter>[A-z0-9_\\-]*)/rc/(?P<hash>[^/]++)/(?P<path>.+)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_liip_imagine_filter_runtime;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'liip_imagine_filter_runtime')), array (  '_controller' => 'liip_imagine.controller:filterRuntimeAction',));
            }
            not_liip_imagine_filter_runtime:

            // liip_imagine_filter
            if (preg_match('#^/media/cache/resolve/(?P<filter>[A-z0-9_\\-]*)/(?P<path>.+)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_liip_imagine_filter;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'liip_imagine_filter')), array (  '_controller' => 'liip_imagine.controller:filterAction',));
            }
            not_liip_imagine_filter:

        }

        if (0 === strpos($pathinfo, '/sitemap')) {
            // PrestaSitemapBundle_index
            if (preg_match('#^/sitemap\\.(?P<_format>xml)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'PrestaSitemapBundle_index')), array (  '_controller' => 'Presta\\SitemapBundle\\Controller\\SitemapController::indexAction',));
            }

            // PrestaSitemapBundle_section
            if (preg_match('#^/sitemap\\.(?P<name>[^/\\.]++)\\.(?P<_format>xml)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'PrestaSitemapBundle_section')), array (  '_controller' => 'Presta\\SitemapBundle\\Controller\\SitemapController::sectionAction',));
            }

        }

        // remove_trailing_slash
        if (preg_match('#^/(?P<url>.*/)$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_remove_trailing_slash;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'remove_trailing_slash')), array (  '_controller' => 'AppBundle\\Controller\\RedirectingController::removeTrailingSlashAction',));
        }
        not_remove_trailing_slash:

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
