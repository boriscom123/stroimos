<?php
namespace AppBundle\Twig;

use Html2Text\Html2Text;

class NewsletterPostTextCropExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'newsletter_post_text_crop';
    }

    public function getFilters()
    {
      return array(
          new \Twig_SimpleFilter('newsletter_post_text_crop', array($this, 'cropText')),
      );
    }

    public function cropText($text)
    {
      $words = array(
        'сообщил', 'сообщила', 'сообщили',
        'заявил', 'заявила', 'заявили',
        'рассказал', 'рассказала', 'рассказали',
        'сказал', 'сказала', 'сказали',
        'отметил', 'отметила', 'отметили',
        'добавил', 'добавила', 'добавили',
        'пояснил', 'пояснила', 'пояснили',
        'заключил', 'заключила', 'заключили'
      );
      foreach ($words as $word) {
        $pos = strpos($text, $word);        
        if ($pos !== false) {          
          $text = substr(explode($word, $text)[0], 0, -2).'.';          
          break;
        }
      }      
      return $text;
    }    
}
