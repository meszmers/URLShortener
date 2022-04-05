<?php

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class Database
{
    private static ?Connection $connection = null;

    public static function connection(): Connection
    {
        if (self::$connection === null) {
            $connectionParams = [
                'dbname' => 'URLShortener',
                'user' => 'root',
                'password' => 'password',
                'host' => 'localhost',
                'driver' => 'pdo_mysql',
            ];

            try {
                self::$connection = DriverManager::getConnection($connectionParams);
            } catch (Exception $e) {
                echo 'Connection Error: ' . $e->getMessage();
                die;
            }

        }
        return self::$connection;
    }
}