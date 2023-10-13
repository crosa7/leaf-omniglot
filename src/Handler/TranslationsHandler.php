<?php

declare(strict_types=1);


namespace LeafOmniglot\Handler;


use LeafOmniglot\Constants\ConfigConstants;
use LeafOmniglot\Exceptions\MissingTranslationFileException;
use LeafOmniglot\Reader\ConfigReader;

class TranslationsHandler
{
    private static array $translationsArrayByLang = [];

    private LocaleHandler $localeHandler;

    /**
     * @param \LeafOmniglot\Handler\LocaleHandler $localeHandler
     */
    public function __construct(LocaleHandler $localeHandler)
    {
        $this->localeHandler = $localeHandler;
    }

    /**
     * @return void
     */
    public function init(): void
    {
        $currentLocale = $this->localeHandler->getCurrentLocale();
        if (!$currentLocale) {
            $defaultLocale = $this->localeHandler->getDefaultLocale();
            $this->localeHandler->setCurrentLocale($defaultLocale);
            $currentLocale = $defaultLocale;
        }

        if (!isset(static::$translationsArrayByLang[$currentLocale])) {
            static::$translationsArrayByLang = [];
            $translationFilesByLocale = $this->localeHandler->getTranslationFilesByLocale();

            $folderPath = ConfigReader::config(ConfigConstants::KEY_TRANSLATION_FILES_LOCATION);

            if(!isset($translationFilesByLocale[$currentLocale])) {
                throw new MissingTranslationFileException($currentLocale);
            }

            $jsonTranslations = file_get_contents($folderPath . '/' . $translationFilesByLocale[$currentLocale]);

            static::$translationsArrayByLang[$currentLocale] = json_decode($jsonTranslations, true);
        }
    }

    /**
     * @param string $key
     * @param array $params
     *
     * @return string
     */
    public function getTranslationByKey(string $key, array $params = []): string
    {
        $currentLocale = $this->localeHandler->getCurrentLocale();

        if (isset(static::$translationsArrayByLang[$currentLocale][$key]) && $params) {
            $translationString = static::$translationsArrayByLang[$currentLocale][$key];

            foreach ($params as $key => $value) {
                if (!preg_match('/'. $key . '/', $translationString)) {
                    trigger_error('Param "' . $key . '" not found in translation string "' . $translationString. '"');
                }
                $translationString = str_replace($key, $value, $translationString);
            }

            return $translationString;
        }

        return static::$translationsArrayByLang[$currentLocale][$key] ?? $key;
    }
}
