<?php

namespace spec\Knp\Input;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Input;

class ConfigSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Input\Config');
    }

    public function it_reconfigures_based_on_rules()
    {
        $this->when(function(Input $input) {

        });
    }

    public function it_should_limit_accepted_choices()
    {
        $this->accepts('1', '3');
    }
}
