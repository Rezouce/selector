<?php
namespace Selector\Parser;

interface Parser
{
    /**
     * Decode the data to an array
     *
     * @param mixed $data
     * @return array
     * @throws ParserException
     */
    public function decode($data);

    /**
     * Encode the data.
     *
     * @param $data
     * @return mixed
     */
    public function encode($data);
}
