<?php

declare(strict_types=1);

namespace Sunrise\Translator\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sunrise\Translator\TranslatorInterface;
use Sunrise\Translator\TranslatorManager;

final class TranslatorManagerTest extends TestCase
{
    /**
     * @var array<array-key, TranslatorInterface&MockObject>
     */
    private array $mockedTranslators = [];

    protected function setUp(): void
    {
        $this->mockedTranslators = [];
    }

    private function createTranslatorManager(): TranslatorManager
    {
        return new TranslatorManager($this->mockedTranslators);
    }

    public function testTranslateTemplateWithoutTranslators(): void
    {
        self::assertSame('Hello', $this->createTranslatorManager()->translate('app', 'sr', 'Hello'));
    }

    public function testTranslateTemplateWithSuitableTranslator(): void
    {
        $this->mockedTranslators[0] = $this->createMock(TranslatorInterface::class);
        $this->mockedTranslators[0]->expects(self::once())->method('hasTranslation')->with('app', 'sr', 'Hello')->willReturn(true);
        $this->mockedTranslators[0]->expects(self::once())->method('getTranslation')->with('app', 'sr', 'Hello')->willReturn('Zdravo');
        self::assertSame('Zdravo', $this->createTranslatorManager()->translate('app', 'sr', 'Hello'));
    }

    public function testTranslateTemplateWithoutSuitableTranslator(): void
    {
        $this->mockedTranslators[0] = $this->createMock(TranslatorInterface::class);
        $this->mockedTranslators[0]->expects(self::once())->method('hasTranslation')->with('app', 'sr', 'Hello')->willReturn(false);
        $this->mockedTranslators[0]->expects(self::never())->method('getTranslation');
        self::assertSame('Hello', $this->createTranslatorManager()->translate('app', 'sr', 'Hello'));
    }

    public function testTranslateTemplateWithEmptyTranslation(): void
    {
        $this->mockedTranslators[0] = $this->createMock(TranslatorInterface::class);
        $this->mockedTranslators[0]->expects(self::once())->method('hasTranslation')->with('app', 'sr', 'Hello')->willReturn(true);
        $this->mockedTranslators[0]->expects(self::once())->method('getTranslation')->with('app', 'sr', 'Hello')->willReturn('');
        self::assertSame('', $this->createTranslatorManager()->translate('app', 'sr', 'Hello'));
    }

    public function testReplacePlaceholdersInTemplate(): void
    {
        self::assertSame('Hello, Marko Petrović!', $this->createTranslatorManager()->translate('app', 'sr', 'Hello, {0} {1}!', ['{0}' => 'Marko', '{1}' => 'Petrović']));
    }

    public function testReplacePlaceholdersInTemplateWhenNoPlaceholdersProvided(): void
    {
        self::assertSame('Hello, {0} {1}!', $this->createTranslatorManager()->translate('app', 'sr', 'Hello, {0} {1}!'));
    }

    public function testReplacePlaceholdersWhenNoPlaceholdersInTemplate(): void
    {
        self::assertSame('Hello, Friend!', $this->createTranslatorManager()->translate('app', 'sr', 'Hello, Friend!', ['{0}' => 'Marko', '{1}' => 'Petrović']));
    }

    public function testReplacePlaceholdersInTranslation(): void
    {
        $this->mockedTranslators[0] = $this->createMock(TranslatorInterface::class);
        $this->mockedTranslators[0]->expects(self::once())->method('hasTranslation')->with('app', 'sr', 'Hello, {0} {1}!')->willReturn(true);
        $this->mockedTranslators[0]->expects(self::once())->method('getTranslation')->with('app', 'sr', 'Hello, {0} {1}!')->willReturn('Zdravo, {0} {1}!');
        self::assertSame('Zdravo, Marko Petrović!', $this->createTranslatorManager()->translate('app', 'sr', 'Hello, {0} {1}!', ['{0}' => 'Marko', '{1}' => 'Petrović']));
    }

    public function testReplacePlaceholdersInTranslationWhenNoPlaceholdersProvided(): void
    {
        $this->mockedTranslators[0] = $this->createMock(TranslatorInterface::class);
        $this->mockedTranslators[0]->expects(self::once())->method('hasTranslation')->with('app', 'sr', 'Hello, {0} {1}!')->willReturn(true);
        $this->mockedTranslators[0]->expects(self::once())->method('getTranslation')->with('app', 'sr', 'Hello, {0} {1}!')->willReturn('Zdravo, {0} {1}!');
        self::assertSame('Zdravo, {0} {1}!', $this->createTranslatorManager()->translate('app', 'sr', 'Hello, {0} {1}!'));
    }

    public function testReplacePlaceholdersWhenNoPlaceholdersInTranslation(): void
    {
        $this->mockedTranslators[0] = $this->createMock(TranslatorInterface::class);
        $this->mockedTranslators[0]->expects(self::once())->method('hasTranslation')->with('app', 'sr', 'Hello, Friend!')->willReturn(true);
        $this->mockedTranslators[0]->expects(self::once())->method('getTranslation')->with('app', 'sr', 'Hello, Friend!')->willReturn('Zdravo, Prijatelj!');
        self::assertSame('Zdravo, Prijatelj!', $this->createTranslatorManager()->translate('app', 'sr', 'Hello, Friend!', ['{0}' => 'Marko', '{1}' => 'Petrović']));
    }

    public function testSortTranslators(): void
    {
        $this->mockedTranslators[0] = $this->createMock(TranslatorInterface::class);
        $this->mockedTranslators[0]->expects(self::once())->method('hasTranslation')->with('app', 'sr', 'Hello')->willReturn(false);
        $this->mockedTranslators[0]->expects(self::never())->method('getTranslation');
        $this->mockedTranslators[0]->expects(self::any())->method('getWeight')->willReturn(2);

        $this->mockedTranslators[1] = $this->createMock(TranslatorInterface::class);
        $this->mockedTranslators[1]->expects(self::once())->method('hasTranslation')->with('app', 'sr', 'Hello')->willReturn(true);
        $this->mockedTranslators[1]->expects(self::once())->method('getTranslation')->with('app', 'sr', 'Hello')->willReturn('Zdravo');
        $this->mockedTranslators[1]->expects(self::any())->method('getWeight')->willReturn(0);

        $this->mockedTranslators[2] = $this->createMock(TranslatorInterface::class);
        $this->mockedTranslators[2]->expects(self::once())->method('hasTranslation')->with('app', 'sr', 'Hello')->willReturn(false);
        $this->mockedTranslators[2]->expects(self::never())->method('getTranslation');
        $this->mockedTranslators[2]->expects(self::any())->method('getWeight')->willReturn(1);

        self::assertSame('Zdravo', $this->createTranslatorManager()->translate('app', 'sr', 'Hello'));
    }
}
