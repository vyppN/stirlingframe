<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/18/2015 AD
 * Time: 12:45 AM
 */

namespace system\kernel;


class Session
{

    private $sessionName;

    public function __construct($sessionName=null, $regenerateId=false, $sessionId=null)
    {
        if (!is_null($sessionId)) {
            session_id($sessionId);
        }

        if ($regenerateId) {
            //session_regenerate_id(true);
        }

        if (!is_null($sessionName)) {
            $this->sessionName = session_name($sessionName);
        }
    }


    protected function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    /*
        to set something like $_SESSION['key1']['key2']['key3']:
        $session->setMd(array('key1', 'key2', 'key3'), 'value')
    */
    protected function setMd($keyArray, $val)
    {
        $arrStr = "['".implode("']['", $keyArray)."']";
        $_SESSION{$arrStr} = $val;
    }


    protected function get($key)
    {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : false;
    }

    /*
        to get something like $_SESSION['key1']['key2']['key3']:
        $session->getMd(array('key1', 'key2', 'key3'))
    */
    protected function getMd($keyArray)
    {
        $arrStr = "['".implode("']['", $keyArray)."']";
        return (isset($_SESSION{$arrStr})) ? $_SESSION{$arrStr} : false;
    }


    protected function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }


    protected function deleteMd($keyArray)
    {
        $arrStr = "['".implode("']['", $keyArray)."']";
        if (isset($_SESSION{$arrStr})) {
            unset($_SESSION{$arrStr});
            return true;
        }
        return false;
    }


    protected function regenerateId($destroyOldSession=false)
    {
        session_regenerate_id(false);

        if ($destroyOldSession) {
            //  hang on to the new session id and name
            $sid = session_id();
            //  close the old and new sessions
            session_write_close();
            //  re-open the new session
            session_id($sid);
            session_start();
        }
    }


    protected function destroy()
    {
        return session_destroy();
    }


    protected function getName()
    {
        return $this->sessionName;
    }

}