<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Support\PetstoreFixture;
use PHPUnit\Framework\TestCase;

/**
 * import-generated-type-references (T-260730): an emitted PHPDoc type used
 * to carry the fully qualified class name even when the class was already
 * imported or shared the file's own namespace, and an emitted body called a
 * global function or constant `\`-prefixed instead of importing it —
 * `PhpNamespace::simplifyType()` and `addUseFunction()`/`addUseConstant()`
 * both existed and neither was reached.
 *
 * These pin the shortened forms directly so a regression back to the FQCN
 * or the `\`-prefixed spelling fails the suite rather than merely looking
 * untidy in a diff.
 */
final class GeneratedSymbolShorteningTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/petstore-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\SymbolShortening';

    private static GenerationPlan $plan;

    public static function setUpBeforeClass(): void
    {
        $output = self::makeSandboxDir('paogen-symbol-shortening-');

        self::$plan = self::generator()->generate(new Profile(
            schema: self::SCHEMA,
            output: $output,
            namespace: self::NAMESPACE,
            // No skip list: petstore's `uploadFile` stopped being
            // unrepresentable in represent-non-json-request-and-response-bodies,
            // and nothing else in this document ever was.
            securitySchemes: PetstoreFixture::SECURITY_SCHEMES,
        ));
    }

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testASameNamespaceModelDocTypeIsShortenedToTheBareClassName(): void
    {
        // `Pet::$tags` is `list<$ref Tag>` and `Tag` lives in the same
        // `Generated\Model` namespace as `Pet` — the emitter used to
        // concatenate the FQCN into the comment by hand even though nette
        // already resolves the bare name for anything else in that file.
        $pet = $this->sourceEndingWith('Generated/Model/Pet.php');

        self::assertStringContainsString('@param ?list<Tag> $tags', $pet);
        self::assertStringNotContainsString('Model\\Tag', $pet);
    }

    public function testAnImportedGlobalFunctionIsWrittenUnqualifiedInAnEmittedBody(): void
    {
        // The emitter used to spell a global function `\array_map(...)`
        // inline; it imports the symbol once with `use function array_map;`
        // and calls it unqualified, mirroring what
        // `import-global-functions-in-source` already does for paogen's own
        // sources. `ApiException` no longer calls one at all — a declared
        // body is hydrated by the runtime now, never decoded by hand
        // (typed-error-responses) — so the emitted file this pins is a
        // query parameter that is a list of scalar-binding value objects:
        // each item needs its own `toScalar()`, called through `array_map`.
        $plan = self::generator()->generate(new Profile(
            schema: __DIR__ . '/../fixtures/schemas/parameter-shape-references-3.0.yaml',
            output: self::makeSandboxDir('paogen-symbol-shortening-array-map-'),
            namespace: self::NAMESPACE . 'ArrayMap',
        ));
        $client = '';

        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, 'Generated/ApiClient.php')) {
                $client = $source;
            }
        }

        self::assertStringContainsString('use function array_map;', $client);
        self::assertStringContainsString(
            'array_map(static fn(TagId $__v): string => $__v->toScalar(), $tags)',
            $client,
        );
        self::assertStringNotContainsString('\\array_map(', $client);
    }

    public function testAnEmittedClientCarriesNoImportItDoesNotUse(): void
    {
        // The collapse onto a transport took every request-assembly symbol
        // out of the emitted body. An import left behind for one of them
        // would be an unused-import finding in the consumer's own project,
        // which is the tier `analysis-runs-at-maximum-strictness` admits
        // nothing on.
        $client = $this->sourceEndingWith('Generated/PetClient.php');

        self::assertStringNotContainsString('use function', $client);
        self::assertStringNotContainsString('use const', $client);
        self::assertStringContainsString('use Mlavrinenko\\Paogen\\Runtime\\Contract\\Endpoint;', $client);
    }

    private function sourceEndingWith(string $suffix): string
    {
        foreach (self::$plan->writes as $path => $source) {
            if (str_ends_with($path, $suffix)) {
                return $source;
            }
        }

        self::fail("no write ending in {$suffix}");
    }
}
