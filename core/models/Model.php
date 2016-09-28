<?php

namespace core\models;

use core\models\ConnectionDB;
use core\traits\MethodDB;

class Model
{
    use MethodDB;

    private $_connection;
    public $result;
    protected $tableName = '';

    public function getTableName()
    {
        if($this->tableName === '') {
            $this->tableName = $this->getTabName();
        }
        return $this->tableName;
    }

    protected function getTabName()
    {
        $nameClass = get_class($this);
        $tmp = explode("\\", $nameClass);
        $nameClass = array_pop($tmp);
        $nameClass = str_replace("Model", "", $nameClass);
        return strtolower($nameClass);
    }

    public function __construct()
    {
        $this->_connection = ConnectionDB::getConnection();
    }

    public function all()
    {
        $query = "select {$this->select} from {$this->getTableName()}";
        if(count($this->where) !== 0) {
            foreach ($this->where as $value) {
                $query .= $value . " ";
            }
        }
        if($this->orderBY !== "") {
            $query .= "{$this->orderBY}";
        }
        $res = $this->_connection->prepare($query);
        foreach ($this->bindArr as $key => $value) {
            $res->bindValue($key, $value);
        }
        $res->execute();
        $response = $res->fetchAll(\PDO::FETCH_ASSOC);
        if (!empty($response)) {
            foreach ($response as $value) {
                foreach ($value as $key => $val) {
                    $this->result[$key] = $val;
                }
                $viewResult[] = clone $this;
            }
        }
        return $viewResult;
    }
}