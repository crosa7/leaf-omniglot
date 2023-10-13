<?php

declare(strict_types=1);


namespace LeafOmniglot\Handler;


use LeafOmniglot\Constants\ConfigConstants;
use LeafOmniglot\Plugins\Locale\LocaleStrategyPluginInterface;
use LeafOmniglot\Reader\ConfigReader;

class LocaleHandler
{
    private const TRANSLATION_FILE_SUFFIX = '.locale.json';
    private const TRANSLATION_FILES_SUFFIX_PATTERN = '/\.locale\.json$/';

    private array $translationFilesByLocale = [];

    private LocaleStrategyPluginInterface $localeStrategyPlugin;

    /**
     * @param \LeafOmniglot\Plugins\Locale\LocaleStrategyPluginInterface $localeStrategyPlugin
     */
    public function __construct(LocaleStrategyPluginInterface $localeStrategyPlugin)
    {
        $this->localeStrategyPlugin = $localeStrategyPlugin;
    }

    /**
     * @param string $locale
     *
     * @return void
     *
     * @throws \Exception
     */
    public function setCurrentLocale(string $locale): void
    {
        $translationFilesByLocale = $this->getTranslationFilesByLocale();
        $this->verifyTranslationFileExistsForLocale($translationFilesByLocale, $locale);

        $this->localeStrategyPlugin->setCurrentLocale($locale);
    }

    /**
     * @return string|null
     */
    public function getCurrentLocale(): ?string
    {
        return $this->localeStrategyPlugin->getCurrentLocale();
    }

    /**
     * Returns configured default locale
     *
     * @return string
     */
    public function getDefaultLocale(): string
    {
        return ConfigReader::config(ConfigConstants::KEY_DEFAULT_LOCALE);
    }

    /**
     * @return array<string, string>
     */
    public function getTranslationFilesByLocale(): array
    {
        if (!$this->translationFilesByLocale) {
            $files = scandir(ConfigReader::config(ConfigConstants::KEY_TRANSLATION_FILES_LOCATION));
            $filteredFiles = preg_grep(self::TRANSLATION_FILES_SUFFIX_PATTERN, $files);

            $translationFilesByLocale = [];
            foreach ($filteredFiles as $fileName) {
                $locale = basename($fileName, self::TRANSLATION_FILE_SUFFIX);
                $translationFilesByLocale[$locale] = $fileName;
            }

            $this->translationFilesByLocale = $translationFilesByLocale;
        }

        return $this->translationFilesByLocale;
    }

    /**
     * @return array
     */
    public function getAvailableLocales(): array
    {
        return array_keys($this->getTranslationFilesByLocale());
    }

    /**
     * @param array $translationFilesByLocale
     * @param string $locale
     *
     * @return void
     *
     * @throws \Exception
     */
    private function verifyTranslationFileExistsForLocale(array $translationFilesByLocale, string $locale): void
    {
        if (!isset($translationFilesByLocale[$locale])) {
            trigger_error(
                sprintf(
                    'Translation file for language not found, make sure you have the following file "%s" inside the configured translation files folder',
                    $locale . self::TRANSLATION_FILE_SUFFIX
                ));
        }
    }
}
