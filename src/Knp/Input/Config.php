<?php

namespace Knp\Input;

use Knp\Input;
use Knp\Input\When;

class Config implements \ArrayAccess
{
    private $parent;
    private $when = [];
    private $children = [];
    private $accepted = [];

    public function __construct(self $parent = null)
    {
        $this->parent = $parent;
    }

    public function when(callable $condition)
    {
        $this->when[] = $when = new When($condition, $this);

        return $when;
    }

    public function handle(Input $input)
    {
        $result = new Result;
        foreach ($this->when as $when) {
            if ($when->conditionMatches($input)) {
                $when($input, $this, $result);
            }
        }

        // @TODO move to seprate class
        foreach ((array)$input->all() as $key => $value) {
            if (!in_array($key, array_keys($this->children))) {
                $result->extraKey($key);
            }
            if (!in_array($value, $this->accepted)) {
                $result->invalidValue($key, $value);
            }
        }

        foreach ($this->children as $key => $child) {
            if (!in_array($key, array_keys($input->all()))) {
                $result->missesKey($key);
            }
            $childInput = Input::fromValue(@$input->all()[$key]);
            $childResult = $child->handle($childInput);
            $result->add($childResult, $key);
        }

        return $result;
    }

    public function accepts(... $values)
    {
        $this->accepted = $values;

        return $this;
    }

    public function parent()
    {
        return $this->parent;
    }

    public function offsetExists($offset)
    {
        return isset($this->children[$offset]);
    }

    public function offsetSet($offset, $value)
    {
        $this->children[$offset] = $value;
    }

    public function offsetGet($offset)
    {
        if (!isset($this->children[$offset])) {
            $this->children[$offset] = new self($this);
        }

        return $this->children[$offset];
    }

    public function offsetUnset($offset)
    {
        unset($this->children[$offset]);
    }

    public function __get($key)
    {
        return $this->offsetGet($key);
    }
}
