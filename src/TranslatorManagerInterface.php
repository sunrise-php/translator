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

namespace Sunrise\Translator;

interface TranslatorManagerInterface
{
    /**
     * @param array<array-key, mixed> $placeholders
     */
    public function translate(string $domain, string $locale, string $template, array $placeholders = []): string;
}
