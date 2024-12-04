<?php
namespace  Web\Database;

class Criteria
{
    private $filters;
    private $properties;

    public function __construct()
    {
        $this->filters = [];
        $this->properties = [];
    }

    public function add($variable, $compare, $value, $logic_op = 'and')
    {
        if (empty($this->filters)) {
            $logic_op = null; // Primeiro filtro não precisa de operador lógico
        }
        $this->filters[] = [$variable, $compare, $this->transform($value), $logic_op];
    }

    public function transform($value)
    {
        if (is_array($value)) {
            $foo = [];
            foreach ($value as $x) {
                if (is_integer($x)) {
                    $foo[] = $x;
                } elseif (is_string($x)) {
                    $foo[] = "'$x'";
                }
            }
            return '(' . implode(',', $foo) . ')';
        } elseif (is_string($value)) {
            return "'$value'";
        } elseif (is_null($value)) {
            return 'NULL';
        } elseif (is_bool($value)) {
            return $value ? 'TRUE' : 'FALSE';
        } else {
            return $value;
        }
    }

    public function dump()
    {
        if (is_array($this->filters) && count($this->filters) > 0) {
            $result = '';
            foreach ($this->filters as $filter) {
                if (!empty($result)) {
                    $result .= " {$filter[3]} "; // Operador lógico
                }
                $result .= "{$filter[0]} {$filter[1]} {$filter[2]}";
            }
            return "({$result})";
        }
        return '';
    }



    public function setProperty($property,$value){

        $this->properties[$property] = $value;
    }

    public function getProperty($property){

        if(isset($this->properties[$property])) 
         {
            return $this->properties[$property];
         }
    }
}


