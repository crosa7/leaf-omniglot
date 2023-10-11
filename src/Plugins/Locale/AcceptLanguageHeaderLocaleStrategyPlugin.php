<?php

declare(strict_types=1);


namespace App\src\Plugins\Locale;


use Leaf\Http\Request;

class AcceptLanguageHeaderLocaleStrategyPlugin implements LocaleStrategyPluginInterface
{
    /**
     * @param string $locale
     *
     * @return void
     */
    public function setCurrentLocale(string $locale): void
    {
        // Not Needed in this case
    }

    /**
     * @return string|null
     */
    public function getCurrentLocale(): ?string
    {
        return Request::headers('Accept-Language');
    }
}
