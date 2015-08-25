<?php
use system\kernel\Security;

ob_start();
session_start();

if(!preg_match('/^(505.{2})$/',PHP_VERSION_ID,$matches)){
    echo 'Needs PHP 5.5+, please update your PHP version';
    die();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);


/* DEFINE CONSTANT */
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", __DIR__);


/* INITIALIZE*/
require __DIR__ . DS . 'paths.php';
require __DIR__ . DS . 'autoloader.php';
require __DIR__.DS.'vendor'.DS.'autoload.php';


/* AUTOLOAD CLASSES */
spl_autoload_register(array('Autoloader','load'));
Autoloader::loadGlobal();
system\Config::load();

/*CSRF Protection*/
if(system\Config::$app['csrf']) {
    require 'csrf.php';
}

/* SET HOME URL */
define('HOME',system\Config::$app['base_url']);
define('PUBLICS',HOME.'app/publics/');
define('PICTURES',PUBLICS.'images/');
define('STYLESHEETS', PUBLICS.'css/');
define('JAVASCRIPT', PUBLICS.'js/');


/* CACHE */
$enable_cache = system\Config::$app['cache'];

if($enable_cache) {
    require_once __DIR__ . DS . 'system' . DS . 'cache.php';
}


/* ROUTER */
$router = new system\Router();
if(isset($_SERVER['PATH_INFO'])){

    $uri = $_SERVER['PATH_INFO'];
    if(!Security::Instance()->filter($uri)){
        $uri = '/denied';
    }
    $router->pathRoute($uri);
}else{
    $router->defaultRoute();
}

$router->launch();

if(!is_null($view = system\kernel\View::instance())){
    $view->launch();
}

/* END CACHE */
if($enable_cache) {
    require_once __DIR__ . DS . 'system' . DS . 'endcache.php';
}