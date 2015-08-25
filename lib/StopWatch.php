<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/25/2015 AD
 * Time: 4:27 AM
 */

namespace lib;


class StopWatch {
    /**
     * @var $start float The start time of the StopWatch
     */
    private static $startTimes = array();
    /**
     * Start the timer
     *
     * @param $timerName string The name of the timer
     * @return void
     */
    public static function start($timerName = 'default'){
        self::$startTimes[$timerName] = microtime(true);
    }
    /**
     * Get the elapsed time in seconds
     *
     * @param $timerName string The name of the timer to start
     * @return float The elapsed time since start() was called
     */
    public static function elapsed($timerName = 'default'){
        return microtime(true) - self::$startTimes[$timerName];
    }
}