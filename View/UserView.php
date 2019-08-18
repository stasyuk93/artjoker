<?php

namespace View;

class UserView extends View
{

    protected $path = 'user/';

    public function index(array $params)
    {
        $this->content = $this->renderByBaseTempalte(view($this->getPath('index'), $params));
        $this->render();

    }

    public function getPath($path)
    {
        return $this->basePath.$this->path.$path;
    }

    public function register(array $params)
    {
        $this->content = $this->renderByBaseTempalte(view($this->getPath('register'), $params));
        $this->render();
    }

}