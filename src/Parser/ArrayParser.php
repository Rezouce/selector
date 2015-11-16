<?php
namespace Selector\Parser;

class ArrayParser implements Parser
{

    public function decode($data)
    {
        if (null === $data) {
            $data = [];
        }

        if (!is_array($data)) {
            throw new ParserException('The data provided is not an array.');
        }

        return $data;
    }

    public function encode($data)
    {
        return $data;
    }
}
