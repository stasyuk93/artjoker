<?php

namespace Model;


class KOATUU extends Model
{
    protected $table = 't_koatuu_tree';

    private $ter_id;

    private $ter_pid;

    private $ter_name;

    private $ter_address;

    private $ter_type_id;

    private $ter_level;

    private $ter_mask;

    private $reg_id;

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

    /**
     * @return mixed
     */
    public function getTerId()
    {
        return $this->ter_id;
    }

    /**
     * @return mixed
     */
    public function getTerPid()
    {
        return $this->ter_pid;
    }

    /**
     * @return mixed
     */
    public function getTerName()
    {
        return $this->ter_name;
    }

    /**
     * @return mixed
     */
    public function getTerAddress()
    {
        return $this->ter_address;
    }

    /**
     * @return mixed
     */
    public function getTerTypeId()
    {
        return $this->ter_type_id;
    }

    /**
     * @return mixed
     */
    public function getTerLevel()
    {
        return $this->ter_level;
    }

    /**
     * @return mixed
     */
    public function getTerMask()
    {
        return $this->ter_mask;
    }

    /**
     * @return mixed
     */
    public function getRegId()
    {
        return $this->reg_id;
    }

    /**
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @param mixed $ter_id
     */
    public function setTerId($ter_id)
    {
        $this->ter_id = $ter_id;
    }

    /**
     * @param mixed $ter_pid
     */
    public function setTerPid($ter_pid)
    {
        $this->ter_pid = $ter_pid;
    }

    /**
     * @param mixed $ter_name
     */
    public function setTerName($ter_name)
    {
        $this->ter_name = $ter_name;
    }

    /**
     * @param mixed $ter_address
     */
    public function setTerAddress($ter_address)
    {
        $this->ter_address = $ter_address;
    }

    /**
     * @param mixed $ter_type_id
     */
    public function setTerTypeId($ter_type_id)
    {
        $this->ter_type_id = $ter_type_id;
    }

    /**
     * @param mixed $ter_level
     */
    public function setTerLevel($ter_level)
    {
        $this->ter_level = $ter_level;
    }

    /**
     * @param mixed $ter_mask
     */
    public function setTerMask($ter_mask)
    {
        $this->ter_mask = $ter_mask;
    }

    /**
     * @param mixed $reg_id
     */
    public function setRegId($reg_id)
    {
        $this->reg_id = $reg_id;
    }


}