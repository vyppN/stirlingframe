<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/24/2015 AD
 * Time: 1:54 AM
 */

namespace system\generator;


class ReflectionHelper
{

    public function checkPatternWithMultipleParams($pattern,$string){
        preg_match_all($pattern, $string, $varAnnotations);
        return $varAnnotations[2][0];
    }

    public function checkPatternWithSingleParams($pattern,$string){
        preg_match_all($pattern, $string, $varAnnotations);
        return $varAnnotations[1][0];
    }
}