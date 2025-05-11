<?php

declare(strict_types=1);

namespace Sunrise\Translator\Tests\Adapter;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sunrise\Translator\Adapter\SymfonyTranslator;
use Sunrise\Translator\TranslatorManagerInterface;

final class SymfonyTranslatorTest extends TestCase
{
    private TranslatorManagerInterface&MockObject $translatorManager;

    protected function setUp(): void
    {
        $this->translatorManager = $this->createMock(TranslatorManagerInterface::class);
    }

    public function testTrans(): void
    {
        $translator = new SymfonyTranslator($this->translatorManager, 'validator', 'en');
        $this->translatorManager->expects(self::once())->method('translate')->with('app', 'sr', 'Hello, {0}!', ['{0}' => 'Marko'])->willReturn('Zdravo, Marko!');
        self::assertSame('Zdravo, Marko!', $translator->trans('Hello, {0}!', ['{0}' => 'Marko'], 'app', 'sr'));
    }

    public function testDefaultParams(): void
    {
        $translator = new SymfonyTranslator($this->translatorManager, 'app', 'sr');
        $this->translatorManager->expects(self::once())->method('translate')->with('app', 'sr', 'Hello, {0}!', ['{0}' => 'Marko'])->willReturn('Zdravo, Marko!');
        self::assertSame('Zdravo, Marko!', $translator->trans('Hello, {0}!', ['{0}' => 'Marko']));
    }

    public function testGetLocale(): void
    {
        $translator = new SymfonyTranslator($this->translatorManager, 'app', 'sr');
        self::assertSame('sr', $translator->getLocale());
    }

    public function testSetLocale(): void
    {
        $translator = new SymfonyTranslator($this->translatorManager, 'app', 'sr');
        $translator->setLocale('ru');
        self::assertSame('ru', $translator->getLocale());
        $this->translatorManager->expects(self::once())->method('translate')->with('app', 'ru', 'Hello, {0}!', ['{0}' => 'Marko'])->willReturn('Здравствуй, Марко!');
        self::assertSame('Здравствуй, Марко!', $translator->trans('Hello, {0}!', ['{0}' => 'Marko']));
    }
}
