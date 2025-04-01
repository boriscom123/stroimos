<?php
namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchPageTest extends WebTestCase
{
    public function testSearchPage()
    {
        $client = self::createClient();

        $url = '/search?q=москва';
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), sprintf('Failed to open "%s"', $url));

        $this->assertGreaterThan(0, $crawler->filter('.news-list article')->count(), 'At least 1 item in list expected');
    }
}
