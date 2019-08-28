<?php

namespace Model;

use Library\QueryBuilder;
use Library\Paginate;

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
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @var Paginate|NULL
     */
    protected $paginate;

    /**
     * @var int
     */
    protected $countPerPage = 10;

    /**
     * @var null|int
     */
    protected $_count;

    /**
     * @var QueryBuilder|null
     */
    protected $queryBuilder;

    /**
     * Model constructor.
     * @param $entity
     */
    public function __construct()
    {
        $this->_entity = get_called_class();
        if($this->_table === null) $this->setTableByEntity($this->_entity);
    }

    /**
     * @return QueryBuilder
     */
    public function query()
    {
        return new QueryBuilder($this->_table);
    }

    /**
     * @return object|null
     */
    public function first()
    {
        $data = $this->queryBuilder->get();
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
        $data = $this->queryBuilder->all();
        if($data){
            $this->setDatas($data);
            return $this->getData();
        }
        return [];
    }

    /**
     * @param $column
     * @param $operator
     * @param null $param
     * @return $this
     */
    public function where($column, $operator, $param = null)
    {
        if($this->queryBuilder === null){
            $this->queryBuilder = $this->query()->where($column, $operator, $param);
        } else {
            $this->queryBuilder->where($column, $operator, $param);
        }
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

    /**
     * @param $data
     * @return $this
     */
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

    /**
     * @return array
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];
        $properties = $this->getFillable();
        foreach ($properties as $property){
            $array[$property] = $this->$property;
        }
        return $array;
    }

    /**
     * @return NULL|Paginate
     */
    public function getPaginate()
    {
        return $this->paginate;
    }

    /**
     * @return $this
     */
    protected function setPaginate()
    {
        $this->paginate = new Paginate(ceil($this->count() / $this->countPerPage), $this->countPerPage);
        return $this;
    }

    /**
     * @return QueryBuilder
     */
    public function limit()
    {
        if($this->paginate === null) $this->setPaginate();
        $offset = abs(($this->paginate->getCurrentPage() - 1) * $this->countPerPage);
        if($offset > $this->count()) notFound();
        return $this->query()->setLimit($this->countPerPage, $offset);
    }

    /**
     * @return array
     */
    public function paginate()
    {
        $data = $this->limit()->all();
        if($data){
            $this->setDatas($data);
            return $this->getData();
        }
        return [];
    }

    /**
     * @return mixed
     */
    public function count()
    {
        if($this->_count === null) $this->_count = $this->query()->count();
        return $this->_count;
    }

}