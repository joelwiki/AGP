<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 25/03/18
 * Time: 17:40
 */

namespace AppBundle\Utils;

class ReplaceAccentedChar {

    private static $accented_characters_replacement = array(
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a',
        'Þ'=>'B',
        'þ'=>'b',
        'Ç'=>'C',
        'ç'=>'c',
        'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e',
        'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I',
        'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i',
        'Ñ'=>'N',
        'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O',
        'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o',
        'Š'=>'S',
        'š'=>'s',
        'ß'=>'Ss',
        'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U',
        'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü' => 'u',
        'Ý'=>'Y',
        'ý'=>'y', 'ÿ'=>'y',
        'Ž'=>'Z',
        'ž'=>'z',
        '&' => '',
        '\''=>'',
        '"'=>'',
        '@'=>'',
        '€'=>'',
        '$'=>''
    );

    public static function replace_accented_char($orig_string) {
        if (!isset($orig_string)) {
            return false;
        }

        $str = strtr( $orig_string, self::$accented_characters_replacement );

        return $str;
    }
}