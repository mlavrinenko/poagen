<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Runtime\Http\HttpTransport;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Support\StubErrorFactory;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * report-unsupported-security-schemes: every scheme kind that reduces to
 * one credential on one request is wired, and each one is proven here at
 * the wire — the header or query parameter a PSR-18 client actually
 * receives, not merely a constructor argument that exists.
 *
 * Before this, `apiKey in: cookie`, `http basic`, `http` with a vendor
 * scheme token, `oauth2` and `openIdConnect` all classified as unsupported
 * and were dropped in silence: the client compiled, took no credential,
 * sent every request bare, and the run exited 0.
 */
final class WiredSecuritySchemesTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/security-kinds-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\SecurityKinds';
    private const string BASE_URI = 'https://security-kinds.example/api/v1';

    public static function setUpBeforeClass(): void
    {
        self::generateRootClientOnce(self::SCHEMA, self::NAMESPACE, 'paogen-securitykinds-');
    }

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testEveryWiredSchemeClaimsAConstructorArgumentAndTheUnwireableOneClaimsNone(): void
    {
        // One argument per scheme, in ascending scheme-name order, except
        // `http basic` — whose credential is genuinely two values.
        foreach (['basicUser', 'basicPassword', 'cookieKey', 'oauthAuth', 'oidcAuth', 'tokenAuth'] as $arg) {
            self::assertSame(
                1,
                substr_count(self::$rootClientSource, 'private string $' . $arg . ','),
                $arg . ' must be promoted exactly once',
            );
        }

        // mutualTLS has no request-level credential, and a scheme nothing
        // requires is not wired at all.
        self::assertStringNotContainsString('$mtls', self::$rootClientSource);
        self::assertStringNotContainsString('$unusedDigest', self::$rootClientSource);
    }

    public function testACookieApiKeyTravelsAsANameValuePairInsideTheCookieHeader(): void
    {
        $body = self::methodSlice(self::$rootClientSource, 'cookieScheme');
        self::assertStringContainsString("->header('Cookie', 'session=' . \$this->cookieKey)", $body);

        $client = $this->buildClient();
        self::invokeGenerated(self::rootClientReflection(), $client['client'], 'cookieScheme');

        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('session=cookie-value', $client['http']->lastRequest->getHeaderLine('Cookie'));
    }

    public function testHttpBasicTakesTwoArgumentsAndSendsThemBase64EncodedAfterTheSchemeToken(): void
    {
        $body = self::methodSlice(self::$rootClientSource, 'basicScheme');
        self::assertStringContainsString(
            "->header('Authorization', 'Basic ' . base64_encode(\$this->basicUser . ':' . \$this->basicPassword))",
            $body,
        );

        $client = $this->buildClient();
        self::invokeGenerated(self::rootClientReflection(), $client['client'], 'basicScheme');

        self::assertNotNull($client['http']->lastRequest);
        // RFC 7617: the user and password join with a colon and the pair is
        // base64-encoded. A consumer never has to know that.
        self::assertSame(
            'Basic ' . base64_encode('alice:s3cret'),
            $client['http']->lastRequest->getHeaderLine('Authorization'),
        );
    }

    public function testAVendorHttpSchemeTokenIsSentVerbatimBeforeTheCredential(): void
    {
        // `scheme: Token` is not a token paogen knows, and RFC 7235 says a
        // credential follows the scheme token whatever the token is. The
        // document's own spelling survives — `Token`, not `token`.
        $body = self::methodSlice(self::$rootClientSource, 'tokenScheme');
        self::assertStringContainsString("->header('Authorization', 'Token ' . \$this->tokenAuth)", $body);

        $client = $this->buildClient();
        self::invokeGenerated(self::rootClientReflection(), $client['client'], 'tokenScheme');

        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('Token vendor-word-credential', $client['http']->lastRequest->getHeaderLine('Authorization'));
    }

    public function testAnOAuth2AccessTokenIsSentAsABearerCredential(): void
    {
        // RFC 6750 says that is what an OAuth2 access token looks like on
        // the wire, for every one of the four flows. paogen sends the token
        // it was given and never obtains one.
        $body = self::methodSlice(self::$rootClientSource, 'oauthScheme');
        self::assertStringContainsString("->header('Authorization', 'Bearer ' . \$this->oauthAuth)", $body);

        $client = $this->buildClient();
        self::invokeGenerated(self::rootClientReflection(), $client['client'], 'oauthScheme');

        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('Bearer oauth-access-token', $client['http']->lastRequest->getHeaderLine('Authorization'));
    }

    public function testAnOpenIdConnectTokenIsIdenticalToOAuth2AtTheWire(): void
    {
        $body = self::methodSlice(self::$rootClientSource, 'oidcScheme');
        self::assertStringContainsString("->header('Authorization', 'Bearer ' . \$this->oidcAuth)", $body);

        $client = $this->buildClient();
        self::invokeGenerated(self::rootClientReflection(), $client['client'], 'oidcScheme');

        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('Bearer oidc-access-token', $client['http']->lastRequest->getHeaderLine('Authorization'));
    }

    public function testAMutualTlsOperationSendsNoCredentialBecauseThereIsNoneToSend(): void
    {
        $body = self::methodSlice(self::$rootClientSource, 'mutualTlsScheme');
        self::assertStringNotContainsString('->header(', $body);
        self::assertStringNotContainsString('->query(', $body);

        $client = $this->buildClient();
        self::invokeGenerated(self::rootClientReflection(), $client['client'], 'mutualTlsScheme');

        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('', $client['http']->lastRequest->getHeaderLine('Authorization'));
        self::assertSame('', $client['http']->lastRequest->getHeaderLine('Cookie'));
    }

    /**
     * @return array{client: object, http: RecordingClient}
     */
    private function buildClient(): array
    {
        $factory = new Psr17Factory();
        $http = new RecordingClient(new Response(204, [], ''));

        $client = self::rootClientReflection()->newInstanceArgs([
            'transport' => new HttpTransport(self::BASE_URI, new StubErrorFactory(), $http, $factory, $factory),
            'basicUser' => 'alice',
            'basicPassword' => 's3cret',
            'cookieKey' => 'cookie-value',
            'oauthAuth' => 'oauth-access-token',
            'oidcAuth' => 'oidc-access-token',
            'tokenAuth' => 'vendor-word-credential',
        ]);

        return ['client' => $client, 'http' => $http];
    }
}
