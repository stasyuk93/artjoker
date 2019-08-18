<?php

namespace Model;


class City extends KOATUU
{
    public function getAllCitiesByRegion($region_id)
    {
        return $this->where('reg_id',$region_id)->where('ter_level', 2)->findAll();
    }


}