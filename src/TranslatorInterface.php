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

interface TranslatorInterface
{
    public function hasTranslation(string $domain, string $locale, string $template): bool;

    public function getTranslation(string $domain, string $locale, string $template): string;

    public function getWeight(): int;
}
