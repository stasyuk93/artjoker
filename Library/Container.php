<?php

namespace Library;


class Container
{
    private static $app = [];

    public static function get($key)
    {
        if(array_key_exists($key, self::$app)) {
            return self::$app[$key];
        }
        return false;
    }

    public static function set($key, $class)
    {
        self::$app[$key] = new $class();
    }


    public static function init()
    {
        $services = include 'config/services.php';
        foreach ($services['alias'] as $key => $value){
            self::set($key,$value);
        }
    }
}