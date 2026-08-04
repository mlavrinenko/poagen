<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\ResponseUnionSelectionTest;
use PHPUnit\Framework\TestCase;

use const DIRECTORY_SEPARATOR;

/**
 * `a-union-response-selects-its-branch`: the generation-time half. Runtime
 * hydration is proven against the emitted classes directly by
 * {@see ResponseUnionSelectionTest};
 * this covers what the generator itself decides — the return type it
 * writes, and the refusal when nothing resolves the union.
 */
final class ResponseUnionTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/union-response-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\ResponseUnion';

    private const array WORKING_PIN = [
        'getUndecidableCreature.response' => ['branch' => 'Celsius', 'reason' => 'this client reads metric sensors'],
    ];

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    /**
     * The structural case: a native `Dog|Cat` return type, decided from the
     * branches alone with no guidance at all.
     */
    public function testAStructuralUnionEmitsTheNativePhpUnionReturnType(): void
    {
        $client = $this->clientSource();

        self::assertStringContainsString('@return Envelope<Dog|Cat>', $client);
        self::assertStringContainsString('public function getCreature(): Envelope', $client);
    }

    /**
     * A response whose `oneOf`/`anyOf` branches are themselves arrays reads
     * as `list<Dog|Cat>`, not `list<Dog>|list<Cat>` — the latter cannot be
     * written as a native PHP type at all, since both erase to plain `array`.
     */
    public function testAnArrayOfTwoItemShapesEmitsAListOfTheUnion(): void
    {
        $client = $this->clientSource();

        self::assertStringContainsString('public function listCreatures(): Envelope', $client);
        self::assertStringContainsString('@return Envelope<list<Dog|Cat>>', $client);
    }

    /**
     * The closed-shape branch gets its own synthesised class, exactly the
     * way an inline request-body branch already does.
     */
    public function testAnInlineClosedBranchIsSynthesisedIntoItsOwnClass(): void
    {
        $client = $this->clientSource();

        self::assertStringContainsString('@return Envelope<Dog|GetRestrictionsResponseBranch2>', $client);
        self::assertStringContainsString('public function getRestrictions(): Envelope', $client);
    }

    /**
     * The document's own `discriminator` resolves without any profile
     * guidance — the response is still a plain native union, and the
     * `Discriminator` carrying the mapping lives in the call expression,
     * not in the return type.
     */
    public function testADocumentDiscriminatorNeedsNoProfileGuidance(): void
    {
        $client = $this->clientSource();
        $method = self::methodSlice($client, 'getTaggedCreature');

        self::assertStringContainsString('public function getTaggedCreature(): Envelope', $method);
        self::assertStringContainsString("new Discriminator(field: 'kind'", $method);
        self::assertStringContainsString("'canine' => Dog::class", $method);
        self::assertStringContainsString("'feline' => Cat::class", $method);
    }

    /**
     * A pin types the response as its single branch directly — no union
     * return type survives it, mirroring a pinned property.
     */
    public function testAPinnedResponseReturnsItsSingleBranchDirectly(): void
    {
        $client = $this->clientSource();

        self::assertStringContainsString('@return Envelope<Celsius>', $client);
        self::assertStringContainsString('public function getUndecidableCreature(): Envelope', $client);
    }

    /**
     * Bullet 3: a response union no rule resolves refuses at generation
     * time, naming the operation, the status and the branches — the same
     * sentence shape the property position already uses.
     */
    public function testAnUndecidableResponseUnionRefusesNamingOperationStatusAndBranches(): void
    {
        try {
            $this->plan([]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString('getUndecidableCreature', $e->getMessage());
            self::assertStringContainsString('200 response', $e->getMessage());
            self::assertStringContainsString('Celsius', $e->getMessage());
            self::assertStringContainsString('Fahrenheit', $e->getMessage());
            self::assertStringContainsString('paogen will not guess', $e->getMessage());
        }
    }

    /**
     * @param array<string,array{branch:string,reason:string}> $pins
     */
    private function plan(array $pins): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-response-union-'),
            namespace: self::NAMESPACE,
            unionPins: $pins,
        ));
    }

    private function clientSource(): string
    {
        $plan = $this->plan(self::WORKING_PIN);

        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, DIRECTORY_SEPARATOR . 'ApiClient.php')) {
                return $source;
            }
        }

        self::fail('the plan wrote no ApiClient.php');
    }
}
