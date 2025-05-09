<?php

/**
 * It's free open-source software released under the MIT License.
 *
 * @author Anatoly Nekhay <afenric@gmail.com>
 * @copyright Copyright (c) 2025, Anatoly Nekhay
 * @license https://github.com/sunrise-php/translator/blob/master/LICENSE
 * @link https://github.com/sunrise-php/translator
 */

declare(strict_types=1);

namespace Sunrise\Translator\Adapter;

use Sunrise\Translator\TranslatorManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface as SymfonyTranslatorInterface;

/**
 * @since 1.1.0
 */
final class SymfonyTranslator implements SymfonyTranslatorInterface
{
    public function __construct(
        private readonly TranslatorManagerInterface $translatorManager,
        private readonly string $defaultDomain,
        private readonly string $defaultLocale,
    ) {
    }

    /**
     * @inheritDoc
     *
     * @param array<array-key, mixed> $parameters
     */
    public function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
    {
        $domain ??= $this->defaultDomain;
        $locale ??= $this->defaultLocale;

        return $this->translatorManager->translate($domain, $locale, $id, $parameters);
    }

    /**
     * @inheritDoc
     */
    public function getLocale(): string
    {
        return $this->defaultLocale;
    }
}
