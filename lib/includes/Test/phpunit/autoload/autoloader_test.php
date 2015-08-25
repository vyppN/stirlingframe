<?php

define(DS,DIRECTORY_SEPARATOR);
define(ROOT,dirname(dirname(dirname(dirname(__FILE__)))));
define(APPROOT,ROOT.DS.'app');

class AutoloaderTest
{
    public static $directories = ['models','controllers'];

    public static function loadtest($class){
        $filename = ROOT.DS.strtolower($class).'.php';
        if(!self::isWindows()){
            $filename = str_replace('\\','/',$filename);
        }
        if(file_exists($filename)){
            require $filename;
        }
    }

    public static function loadGlobal()
    {
        if(!empty(self::$directories)){
            foreach(self::$directories as $directory){
                $handle = opendir(APPROOT.DS.$directory.DS);
                while(false !== ($entry = readdir($handle))){
                    if($entry != '.' && $entry != '..' && $entry != '.php'){
                        require APPROOT.DS.$directory.DS.$entry;
                    }
                }
            }
        }
        self::$directories = array();
    }

    private static function isWindows(){
        return (strtoupper(substr(PHP_OS,0,3))==='WIN');
    }
}