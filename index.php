<?php
session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once 'Library/autoload.php';
try{

    $class = new \Library\Router();
    $class->map('/', 'UserController@index');
    $class->map('/register', 'UserController@registerForm',['methods'=>'GET']);
    $class->map('/user/create', 'UserController@create',['methods'=>'POST']);
    $class->map('/territory/:ter_id/children', 'TerritoryController@getAllChildrenTerritory',['filters' => ['ter_id' => '([\d]{10})']]);

    $class->handler();

} catch (Exception $e){
    dump($e);
}
