<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/23/2015 AD
 * Time: 5:58 PM
 */

namespace system\security;


class FilterPath
{

    public static function restrictController($controller){
        return "/^(\\/)(($controller)(\\/)(.*)|($controller$))/";
    }

    public static function restrictMethod($controller,$method){
        return "/^(\\/$controller\\/$method\\/)(,*)|^(\\/$controller\\/$method$)/";
    }

    public static function staticPath($path){
        $path = str_replace('/','\\/',$path);
        return "/^($path)(\\/?)$/";
    }
}