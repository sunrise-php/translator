<?php

declare(strict_types=1);

namespace Sunrise\Translator\Tests\Translator;

use PHPUnit\Framework\TestCase;
use Sunrise\Translator\Translator\DirectoryTranslator;

final class DirectoryTranslatorTest extends TestCase
{
    private static function createDirectoryTranslator(
        ?string $domain = null,
        ?string $directory = null,
    ): DirectoryTranslator {
        return new DirectoryTranslator(
            domain: $domain ?? 'app',
            directory: $directory ?? __DIR__ . '/../Fixture/translations',
        );
    }

    public function testTranslate(): void
    {
        $directoryTranslator = self::createDirectoryTranslator();
        self::assertTrue($directoryTranslator->hasTranslation('app', 'sr', 'Hello'));
        self::assertSame('Zdravo', $directoryTranslator->getTranslation('app', 'sr', 'Hello'));
        self::assertTrue($directoryTranslator->hasTranslation('app', 'sr', 'Goodbye'));
        self::assertSame('Doviđenja', $directoryTranslator->getTranslation('app', 'sr', 'Goodbye'));
    }

    public function testUnsupportedDomain(): void
    {
        self::assertFalse(self::createDirectoryTranslator()->hasTranslation('foo', 'sr', 'Hello'));
        self::assertSame('Hello', self::createDirectoryTranslator()->getTranslation('foo', 'sr', 'Hello'));
    }

    public function testUnsupportedLocale(): void
    {
        self::assertFalse(self::createDirectoryTranslator()->hasTranslation('app', 'me', 'Hello'));
        self::assertSame('Hello', self::createDirectoryTranslator()->getTranslation('app', 'me', 'Hello'));
    }

    public function testUnknownFile(): void
    {
        self::assertFalse(self::createDirectoryTranslator(directory: '/')->hasTranslation('app', 'sr', 'Hello'));
        self::assertSame('Hello', self::createDirectoryTranslator(directory: '/')->getTranslation('app', 'sr', 'Hello'));
    }

    public function testEmptyFile(): void
    {
        self::assertFalse(self::createDirectoryTranslator()->hasTranslation('app', 'hr', 'Hello'));
        self::assertSame('Hello', self::createDirectoryTranslator()->getTranslation('app', 'hr', 'Hello'));
    }

    public function testInvalidFile(): void
    {
        self::assertFalse(self::createDirectoryTranslator()->hasTranslation('app', 'bs', 'Hello'));
        self::assertSame('Hello', self::createDirectoryTranslator()->getTranslation('app', 'bs', 'Hello'));
    }

    public function testWeight(): void
    {
        self::assertSame(0, self::createDirectoryTranslator()->getWeight());
    }
}
