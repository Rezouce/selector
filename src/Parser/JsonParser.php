<?php
namespace Selector\Parser;

class JsonParser implements Parser
{

    /**
     * Parse a JSON string to an array
     *
     * @param string $data
     * @return array
     * @throws ParserException
     */
    public function parse($data)
    {
        $content = json_decode($data, true);

        if (null === $content) {
            throw new ParserException('The data provided is not a valid JSON.');
        }

        return $content;
    }
}
