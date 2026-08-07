<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Emit\ComponentCatalog;
use Poagen\Generator\Generator\Enum\EnumCatalog;
use Poagen\Generator\Generator\Naming\NameRegistry;
use Poagen\Generator\Generator\Naming\PascalCaseSanitiser;
use Poagen\Generator\Generator\PhpDocTypeValidator;

/**
 * refined-phpdoc-types: the stale-guidance refusal on `$phpDocTypes`, built
 * from the real {@see ComponentCatalog} the same way a run builds it, so the
 * validator's reading of "what the model contains" is the run's reading.
 */
final class PhpDocTypeValidatorTest extends TestCase
{
    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/refined-types-3.0.yaml';

    public function testAValidEntryProducesNoFailure(): void
    {
        self::assertSame([], $this->validate(['LineItem.amount' => 'numeric-string']));
    }

    public function testAnEmptyMapProducesNoFailure(): void
    {
        self::assertSame([], $this->validate([]));
    }

    public function testAKeyWithNoDotIsReported(): void
    {
        $failures = $this->validate(['LineItem' => 'numeric-string']);

        self::assertCount(1, $failures);
        self::assertStringContainsString('missing dot', $failures[0]);
    }

    public function testAComponentAbsentFromTheDocumentIsReported(): void
    {
        $failures = $this->validate(['Ghost.amount' => 'numeric-string']);

        self::assertCount(1, $failures);
        self::assertStringContainsString('component absent from the document', $failures[0]);
    }

    public function testAPropertyAbsentFromTheComponentIsReported(): void
    {
        $failures = $this->validate(['LineItem.ghost' => 'numeric-string']);

        self::assertCount(1, $failures);
        self::assertStringContainsString("property absent from component 'LineItem'", $failures[0]);
    }

    public function testEveryProblemIsReportedInOnePass(): void
    {
        $failures = $this->validate([
            'LineItem' => 'numeric-string',
            'Ghost.amount' => 'numeric-string',
            'LineItem.ghost' => 'numeric-string',
        ]);

        self::assertCount(3, $failures);
    }

    /**
     * @param  array<string,string> $phpDocTypes
     * @return list<string>
     */
    private function validate(array $phpDocTypes): array
    {
        $openApi = Reader::readFromYamlFile(self::SCHEMA, OpenApi::class, false);
        self::assertInstanceOf(OpenApi::class, $openApi);

        $registry = new NameRegistry(new PascalCaseSanitiser());
        $enums = new EnumCatalog('Acme\\Generated\\Enum');
        $components = ComponentCatalog::build($openApi, $registry, $enums);

        return new PhpDocTypeValidator()->validate($openApi, $components, $phpDocTypes);
    }
}
