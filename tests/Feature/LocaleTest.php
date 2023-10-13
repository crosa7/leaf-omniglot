<?php

it('tests that setCurrentLocale sets locale and getCurrentLocale retrieves it', function () {
    omniglot()->init([
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]);

    expect(omniglot()->getCurrentLocale())->toBe('en_US');

    omniglot()->setCurrentLocale('pt_PT');

    expect(omniglot()->getCurrentLocale())->toBe('pt_PT');
});

it('tests that setCurrentLocale throws exception if locale on found in files', function () {
    omniglot()->init([
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]);

    expect(omniglot()->getCurrentLocale())->toBe('en_US');

    expect(fn () => omniglot()->setCurrentLocale('random_locale'))
        ->toThrow(\LeafOmniglot\Exceptions\MissingTranslationFileException::class);
});

it('tests that getAvailableLocales gets all locales that there are files for', function () {
    omniglot()->init([
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]);

    expect(omniglot()->getAvailableLocales())->toBe(['en_US', 'pt_BR', 'pt_PT']);
});

it('tests that getDefaultLocale returns configured default locale', function () {
    omniglot()->init([
        'DEFAULT_LOCALE' => 'pt_PT',
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]);

    expect(omniglot()->getDefaultLocale())->toBe('pt_PT');

    // Here because of caching issues with tests
    \LeafOmniglot\Reader\ConfigReader::config('DEFAULT_LOCALE', 'en_US');
});

afterEach(function () {
    session_destroy();
});
