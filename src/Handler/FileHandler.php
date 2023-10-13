<?php

declare(strict_types=1);


namespace LeafOmniglot\Handler;


use LeafOmniglot\Constants\ConfigConstants;
use LeafOmniglot\Exceptions\MissingTranslationFileException;
use LeafOmniglot\Reader\ConfigReader;

class FileHandler
{
    private static array $translationsArrayByLocale = [];
    private static array $translationFilesByLocale = [];

    private const TRANSLATION_FILE_SUFFIX = '.locale.json';
    private const TRANSLATION_FILES_SUFFIX_PATTERN = '/\.locale\.json$/';

    /**
     * @param string $locale
     *
     * @return void
     */
    public function loadTranslationsByLocale(string $locale): void
    {
        if (!isset(static::$translationsArrayByLocale[$locale])) {
            static::$translationsArrayByLocale = [];
            $translationFilesByLocale = $this->getTranslationFiles();

            $folderPath = ConfigReader::config(ConfigConstants::KEY_TRANSLATION_FILES_LOCATION);

            if(!isset($translationFilesByLocale[$locale])) {
                throw new MissingTranslationFileException($locale);
            }

            $jsonTranslations = file_get_contents($folderPath . '/' . $translationFilesByLocale[$locale]);

            static::$translationsArrayByLocale[$locale] = json_decode($jsonTranslations, true);
        }
    }

    /**
     * @return array<string, string>
     */
    public function getTranslationFiles(): array
    {
        if (!static::$translationFilesByLocale) {
            $files = scandir(ConfigReader::config(ConfigConstants::KEY_TRANSLATION_FILES_LOCATION));
            $filteredFiles = preg_grep(self::TRANSLATION_FILES_SUFFIX_PATTERN, $files);

            $translationFilesByLocale = [];
            foreach ($filteredFiles as $fileName) {
                $locale = basename($fileName, self::TRANSLATION_FILE_SUFFIX);
                $translationFilesByLocale[$locale] = $fileName;
            }

            static::$translationFilesByLocale = $translationFilesByLocale;
        }

        return static::$translationFilesByLocale;
    }

    /**
     * @return array
     */
    public function getTranslations(): array
    {
        return static::$translationsArrayByLocale;
    }
}
