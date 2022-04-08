<?php

namespace App\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class DatabasePDO
{
    private static ?Connection $connection = null;

    public static function connection(): Connection
    {
        if (self::$connection === null) {
            $connectionParams = [
                'dbname' => $_ENV['DBNAME'],
                'user' => $_ENV['USER'],
                'password' => $_ENV['PASSWORD'],
                'host' => $_ENV['HOST'],
                'driver' => $_ENV['DRIVER'],
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