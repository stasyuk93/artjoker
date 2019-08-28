<?php

namespace Model;
use Model\KOATUU;
use Library\Paginate;

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