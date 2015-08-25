<?php

function path($path){
    $paths = array('sys'=>__DIR__.DS.'system','app'=>__DIR__.DS.'app');
    return $paths[$path];
}