<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Tests\Generated\RecordingClient;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;
use Poagen\Generator\Tests\Support\StubErrorFactory;
use Poagen\Runtime\Http\HttpTransport;
use ReflectionClass;

/**
 * query-apikey-security-scheme (T-260730), plus the cookie variant
 * report-unsupported-security-schemes added later: an `apiKey` scheme declared
 * with `in: query` used to classify as `KIND_UNSUPPORTED`, so
 * `SecuritySchemeCatalog` silently dropped it from both the constructor
 * and every operation's active schemes — no diagnostic (the kilbil
 * loyalty document's `h` scheme). The client compiled, took no
 * credential, sent every request bare, and exited 0.
 *
 * These tests prove the fix at the wire: not that a constructor argument
 * merely exists, but that calling the generated method puts the
 * credential in the request URI a PSR-18 client actually sends.
 */
final class QueryApiKeySecuritySchemeTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/query-apikey-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\QueryApiKey';
    private const string BASE_URI = 'https://query-apikey.example/api/v1';

    private static string $clientSource = '';

    /** @var ReflectionClass<object>|null */
    private static ?ReflectionClass $clientReflection = null;

    public static function setUpBeforeClass(): void
    {
        // Real files on disk, not just in-memory plan text, so the generated class
        // can be required and executed — proving the credential reaches the wire
        // rather than only the constructor argument list.
        $result = self::generateRootClient(self::SCHEMA, self::NAMESPACE, 'poagen-queryapikey-');
        self::$clientSource = $result['source'];
        self::$clientReflection = $result['reflection'];
    }

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testTheQueryApiKeySchemeGetsAConstructorArgumentJustLikeTheHeaderVariant(): void
    {
        self::assertStringContainsString('private string $queryKey,', self::$clientSource);
        self::assertStringContainsString('private string $headerKey,', self::$clientSource);
        // `in: cookie` was the one apiKey variant this task left unwired.
        // report-unsupported-security-schemes wired it, so it takes an
        // argument now like the other two.
        self::assertStringContainsString('private string $cookieKey,', self::$clientSource);
    }

    public function testAnOperationWithNoQueryParamsOfItsOwnStillGetsTheCredentialAppended(): void
    {
        $body = self::methodSlice(self::$clientSource, 'getStatus');

        // The credential is one query key like any other, and unconditional:
        // an active scheme is always sent, so it carries no null branch.
        self::assertStringContainsString("->query('k', \$this->queryKey)", $body);

        $client = $this->buildClient(queryKey: 'a&b=c', headerKey: 'unused');
        self::invokeGenerated($this->reflection(), $client['client'], 'getStatus');

        self::assertNotNull($client['http']->lastRequest);
        // urlencoded: the raw value contains '&' and '=', which would
        // otherwise break the query string or smuggle a second pair.
        self::assertSame('k=a%26b%3Dc', $client['http']->lastRequest->getUri()->getQuery());
    }

    public function testAnOperationWithItsOwnQueryParametersGetsOneQueryStringNotTwo(): void
    {
        $body = self::methodSlice(self::$clientSource, 'listItems');

        // The credential joins the operation's own keys in one chain, so
        // there is one query string to build rather than two to splice.
        self::assertStringContainsString("->query('limit', \$limit)", $body);
        self::assertStringContainsString("->query('cursor', \$cursor)", $body);
        self::assertStringContainsString("->query('k', \$this->queryKey)", $body);

        $client = $this->buildClient(queryKey: 'sekret', headerKey: 'unused');
        self::invokeGenerated($this->reflection(), $client['client'], 'listItems', 5, 'abc');

        self::assertNotNull($client['http']->lastRequest);
        $uri = $client['http']->lastRequest->getUri();

        // Exactly one '?' — the credential joined the same query string
        // as the operation's own parameters rather than producing a
        // second, broken one.
        self::assertSame(1, substr_count((string) $uri, '?'));

        $parsed = [];
        parse_str($uri->getQuery(), $parsed);
        self::assertSame(['limit' => '5', 'cursor' => 'abc', 'k' => 'sekret'], $parsed);
    }

    public function testAnOperationLevelSecurityEmptyArrayDisablesTheCredentialEntirely(): void
    {
        $body = self::methodSlice(self::$clientSource, 'disabledAuth');

        self::assertStringNotContainsString('->query(', $body);
        self::assertStringNotContainsString('queryKey', $body);

        $client = $this->buildClient(queryKey: 'should-not-appear', headerKey: 'unused');
        self::invokeGenerated($this->reflection(), $client['client'], 'disabledAuth');

        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('', $client['http']->lastRequest->getUri()->getQuery());
    }

    public function testAnOperationLevelRequirementNamingADifferentSchemeOverridesTheGlobalOne(): void
    {
        $body = self::methodSlice(self::$clientSource, 'overrideAuth');

        self::assertStringNotContainsString('queryKey', $body);
        self::assertStringContainsString("->header('X-Different-Key', \$this->headerKey)", $body);

        $client = $this->buildClient(queryKey: 'unused', headerKey: 'header-secret');
        self::invokeGenerated($this->reflection(), $client['client'], 'overrideAuth');

        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('', $client['http']->lastRequest->getUri()->getQuery());
        self::assertSame('header-secret', $client['http']->lastRequest->getHeaderLine('X-Different-Key'));
    }

    public function testACookieApiKeySchemeTravelsInACookieHeaderNotTheQueryString(): void
    {
        // `in: cookie` was left unwired when this fixture was written and is
        // wired now (report-unsupported-security-schemes). The half of the
        // original guard that still holds is that it must not be rerouted
        // into the query string the query variant uses.
        $body = self::methodSlice(self::$clientSource, 'cookieSchemeUnaffected');

        self::assertStringNotContainsString('->query(', $body);
        self::assertStringContainsString("->header('Cookie', 'session=' . \$this->cookieKey)", $body);

        $client = $this->buildClient(queryKey: 'unused', headerKey: 'unused', cookieKey: 'abc123');
        self::invokeGenerated($this->reflection(), $client['client'], 'cookieSchemeUnaffected');

        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('', $client['http']->lastRequest->getUri()->getQuery());
        self::assertSame('session=abc123', $client['http']->lastRequest->getHeaderLine('Cookie'));
    }

    /**
     * @return array{client: object, http: RecordingClient}
     */
    private function buildClient(string $queryKey, string $headerKey, string $cookieKey = 'unused'): array
    {
        $factory = new Psr17Factory();
        $http = new RecordingClient(new Response(204, [], ''));

        $client = $this->reflection()->newInstanceArgs([
            'transport' => new HttpTransport(
                self::BASE_URI,
                new StubErrorFactory(),
                $http,
                $factory,
                $factory,
            ),
            'cookieKey' => $cookieKey,
            'headerKey' => $headerKey,
            'queryKey' => $queryKey,
        ]);

        return ['client' => $client, 'http' => $http];
    }

    /**
     * @return ReflectionClass<object>
     */
    private function reflection(): ReflectionClass
    {
        self::assertInstanceOf(ReflectionClass::class, self::$clientReflection);

        return self::$clientReflection;
    }
}
