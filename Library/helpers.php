<?php

function app($key)
{
    return \Library\Container::get($key);
}

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

function view($pathView, array $params = [])
{
    $pathView = $pathView.".php";
    if(file_exists($pathView)){
        ob_start();
        if($params) extract($params);
        include ($pathView);
        $view = ob_get_clean();
        return $view;
    }
    throw new Exception("File $pathView not exists");
}

function responseJson($variable)
{
    header("Content-Type: application/json");
    echo json_encode($variable);
}

function setError($msg,$data = null)
{
    $_SESSION['error']['message'] = $msg;
    if($data) $_SESSION['error']['data'] = $data;
}

function unsetError()
{
    unset($_SESSION['error']);
}

function error()
{
    if(isset($_SESSION['error'])) return $_SESSION['error'];
    return null;
}

function old($key)
{
    if(isset( $_SESSION['old'][$key])) return $_SESSION['old'][$key];
    return null;
}

function redirect($uri,$setRequest = false)
{
    if($setRequest) $_SESSION['old'] = $_REQUEST;
    if($uri == '/') $uri = '';
    header("Location: {$_SERVER['HTTP_ORIGIN']}/$uri");
    exit();
}

/**
 * @return bool|Library\Router
 */
function route()
{
    return app('Router');
}

/**
 * @return bool|Library\Request
 */
function request()
{
    return app('Request');
}

function notFound()
{
    header("HTTP/1.0 404 Not Found");
    echo "404 Not found";
    exit();
}