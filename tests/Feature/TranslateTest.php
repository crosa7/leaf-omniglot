<?php

it('tests that translate, translates by key', function () {
    omniglot()->init([
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]);

    expect(tl('welcome.page.title'))->toBe('Hello World EN');
    expect(tl('test.title'))->toBe('Its a test EN!');
});

it('tests that translate, translates with single and multiple parameters', function () {
    omniglot()->init([
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]);

    expect(
        tl('test.with.param1', ['%param%' => 'good'])
    )->toBe('Test good EN');

    expect(
        tl('test.with.param2', ['--param--' => 'good'])
    )->toBe('Test good');

    expect(
        tl('test.with.multiple.params', ['%param1%' => 'good', '%param2%' => 'stuff'])
    )->toBe('Test good and stuff');
});

it('tests that translate, translates for multiple languages', function () {
    omniglot()->init([
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]);

    expect(
        tl('test.with.param1', ['%param%' => 'good'])
    )->toBe('Test good EN');

    omniglot()->setCurrentLocale('pt_PT');

    expect(
        tl('test.with.param1', ['%param%' => 'good'])
    )->toBe('Test good PT');
});

it('tests that translate, fallback to translation key in case translation not found', function () {
    omniglot()->init([
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]);

    expect(tl('not.found.key'))->toBe('not.found.key');
});

it('tests that translate, throws exception if translation parameter not found', function () {
    omniglot()->init([
        'TRANSLATION_FILES_LOCATION' => './tests/data/locales'
    ]);

    expect(
        fn () => tl('test.title', ['%param%' => 'not good'])
    )->toThrow(\LeafOmniglot\Exceptions\TranslationParamNotFoundException::class, 'Param "%param%" not found in translation string "Its a test EN!"');
});

afterEach(function () {
    session_destroy();
});
