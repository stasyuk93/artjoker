<?php

namespace Model;

use Library\QueryBuilder;

class Model
{

    /**
     * @var string
     */
    protected $_entity;

    /**
     * @var string
     */
    protected $_table;

    /**
     * @var array
     */
    protected $_data;

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;


    /**
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [];

    /**
     * Model constructor.
     * @param $entity
     */
    public function __construct()
    {
        $this->_entity = get_called_class();
        if($this->_table === null) $this->setTableByEntity($this->_entity);
        $this->queryBuilder = new QueryBuilder($this->_table);
    }


    public function query()
    {
        return $this->queryBuilder;
    }

    public function first()
    {
        $data = $this->query()->get();
        if($data){
            $this->setData($data);
            return $this->getData()[0];
        }
        return null;
    }

    /**
     * @param mixed $id
     * @return object|null
     */
    public function find($id)
    {
        $data = $this->query()->select()->where($this->primaryKey,$id)->get();
        if($data){
            $this->setData($data);
            return $this->getData()[0];
        }
        return null;
    }

    public function findAll()
    {
        $data = $this->query()->all();
        if($data){
            $this->setDatas($data);
            return $this->getData();
        }
        return null;
    }

    public function where($column, $operator, $param = null)
    {
        $this->query()->where($column, $operator, $param);
        return $this;
    }

    public function save(array $params = [])
    {
        if(!$params) {
            $params = $this->getProperties();
        }
        return $this->query()->insert($params);
    }

    public function delete()
    {
        return $this->query()->delete();
    }

    public function update()
    {
        $params = $this->getProperties();
        return $this->query()->update($params);
    }

    protected function setDatas($data)
    {
        foreach ($data as $item){
            $this->setData($item);
        }
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    protected function setData($data)
    {
        $entity = $this->getEntity();
        $object =  new $entity();
        foreach ($data as $key => $val){
            $object->$key = $val;
        }
        $this->_data[] = $object;

        return $this;
    }

    /**
     * @return array
     */
    protected function getProperties()
    {
        $result = [];
        foreach ($this->getFillable() as $property) {
            $result[$property] = $this->$property;
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @return object
     */
    protected function getEntity()
    {
        return $this->_entity;
    }

    /**
     * @param string $entity
     * @return $this
     */
    private function setTableByEntity($entity)
    {
        $this->_table =  mb_strtolower(str_ireplace("model\\", "", $entity));
        return $this;
    }

    public function getFillable()
    {
        return $this->fillable;
    }

    public function toArray()
    {
        $array = [];
        $properties = $this->getFillable();
        foreach ($properties as $property){
            $array[$property] = $this->$property;
        }
        return $array;
    }
}