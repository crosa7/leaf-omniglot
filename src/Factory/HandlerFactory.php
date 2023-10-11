<?php

declare(strict_types=1);


namespace App\src\Factory;

use App\src\Handler\LocaleHandler;
use App\src\Handler\TranslationsHandler;
use App\src\Reader\ConfigReader;

class HandlerFactory
{
    /**
     * @return \App\src\Handler\TranslationsHandler
     */
    public function createTranslationsHandler(): TranslationsHandler
    {
       return new TranslationsHandler($this->createLocaleHandler());
    }

    /**
     * @return \App\src\Handler\LocaleHandler
     */
    public function createLocaleHandler(): LocaleHandler
    {
        return new LocaleHandler(ConfigReader::getLocaleStrategy());
    }
}
