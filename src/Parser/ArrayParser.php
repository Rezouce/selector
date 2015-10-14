<?php
namespace Selector\Parser;

class ArrayParser implements Parser
{

    /**
     * Parse an array to an array
     *
     * @param string $data
     * @return array
     * @throws ParserException
     */
    public function parse($data)
    {
        if (!is_array($data)) {
            throw new ParserException('The data provided is not an array.');
        }

        return $data;
    }
}
