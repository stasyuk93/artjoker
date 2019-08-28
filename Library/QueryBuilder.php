<?php

namespace Library;


class QueryBuilder extends Database
{
    /**
     * @var string
     */
    private $select;

    /**
     * @var array
     */
    private $where;

    /**
     * @var array
     */
    private $order;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $table;

    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $limit;

    /**
     * @var array
     */
    private $counter = [];

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function count()
    {
        return self::getFetchColumn($this->select('COUNT(*)')->select);
    }

    public function select($fields = '*')
    {
        $this->select = "SELECT $fields FROM {$this->getTable()} ";
        return $this;
    }

    public function where($column, $operator, $param = null)
    {
        if($param === null){
            $param = $operator;
            $operator = '=';
        }

        $prepareColumn = $column.$this->getCounter($column);

        $where = [
            'column' => $column,
            'operator' => $operator,
            'prepare' => $prepareColumn
        ];

        $this->setParam($prepareColumn, $param)->setWhere($where);

        return $this;
    }

    public function update(array $data)
    {
        $query = $this->updateQuery($data);
        $where = $this->getWhere();
        $query .= $where;
        return $this->set($query, $data);
    }

    public function insert(array $data)
    {
        $query = $this->insertQuery($data);
        return $this->add($query, $data);
    }

    public function delete()
    {
        return $this->deleteQuery();
    }

    private function insertQuery(array $fields)
    {
        $query_fields = $this->transformFieldsInsert($fields);
        return "INSERT INTO {$this->getTable()} ({$query_fields['fields']}) VALUES({$query_fields['prepare']});";
    }

    private function updateQuery(array $fields)
    {
        return "UPDATE {$this->getTable()} SET {$this->transformFields($fields, true)} ";
    }

    /**
     * @return string
     */
    private function deleteQuery()
    {
        $query = "DELETE FROM {$this->getTable()} ";
        $where = $this->getWhere();

        return $query.$where;
    }

    public function get()
    {
        $query = empty($this->select)? $this->select()->select : $this->select;
        $query .= $this->getWhere();
        $query .= $this->getOrder();
        $this->setQuery($query);
        return $this->getRow($query, $this->getParams());
    }

    public function all()
    {
        $query = empty($this->select)? $this->select()->select : $this->select;
        $query .= $this->getWhere();
        $query .= $this->getOrder();
        $query .= $this->getLimit();
        $this->setQuery($query);
        return $this->getAll($query, $this->getParams());
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    protected function setParam($key, $value)
    {
        $this->params[$key] = $value;
        return $this;
    }

    /**
     * @return string
     */
    private function transformWhere()
    {
        if(!$this->where) return null;
        $queryWhere = ' WHERE ';
        $whereArray = [];
        foreach ($this->where as $operator => $array){
            if($array){
                foreach ($array as $key => $value){
                    $whereArray[$operator][] = "{$value['column']} {$value['operator']} :{$value['prepare']}";
                }
                $queryWhere .= implode(" $operator ", $whereArray[$operator]);
            }
        }

        return $queryWhere;
    }

    /**
     * @return string
     */
    private function getWhere()
    {
        return $this->transformWhere();
    }

    /**
     * @param array $where
     * @return $this
     */
    private function setWhere(array $where)
    {
        $this->where['AND'][] = $where;
        return $this;
    }

    /**
     * @param array $where
     * @return $this
     */
    private function setOrWhere(array $where)
    {
        $this->where['OR'][] = $where;
        return $this;
    }

    /**
     * @return mixed
     */
    private function getOrder()
    {
        return $this->order;
    }

    /**
     * @param array $order
     * @return $this
     */
    private function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     * @return $this
     */
    private function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return "`$this->table`";
    }


    private function transformColumn($column, $operator, $param)
    {
        $prepare = $column.$this->getCounter($column);
        $this->setParam($prepare,$param);
        $query = "$column $operator :$prepare";

        return $query;
    }

    /**
     * @param array $fields
     * @return array
     */
    private function transformFieldsInsert(array $fields)
    {
        $prepare_value = '';
        $fields_str = '';
        foreach ($fields as $key => $field){
            $fields_str .= "$key,";
            $prepare_value .= ":$key,";
        }
        $fields_str = substr($fields_str, 0, -1);
        $prepare_value = substr($prepare_value, 0 , -1);
        return [
            'prepare' => $prepare_value,
            'fields' => $fields_str
        ];
    }

    /**
     * @param array $fields
     * @return bool|string
     */
    private function transformFields(array $fields, $transformKey = false)
    {
        $query = '';
        foreach ($fields as $key => $field){
            if($transformKey) $field = $transformKey;
            $query .= "`$field` = :$field,";
        }
        return substr($query,0,-1);
    }

    /**
     * @param string $counter
     * @return integer
     */
    private function getCounter($counter)
    {
        if(!array_key_exists($counter,$this->counter)){
            $this->counter[$counter] = 1;
        } else {
            $this->setCounter($counter);
        }
        return $this->counter[$counter];
    }

    /**
     * @param string $counter
     * @return $this
     */
    private function setCounter($counter)
    {

        $this->counter[$counter] += 1;

        return $this;
    }

    /**
     * @return string
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param $limit
     * @param null $offset
     * @return $this
     */
    public function setLimit($limit, $offset = null)
    {
        $this->limit = "LIMIT $limit ";
        if($offset !== null) $this->limit .= "OFFSET $offset ";
        return $this;
    }

}