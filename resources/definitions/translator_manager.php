<?php

declare(strict_types=1);

use Sunrise\Translator\TranslatorManager;
use Sunrise\Translator\TranslatorManagerInterface;

use function DI\create;
use function DI\get;

return [
    'translator.translators' => [],

    TranslatorManagerInterface::class => create(TranslatorManager::class)
        ->constructor(
            translators: get('translator.translators'),
        ),
];
