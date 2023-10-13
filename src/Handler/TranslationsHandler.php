<?php

declare(strict_types=1);


namespace LeafOmniglot\Handler;


use LeafOmniglot\Exceptions\TranslationParamNotFoundException;

class TranslationsHandler
{
    private LocaleHandler $localeHandler;

    private FileHandler $fileHandler;

    /**
     * @param \LeafOmniglot\Handler\LocaleHandler $localeHandler
     * @param \LeafOmniglot\Handler\FileHandler $fileHandler
     */
    public function __construct(LocaleHandler $localeHandler, FileHandler $fileHandler)
    {
        $this->localeHandler = $localeHandler;
        $this->fileHandler = $fileHandler;
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

        $this->fileHandler->loadTranslationsByLocale($currentLocale);
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
        $translations = $this->fileHandler->getTranslations();

        if (isset($translations[$currentLocale][$key]) && $params) {
            $translationString = $translations[$currentLocale][$key];

            foreach ($params as $key => $value) {
                if (!preg_match('/'. $key . '/', $translationString)) {
                    throw new TranslationParamNotFoundException($key, $translationString);
                }
                $translationString = str_replace($key, $value, $translationString);
            }

            return $translationString;
        }

        return $translations[$currentLocale][$key] ?? $key;
    }
}
