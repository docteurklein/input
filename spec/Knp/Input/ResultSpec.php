<?php

namespace spec\Knp\Input;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Input\Config;

class ResultSpec extends ObjectBehavior
{
    function it_is_initializable(Config $config)
    {
        $this->beConstructedWith($config);
    }
}
