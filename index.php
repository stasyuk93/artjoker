<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'Library/autoload.php';

try{

    $class = new \Library\Router();
    $class->map('/', 'UserController@index');
    $class->map('/region', 'TerritoryController@getAllRegions');
    $class->map('/region/:region_id/cities', 'TerritoryController@getAllCitiesByRegion',['filters' => ['region_id' => '([\d]{1,2})']]);
    $class->map('/city/:ter_id/village', 'TerritoryController@getAllChildrenTerritoryByCity',['filters' => ['ter_id' => '([\d]{10})']]);
//    $class->map('/city/:ter_id/urban-village', 'TerritoryController@getAllVillageByCity',['filters' => ['ter_id' => '([\d]{10})']]);

    $class->map('/qwe/:name/tet/:tet', function($name,$tet) { echo "Hello $name. for $tet"; },['methods'=>'GET']);

    $class->handler();

//    $a = $class->matchCurrentRequest();
//    $target = $a->getTarget();

//    $obj = 1;
//    \Library\dd($a->getTarget());
} catch (Exception $e){
    dump($e);
}
