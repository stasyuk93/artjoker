<?php

namespace Library;
use PDO;
use PDOException;

class Database
{
    /**
     * Объект PDO.
     */
    private static $dbh = null;

    /**
     * Statement Handle.
     */
    private static $sth = null;

    /**
     * Подключение к БД
     */
    public static function getDbh()
    {
        if (!self::$dbh) {
            $connection = new Connection();
            self::$dbh = $connection->getPDO();
        }

        return self::$dbh;
    }

    /**
     * Добавление в таблицу, в случаи успеха вернет вставленный ID, иначе 0.
     */
    public static function add($query, $param = array())
    {
        self::$sth = self::getDbh()->prepare($query);
        return (self::$sth->execute((array) $param)) ? self::getDbh()->lastInsertId() : 0;
    }

    /**
     * Выполнение запроса.
     */
    public static function set($query, $param = array())
    {
        self::$sth = self::getDbh()->prepare($query);
        return self::$sth->execute((array) $param);
    }

    /**
     * Получение строки из таблицы.
     */
    public static function getRow($query, $param = array())
    {
        self::$sth = self::getDbh()->prepare($query);
        self::$sth->execute((array) $param);
        return self::$sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Получение всех строк из таблицы.
     */
    public static function getAll($query, $param = array())
    {
        self::$sth = self::getDbh()->prepare($query);
        self::$sth->execute((array) $param);
//        self::$sth->debugDumpParams();
        $data =  self::$sth->fetchAll(PDO::FETCH_ASSOC);
        if(!$data) return null;
        return $data;
    }

    /**
     * Получение значения.
     */
    public static function getValue($query, $param = array(), $default = null)
    {
        $result = self::getRow($query, $param);
        if (!empty($result)) {
            $result = array_shift($result);
        }

        return (empty($result)) ? $default : $result;
    }

    /**
     * Получение столбца таблицы.
     */
    public static function getColumn($query, $param = array())
    {
        self::$sth = self::getDbh()->prepare($query);
        self::$sth->execute((array) $param);
        return self::$sth->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * @param $query
     * @param array $param
     * @return mixed
     */
    public static function getFetchColumn($query, $param = array())
    {
        self::$sth = self::getDbh()->prepare($query);
        self::$sth->execute((array) $param);
        return self::$sth->fetchColumn();
    }
}