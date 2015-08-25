<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/23/2015 AD
 * Time: 7:03 PM
 */

namespace system\security;


class RestrictController extends Authentication
{
    public function __construct($path, array $roles)
    {
        $newpath = FilterPath::restrictController($path);
        parent::__construct($newpath, $roles);
    }

}