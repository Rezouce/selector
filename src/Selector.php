<?php
namespace Selector;

use Selector\Parser\ArrayParser;
use Selector\Parser\Parser;

class Selector
{

    private $data;

    private $selector;

    private $key;

    private $index;

    public function __construct($data, Parser $parser)
    {
        $this->data = $parser->parse($data);
    }

    /**
     * Get the values from the data provided, matching the selector.
     *
     * @param string $selector
     * @return mixed
     * @throws SelectorException
     */
    public function get($selector)
    {
        $this->selector = $selector;

        $matchingData = $this->matchingData();

        if ($this->hasNextSelector()) {
            try {
                return (new static($matchingData, new ArrayParser))->get($this->selector);
            } catch (SelectorException $e) {
                throw new SelectorException(
                    $e->getRawMessage(),
                    $this->key . ($this->index ? '[' . $this->index . ']' : ''),
                    $e
                );
            }
        }

        return $matchingData;
    }

    /**
     * Update the currentKey with the selector's next key.
     */
    private function updateKey()
    {
        $this->key = strstr($this->selector, '.', true) ?: $this->selector;

        $this->updateSelector();

        $this->extractIndexFromKey();
    }

    /**
     * Extract the current key's index if it has one.
     */
    private function extractIndexFromKey()
    {
        $hasKey = preg_match('/^([[:alnum:]]+)\[([0-9]+)\]$/', $this->key, $matches);

        if ($hasKey) {
            $this->key = $matches[1];
            $this->index = $matches[2];
        } else {
            $this->index = false;
        }
    }

    /**
     * Remove the current key from the selector.
     *
     * @return string
     */
    private function updateSelector()
    {
        $this->selector = substr($this->selector, strlen($this->key) + 1);

        return $this->selector;
    }

    /**
     * Get the data for the currentKey
     *
     * @return mixed
     * @throws SelectorException
     */
    private function matchingData()
    {
        $this->updateKey();

        // If the data is an numeric array, each value need to be parse individually
        // and the aggregate results will be returned.
        if ($this->isNumericArray($this->data)) {
            return $this->aggregateFromNumericArray();
        }

        // If the selector try to access to a specify value from an array,
        // this value will be returned.
        if ($this->hasIndex()) {
            $this->checkIsNumeric();
            $this->checkIndexExists();

            return $this->data[$this->key][$this->index];
        }

        // If it try to access a scalar value, it will be returned or null
        // if it doen't exists
        return isset($this->data[$this->key]) ? $this->data[$this->key] : null;
    }

    /**
     * Check if the current key has an index.
     *
     * @return bool
     */
    private function hasIndex()
    {
        return false !== $this->index;
    }

    /**
     * Check if an array is numeric.
     *
     * @param array $array
     * @return bool
     */
    private function isNumericArray(array $array)
    {
        return is_array($array) && (array_keys($array) === range(0, count($array) - 1));
    }

    /**
     * Check if there is the selector is empty after the current key being extracted.
     *
     * @return bool
     */
    private function hasNextSelector()
    {
        return '' != $this->selector;
    }

    /**
     * Check if the array has the asked index.
     *
     * @throws SelectorException
     */
    private function checkIndexExists()
    {
        if (!isset($this->data[$this->key][$this->index])) {
            throw new SelectorException(
                'You tried to access the index "%s" which doesn\'t exist.',
                $this->key . '[' . $this->index . ']'
            );
        }
    }

    /**
     * Check if the desired data is a numeric array.
     *
     * @throws SelectorException
     */
    private function checkIsNumeric()
    {
        if (!$this->isNumericArray($this->data[$this->key])) {
            throw new SelectorException(
                'You tried to access an index "%s" when the data are not an associative array.',
                $this->key . '[' . $this->index . ']'
            );
        }
    }

    /**
     * Get the data from each array's value and return them.
     *
     * @return array
     * @throws SelectorException
     */
    private function aggregateFromNumericArray()
    {
        $result = [];

        foreach ($this->data as $data) {
            $result[] = (new static($data, new ArrayParser))->get($this->key);
        }

        return $result;
    }
}
