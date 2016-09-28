<?php
class Database
{
    private static $connection;

    private static function connect()
    {
        $server = 'localhost';
        $database = 'jugueton';
        $username = 'root';
        $password = '';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8");
        self::$connection = null;
        try
        {
            self::$connection = new PDO("mysql:host=".$server."; dbname=".$database, $username, $password, $options);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $exception)
        {
            die($exception->getMessage());
        }
    }

    private static function desconnect()
    {
        self::$connection = null;
    }

    public static function executeRow($query, $values = null)
    {
        $res = false;
        self::connect();
        $statement = self::$connection->prepare($query);
        $res = $statement->execute($values);
        self::desconnect();
        return $res;
    }

    public static function getRow($query, $values = null) {
        self::connect();
        $statement = null;
        $statement = self::$connection->prepare($query);
        $statement->execute($values);
        self::desconnect();
        return $statement->fetch(PDO::FETCH_BOTH);
    }

    public static function getRows($query, $values = null) {
        self::connect();
        $statement = self::$connection->prepare($query);
        $statement->execute($values);
        self::desconnect();
        return $statement->fetchAll(PDO::FETCH_BOTH);
    }

    public static function getValue($query, $values = null, $indice) {
        $fila = self::getRow($query, $values);
        return $fila[$indice];
    }
}
?>