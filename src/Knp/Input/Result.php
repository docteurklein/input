<?php

namespace Knp\Input;

class Result
{
    public $children = [];
    public $missingKeys = [];
    public $extraKeys = [];
    public $invalidValues = [];

    public function extraKey($key)
    {
        $this->extraKeys[] = $key;
    }

    public function missesKey($key)
    {
        $this->missingKeys[] = $key;
    }

    public function invalidValue($key, $value)
    {
        $this->invalidValues[$key] = $value;
    }

    public function add(self $result, $key)
    {
        $this->children[$key] = $result;
    }
}
