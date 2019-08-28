<?php

namespace Model;


class Region extends KOATUU
{

    public function getAll()
    {
        $data = $this->query()->where('ter_type_id',0)->all();
        if($data){
            $this->setDatas($data);
            return $this->getData();
        }
        return null;
    }
}