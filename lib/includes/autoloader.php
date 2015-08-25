<?php

class Autoloader
{

    public static function load($class){
        $filename = __DIR__.DS.strtolower($class).'.php';
        if(!self::isWindows()){
            $filename = str_replace('\\','/',$filename);
        }
        if(file_exists($filename)){
            require $filename;
        }
    }

    public static function loadGlobal()
    {
        $directories = include path('app').DS.'config'.DS.'autoload_dir.php';

        if(!empty($directories)){
            foreach($directories as $directory){
                $handle = opendir(path('app').DS.$directory.DS);
                while(false !== ($entry = readdir($handle))){
                    if($entry != '.' && $entry != '..' && $entry != '.php'){
                        require path('app').DS.$directory.DS.$entry;
                    }
                }
            }
        }
    }

    private static function isWindows(){
        return (strtoupper(substr(PHP_OS,0,3))==='WIN');
    }
}