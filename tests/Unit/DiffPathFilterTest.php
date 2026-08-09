<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\DiffPathFilter;
use Poagen\Generator\Generator\GenerationPlan;

/**
 * Unit coverage for {@see DiffPathFilter} — `poagen generate --diff`'s
 * `--diff=<glob>` path scope, exercised directly against paths rather than
 * through a {@see GenerationPlan} — see that class's own docblock for why
 * it is built to allow exactly this.
 */
final class DiffPathFilterTest extends TestCase
{
    private const string ROOT = '/out';

    public function testALiteralPatternMatchesTheExactRelativePathOnly(): void
    {
        $filter = new DiffPathFilter('Generated/Model/Pet.php', self::ROOT);

        self::assertTrue($filter->matches('/out/Generated/Model/Pet.php'));
        self::assertFalse($filter->matches('/out/Generated/Model/Tag.php'));
    }

    public function testALiteralPatternAlsoMatchesEverythingBeneathItAsADirectoryPrefix(): void
    {
        $filter = new DiffPathFilter('Generated/Model', self::ROOT);

        self::assertTrue($filter->matches('/out/Generated/Model/Pet.php'));
        self::assertFalse($filter->matches('/out/Generated/ApiClient.php'));
        // Not a sibling directory sharing the prefix by accident.
        self::assertFalse($filter->matches('/out/Generated/ModelExtra/Pet.php'));
    }

    public function testADoubleStarPatternIsEquivalentToTheLiteralPrefixForm(): void
    {
        $filter = new DiffPathFilter('Generated/Model/**', self::ROOT);

        self::assertTrue($filter->matches('/out/Generated/Model/Pet.php'));
        self::assertFalse($filter->matches('/out/Generated/ApiClient.php'));
    }

    public function testASingleStarDoesNotCrossADirectorySeparator(): void
    {
        $filter = new DiffPathFilter('Generated/*.php', self::ROOT);

        self::assertTrue($filter->matches('/out/Generated/ApiClient.php'));
        self::assertFalse($filter->matches('/out/Generated/Model/Pet.php'));
    }

    public function testAQuestionMarkMatchesExactlyOneNonSlashCharacter(): void
    {
        $filter = new DiffPathFilter('Generated/Enum/?.php', self::ROOT);

        self::assertTrue($filter->matches('/out/Generated/Enum/A.php'));
        self::assertFalse($filter->matches('/out/Generated/Enum/AB.php'));
    }

    public function testAPathOutsideTheOutputRootIsMatchedAgainstItsRawForm(): void
    {
        $filter = new DiffPathFilter('/elsewhere/Foo.php', self::ROOT);

        self::assertTrue($filter->matches('/elsewhere/Foo.php'));
        self::assertFalse($filter->matches('/out/Generated/Foo.php'));
    }

    public function testAGlobMatchingNothingMatchesNoPath(): void
    {
        $filter = new DiffPathFilter('NoSuchDir/**', self::ROOT);

        self::assertFalse($filter->matches('/out/Generated/ApiClient.php'));
        self::assertFalse($filter->matches('/out/Generated/Model/Pet.php'));
    }
}
