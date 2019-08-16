<?php

namespace Model;


class User extends Model
{
    private $id;

    private $name;

    private $email;

    private $city_id;

    protected $fillable = [
        'id',
        'name',
        'email',
        'city_id',
    ];


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getCityId()
    {
        return $this->city_id;
    }



    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $city_id
     */
    public function setCityId($city_id)
    {
        $this->city_id = $city_id;
    }




    public function test(){
//        dd($this->getProperties());
       $a = $this->find(1);

        dd($a);
    }


}