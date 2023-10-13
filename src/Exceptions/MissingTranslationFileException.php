<?php

declare(strict_types=1);


namespace LeafOmniglot\Exceptions;


use Throwable;

class MissingTranslationFileException extends \Exception
{
    /**
     * @param $message
     * @param $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $currentLocale, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = 'Translation file not found for locale "' . $currentLocale . '" make sure you have a translation file named "' . $currentLocale . '.locale.json" in your translation files folder';
    }
}
