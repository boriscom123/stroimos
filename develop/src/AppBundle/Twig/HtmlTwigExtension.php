<?php
namespace AppBundle\Twig;

use Html2Text\Html2Text;

class HtmlTwigExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'app_html';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('html2text', function ($html, array $options = ['do_links' => 'none','width' => 0]) {
                return (new Html2Text($html, $options))->getText();
            }),
            new \Twig_SimpleFilter('md5', function ($str) {
                return md5($str);
            })
        ];
    }
}