<?php

declare(strict_types=1);


namespace App\src\Plugins\Locale;


use Leaf\Http\Session;

class SessionLocaleStrategyPlugin implements LocaleStrategyPluginInterface
{
    private const SESSION_KEY_CURRENT_LOCALE = 'OMNIGLOT_LOCALE';

    /**
     * @param string $locale
     *
     * @return void
     */
    public function setCurrentLocale(string $locale): void
    {
        $session = new Session();

        $session::set(self::SESSION_KEY_CURRENT_LOCALE, $locale);
    }

    /**
     * @return string|null
     */
    public function getCurrentLocale(): ?string
    {
        $session = new Session();

        return $session::get(self::SESSION_KEY_CURRENT_LOCALE);
    }
}
