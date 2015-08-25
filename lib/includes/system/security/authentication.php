<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/17/2015 AD
 * Time: 4:48 AM
 */

namespace system\security;


abstract class Authentication
{
    /**
     * @var String $path;
     */
    private $path;

    /**
     * @var array $roles;
     */
    private $roles;

    /**
     * Authentication constructor.
     * @param String $path
     * @param array $roles
     */
    public function __construct($path, array $roles)
    {
        $this->path = $path;
        $this->roles = $roles;
    }

    /**
     * @return String
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

}