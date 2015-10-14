<?php

namespace spec\Selector\Parser;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Selector\Parser\JsonParser');
    }

    function it_should_return_json_decode_a_json_string()
    {
        $data = ['a', 'valid', ['json' => 'string']];

        $this->parse(json_encode($data))->shouldReturn($data);
    }

    function it_should_throws_an_exception_if_the_data_provided_is_not_a_valid_json()
    {
        $this->shouldThrow('Selector\Parser\ParserException')->duringParse('{Not a valid JSON.}');
    }
}
