<?php

namespace View;

class View
{
    protected $baseFileTemplate = 'app';

    protected $content;

    protected $params;

    protected $basePath = 'Templates/';

    public function render()
    {
        echo $this->content;
    }

    public function getPathBaseTemplate()
    {
        return $this->basePath.$this->baseFileTemplate;
    }

    public function renderByBaseTempalte($content)
    {
        return view($this->getPathBaseTemplate(),['content' => $content]);
    }
}