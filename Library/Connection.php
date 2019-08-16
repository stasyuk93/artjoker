<?php

namespace Library;

use PDO;
use PDOException;

class Connection
{
    private $DRIVER;
    private $HOST;
    private $USER;
    private $PASSWORD;
    private $NAME;
    private $CHARSET;
    private $pdo;

    public function __construct()
    {

            $this->setConfig();
            $dsn = "$this->DRIVER:host=$this->HOST;dbname=$this->NAME;charset=$this->CHARSET";
            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->pdo = new PDO($dsn, $this->USER, $this->PASSWORD, $opt);
    }

    private function setConfig()
    {
        $this->DRIVER = config('db_driver','mysql');
        $this->CHARSET = config('charset','utf8');
        $this->USER = config('db_user');
        $this->PASSWORD = config('db_password','');
        $this->HOST = config('db_host','127.0.0.1');
        $this->NAME = config('db_name','');
    }

    public function getPDO()
    {
        return $this->pdo;
    }

}