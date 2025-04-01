<?php
namespace AppBundle\Twig;

use Html2Text\Html2Text;

class UrlHashUtmFixExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'url_hash_utm_fix';
    }

    public function getFilters()
    {
      return array(
          new \Twig_SimpleFilter('url_hash_utm_fix', array($this, 'fixHashUtmUrl')),
      );
    }

    public function fixHashUtmUrl($url, $utm)
    {
        $parsed_url = parse_url($url);
        $parsed_url['query'] = isset($parsed_url['query']) ? $parsed_url['query'].($parsed_url['query'] ? '&' : '').$utm : '';
        return $this->unparseUrl($parsed_url);
    }

    private function unparseUrl($parsed_url) {
      $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
      $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
      $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
      $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
      $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
      $pass     = ($user || $pass) ? "$pass@" : '';
      $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
      $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
      $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
      return "$scheme$user$pass$host$port$path$query$fragment";
    }
}
