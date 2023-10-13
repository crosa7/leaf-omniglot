<?php

declare(strict_types=1);


namespace LeafOmniglot\Exceptions;


use Throwable;

class LocaleStrategyNotFoundException extends \Exception
{
    /**
     * @param $message
     * @param $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $strategy, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = 'No locale strategy found for "' . $strategy . '" please use either "session", "accept-language-header" or implement a custom strategy';
    }
}
