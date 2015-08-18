<?php

namespace Knp\Input;

use Knp\Input;
use Knp\Input\Config;
use Knp\Input\Result;

class When
{
    private $condition;
    private $then = [];
    private $config;

    public function __construct(callable $condition, Config $config)
    {
        $this->condition = $condition;
        $this->config = $config;
    }

    public function conditionMatches(Input $input)
    {
        $condition = $this->condition;

        return $condition($input, $this->config);
    }

    public function then(callable $then)
    {
        $this->then[] = $then;
    }

    public function __invoke(Input $input, Result $result)
    {
        foreach ($this->then as $then) {
            $then($input, $this->config, $result);
        }
    }
}
