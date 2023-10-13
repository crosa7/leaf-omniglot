<?php

declare(strict_types=1);


namespace LeafOmniglot\Exceptions;


use Throwable;

class TranslationParamNotFoundException extends \Exception
{
    /**
     * @param $message
     * @param $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $key, string $translationString, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = 'Param "' . $key . '" not found in translation string "' . $translationString. '"';
    }
}
