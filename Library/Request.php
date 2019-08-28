<?php

namespace Library;


class Request
{

    private $request = [];

    private $get = [];

    public function __construct()
    {
        $this->request = $_REQUEST;
        $this->get = $_GET;
    }

    public function currentUrl()
    {
        $uri =  $_SERVER['REQUEST_URI'];
        if(($pos = strpos($uri, '?')) !== false) {
            $uri =  substr($uri, 0, $pos);
        }
        return $uri;
    }

    public function __get($key)
    {
        if(array_key_exists($key,$this->request)){
            return $this->request[$key];
        }
        return null;
    }

    public function __set($key, $value)
    {
        $this->request[$key] = $value;
        return $this;
    }

    public function setGet($key, $value)
    {
        $this->request[$key] = $this->get[$key] = $value;
        return $this;
    }

    public function getUrlWithParams($params = [], $url = null)
    {
        if($url === null) $url = $this->currentUrl();
        $request = '';
        if($this->get){
            foreach ($this->get as $key => $value) {
                if(array_key_exists($key,$params)) continue;
                $request .= "$key=$value&";
            }
        }
        if ($params){
            foreach ($params as $key => $value){
                $request .= "$key=$value&";
            }
        }
        $request = substr($request, 0, -1);
        if($request){
            $url .= '?'.$request;
        }

        return $url;
    }

}