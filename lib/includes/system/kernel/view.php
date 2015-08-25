<?php

namespace system\kernel;


/**
 * Class View
 * @package system\kernel
 */
class View
{
    public $view_file;
    public $data;
    private static $view = null;

    /**
     * @return View
     */
    public static function &instance()
    {
        return self::$view;
    }

    public static function response($view_file, $data=array())
    {
        $data['home'] = HOME;
        $data['publics'] = PUBLICS;
        $data['javascripts'] = JAVASCRIPT;
        $data['stylesheets'] = STYLESHEETS;
        $data['images'] = PICTURES;
        $data['css'] = Controller::loadCSS();



        if(is_null(self::$view)){
            self::$view = new View;
        }
        self::$view->view_file = $view_file;
        self::$view->data = $data;
    }

    public function launch(){
        $view_file = str_replace('.',DS,$this->view_file);
        $path = path('app').DS.'views';
        require_once ROOT.DS.'vendor'.DS.'autoload.php';
        $loader = new \Twig_Loader_Filesystem($path);
        $twig = new \Twig_Environment($loader);

        echo $twig->render($view_file.'.twig',$this->data);
    }
}