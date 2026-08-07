<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

use function array_values;

/**
 * refined-phpdoc-types end to end: the constraint-derived narrowings and the
 * `$phpDocTypes` override reach the emitted model as `@param` lines on the
 * promoted constructor parameters — which is how PHPStan narrows a
 * constructor-promoted readonly property.
 *
 * Asserts the printed source rather than a runtime round trip on purpose: the
 * refinement is a static-analysis fact (`non-empty-string` is `string` at
 * runtime), so the emitted PHPDoc is exactly what there is to check.
 */
final class RefinedPhpDocTypeTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/refined-types-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\RefinedPhpDoc';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testConstraintsAndTheOverrideEmitRefinedParamLines(): void
    {
        $source = $this->emitLineItem(['LineItem.amount' => 'numeric-string']);

        // minLength >= 1 → non-empty-string.
        self::assertStringContainsString('@param non-empty-string $sku', $source);
        // inclusive minimum 1 → positive-int.
        self::assertStringContainsString('@param positive-int $quantity', $source);
        // 3.0 exclusive-of-zero → positive-int; discount is optional, so the
        // nullable doc form applies.
        self::assertStringContainsString('@param ?positive-int $discount', $source);
        // override wins where OpenAPI has no keyword.
        self::assertStringContainsString('@param numeric-string $amount', $source);
    }

    public function testBoundsThatNarrowNothingEmitNoParamLine(): void
    {
        $source = $this->emitLineItem([]);

        // An unconstrained string and an inclusive minimum of 0 both stay
        // bare native types — no @param line invented for them.
        self::assertStringNotContainsString('$note', $this->paramLines($source));
        self::assertStringNotContainsString('$balance', $this->paramLines($source));
        // …and with no override, amount is a bare string too.
        self::assertStringNotContainsString('$amount', $this->paramLines($source));
    }

    public function testAnOptionalNarrowedPropertyKeepsTheNullableDocForm(): void
    {
        // `note` is optional; give it a minLength so it narrows, and assert the
        // nullable doc form is `?non-empty-string`, not a broken `?string`.
        $source = $this->emitLineItem([], self::SCHEMA_WITH_OPTIONAL_NOTE);

        self::assertStringContainsString('@param ?non-empty-string $note', $source);
    }

    public function testAKeyNamingAComponentAbsentFromTheDocumentFailsTheRun(): void
    {
        try {
            $this->plan(['NoSuchModel.amount' => 'numeric-string']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$phpDocTypes['NoSuchModel.amount']", $e->getMessage());
            self::assertStringContainsString('component absent from the document', $e->getMessage());
        }
    }

    public function testAKeyNamingAPropertyAbsentFromThatComponentFailsTheRun(): void
    {
        try {
            $this->plan(['LineItem.no_such_property' => 'numeric-string']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$phpDocTypes['LineItem.no_such_property']", $e->getMessage());
            self::assertStringContainsString("property absent from component 'LineItem'", $e->getMessage());
        }
    }

    public function testAKeyWithNoDotFailsTheRun(): void
    {
        try {
            $this->plan(['LineItem' => 'numeric-string']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$phpDocTypes['LineItem']", $e->getMessage());
            self::assertStringContainsString('missing dot', $e->getMessage());
        }
    }

    public function testRegenerationIsDeterministic(): void
    {
        $phpDocTypes = ['LineItem.amount' => 'numeric-string'];

        self::assertSame(
            array_values($this->plan($phpDocTypes)->writes),
            array_values($this->plan($phpDocTypes)->writes),
        );
    }

    private const string SCHEMA_WITH_OPTIONAL_NOTE = __DIR__ . '/../fixtures/schemas/refined-types-optional-3.0.yaml';

    /**
     * @param array<string,string> $phpDocTypes
     */
    private function emitLineItem(array $phpDocTypes, ?string $schema = null): string
    {
        $output = self::makeSandboxDir('poagen-refined-phpdoc-');
        self::generator()->generate(new Profile(
            schema: $schema ?? self::SCHEMA,
            output: $output,
            namespace: self::NAMESPACE,
            phpDocTypes: $phpDocTypes,
        ));

        $path = $output . '/Generated/Model/LineItem.php';
        self::assertFileExists($path);

        return (string) file_get_contents($path);
    }

    /**
     * Only the `@param` lines, so a `$note` appearing in the native signature
     * is not mistaken for a doc-type narrowing.
     */
    private function paramLines(string $source): string
    {
        $lines = '';

        foreach (explode("\n", $source) as $line) {
            if (str_contains($line, '@param')) {
                $lines .= $line . "\n";
            }
        }

        return $lines;
    }

    /**
     * @param array<string,string> $phpDocTypes
     */
    private function plan(array $phpDocTypes): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('poagen-refined-phpdoc-'),
            namespace: self::NAMESPACE,
            phpDocTypes: $phpDocTypes,
        ));
    }
}
