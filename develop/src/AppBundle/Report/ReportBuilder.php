<?php
namespace AppBundle\Report;

use AppBundle\Entity\SpotlightItem;
use Doctrine\ORM\EntityManager;

class ReportBuilder
{
    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return ReportInterface[]
     */
    public function getReports()
    {
        $reportItems = $this->getReportItems();
        $connection = $this->em->getConnection();
        foreach($reportItems as $item) {
            if($item instanceof ReportInterface) {
                $item->setConnection($connection);
            }
        }

        return $reportItems;
    }

    /**
     * @return array
     */
    private function getReportItems()
    {
        $spotlitItemClassName = addslashes(SpotlightItem::class);
        return [
            new ReportGroup(
                'news_total',
                [
                    new ReportItem('news', 'post', 'publishable = true and category_id = 1'),
                    new ReportItem('news_city', 'post', 'publishable = true and category_id = 2')
                ],
                6164
            ),
            new ReportGroup(
                'article_total',
                [
                    new ReportItem('article', 'post', 'publishable = true and category_id = 3'),
                    new ReportItem('page_photo_lines', 'post', 'publishable = true and category_id = 6'),
                ],
                505
            ),
            new ReportItem('interview', 'post', 'publishable = true and category_id = 5', 220),
            new ReportItem('press_release', 'post', 'publishable = true and category_id = 7', 3085),
            //new ReportItem('shorthand_report', 'post', 'publishable = true and category_id = 8', 1),

            new ReportItem('announcement', 'announcement', '', 200),
            new ReportItem('document', 'document', 'publishable = true', 36),
            new ReportItem('video', 'video', 'publishable = true', 300),
            new ReportItem('photo', 'media__media', 'provider_name = "sonata.media.provider.image" and context = "gallery_media"', 7200),
            new ReportGroup(
                'infographic',
                [
                    new ReportItem('infographic_entity', 'infographics', ''),
                    new ReportItem('infographic_from_media', 'media__media', 'name LIKE "infogr_%"')
                ],
                300
            ),
            new ReportGroup(
                'banner',
                [
                    new ReportItem('banner_on_main_page', 'block', 'type="hot_news_block"', 550),
                    new ReportItem('embedded_banner', 'banner' , ''),
                    new ReportItem(
                        'spotlightitem_banner',
                        'ext_log_entries',
                        "action = \"create\" and object_class=\"{$spotlitItemClassName}\"",
                        null,
                        'logged_at'
                    )
                ],
                648
            ),
            new ReportItem('collage', 'media__media', 'name LIKE "collage_%"', 400),
            new ReportGroup(
                'page_total',
                [
                    new ReportItem('page', 'page', 'publishable = true'),
                    new ReportItem('page_builder_science', 'post', 'publishable = true and category_id = 4'),
                    new ReportItem('page_person', 'person', 'publishable = true'),
                    new ReportItem('page_organization', 'organization', 'publishable = true'),
                    new ReportItem('page_road', 'road', 'publishable = true'),
                    new ReportItem('page_metro', 'metro_station', 'publishable = true'),
                    new ReportItem('page_construction', 'construction', 'publishable = true and object_id is null and unique_id is null'),
                    new ReportItem('page_faq', 'faq_block', 'publishable = true'),
                    new ReportItem(
                        'page_newsletters',
                        'newsletter',
                        '',
                        null,
                        'created_at'),
                ],
                360
            )
        ];
    }
}
