<?php

namespace Model;
use Model\KOATUU;

class User extends Model
{

    protected $fillable = [
        'id',
        'name',
        'email',
        'city_id',
    ];

    public function territory()
    {
        $koatu = new KOATUU();
        return $koatu->find($this->city_id);
    }
}