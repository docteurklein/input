<?php

namespace spec\Knp;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InputSpec extends ObjectBehavior
{
    public function it_gets_original_data()
    {
        $this->beConstructedThrough('fromArray', [['yep']]);
        $this->all()->shouldReturn(['yep']);
    }

    public function it_should_tell_if_input_contains_key()
    {
        $this->beConstructedThrough('fromArray', [['test' => 'yep']]);
        $this->contains('test')->shouldBe(true);
    }
}
