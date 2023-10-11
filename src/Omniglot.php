<?php

declare(strict_types=1);


namespace App\src;

use App\src\Reader\ConfigReader;

class Omniglot extends Core
{
    /**
     * @param array $config
     *
     * @return void
     */
    public function init(array $config = []): void
    {
        ConfigReader::init($config);
        $this->getHandlerFactory()->createTranslationsHandler()->init();
    }

    /**
     * @param string $key - translation key defined in the locale file
     * @param array $params - parameter in the translated string defined in the locale file
     *
     * @return string
     */
    public function translate(string $key, array $params = []): string
    {
        return $this->getHandlerFactory()->createTranslationsHandler()->getTranslationByKey($key, $params);
    }

    /**
     * @param string $locale - must match the file name Ex: file: en_US.locale.json, localeName: en_US
     *
     * @return void
     *
     * @throws \Exception
     */
    public function setCurrentLocale(string $locale): void
    {
        $this->getHandlerFactory()->createLocaleHandler()->setCurrentLocale($locale);
    }

    /**
     * @return string|null
     */
    public function getCurrentLocale(): ?string
    {
        return $this->getHandlerFactory()->createLocaleHandler()->getCurrentLocale();
    }

    /**
     * Returns all available locales based on the created locale files
     *
     * @return array
     */
    public function getAvailableLocales(): array
    {
        return $this->getHandlerFactory()->createLocaleHandler()->getAvailableLocales();
    }

    /**
     * Returns configured default locale
     *
     * @return string
     */
    public function getDefaultLocale(): string
    {
        return $this->getHandlerFactory()->createLocaleHandler()->getDefaultLocale();
    }
}
