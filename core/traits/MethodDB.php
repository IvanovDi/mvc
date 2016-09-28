<?php
namespace core\traits;

use core\models\ConnectionDB;

trait MethodDB
{
    private $select = "*";
    private $where = [];
    private $orderBY = '';
    private $bindArr = [];

    protected function checkBind($param)
    {
        $count = 1;
       foreach ($this->bindArr as $key => $value){
           if ($param === $key || $param . $count === $key) {
               $count++;
           }
       }
       if($count !== 1) {
           return $param . $count;
       } else {
           return $param;
       }
    }

    public function select($param)
    {
        if($param) {
            if (is_array($param)) {
                $param = implode(",", $param);
            }
            $this->select = $param;
        }
        return $this;
    }

    public function whereBetween($field, $begin, $end)
    {
         return $this->whereOrigin('AND', $field, 'between', $begin, $end);
    }

    public function orWhere(...$arg)
    {
        return $this->whereOrigin('OR', ...$arg);
    }

    public function where(...$arg)
    {
        return $this->whereOrigin('AND', ...$arg);
    }

    protected function whereOrigin($operator, ...$arg)
    {
        $count = count($arg);
        if ($count === 0) {
            return $this;
        }
        switch($count) {
            case 1 :
                $where = '';
                if(is_array($arg[0])) {
                    foreach ($arg[0] as $key => $value) {
                        $param = $this->checkBind($key);
                        $this->bindArr[$param] = $value;
                        $where .= $where === '' ? " {$key} = :{$param} " : " AND {$key} = :{$param} ";
                    }
                }
                break;
            case 2 :
                $param = $this->checkBind($arg[0]);
                $this->bindArr[$param] = $arg[1];
                $where = " {$arg[0]} = :{$param}";
                break;
            case 3 :
                if(array_search($arg[1], ['=', '!=', '>=', '<=', '<', '>'])) {
                    $param = $this->checkBind($arg[0]);
                    $this->bindArr[$param] = $arg[2];
                    $where = " {$arg[0]} {$arg[1]} :{$param} ";
                } else {
                    echo 'not the right parameters and try again';
                    return;
                }
                break;
            case 4 :
                if($arg[1] === 'between') {
                    $param1 = $this->checkBind($arg[0]);
                    $this->bindArr[$param1] = $arg[2];
                    $param2 = $this->checkBind($arg[0]);
                    $this->bindArr[$param2] = $arg[3];
                    $where = " {$arg[0]} {$arg[1]} :{$param1} and :{$param2}";
                } else {
                    echo 'no correct params try again';
                }
                break;
        }
        if(count($this->where) === 0) {
            $this->where [] = ' where ' . $where;
        } else {
            $this->where [] = $operator . $where;
        }
        return $this;
    }

    public function __call($name, $arguments)
    {
        $name = strtolower($name);
        if(strripos($name, 'id') || (strripos($name, 'id') && strripos($name, 'name'))) {
            $name = str_replace("where", "", $name);
            $res = explode("and", $name);
            $count = count($arguments);
            switch ($count) {
                case 1:
                    $param = $this->checkBind($res[0]);
                    $this->bindArr[$param] = $arguments[0];
                    $where = " {$res[0]} = :{$param}";
                    break;
                case 2:
                    $param1 = $this->checkBind($res[0]);
                    $this->bindArr[$param1] = $arguments[0];
                    $param2 = $this->checkBind($res[1]);
                    $this->bindArr[$param2] = $arguments[1];
                    $where = " {$res[0]} = :{$param1} and {$res[1]} = :{$param2}";
                    break;
                default:
                    echo 'the called method does not exist';
            }
            if (count($this->where) === 0) {
                $this->where [] = " where$where";
            } else {
                $this->where [] = "AND $where";
            }
        } else {
            echo 'there is no method';
            return;
        }
       return $this;
    }

    public function orderBy(...$arg)
    {
        $this->orderBY = $this->orderBY === '' ? ' ORDER BY ' : ' ';
        if(is_array($arg[0])) {
            foreach ($arg[0] as $key => $value) {
                $value = strtolower($value);
                if($value  === "desc") {
                    $this->orderBY .= "{$key} DESC, ";
				} else {
                    $this->orderBY .= "{$key} ASC, ";
                }
            }
            $this->orderBY = substr($this->orderBy, 0, -2);
        } else {
            $this->orderBY .= $arg[0] .' ' . $arg[1] ?? 'ASC';
        }
        return $this;
    }

}