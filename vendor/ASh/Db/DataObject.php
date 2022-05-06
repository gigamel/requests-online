<?php

namespace vendor\ASh\Db;

use PDOException;
use abstracts\Base;

final class DataObject extends Base
{
    /**
     * @var null|\PDO $dbh 
     */
    public static $dbh;

    private function __construct() {}
    
    /**
     * @return null|DataObject
     */
    public static function connect(): ?DataObject
    {
        if (static::$dbh instanceof \PDO) {
            return static::$dbh;
        }

        try {
            $settings = \ASh::$app->getOption('pdo');

            $settings['dsn'] = (string)($settings['dsn'] ?? '');
            $settings['user'] = (string)($settings['user'] ?? '');
            $settings['password'] = (string)($settings['password'] ?? '');

            static::$dbh = new \PDO(
                $settings['dsn'],
                $settings['user'],
                $settings['password']
            );
        } catch (PDOException $e) {
            static::$dbh = null;
        }
        
        return static::$dbh;
    }
}
