<?php

declare(strict_types=1);


namespace LeafOmniglot\Handler;


use LeafOmniglot\Constants\ConfigConstants;
use LeafOmniglot\Plugins\Locale\LocaleStrategyPluginInterface;
use LeafOmniglot\Reader\ConfigReader;

class LocaleHandler
{
    private LocaleStrategyPluginInterface $localeStrategyPlugin;

    private FileHandler $fileHandler;

    /**
     * @param \LeafOmniglot\Plugins\Locale\LocaleStrategyPluginInterface $localeStrategyPlugin
     * @param \LeafOmniglot\Handler\FileHandler $fileHandler
     */
    public function __construct(LocaleStrategyPluginInterface $localeStrategyPlugin, FileHandler $fileHandler)
    {
        $this->localeStrategyPlugin = $localeStrategyPlugin;
        $this->fileHandler = $fileHandler;
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
        $this->fileHandler->loadTranslationsByLocale($locale);
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
     * @return array
     */
    public function getAvailableLocales(): array
    {
        return array_keys($this->fileHandler->getTranslationFiles());
    }
}
