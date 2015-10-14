<?php

namespace spec\Selector;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Selector\SelectorException;

class SelectorExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Selector\SelectorException');
    }

    function it_should_hydrate_the_message_with_the_selector()
    {
        $this->beConstructedWith('The selector is %s', 'my.selector');

        $this->getMessage()->shouldReturn('The selector is my.selector');
    }

    function it_should_hydrate_the_message_with_a_combination_of_both_its_selector_and_its_previous_selector(SelectorException $previous)
    {
        $previous->getSelector()->willReturn('selector');

        $this->beConstructedWith('The selector is %s', 'my', $previous);

        $this->getMessage()->shouldReturn('The selector is my.selector');
    }
}
