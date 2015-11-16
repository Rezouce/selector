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

    function it_should_decode_a_json_string()
    {
        $data = ['a', 'valid', ['json' => 'string']];

        $this->decode(json_encode($data))->shouldReturn($data);
    }

    function it_should_throws_an_exception_during_decoding_if_the_data_provided_is_not_a_valid_json()
    {
        $this->shouldThrow('Selector\Parser\ParserException')->duringDecode('{Not a valid JSON.}');
    }

    function it_should_encode_a_json_string()
    {
        $data = ['a', 'valid', ['json' => 'string']];

        $this->encode($data)->shouldReturn(json_encode($data));
    }
}
