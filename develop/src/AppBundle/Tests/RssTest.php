<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RssTest extends WebTestCase
{
    /**
     * @dataProvider rssUrlProvider
     *
     * @param string $url
     */
    public function testRss($url)
    {
        $client = self::createClient();
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), sprintf('Failed to open "%s"', $url));

        $this->assertGreaterThan(0, $crawler->filter('item')->count(), sprintf('No items found in RSS feed "%s"', $url));
    }

    public function rssUrlProvider()
    {
        return [
            ['/news/rss'],
            ['/news/yarss'],
            ['/news/ramrss'],
            ['/news/mailru'],
            ['/news/ya_geo_rss']
        ];
    }
}
