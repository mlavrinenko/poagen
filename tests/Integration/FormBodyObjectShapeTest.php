<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\Emit\ObjectShape;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

use function str_ends_with;

use const DIRECTORY_SEPARATOR;

/**
 * form-urlencoded-body-requires-the-literal-type-object-keyword:
 * `RequestBodyAnalyzer::formBody()` decides an `application/x-www-form-urlencoded`
 * body's objectness through {@see ObjectShape}
 * rather than reading the `type: object` keyword alone — the fourth site of the
 * root cause `close-the-three-sites-that-widen-a-declared-shape` fixed
 * elsewhere. A form body whose schema declares properties without the keyword
 * now resolves exactly like its keyword-bearing twin; a schema that
 * genuinely declares no object shape still refuses.
 */
final class FormBodyObjectShapeTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/form-object-shape-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\FormObjectShape';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    /**
     * `formWithType` and `formWithoutType` declare the identical property
     * set — the only difference is the `type: object` keyword. Both must
     * flatten to the same parameter list and the same wire field names.
     */
    public function testAFormBodyWithoutTheTypeKeywordEmitsTheSameFieldsAsWithIt(): void
    {
        $client = $this->clientSource($this->plan(['formNotObject' => 'fixture-only refusal']));

        $withType = self::methodSlice($client, 'formWithType');
        $withoutType = self::methodSlice($client, 'formWithoutType');

        self::assertStringContainsString(
            'public function formWithType(string $name, ?string $tag = null): Envelope',
            $withType,
        );
        self::assertStringContainsString(
            'public function formWithoutType(string $name, ?string $tag = null): Envelope',
            $withoutType,
        );
        self::assertStringContainsString("->form(['name' => \$name, 'tag' => \$tag])", $withType);
        self::assertStringContainsString("->form(['name' => \$name, 'tag' => \$tag])", $withoutType);
    }

    /**
     * `formNotObject`'s schema is `{}` — no type keyword, no properties, no
     * additionalProperties value schema. ObjectShape answers no here exactly
     * as SchemaType alone would, so this stays a refusal rather than the fix
     * widening every non-object form schema into an accepted one.
     */
    public function testASchemaThatDeclaresNoObjectShapeStillRefuses(): void
    {
        $message = $this->refusalMessage([
            'formWithType' => 'fixture-only refusal',
            'formWithoutType' => 'fixture-only refusal',
        ]);

        self::assertStringContainsString('formNotObject', $message);
        self::assertStringContainsString('application/x-www-form-urlencoded', $message);
        self::assertStringContainsString('not an inline `type: object`', $message);
    }

    /**
     * Only the genuinely non-object schema needs a skip entry — both the
     * keyword-bearing and the keyword-less object schemas resolve on their
     * own, unlisted.
     */
    public function testOnlyTheGenuinelyNonObjectFormIsSkipped(): void
    {
        $plan = $this->plan(['formNotObject' => 'fixture-only refusal']);

        self::assertCount(1, $plan->skippedOperations);
        self::assertSame('formNotObject', $plan->skippedOperations[0]->operationId);
    }

    /**
     * @param array<string,string> $skip
     */
    private function plan(array $skip): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('poagen-form-object-shape-'),
            namespace: self::NAMESPACE,
            skip: $skip,
        ));
    }

    /**
     * @param array<string,string> $skip every refusal except the one under
     *                                    test — left unlisted so it surfaces
     *                                    in the exception
     */
    private function refusalMessage(array $skip): string
    {
        try {
            $this->plan($skip);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            return $e->getMessage();
        }
    }

    private function clientSource(GenerationPlan $plan): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, DIRECTORY_SEPARATOR . 'ApiClient.php')) {
                return $source;
            }
        }

        self::fail('the plan wrote no ApiClient.php');
    }
}
