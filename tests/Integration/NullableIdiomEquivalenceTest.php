<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use function basename;

/**
 * swap-openapi-parser-for-31-support: the two spellings of "this may be null"
 * are one statement, and they reach the consumer as one PHP type.
 *
 * OpenAPI 3.0 says it with the `nullable: true` flag; 3.1 says it with
 * `type: [T, "null"]`, the JSON Schema 2020-12 form, and has no `nullable`
 * flag at all. A parser that models 3.0 hands the second spelling through
 * without refusing it, which is why the swap to a 3.1-native parser was worth
 * making and why the risk it carries is silent misreading rather than
 * rejection. Byte-identical output from a fixture pair that differs in nothing
 * else is the only assertion that cannot be satisfied by both sides agreeing
 * on `mixed`, so this file makes the types explicit as well.
 */
final class NullableIdiomEquivalenceTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA_30 = __DIR__ . '/../fixtures/schemas/nullable-idiom-3.0.yaml';
    private const string SCHEMA_31 = __DIR__ . '/../fixtures/schemas/nullable-idiom-3.1.yaml';

    // One namespace for both runs: the emitted namespace is part of the bytes
    // being compared, so varying it would make the comparison vacuous.
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\NullableIdiom';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testTheTwoIdiomsEmitTheSameBytes(): void
    {
        $thirty = $this->sourcesOf(self::SCHEMA_30);
        $thirtyOne = $this->sourcesOf(self::SCHEMA_31);

        self::assertSame(array_keys($thirty), array_keys($thirtyOne), 'the two idioms emitted different files');
        self::assertSame($thirty, $thirtyOne);
    }

    /**
     * Agreeing on the wrong type is still agreement, so the types are named
     * here rather than left to the comparison above. Each property sits at a
     * site that used to resolve nullability on its own: a required property,
     * an optional scalar, an array, a synthesised inline object, a synthesised
     * enum.
     */
    public function testTheAgreedTypeIsTheOneTheDocumentDeclared(): void
    {
        $model = $this->sourcesOf(self::SCHEMA_31)['Member.php'];

        self::assertStringContainsString('public ?string $nickname,', $model);
        self::assertStringContainsString('public ?float $score = null,', $model);
        self::assertStringContainsString('@param ?list<string> $tags', $model);
        self::assertStringContainsString('public ?MemberAddress $address,', $model);
        self::assertStringContainsString('public ?MemberTier $tier = null,', $model);
        self::assertStringNotContainsString('mixed', $model);
    }

    public function testANullableQueryParameterIsNullableUnderBothIdioms(): void
    {
        foreach ([self::SCHEMA_30, self::SCHEMA_31] as $schema) {
            self::assertStringContainsString(
                'public function getMember(string $memberId, ?string $since = null): Envelope',
                $this->sourcesOf($schema)['ApiClient.php'],
            );
        }
    }

    /**
     * Pins the pair to the one difference it is allowed to have. Rewriting
     * every `type: T` + `nullable: true` into the two-member list, and the
     * version string with it, has to turn one file into the other exactly —
     * if a later edit adds anything else to either side, the equivalence above
     * stops being about the idiom and this fails first.
     */
    public function testTheFixturePairDiffersOnlyInTheIdiom(): void
    {
        $thirty = (string) file_get_contents(self::SCHEMA_30);
        $rewritten = preg_replace(
            '/^(\s*)type: (\w+)\n\1nullable: true$/m',
            "\$1type:\n\$1  - \$2\n\$1  - \"null\"",
            str_replace('openapi: 3.0.3', 'openapi: 3.1.0', $thirty),
        );

        self::assertStringContainsString('nullable: true', $thirty, 'the 3.0 fixture stopped using the 3.0 idiom');
        self::assertSame((string) file_get_contents(self::SCHEMA_31), $rewritten);
    }

    /**
     * @return array<string,string> emitted file basename → source
     */
    private function sourcesOf(string $schema): array
    {
        $plan = self::generator()->plan(new Profile(
            schema: $schema,
            output: self::makeSandboxDir('paogen-nullable-idiom-'),
            namespace: self::NAMESPACE,
        ));

        return $this->byBasename($plan);
    }

    /**
     * @return array<string,string>
     */
    private function byBasename(GenerationPlan $plan): array
    {
        $out = [];

        foreach ($plan->writes as $path => $source) {
            $out[basename($path)] = $source;
        }

        ksort($out);

        return $out;
    }
}
