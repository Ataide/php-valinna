<?php

class Banco
{
    private static $user = 'postgres';
    private static $password = 'pass';

    private static $cont = null;

    public function __construct()
    {
        die('Init não implementada.');
    }

    public static function connect()
    {
        if (null == self::$cont) {
            try
            {
                $dsn = "pgsql:host=10.0.0.107;port=5433;dbname=postgres;";
                self::$cont = new PDO($dsn, self::$user, self::$password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            } catch (PDOException $exception) {
                die($exception->getMessage());
            }
        }
        return self::$cont;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }
}
