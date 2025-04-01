<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SitemapTest extends WebTestCase
{
    public function testSitemap()
    {
        $client = self::createClient();
        $sitemapIndex = $client->request('GET', '/sitemap.xml');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Failed to open sitemap.xml');

        $sitemapLocation = $sitemapIndex->filterXPath('//loc');
        $locCount = $sitemapLocation->count();
        $this->assertEquals(1, $locCount, sprintf('Exactly 1 <loc> element expected, %u found in sitemap.xml', $locCount));

        $url = $sitemapLocation->text();
        $sitemap= $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), sprintf('Failed to open "%s"', $url));

        $urlCount = $sitemap->filterXPath('//url')->count();
        $urlMin = 20;
        $this->assertGreaterThan($urlMin, $urlCount, sprintf('At least %u <url> element expected, %u found', $urlMin, $urlCount));
    }
}
