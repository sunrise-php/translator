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

namespace Sunrise\Translator\Translator;

use Sunrise\Translator\TranslatorInterface;

use function is_array;
use function is_file;
use function sprintf;

final class DirectoryTranslator implements TranslatorInterface
{
    /**
     * [locale, [template => translation]]
     *
     * @var array<string, array<string, string>>
     */
    private array $translations = [];

    public function __construct(
        private readonly string $domain,
        private readonly string $directory,
    ) {
    }

    public function hasTranslation(string $domain, string $locale, string $template): bool
    {
        $this->loadTranslations($domain, $locale);

        return isset($this->translations[$locale][$template]);
    }

    public function getTranslation(string $domain, string $locale, string $template): string
    {
        $this->loadTranslations($domain, $locale);

        return $this->translations[$locale][$template] ?? $template;
    }

    public function getWeight(): int
    {
        return 0;
    }

    private function loadTranslations(string $domain, string $locale): void
    {
        if ($this->domain !== $domain) {
            return;
        }

        if (isset($this->translations[$locale])) {
            return;
        }

        $this->translations[$locale] = [];

        $file = sprintf('%s/%s.php', $this->directory, $locale);
        if (!is_file($file)) {
            return;
        }

        $translations = (static fn(): mixed => include $file)();
        if (!is_array($translations)) {
            return;
        }

        /** @var array<string, string> $translations */
        $this->translations[$locale] = $translations;
    }
}
