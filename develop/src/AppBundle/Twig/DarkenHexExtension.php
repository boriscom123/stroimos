<?php
namespace AppBundle\Twig;

class DarkenHexExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'darken_hex';
    }

    public function getFilters()
    {
      return array(
          new \Twig_SimpleFilter('darken_hex', array($this, 'darken')),
      );
    }

    public function darken($hex)
    {
      $percent = '-0.4';
      $hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
      $new_hex = '#';

      if ( strlen( $hex ) < 6 ) {
        $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
      }

      for ($i = 0; $i < 3; $i++) {
        $dec = hexdec( substr( $hex, $i*2, 2 ) );
        $dec = min( max( 0, $dec + $dec * $percent ), 255 );
        $new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
      }

      return $new_hex;
    }
}