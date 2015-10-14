<?php
namespace Selector\Parser;

interface Parser
{
    /**
     * Parse the data to an array
     *
     * @param $data
     * @return array
     * @throws ParserException
     */
    public function parse($data);
}
