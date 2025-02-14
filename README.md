## Translation Manager

### A flexible translation manager.

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sunrise-php/translator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/translator/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/sunrise-php/translator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/translator/?branch=master)
[![Total Downloads](https://poser.pugx.org/sunrise/translator/downloads?format=flat)](https://packagist.org/packages/sunrise/translator)

## Installation

```bash
composer require sunrise/translator
```

## How to use

### Quick Start

```php
// Contents of this example translation file (located at /translations/sr.php):

return [
    'Hello, {username}!' => 'Zdravo, {username}!',
];
```

```php
use Sunrise\Translator\TranslatorManager;
use Sunrise\Translator\Translator\DirectoryTranslator;

$translator = new TranslatorManager(
    translators: [
        new DirectoryTranslator(
            domain: 'app',
            directory: '/translations',
        ),
    ],
);

// Result: Zdravo, Marko!
$translator->translate(domain: 'app', locale: 'sr', template: 'Hello, {username}!', placeholders: ['{username}' => 'Marko']);
```

### PHP-DI definitions

```php
use DI\ContainerBuilder;
use Sunrise\Translator\TranslatorManagerInterface;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinition(__DIR__ . '/../vendor/sunrise/translator/resources/definitions/translator_manager.php');

$container = $containerBuilder->build();

// See above for usage examples.
$translator = $container->get(TranslatorManagerInterface::class);
```

## Tests

```bash
composer test
```
