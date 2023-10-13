<!-- markdownlint-disable no-inline-html -->
<p align="center">
  <br><br>
  <img src="https://leafphp.netlify.app/assets/img/leaf3-logo.png" height="100"/>
  <h1 align="center">Leaf Omniglot</h1>
  <br><br>
</p>


[//]: # ([![Latest Stable Version]&#40;https://poser.pugx.org/leafs/auth/v/stable&#41;]&#40;https://packagist.org/packages/leafs/auth&#41;)

[//]: # ([![Total Downloads]&#40;https://poser.pugx.org/leafs/auth/downloads&#41;]&#40;https://packagist.org/packages/leafs/auth&#41;)

[//]: # ([![License]&#40;https://poser.pugx.org/leafs/auth/license&#41;]&#40;https://packagist.org/packages/leafs/auth&#41;)

Leaf Omniglot is a simple but powerful module that adds multi language capabilities to your leaf applications.

## Installation

You can easily install Leaf Omniglot using [Composer](https://getcomposer.org/).

```bash
composer require crosa7/leaf-omniglot
```

[//]: # (Or with Leaf Cli)

[//]: # ()
[//]: # (```sh)

[//]: # (leaf install omniglot)

[//]: # (```)

## Quick Start Guide

### Create translation folder and files

```php
// Create a folder named "locales" in your project root
// (you can also create in another place that makes more sense, just be aware to configure the path accordingly)

// Create the following file inside the "locales" folder
en_US.locale.json

// With the following content
{
    "welcome.title": "Hello World"
}
```

### Initialize Omniglot

In your index.php file (if using MVC: public/index.php). Add these lines:

```php
omniglot()->init(
    [
        'TRANSLATION_FILES_LOCATION' => './locales',
    ]
);
```

### Add Language Switch Route

In your routes file ("_app.php" for MVC and "index.php" for base Leaf) add this line:

```php
omniglot()->addLanguageSwitchRoute();
```

### Start Translating

Now in your template file you can add the following:

(this example is using blade as template engine but you can adjust according to your template engine)
```php
<form method="post" action="/language/switch">
  <select name="locale" onchange="this.form.submit()">
    @foreach(omniglot()->getAvailableLocales() as $locale)
        <option value="{{ $locale }}" {{ omniglot()->getCurrentLocale() === $locale ? 'selected' : '' }}>{{ $locale }}</option>
    @endforeach
  </select>
</form>

<h1>{{ tl('welcome.title') }}</h1>
```

You should then see inside the "h1" tag in your browser the text: Hello World

## Basic Usage

After installing omniglot, you need to create a folder where your translation files will live.
Inside this folder you create the files in the following way:

```
en_US.locale.json
pt_PT.locale.json
```

The important part is having a file suffixed with `.locale.json` the name for the language does not matter.
You can use for example `en.locale.json` as well

### Translation file content

Your translation files should have the following format:

```php
{
    "welcome.page.title": "This is the page title translation",
    "welcome.page.sub_title": "This is welcome page subtitle"
}
```

As key in the json, you have the translation key, used to identify the translation and as value you have the translation itself in the language that
you defined in the filename

### Init

Initialize the module and pass your custom configuration

```php
omniglot()->init([
    'DEFAULT_LOCALE' => 'en_US',
    'TRANSLATION_FILES_LOCATION' =>  './locales',
]);
```

## Configurations

These are the available configuration parameters that you can pass inside the `init()` method as seen above.

### DEFAULT_LOCALE

With this parameter you define your default locale so that this is the initial locale used in your application load.
**The value configured here MUST match the translation file name that you define for this locale**. Example:
```php
DEFAULT_LOCALE => en_US

// Translation file name
en_US.locale.json
```

### TRANSLATION_FILES_LOCATION

As the name says, this is the path to the folder that contains the translation files, one suggestion would be:
`'TRANSLATION_FILES_LOCATION' =>  './locales'` and then put the translation files inside a `locales` folder.

### LOCALE_STRATEGY

With this you defined the way that you want Omniglot to behave when fetching and storing the chosen locale.
Possible values are: `session`, `accept-language-header` and `custom`.
- **session:** This is useful for a mvc/website setup. When you use omniglot and call `setCurrentLocale` or `getCurrentLocale` the current locale will be fetched/stored in session.
- **accept-language-header:** This is useful when you are using Leaf as an API only. You just need to set the `Accept-Language` header to the value of the locale that you want to use
and omniglot will translate according to this locale. `setCurrentLocale` here won't do anything as in this use case only the external application that calls the API, sets the locale.
- **custom:** This is a more advanced option. Omniglot allows you to create your own locale fetching/storing strategy. To do this
you need to create a class that implements `LocaleStrategyPluginInterface`. This interface has two methods:
  - getCurrentLocale(): This should return a string with the locale name.
  - setCurrentLocale(): And this is used to store the current locale (if needed). Does not return anything.

### CUSTOM_LOCALE_STRATEGY_CLASS_NAME

After setting `LOCALE_STRATEGY` to `custom` and implementing your own class that implements the mentioned interface.  
You set here the class name of your new class, example:

```php
// Your class: RequestLocaleStrategy
CUSTOM_LOCALE_STRATEGY_CLASS_NAME => RequestLocaleStrategy::class
```

### Available methods

#### tl()

This method you can call from anywhere in functional mode and is the main method for translating you strings. This method takes two parameters:  
- key: The translation key defined in your translation files
- params: An array with the parameters that you define in your translation files, example:

```php
// Translation file content
{
    "welcome.page.title": "Welcome %firstName% --lastName-- to the dashboard",
    "navbar.title": "Dashboard"
}

// Translation method call
tl('welcome.page.title', ['%firstName%' => 'John', '--lastName--' => 'Doe']); // Welcome John Doe to the dashboard

// You can use anything as parameter identifier. Omniglot will look for anything that you pass as key  
// in the parameters array and replace anything that it finds with this pattern and replace by the value you pass.

// In case of translations without parameters you can simply call:
tl('navbar.title'); // Dashboard

```

#### omniglot()

This method allows you to use any method inside the Omniglot class. For example you could use `omniglot()->translate()` instead of `tl()`.
The following methods are available under `omniglot()`:
- **omniglot()->init():** Explained above in the Basic Usage
- **omniglot()->translate():** Same as `tl()`
- **omniglot()->setCurrentLocale():** Used to set the current selected locale based on the chosen strategy
- **omniglot()->getCurrentLocale():** Fetches current configured locale or the default locale in case nothing is configured yet
- **omniglot()->getAvailableLocales():** Returns an array of locales available. This is fetched from the file names on the configured `locales` folder
- **omniglot()->getDefaultLocale():** As the name implies, returns the configured default locale


#### omniglot()->addLanguageSwitchRoute()

You can call this method in the same file where you define your routes. For Leaf MVC / API that would be `_app`.   
For a simple Leaf application it would be in `index.php`.

This will automatically create a POST route for you to call when you want to switch language.  
You simply need to do a POST to `/language/switch`, with the following POST data:

````php
{
    "locale": "en_US"
}
````

And it will set this as current locale if the corresponding file exists. It will also redirect back to the page it was called from.

It also accepts 3 parameters.
- **path**: By default the defined path is `/language/switch` but you can pass any path you want
- **requestLocaleParamName**: By default the route is expecting POST data with a property called `locale` by default but this can be changed with this parameter
- **redirectToReferer**: By default this route will automatically redirect to referer but you can set this to `false` and then it will just return a simple json response





## Links/Projects

- [Leaf Docs](https://leafphp.dev)
