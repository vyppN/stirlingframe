<?php


namespace system\database;
use MongoClient;

class MongoConnection {
    static $db = NULL;

    public static function getConnection($dbhost = '127.0.0.1', $dbname = 'pcare')
    {
        if (self::$db === NULL)
        {
            try
            {
                $m = new MongoClient("mongodb://admin:fk86~hB4xlKHfEv@$dbhost:27017");
            } catch (MongoConnectionException $e)
            {
                die('Failed to connect to MongoDB ' . $e->getMessage());
            }
            self::$db = $m->$dbname;
        }

        return self::$db;
    }
}
