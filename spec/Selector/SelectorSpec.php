<?php

namespace spec\Selector;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Selector\Parser\Parser;

class SelectorSpec extends ObjectBehavior
{

    function let(Parser $parser)
    {
        $data = [
            'scalar' => 'value',
            'depth' => [
                'depth-scalar' => 'depth-value',
            ],
            'users' => [
                [
                    'name' => 'Steve',
                    'age' => 49,
                ],
                [
                    'name' => 'Edward',
                    'age' => 34,
                ],
            ],
            'aggregation' => [
                [
                    'id' => 1,
                ],
                [
                    'no-id' => 2,
                ],
                [
                    'id' => 3,
                ],
            ]
        ];

        $parser->parse($data)->willReturn($data);

        $this->beConstructedWith($data, $parser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Selector\Selector');
    }

    function it_should_return_the_values_for_simple_selectors()
    {
        $this->get('scalar')->shouldReturn('value');

        $this->get('depth')->shouldReturn(['depth-scalar' => 'depth-value']);

        $this->get('users')->shouldReturn([
            [
                'name' => 'Steve',
                'age' => 49,
            ],
            [
                'name' => 'Edward',
                'age' => 34,
            ]
        ]);
    }

    function it_should_return_the_values_for_depth_selectors()
    {
        $this->get('depth.depth-scalar')->shouldReturn('depth-value');
    }

    function it_should_return_an_aggregration_of_values_for_array_depth_selectors()
    {
        $this->get('users.name')->shouldReturn(['Steve', 'Edward']);
    }

    function it_should_return_te_value_when_matching_an_array_index()
    {
        $this->get('users[0]')->shouldReturn([
            'name' => 'Steve',
            'age' => 49,
        ]);

        $this->get('users[1].name')->shouldReturn('Edward');
    }

    function it_should_return_null_if_the_selector_match_nothing()
    {
        $this->get('inexistant-key')->shouldReturn(null);
    }

    function it_should_throw_an_exception_if_the_selector_try_to_access_an_unexisting_index()
    {
        $this->shouldThrow('Selector\SelectorException')->duringGet('users[99]');
    }

    function it_should_ignore_missing_values_when_aggregating_data_from_a_depth_selector()
    {
        $this->get('aggregation.id')->shouldReturn([1, null, 3]);
    }
}
