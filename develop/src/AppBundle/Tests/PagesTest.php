<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class PagesTest extends WebTestCase
{
    public function testMainPageIsSuccessful()
    {
        $this->testPageIsSuccessful('/');
    }

    public function testSitemapIsSuccessful()
    {
        $this->testPageIsSuccessful('/sitemap');
    }

    /**
     * @dataProvider pageUrlProvider
     *
     * @param string $url
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();

        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), sprintf('Failed to open "%s"', $url));

        $contentNodes = $crawler->filter('main.page-main')->children()->reduce(function (Crawler $node, $i) {
            $classes = explode(' ', $node->attr('class'));

            return !array_intersect($classes, ['themes-panel', 'themes-panel__fixed', 'themes-fixed__shadow']);
        });

        $this->assertGreaterThan(0, $contentNodes->count(), sprintf('No elements other than theme panel found on page "%s"', $url));
    }

    public function testNewsPopularPage()
    {
        $client = self::createClient();

        $url = '/news/popular';
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), sprintf('Failed to open "%s"', $url));

        $this->assertGreaterThan(0, $crawler->filter('section.news-list article')->count(), 'At least 1 item in list expected');
    }

    /**
     * @dataProvider listPageUrlProvider
     *
     * @param string $listPageUrl
     * @param string $itemSelector
     */
    public function testShowPageIsSuccessful($listPageUrl, $itemSelector)
    {
        $crawler = self::createClient()->request('GET', $listPageUrl);
        if (!$crawler->filter($itemSelector)->count()) {
            return;
        };

        $showUrl = $crawler->filter($itemSelector)->first()->attr('href');
        $this->assertNotEmpty($showUrl);

        $this->testPageIsSuccessful($showUrl);
    }

    public function listPageUrlProvider()
    {
        return [
            ['/news', 'article > a'],
            ['/gallery', 'article > a'],
            ['/video', 'article > a'],
            ['/infographics', 'article > a'],
            ['/construction', 'article > a'],
            ['/structure', 'article > a'],
            ['/documents', '.documents-table-all__document'],
//todo: disabled extra features
//            ['/initiative', '.initiatives-list a'],
//            ['/event', '.events-block__list-item-link'],
            ['/organizations', '.organization-main__item-legend-contact'],
            ['/organization-personalities', '.organization-block__list-item-person'],
        ];
    }

    public function pageUrlProvider()
    {
        $client = self::createClient();
        $homepageUrl = '/';
        $crawler = $client->request('GET', $homepageUrl);

        $links = [];
        $extractHref = function ($node) use (&$links) {
            $links[$node->attr('href')] = true;
        };

        $homepageLinkSelectors = [
            '.top-menu__link[href^="/"]',
            '.main-menu__link[href^="/"]',
            '.dropdown-menu__menu > li > a[href^="/"]',
        ];
        $crawler->filter(implode(', ', $homepageLinkSelectors))->each($extractHref);

        $sitemapUrl = '/sitemap';
        $crawler = $client->request('GET', $sitemapUrl);
        $crawler->filter('.sitemap-block a[href^="/"]')->each($extractHref);

        unset($links[$homepageUrl], $links[$sitemapUrl]);

        return array_map(function ($v) {
            return [$v];
        }, array_keys($links));
    }
}
