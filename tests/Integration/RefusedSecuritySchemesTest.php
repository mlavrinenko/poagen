<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Support\PetstoreFixture;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * report-unsupported-security-schemes, the two buckets that stop the run.
 *
 * `http digest` and `http negotiate` need a challenge and a second request
 * before any credential exists, and paogen will not run a protocol. A
 * scheme type the specification does not define lands in the same bucket:
 * unknown means refused, never ignored. And a requirement naming a scheme
 * the document never declared is refused with instructions, because the
 * consumer is the only one who knows what the vendor meant.
 *
 * Every one of these used to be silence. The client compiled, took no
 * credential, sent every request bare, and the run exited 0.
 */
final class RefusedSecuritySchemesTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string REFUSED = __DIR__ . '/../fixtures/schemas/refused-security-3.0.yaml';
    private const string PETSTORE = __DIR__ . '/../fixtures/schemas/petstore-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\RefusedSecurity';

    /** @var array<string,string> */
    private const array PETSTORE_SKIP = [
        'uploadFile' => 'application/octet-stream request body — not what these scenarios are about',
    ];

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testADigestSchemeAbortsNamingItsTypeAndEveryOperationThatRequiresIt(): void
    {
        $message = $this->refusal($this->profile(self::REFUSED));

        self::assertStringContainsString("security scheme 'digestAuth' (http digest) cannot be wired", $message);
        self::assertStringContainsString(
            'the credential only exists after the server\'s challenge and a second request',
            $message,
        );
        // Every operation, not the first one found.
        self::assertStringContainsString('Required by GET /digest-one (digestOne), GET /digest-two (digestTwo).', $message);
        // And the opt-out, said plainly.
        self::assertStringContainsString(
            'Skipping those operations is the only opt-out — add their operation ids to Profile::$skip.',
            $message,
        );
    }

    public function testAGloballyAppliedRefusedSchemeIsNamedAsGlobalRatherThanListingTheWholeDocument(): void
    {
        $message = $this->refusal($this->profile(self::REFUSED));

        self::assertStringContainsString("security scheme 'negotiateAuth' (http negotiate) cannot be wired", $message);
        self::assertStringContainsString(
            "Applied globally by the document's top-level `security`, so every operation that does not override it "
                . 'requires it.',
            $message,
        );
        // The document has an operation that inherits the global requirement;
        // naming it individually would name every operation in the document.
        self::assertStringNotContainsString('inheritsGlobal', $message);
    }

    public function testASchemeTypeTheSpecificationDoesNotDefineIsRefusedRatherThanIgnored(): void
    {
        $message = $this->refusal($this->profile(self::REFUSED));

        self::assertStringContainsString("security scheme 'inventedAuth' (saml) cannot be wired", $message);
        self::assertStringContainsString('unknown means refused, never ignored', $message);
        self::assertStringContainsString('Required by GET /invented (inventedScheme).', $message);
    }

    public function testAllThreeRefusalsAreReportedInOnePassRatherThanOneRunAtATime(): void
    {
        self::assertStringContainsString('3 problems found; nothing was written', $this->refusal($this->profile(self::REFUSED)));
    }

    public function testARequirementNamingAnUndeclaredSchemeAbortsAndNamesTheProfileKeyThatFixesIt(): void
    {
        // The vendored petstore document does exactly this: it requires
        // `api_key` on two operations and declares only `petstore_auth`.
        $message = $this->refusal($this->profile(self::PETSTORE, self::PETSTORE_SKIP));

        self::assertStringContainsString(
            "security requirement 'api_key' names a scheme components.securitySchemes does not declare",
            $message,
        );
        self::assertStringContainsString(
            'Required by GET /pet/{petId} (getPetById), GET /store/inventory (getInventory).',
            $message,
        );
        self::assertStringContainsString("Declare it under Profile::\$securitySchemes keyed 'api_key'", $message);
        self::assertStringContainsString("['type' => 'apiKey', 'in' => 'header', 'name' => 'api_key']", $message);
    }

    public function testTheProfileDeclarationWiresTheRequirementRatherThanSkippingItsOperations(): void
    {
        $plan = $this->plan($this->profile(self::PETSTORE, self::PETSTORE_SKIP, PetstoreFixture::SECURITY_SCHEMES));
        $store = self::plannedSource($plan->writes, 'StoreClient');

        // Both operations that required it are emitted, and each sends it.
        self::assertStringContainsString(
            "Endpoint::get('/store/inventory')->header('api_key', \$this->apiKey)",
            $store,
        );
        self::assertStringContainsString("->header('api_key', \$this->apiKey)", self::plannedSource($plan->writes, 'PetClient'));
        self::assertSame(
            ['uploadFile'],
            array_map(static fn(object $skip): string => (string) $skip->operationId, $plan->skippedOperations),
        );
    }

    /**
     * Both halves of the same rule: guidance that matches nothing looks like
     * working guidance while doing nothing, so it fails the run rather than
     * being ignored — the same discipline `Profile::$skip` and
     * `Profile::$inlineModels` are already held to.
     *
     * @return array<string, array{0:array<string,array<string,mixed>>, 1:string}>
     */
    public static function staleGuidance(): array
    {
        $ghost = ['type' => 'apiKey', 'in' => 'header', 'name' => 'x'];

        return [
            'a scheme the document already declares' => [
                ['petstore_auth' => $ghost, ...PetstoreFixture::SECURITY_SCHEMES],
                "Profile::\$securitySchemes['petstore_auth'] names a scheme the document already declares",
            ],
            'a scheme no requirement asks for' => [
                [...PetstoreFixture::SECURITY_SCHEMES, 'ghost_key' => $ghost],
                "Profile::\$securitySchemes['ghost_key'] names a scheme no security requirement asks for",
            ],
        ];
    }

    /**
     * @param array<string,array<string,mixed>> $securitySchemes
     */
    #[DataProvider('staleGuidance')]
    public function testGuidanceThatMatchesNothingFailsTheRun(array $securitySchemes, string $expected): void
    {
        self::assertStringContainsString($expected, $this->refusal($this->profile(self::PETSTORE, self::PETSTORE_SKIP, $securitySchemes)));
    }

    /**
     * The two entry points below differ only in whether they expect the run
     * to abort, so what they are run against is built once here rather than
     * restated — including the phpdoc, which is the whole of what the two
     * signatures otherwise had in common.
     *
     * @param array<string,string>              $skip
     * @param array<string,array<string,mixed>> $securitySchemes
     */
    private function profile(string $schema, array $skip = [], array $securitySchemes = []): Profile
    {
        return new Profile(
            schema: $schema,
            output: self::makeSandboxDir('paogen-refused-'),
            namespace: self::NAMESPACE,
            skip: $skip,
            securitySchemes: $securitySchemes,
        );
    }

    private function refusal(Profile $profile): string
    {
        try {
            self::generator()->plan($profile);
        } catch (UnrepresentableConstructsException $e) {
            return $e->getMessage();
        }

        self::fail('expected the run to abort naming the security scheme');
    }

    private function plan(Profile $profile): GenerationPlan
    {
        return self::generator()->plan($profile);
    }
}
