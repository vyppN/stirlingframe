<?php

namespace system\kernel;



use system\security\Authentication;
use system\security\User;
use system\Config;

final class Security
{

    private static $security = null;

    /**
     * Security constructor.
     */
    private function __construct()
    {
    }

    public static function Instance()
    {
        if (self::$security === null) {
            self::$security = new Security();
        }
        return self::$security;
    }

    public function filter($path){
        $authens = Config::$authpath;
        return $this->checkRoute($path,$authens);
    }

    private function checkRoute($path,$authens){
        $user = new User();
        /**
         * @var Authentication $auth
         */
        foreach ($authens as $auth) {
            if(preg_match($auth->getPath(),$path,$matches)){
                if($user->hasSession()){
                    $userRoles = $user->getRoles();
                    foreach ($userRoles as $role) {
                        if(in_array($role,$auth->getRoles())){
                            return true;
                        }
                    }

                }
                return false;
            }
        }
        return true;
    }
}