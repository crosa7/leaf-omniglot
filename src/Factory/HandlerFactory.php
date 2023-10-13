<?php

declare(strict_types=1);


namespace LeafOmniglot\Factory;

use LeafOmniglot\Handler\FileHandler;
use LeafOmniglot\Handler\LocaleHandler;
use LeafOmniglot\Handler\RouteHandler;
use LeafOmniglot\Handler\TranslationsHandler;
use LeafOmniglot\Reader\ConfigReader;

class HandlerFactory
{
    /**
     * @return \LeafOmniglot\Handler\TranslationsHandler
     */
    public function createTranslationsHandler(): TranslationsHandler
    {
       return new TranslationsHandler($this->createLocaleHandler(), $this->createFileHandler());
    }

    /**
     * @return \LeafOmniglot\Handler\LocaleHandler
     */
    public function createLocaleHandler(): LocaleHandler
    {
        return new LocaleHandler(ConfigReader::getLocaleStrategy(), $this->createFileHandler());
    }

    /**
     * @return \LeafOmniglot\Handler\RouteHandler
     */
    public function createRouteHandler(): RouteHandler
    {
        return new RouteHandler();
    }

    /**
     * @return \LeafOmniglot\Handler\FileHandler
     */
    public function createFileHandler(): FileHandler
    {
        return new FileHandler();
    }
}
