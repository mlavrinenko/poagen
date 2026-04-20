<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime;

use Mlavrinenko\Paogen\Runtime\Marshal\MethodDocScanner;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Pet;
use PHPUnit\Framework\TestCase;

/**
 * Exercises the `token_get_all` fallback path that kicks in when
 * `ReflectionMethod::getDocComment()` returns `false` under
 * `opcache.save_comments=0`. See task 029 and ADR-010.
 */
final class DescriptorParserFallbackTest extends TestCase
{
    public function testTokenScanRecoversConstructorPhpdocFromFile(): void
    {
        $reflection = new \ReflectionMethod(Pet::class, '__construct');
        $doc = MethodDocScanner::docFor($reflection);

        self::assertIsString($doc);
        self::assertStringContainsString('@param list<\Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Tag>|null $tags', $doc);
    }

    public function testTokenScanReturnsFalseForInternalReflection(): void
    {
        // `\DateTimeImmutable::__construct` is a C-defined method — no source file.
        $reflection = new \ReflectionMethod(\DateTimeImmutable::class, '__construct');

        self::assertFalse(MethodDocScanner::docFor($reflection));
    }

    public function testHydratorRecoversListItemTypeWhenOpcacheStripsComments(): void
    {
        if (!\extension_loaded('Zend OPcache')) {
            self::markTestSkipped('Zend OPcache not loaded in CLI.');
        }

        $projectRoot = \dirname(__DIR__, 3);
        $autoload = $projectRoot . '/vendor/autoload.php';
        $script = <<<PHP
            <?php
            require {$this->phpString($autoload)};

            \$reflection = new ReflectionMethod(\\Mlavrinenko\\Paogen\\Tests\\Unit\\Runtime\\Fixtures\\Pet::class, '__construct');
            \$stripped = \$reflection->getDocComment() === false;

            \$pet = (new \\Mlavrinenko\\Paogen\\Runtime\\Marshal\\Hydrator())->hydrate(
                \\Mlavrinenko\\Paogen\\Tests\\Unit\\Runtime\\Fixtures\\Pet::class,
                ['id' => 1, 'tags' => [['id' => 10, 'name' => 'friendly']]],
            );

            echo (\$stripped ? 'stripped' : 'keeps-comments'), ':',
                (\$pet->tags[0] instanceof \\Mlavrinenko\\Paogen\\Tests\\Unit\\Runtime\\Fixtures\\Tag ? 'tag' : 'array');
            PHP;
        $scriptPath = $projectRoot . '/build/cache/opcache-fallback-' . uniqid() . '.php';

        if (!is_dir(\dirname($scriptPath))) {
            mkdir(\dirname($scriptPath), 0o755, true);
        }
        file_put_contents($scriptPath, $script);

        try {
            $cmd = \sprintf(
                '%s -d opcache.enable_cli=1 -d opcache.save_comments=0 %s 2>&1',
                escapeshellarg(\PHP_BINARY),
                escapeshellarg($scriptPath),
            );
            $output = trim((string) shell_exec($cmd));
        } finally {
            @unlink($scriptPath);
        }

        // Guard against someone simplifying the test to the point where the
        // fallback doesn't actually fire — we need `getDocComment()` to
        // return false *and* hydration to still produce a Tag.
        self::assertSame('stripped:tag', $output, "Subprocess output: {$output}");
    }

    private function phpString(string $raw): string
    {
        return var_export($raw, true);
    }
}
