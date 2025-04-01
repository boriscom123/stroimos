<?php
namespace AppBundle\DataFixtures\ORM;

class TextSource
{
    public static $news;
    public static $galleries;
    public static $videos;
    public static $infographics;

    public static function loadCsv($filename, callable $rowCallback = null)
    {
        $filename = sprintf('%s/%s', __DIR__ . '/../data/', $filename);


        $file = fopen($filename, 'r');
        if (false === $file) {
            throw new \RuntimeException(sprintf('Could not open %s for reading', $filename));
        }

        $data = [];
        $headers = null;
        while (!feof($file)) {
            $row = fgetcsv($file, 65535, ';', '"');
            if (!isset($headers)) {
                $headers = $row;
                continue;
            }

            if (!is_array($row)) {
                continue;
            }

            $row = array_combine($headers, $row);
            /*$row = array_map(function ($v) {
                return 'NULL' === $v ? null : htmlspecialchars_decode($v, ENT_QUOTES);
            }, $row);*/

            if (!empty($row['text'])) {
                $row['text'] = str_replace('"/images/', '"http://stroi.mos.ru/images/', $row['text']);
                $row['text'] = str_replace('"/uploads/', '"http://stroi.mos.ru/uploads/', $row['text']);
                $row['text'] = str_replace('" /uploads/', '"http://stroi.mos.ru/uploads/', $row['text']);
            }

            if (is_callable($rowCallback)) {
                $rowCallback($row);
            }

            $data[] = $row;
        }

        fclose($file);

        return $data;
    }

    public static function getNewsRow()
    {
        if (!isset(self::$news)) {
            self::$news = self::loadCsv('stub/news.csv');
            reset(self::$news);
        }

        $row = current(self::$news);
        if (empty($row)) {
            reset(self::$news);
            $row = current(self::$news);
        }
        next(self::$news);

        return $row;
    }

    public static function getGalleryRow()
    {
        if (!isset(self::$galleries)) {
            self::$galleries = self::loadCsv('stub/gallery.csv');
            reset(self::$galleries);
        }

        $row = current(self::$galleries);
        if (empty($row)) {
            reset(self::$galleries);
            $row = current(self::$galleries);
        }
        next(self::$galleries);

        return $row;
    }

    public static function getVideoRow()
    {
        if (!isset(self::$videos)) {
            self::$videos = self::loadCsv('stub/video.csv');
            reset(self::$videos);
        }

        $row = current(self::$videos);
        if (empty($row)) {
            reset(self::$videos);
            $row = current(self::$videos);
        }
        next(self::$videos);

        return $row;
    }

    public static function getInfographicsRow()
    {
        if (!isset(self::$infographics)) {
            self::$infographics = self::loadCsv('stub/infographics.csv');
            reset(self::$infographics);
        }

        $row = current(self::$infographics);
        if (empty($row)) {
            reset(self::$infographics);
            $row = current(self::$infographics);
        }
        next(self::$infographics);

        return $row;
    }

    public static function parseDelimitedString($string, $delimiter = '|')
    {
        $arr = array_map(function($item) {
            return trim($item, " \n\r\t");
        }, explode($delimiter, $string));

        $arr = array_diff($arr, ['\N']);

        return array_filter($arr);
    }
}
