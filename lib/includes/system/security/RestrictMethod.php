<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/23/2015 AD
 * Time: 7:06 PM
 */

namespace system\security;


class RestrictMethod extends Authentication
{
    public function __construct($path, array $roles)
    {
        $arr = explode('.',$path);
        $newpath = FilterPath::restrictMethod($arr[0],$arr[1]);
        parent::__construct($newpath, $roles);
    }

}