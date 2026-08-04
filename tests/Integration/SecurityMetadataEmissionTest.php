<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use function basename;

/**
 * report-unsupported-security-schemes, the half that is not a credential:
 * the flow metadata an `oauth2` or `openIdConnect` declaration carries, and
 * the one scheme paogen can only report.
 *
 * A consumer wiring `league/oauth2-client` needs a token endpoint and a
 * scope list. Both are in the document they already handed paogen, so they
 * come back out on the client rather than sending the consumer to the
 * vendor's YAML beside the typed client they were given instead of it.
 */
final class SecurityMetadataEmissionTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/security-kinds-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\SecurityMetadata';

    /**
     * The exact line the run prints on stderr for a `mutualTLS` scheme.
     * The criterion is that the *same* line reaches the client docblock, so
     * it is written once here and asserted against both.
     */
    private const string MUTUAL_TLS_NOTICE = "security scheme 'mtls' is mutualTLS — there is no request-level "
        . 'credential to emit, so the generated client takes none. Configure the client certificate and key on the '
        . 'PSR-18 client you hand to the transport.';

    private static GenerationPlan $plan;

    private static string $rootSource = '';

    public static function setUpBeforeClass(): void
    {
        self::$plan = self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-securitymeta-'),
            namespace: self::NAMESPACE,
        ));

        foreach (self::$plan->writes as $path => $source) {
            if (basename($path) === 'ApiClient.php') {
                self::$rootSource = $source;
            }
        }
    }

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testTheFlowMetadataIsAConstantARunnerCanReadWithoutTheSchemaInHand(): void
    {
        // Every field the document declares survives: the flow's own name,
        // all three URLs, and the scope vocabulary with the vendor's
        // descriptions. A field the document omits is null rather than
        // absent, so the shape does not vary per document.
        self::assertStringContainsString('public const array OAUTH_AUTH_FLOWS = [', self::$rootSource);
        self::assertStringContainsString("'authorizationCode' => [", self::$rootSource);
        self::assertStringContainsString("'clientCredentials' => [", self::$rootSource);
        self::assertStringContainsString(
            "'authorizationUrl' => 'https://security-kinds.example/oauth/authorize'",
            self::$rootSource,
        );
        self::assertStringContainsString("'tokenUrl' => 'https://security-kinds.example/oauth/token'", self::$rootSource);
        self::assertStringContainsString(
            "'refreshUrl' => 'https://security-kinds.example/oauth/refresh'",
            self::$rootSource,
        );
        self::assertStringContainsString("'read:things' => 'read the things'", self::$rootSource);
        self::assertStringContainsString("'write:things' => 'change the things'", self::$rootSource);
    }

    public function testAnOpenIdConnectSchemeCarriesItsDiscoveryDocumentUrl(): void
    {
        // openIdConnect declares no flows of its own — one URL pointing at a
        // discovery document is the whole metadata it carries.
        self::assertStringContainsString(
            'public const string OIDC_AUTH_OPENID_CONNECT_URL = '
                . "'https://security-kinds.example/.well-known/openid-configuration';",
            self::$rootSource,
        );
    }

    public function testTheClientDocblockNamesEachFlowItsUrlsAndItsScopes(): void
    {
        self::assertStringContainsString(
            '`oauthAuth` (oauth2) — one access token, sent as `Authorization: Bearer <token>`.',
            self::$rootSource,
        );
        self::assertStringContainsString('authorizationCode flow:', self::$rootSource);
        self::assertStringContainsString('scope `write:things` — change the things', self::$rootSource);
        // And the boundary this whole task sits on, said in the output
        // rather than only in a decision.
        self::assertStringContainsString(
            'paogen never acquires, refreshes, stores or validates a credential.',
            self::$rootSource,
        );
    }

    public function testAnOperationsOwnScopesAppearOnThatOperationsDocblock(): void
    {
        // Scope names only: the vendor's description of each is a fact about
        // the scheme, stated once on the client rather than under every
        // operation that wants the same two scopes.
        self::assertStringContainsString(
            'Requires `oauthAuth` scopes: `read:things`, `write:things`.',
            $this->docblockOf(self::$rootSource, 'oauthScheme'),
        );
        // An operation whose requirement names no scopes says nothing at all
        // about them — the docblock still carries the `@return` every
        // method now does, but no "Requires" line and no empty list.
        self::assertStringNotContainsString('Requires', $this->docblockOf(self::$rootSource, 'oidcScheme'));
    }

    /**
     * The docblock immediately above one emitted method, or `''` when it has
     * none. `GeneratedTreeSandbox::methodSlice()` starts at the signature, so
     * it cannot answer this.
     */
    private function docblockOf(string $source, string $method): string
    {
        $start = strpos($source, "    public function {$method}(");
        self::assertNotFalse($start, "method {$method} not found in emitted source");
        $before = rtrim(substr($source, 0, $start));

        if (!str_ends_with($before, '*/')) {
            return '';
        }

        return substr($before, (int) strrpos($before, '/**'));
    }

    public function testMutualTlsIsANoticeAndADocblockLineAndNeverAnAbort(): void
    {
        // The run completed — reaching this test at all means plan() did not
        // throw — and the notice channel `report-unrecognised-formats`
        // established is the one that carries it.
        self::assertContains(self::MUTUAL_TLS_NOTICE, self::$plan->notices);
        self::assertSame([], self::$plan->skippedOperations);
        // The same line, so a reader of the client learns it without having
        // kept the run's output.
        self::assertStringContainsString(self::MUTUAL_TLS_NOTICE, self::$rootSource);
    }

    public function testADeclarationNoRequirementNamesIsNeitherReportedNorRefused(): void
    {
        // `unusedTls` is a second mutualTLS scheme and `unusedDigest` is an
        // `http digest` one. Both are declared, neither is required, and an
        // unused declaration costs the consumer nothing — so one produces no
        // notice and the other does not abort the run.
        foreach (self::$plan->notices as $notice) {
            self::assertStringNotContainsString('unusedTls', $notice);
            self::assertStringNotContainsString('unusedDigest', $notice);
        }

        self::assertCount(1, self::$plan->notices);
    }

    /**
     * Asserted against the committed petstore tree rather than the fixture
     * above, because that one tags nothing and so has no sub-client to
     * compare a root against.
     */
    public function testOnlyTheRootCarriesTheDocumentWideMetadataWhileEveryClientCarriesItsOwnScopes(): void
    {
        $golden = dirname(__DIR__) . '/fixtures/generated/petstore/Generated/';
        $root = (string) file_get_contents($golden . 'ApiClient.php');
        $sub = (string) file_get_contents($golden . 'PetClient.php');

        // The metadata is a fact about the document rather than about a tag,
        // so it lives on the composition root — where a consumer wires their
        // transport, which is exactly when a token endpoint is what they
        // need. Restating it per tag would bury the operations a reader
        // opened that class for.
        self::assertStringContainsString('public const array PETSTORE_AUTH_FLOWS = [', $root);
        self::assertStringNotContainsString('PETSTORE_AUTH_FLOWS', $sub);

        // An operation's own scopes are about that operation, so they travel
        // with it onto whichever client carries it.
        self::assertStringContainsString('Requires `petstore_auth` scopes: `write:pets`, `read:pets`.', $sub);
    }
}
