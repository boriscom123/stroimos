<?php
namespace AppBundle\Helper;

class UrlHelper
{
    public static function fixUserEditableLink($link)
    {
        return preg_replace('~^http(s)?://(new)?stroi.mos.ru/~i', '/', $link);
    }
}