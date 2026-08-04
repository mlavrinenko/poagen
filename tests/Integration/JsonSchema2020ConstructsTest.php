<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use function basename;

/**
 * swap-openapi-parser-for-31-support: a JSON Schema 2020-12 keyword no emitter
 * implements stops the run by name.
 *
 * The parser swap widened the input surface — keywords the 3.0 pipeline never
 * had to reason about now arrive parsed and intact — and the decision that
 * accepted that width
 * (`truth/decisions/openapi-31-through-a-maintained-parser.decision-260729.typ`)
 * accepted it on one condition: what must not survive is the third outcome,
 * read and misinterpreted and emitted as something else. So each keyword here
 * is named in the failure, with the pointer to the node that used it and the
 * operation or component that carries the node, and nothing is written.
 *
 * The parser this replaced kept these keywords too — an unrecognised key lands
 * in the same property bag a recognised one does — so nothing hid them.
 * Nothing asked. Measured against these fixtures before the swap; the
 * fixture headers carry the reading.
 */
final class JsonSchema2020ConstructsTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/json-schema-2020-12-3.1.yaml';
    private const string WEBHOOKS = __DIR__ . '/../fixtures/schemas/webhooks-3.1.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\JsonSchema2020';

    /** Every unsupported construct in the fixture, accepted by name. */
    private const array SKIP_ALL = [
        'createBadge' => 'const: proving the rest of the document still generates',
        'createTuple' => 'prefixItems: proving the rest of the document still generates',
        'createProfile' => 'unevaluatedProperties: proving the rest of the document still generates',
        'createAvatar' => 'contentMediaType: proving the rest of the document still generates',
        'Pennant' => 'const: proving the rest of the document still generates',
    ];

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    /**
     * Keyword, the pointer to the node that used it, and the operation or
     * component that carries the node. All three are what a consumer needs to
     * find it in a document they did not write.
     *
     * @var list<array{keyword:string,pointer:string,owner:string}>
     */
    private const array REFUSALS = [
        [
            'keyword' => 'const',
            'pointer' => '/paths/~1badges/post/requestBody/content/application~1json/schema/properties/kind',
            'owner' => 'createBadge',
        ],
        [
            'keyword' => 'prefixItems',
            'pointer' => '/paths/~1tuples/post/requestBody/content/application~1json/schema/properties/point',
            'owner' => 'createTuple',
        ],
        [
            'keyword' => 'unevaluatedProperties',
            'pointer' => '/paths/~1profiles/post/requestBody/content/application~1json/schema',
            'owner' => 'createProfile',
        ],
        [
            'keyword' => 'contentMediaType',
            'pointer' => '/paths/~1avatars/post/requestBody/content/application~1json/schema/properties/image',
            'owner' => 'createAvatar',
        ],
        [
            'keyword' => 'const',
            'pointer' => '/components/schemas/Pennant/properties/kind',
            'owner' => 'component `Pennant`',
        ],
    ];

    public function testEachKeywordIsNamedWithItsPointerAndItsOwner(): void
    {
        $message = $this->refusalMessage(self::SCHEMA);

        foreach (self::REFUSALS as $refusal) {
            $where = "{$refusal['keyword']} at {$refusal['pointer']}";

            self::assertStringContainsString("keyword `{$refusal['keyword']}`", $message, $where);
            self::assertStringContainsString($refusal['pointer'], $message, $where);
            self::assertStringContainsString($refusal['owner'], $message, $where);
        }
    }

    public function testEveryProblemArrivesInOnePassRatherThanOneAtATime(): void
    {
        self::assertStringContainsString('5 problems found', $this->refusalMessage(self::SCHEMA));
    }

    /**
     * The refusal is the whole run, not the offending operation: a client that
     * quietly omits what it could not read is the failure this replaces.
     */
    public function testNothingIsWrittenWhenAKeywordIsRefused(): void
    {
        $output = self::makeSandboxDir('paogen-2020-12-abort-');

        try {
            self::generator()->generate(new Profile(
                schema: self::SCHEMA,
                output: $output,
                namespace: self::NAMESPACE,
            ));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException) {
            self::assertDirectoryDoesNotExist($output . '/Generated');
        }
    }

    /**
     * The 3.1 constructs paogen *does* read are unaffected by the refusals
     * sitting beside them: one document carries both, and accepting the
     * refusals by name leaves the readable operation generating its declared
     * types (`type: [T, "null"]` nullable, a scalar union as a PHP union).
     */
    public function testTheReadableOperationStillGeneratesOnceTheRestIsAccepted(): void
    {
        $written = $this->planWith(self::SKIP_ALL);

        self::assertStringContainsString('public function createCoupon(', $written['ApiClient.php']);
        self::assertStringNotContainsString('public function createBadge(', $written['ApiClient.php']);

        $model = $written['CreateCouponRequestContent.php'];
        self::assertStringContainsString('public ?string $code,', $model);
        self::assertStringContainsString('public ?int $redeemedCount,', $model);
        self::assertStringContainsString('public string|int|null $identifier = null,', $model);
    }

    public function testAWebhookIsRefusedByNameWithTheEntryAndOperationItCarries(): void
    {
        $message = $this->refusalMessage(self::WEBHOOKS);

        self::assertStringContainsString('`webhooks`', $message);
        self::assertStringContainsString('#/webhooks/memberCreated', $message);
        self::assertStringContainsString('operationId `onMemberCreated`', $message);
        // The document's own paths are readable; the client is refused anyway
        // rather than emitted without the half it cannot describe.
        self::assertStringNotContainsString('sendPing', $message);
    }

    private function refusalMessage(string $schema): string
    {
        try {
            $this->planWith([], $schema);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param  array<string,string>  $skip
     * @return array<string,string>  emitted file basename → source
     */
    private function planWith(array $skip, string $schema = self::SCHEMA): array
    {
        $plan = self::generator()->plan(new Profile(
            schema: $schema,
            output: self::makeSandboxDir('paogen-2020-12-'),
            namespace: self::NAMESPACE,
            skip: $skip,
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

        return $out;
    }
}
