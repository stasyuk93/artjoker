<?php

namespace Model;


class Region extends KOATUU
{

    public function getAll()
    {
        return $this->where('ter_type_id',0)->findAll();
    }


}