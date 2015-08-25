<?php
error_reporting(E_ALL);


function __autoload($class) {
    $output = str_replace('\\', '/', $class);
    require_once $output.'.php';
}


use lib\Color;
use lib\Drawing;

if (function_exists($argv[1])) {
    call_user_func_array($argv[1], $argv);
} else {

    $boxheader = "Stirlingframe command error:";
    $massage1 = '# Cloud not find command `'.Color::MEGENTA.$argv[1].Color::RESET.'`          ';
    $resolve = '# Please check your command again.';

    fwrite(STDOUT,PHP_EOL);
    fwrite(STDOUT,Color::BOLD_RED.'[[ERROR]]: Command not found.'.Color::RESET.PHP_EOL);
    fwrite(STDOUT,Drawing::ERROR_BOX($boxheader,$massage1,$resolve));
    fwrite(STDOUT,PHP_EOL);
}

function create(){
    $command = $_SERVER['argv'];
    \lib\Generator::create($command);
}

function test(){
    \lib\Generator::test();
}

function run(){
    $command = $_SERVER['argv'];
    \lib\Server::runserver($command);
}

function delete(){
    $command = $_SERVER['argv'];
    \lib\Generator::delete($command);
}
