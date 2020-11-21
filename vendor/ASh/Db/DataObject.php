<?php
namespace vendor\ASh\Db;

use PDO;
use PDOException;
use abstracts\Base;

class DataObject extends Base
{
    /**
     * @var null|\PDO $dbh 
     */
    public static $dbh = null;
    
    public static function connect()
    {
        if (static::$dbh === null) {
            try {
                static::$dbh = new PDO("mysql:host=localhost;dbname=name;charset=utf8", "user", "password");
            } catch (PDOException $e) {
                static::$dbh = null;
            }
        }
        
        return static::$dbh;
    }
    
    private function __construct()
    {
    }
}
