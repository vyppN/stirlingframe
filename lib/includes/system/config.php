<?php

namespace system;

class Config
{
    public static $app = array();
    public static $database = array();
    public static $authpath = array();

    public static function load()
    {
        self::$app = require path('app').DS.'config'.DS.'app.php';
        self::$database = require path('app').DS.'config'.DS.'database.php';
        self::$authpath = require path('app').DS.'config'.DS.'authen.php';
    }
}