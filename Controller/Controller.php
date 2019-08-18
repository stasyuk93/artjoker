<?php

namespace Controller;


class Controller
{
    public function getPostData(array $fields)
    {
        $post = $_POST;
        $result = [];
        foreach ($fields as $field){
            if(is_array($field)) $field = $this->getPostData($field);
            if(isset($post[$field]) && !empty($post[$field])){
                $result[$field] = $post[$field];
            } else {
                $result[$field] = null;
            }
        }
        return $result;
    }
}