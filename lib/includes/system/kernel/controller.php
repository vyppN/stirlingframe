<?php

namespace system\kernel;


abstract class Controller {
    public $restful = true;

    public static function loadCSS()
    {
        $css = "";
        $dir = scandir(ROOT . DS . 'app' . DS . 'publics' . DS . 'css'.DS.'autoload');
        if($dir !== false){
            foreach($dir as $value){
                if(strpos($value,'css')){
                    $css .= '<link rel="stylesheet" href="' . PUBLICS . 'css/autoload/' . $value . '">';
                }
            }
        }
        return $css;
    }
}