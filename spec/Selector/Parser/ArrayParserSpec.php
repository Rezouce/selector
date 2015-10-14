<?php

namespace spec\Selector\Parser;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrayParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Selector\Parser\ArrayParser');
    }

    function it_should_return_the_same_array_as_provided()
    {
        $data = ['the', 'same', 'array'];

        $this->parse($data)->shouldReturn($data);
    }

    function it_should_throws_an_exception_if_the_data_provided_is_not_an_array()
    {
        $this->shouldThrow('Selector\Parser\ParserException')->duringParse('not-an-array');
    }
}
