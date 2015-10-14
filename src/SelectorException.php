<?php
namespace Selector;

class SelectorException extends \Exception
{

    protected $rawMessage;

    protected $selector;

    public function __construct($message = '', $selector = '', SelectorException $previous = null)
    {
        $this->rawMessage = $message;

        $this->selector = $selector;

        if ($previous) {
            $this->selector .= '.' . $previous->getSelector();
        }

        $message = sprintf($message, $this->getSelector());

        parent::__construct($message, 0, $previous);
    }

    public function getSelector()
    {
        return $this->selector;
    }

    public function getRawMessage()
    {
        return $this->rawMessage;
    }
}
