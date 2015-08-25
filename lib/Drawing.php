<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/24/2015 AD
 * Time: 11:39 PM
 */

namespace lib;


class Drawing
{
    public static function ERROR_BOX($boxheader, $message1, $message2 = null)
    {
        $tl = html_entity_decode('&#x2554;', ENT_NOQUOTES, 'UTF-8'); // top left corner
        $tr = html_entity_decode('&#x2557;', ENT_NOQUOTES, 'UTF-8'); // top right corner
        $bl = html_entity_decode('&#x255a;', ENT_NOQUOTES, 'UTF-8'); // bottom left corner
        $br = html_entity_decode('&#x255d;', ENT_NOQUOTES, 'UTF-8'); // bottom right corner
        $v = html_entity_decode('&#x2502;', ENT_NOQUOTES, 'UTF-8');  // vertical wall
        $h = html_entity_decode('&#x2500;', ENT_NOQUOTES, 'UTF-8');  // horizontal wall

        $message1_len = 44 - strlen($message1);
        $message1_len = $message1_len < 0 ? 0 : $message1_len;

        $message2_len = 44 - strlen($message2);
        $message2_len = $message2_len < 0 ? 0 : $message2_len;

        $data =
            $tl . str_repeat($h, 45) . $tr . PHP_EOL .
            $v . str_repeat(' ', 45) . $v . PHP_EOL .
            $v .' '.Color::BOLD_UNDERLINE_RED. $boxheader .Color::RESET . str_repeat(' ', 44 - strlen($boxheader)) . $v . PHP_EOL .
            $v .' '. $message1 . str_repeat(' ', $message1_len) . $v . PHP_EOL;
        if ($message2 != null) {
            $data .= $v . ' '.$message2 . str_repeat(' ', $message2_len) . $v . PHP_EOL;
        }
        $data .= $v . str_repeat(' ', 45) . $v . PHP_EOL .
            $bl . str_repeat($h, 45) . $br . PHP_EOL;

        return $data;
    }

    public static function SUCCESS_BOX($boxheader, $message1, $message2 = null)
    {
        $tl = html_entity_decode('&#x2554;', ENT_NOQUOTES, 'UTF-8'); // top left corner
        $tr = html_entity_decode('&#x2557;', ENT_NOQUOTES, 'UTF-8'); // top right corner
        $bl = html_entity_decode('&#x255a;', ENT_NOQUOTES, 'UTF-8'); // bottom left corner
        $br = html_entity_decode('&#x255d;', ENT_NOQUOTES, 'UTF-8'); // bottom right corner
        $v = html_entity_decode('&#x2502;', ENT_NOQUOTES, 'UTF-8');  // vertical wall
        $h = html_entity_decode('&#x2500;', ENT_NOQUOTES, 'UTF-8');  // horizontal wall


        $data =
            $tl . str_repeat($h, 45) . $tr . PHP_EOL .
            $v . str_repeat(' ', 45) . $v . PHP_EOL .
            $v .' '.Color::GREEN. $boxheader .Color::RESET . str_repeat(' ', 44 - strlen($boxheader)). $v . PHP_EOL .
            $v .' '. $message1 . str_repeat(' ', 44 - strlen($message1)) . $v . PHP_EOL;
        if ($message2 != null) {
            $data .= $v . ' '.$message2 . str_repeat(' ', 44 - strlen($message2)) . $v . PHP_EOL;
        }
        $data .= $v . str_repeat(' ', 45) . $v . PHP_EOL .
            $bl . str_repeat($h, 45) . $br . PHP_EOL;

        return $data;
    }
}