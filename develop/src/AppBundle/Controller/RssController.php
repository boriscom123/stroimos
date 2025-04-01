<?php
namespace AppBundle\Controller;

use AppBundle\Rss\RssBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RssController extends Controller
{
    const TYPE_YA_GEO_RSS = 'ya_geo_rss';
    const TYPE_WIFI_RSS = 'wifi_rss';
    const TYPE_YA_ZEN_RSS = 'ya_zen_rss';
    const TYPE_WORLD_IS_SMALL_RSS = 'world_is_small_rss';

    const RSS_ITEMS_LIMIT = 50;

    public function showAction($type = null)
    {
        $builder = $this->createRssBuilder($type);

        if($type === self::TYPE_YA_GEO_RSS) {
            $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->getForRss(self::RSS_ITEMS_LIMIT, true);
        } elseif ($type === self::TYPE_WIFI_RSS) {
            $posts = $this->getDoctrine()->getRepository('AppBundle:Post')
                ->getForRss(self::RSS_ITEMS_LIMIT, false, ['forRss' => true]);
        } elseif ($type === self::TYPE_YA_ZEN_RSS) {
            $posts = $this->getDoctrine()->getRepository('AppBundle:Post')
                ->getForRss(self::RSS_ITEMS_LIMIT, false, ['forYaZenRss' => true]);
        } elseif ($type === self::TYPE_WORLD_IS_SMALL_RSS) {
            $posts = $this->getDoctrine()->getRepository('AppBundle:Post')
                ->getForRss(self::RSS_ITEMS_LIMIT, false, ['wordIsSmallRss' => true]);
        } else {
            $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->getForRss(self::RSS_ITEMS_LIMIT);
        }

        foreach ($posts as $post) {
            $builder->addItem($post);
        }

        $response = new Response($builder->render());
        $response->headers->add(array('Content-Type' => 'application/rss+xml; charset=utf-8'));
        $response->setPublic();

        return $response;
    }

    /**
     * @param $type
     * @return RssBuilder
     */
    private function createRssBuilder($type)
    {
        $serviceId = 'rss_builder.' . $type;

        if (!$this->has($serviceId)) {
            throw $this->createNotFoundException();
        }

        return $this->get($serviceId);
    }
}
