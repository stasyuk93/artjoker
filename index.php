<?php
session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once 'Library/autoload.php';
try{
    route()->map('/', 'UserController@index');
    route()->map('/register', 'UserController@registerForm',['methods'=>'GET']);
    route()->map('/register/test', 'UserController@registerForm',['methods'=>'GET']);
    route()->map('/user/create', 'UserController@create',['methods'=>'POST']);
    route()->map('/territory/{ter_id}/children', 'TerritoryController@getAllChildrenTerritory',['filters' => ['ter_id' => '([\d]{10})']]);
    route()->handler();

} catch (Exception $e){
    dump($e);
}
