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

use function strtr;
use function usort;

final class TranslatorManager implements TranslatorManagerInterface
{
    private bool $isSorted = false;

    public function __construct(
        /** @var array<array-key, TranslatorInterface> */
        private array $translators,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function translate(string $domain, string $locale, string $template, array $placeholders = []): string
    {
        $translation = $this->findTranslation($domain, $locale, $template);

        return strtr($translation ?? $template, $placeholders);
    }

    private function findTranslation(string $domain, string $locale, string $template): ?string
    {
        $this->isSorted or $this->sortTranslators();

        foreach ($this->translators as $translator) {
            if ($translator->hasTranslation($domain, $locale, $template)) {
                return $translator->getTranslation($domain, $locale, $template);
            }
        }

        return null;
    }

    private function sortTranslators(): void
    {
        $this->isSorted = usort($this->translators, static fn(
            TranslatorInterface $a,
            TranslatorInterface $b,
        ): int => $b->getWeight() <=> $a->getWeight());
    }
}
