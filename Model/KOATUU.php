<?php

namespace Model;


class KOATUU extends Model
{
    protected $_table = 't_koatuu_tree';

    protected $primaryKey = 'ter_id';

    protected $fillable = [
        'ter_id',
        'ter_pid',
        'ter_name',
        'ter_address',
        'ter_type_id',
        'ter_level',
        'ter_mask',
        'reg_id',
    ];

    public function getAllChildrenTerritory($ter_id)
    {
        return $this->query()->where('ter_pid',$ter_id)->all();
    }

}