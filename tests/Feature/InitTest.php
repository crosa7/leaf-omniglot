<?php

it('tests that init uses configured default locale', function () {
    omniglot()->init([
        'DEFAULT_LOCALE' => 'pt_BR',
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]);

    expect(tl('welcome.page.title'))->toBe('Hello World BR');
});

it('tests that init throws exception when locale file not found', function () {
    expect(fn() => omniglot()->init([
        'DEFAULT_LOCALE' => 'invalid-locale',
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]))->toThrow(
        \LeafOmniglot\Exceptions\MissingTranslationFileException::class,
        'Translation file not found for locale "invalid-locale" make sure you have a translation file named "invalid-locale.locale.json" in your translation files folder'
    );
});

it('tests that init uses locale in session', function () {
    omniglot()->init([
        'DEFAULT_LOCALE' => 'en_US',
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]);

    expect(tl('welcome.page.title'))->toBe('Hello World EN');

    omniglot()->setCurrentLocale('pt_PT');

    omniglot()->init([
        'DEFAULT_LOCALE' => 'en_US',
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]);

    expect(tl('welcome.page.title'))->toBe('Hello World PT');
});

afterEach(function () {
    session_destroy();
});
