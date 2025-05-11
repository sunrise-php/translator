<?php

declare(strict_types=1);

use Sunrise\Translator\Adapter\SymfonyTranslator;
use Sunrise\Translator\TranslatorManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use function DI\create;
use function DI\get;

return [
    'symfony_translator.default_domain' => 'validator',
    'symfony_translator.default_locale' => 'en',

    TranslatorInterface::class => create(SymfonyTranslator::class)
        ->constructor(
            translatorManager: get(TranslatorManagerInterface::class),
            defaultDomain: get('symfony_translator.default_domain'),
            defaultLocale: get('symfony_translator.default_locale'),
        ),
];
