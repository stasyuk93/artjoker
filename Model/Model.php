<?php

namespace Model;

use Library\QueryBuilder;

class Model
{

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $data;

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
        $this->entity = get_called_class();
        if($this->table === null) $this->setTableByEntity($this->entity);
        $this->queryBuilder = new QueryBuilder($this->table);
    }


    protected function query()
    {
        return $this->queryBuilder;
    }

    /**
     * @param int $id
     * @return object|null
     */
    protected function find(int $id)
    {
        $data = $this->query()->select()->where($this->primaryKey,$id)->get();
        if($data){
            $this->setData($data);
            return $this->getData()[0];
        }
        return null;
    }

    protected function findAll()
    {
        $data = $this->query()->all();
        if($data){
            $this->setDatas($data);
            return $this->getData();
        }
        return null;
    }

    protected function where($column, $operator, $param = null)
    {
        $this->query()->where($column, $operator, $param);
        return $this;
    }

    protected function save()
    {
        $params = $this->getProperties();
        $query =  $this->query()->insert($params);
        return  $this->query()->add($query,$params);

    }

    protected function delete()
    {
        return $this->query()->delete();
    }

    protected function update()
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
            $this->setProperty($object, $key, $val);
        }
        $this->data[] = $object;

        return $this;
    }

    /**
     * @param object $object
     * @param string $property
     * @param $value
     * @return $this
     * @throws \Exception
     */
    protected function setProperty(object $object, string $property, $value)
    {
        $method = $this->findObjectMethod($object, 'set'.$property);
        $object->$method($value);
        return $this;
    }

    /**
     * @param object $object
     * @param string $property
     * @return mixed
     * @throws \Exception
     */
    protected function getProperty(object $object, string $property)
    {
        $method = $this->findObjectMethod($object, 'set'.$property);
        return $object->$method();

    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getProperties()
    {
        $result = [];
        foreach ($this->getFillable() as $property) {
            $result[$property] = $this->getProperty($property);
        }
        return $result;
    }

    /**
     * @return array
     */
    protected function getData()
    {
        return $this->data;
    }

    /**
     * @return object
     */
    protected function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     * @return $this
     */
    private function setTableByEntity($entity)
    {
        $this->table =  mb_strtolower(str_ireplace("model\\", "", $entity));
        return $this;
    }

    public function getFillable()
    {
        return $this->fillable;
    }

    private function findObjectMethod($object, $method)
    {
        if(method_exists($object, $method)){
            return $method;
        }
        elseif(method_exists($object, $method = str_replace('_', '',$method))){
            return str_replace('_', '',$method);
        }
        throw new \Exception("$object::$method not exist");
    }

}