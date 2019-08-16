<?php

//namespace Library;
//
//use Closure;


/**
 * Gets the value of an environment variable.
 *
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function config($key, $default = null)
{
    $config = parse_ini_file(dirname(__DIR__).'/config.ini');
    if(array_key_exists($key,$config)){
        return $config[$key];
    } else {
        return $default;
    }
}

function dump($variable)
{
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
}

function dd($variable)
{
    dump($variable);
    die();
}
