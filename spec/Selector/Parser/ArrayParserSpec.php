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

    function it_should_return_the_same_array_as_provided_when_decoding()
    {
        $data = ['the', 'same', 'array'];

        $this->decode($data)->shouldReturn($data);
    }

    function it_should_throws_an_exception_during_decoding_if_the_data_provided_is_not_an_array()
    {
        $this->shouldThrow('Selector\Parser\ParserException')->duringDecode('not-an-array');
    }

    function it_should_return_an_empty_array_during_decoding_if_null_provided()
    {
        $this->decode(null)->shouldReturn([]);
    }

    function it_should_return_the_same_array_as_provided_when_encoding()
    {
        $data = ['the', 'same', 'array'];

        $this->decode($data)->shouldReturn($data);
    }
}
