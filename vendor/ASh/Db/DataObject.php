<?php
namespace vendor\ASh\Db;

use ASh;
use PDO;
use PDOException;
use abstracts\Base;

final class DataObject extends Base
{
    /**
     * @var null|\PDO $dbh 
     */
    public static $dbh = null;
    
    /**
     * @return null|DataObject
     */
    public static function connect()
    {
        if (static::$dbh === null) {
            try {
                $settings = ASh::$app->getOption('pdo');
                
                $settings['dsn'] = is_string($settings['dsn']) ? $settings['dsn'] : null;
                $settings['user'] = is_string($settings['user']) ? $settings['user'] : null;
                $settings['password'] = is_string($settings['password']) ? $settings['password'] : null;
                
                static::$dbh = new PDO($settings['dsn'], $settings['user'], $settings['password']);
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