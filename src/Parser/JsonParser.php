<?php
namespace Selector\Parser;

class JsonParser implements Parser
{

    /**
     * Decode a JSON string to an array
     *
     * @param string $data
     * @return array
     * @throws ParserException
     */
    public function decode($data)
    {
        $content = json_decode($data, true);

        if (null === $content) {
            throw new ParserException('The data provided is not a valid JSON.');
        }

        return $content;
    }

    /**
     * Encode the data from an array
     *
     * @param $data
     * @return mixed
     */
    public function encode($data)
    {
        return json_encode($data);
    }
}
