<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Runtime\Http\HttpTransport;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Support\StubErrorFactory;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

use function strlen;

/**
 * query-apikey-security-scheme (T-260730): an `apiKey` scheme declared
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
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\QueryApiKey';
    private const string BASE_URI = 'https://query-apikey.example/api/v1';

    private static string $clientSource = '';

    /** @var ReflectionClass<object>|null */
    private static ?ReflectionClass $clientReflection = null;

    public static function setUpBeforeClass(): void
    {
        $output = self::makeSandboxDir('paogen-queryapikey-');

        $generator = new Generator(new AttributeScanner(self::composerLoader()));
        $plan = $generator->generate(new Profile(
            schema: self::SCHEMA,
            output: $output,
            namespace: self::NAMESPACE,
        ));

        foreach ($plan->writes as $path => $source) {
            if (basename($path) === 'ApiClient.php') {
                self::$clientSource = $source;
            }
        }

        self::assertNotSame('', self::$clientSource, 'the plan wrote no ApiClient.php');

        // Real files on disk, not just in-memory plan text, so the generated class
        // can be required and executed — proving the credential reaches the wire
        // rather than only the constructor argument list.
        $exceptionPath = $output . '/Generated/ApiException.php';
        $interfacePath = $output . '/Generated/ApiClientInterface.php';
        $clientPath = $output . '/Generated/ApiClient.php';

        self::assertFileExists($exceptionPath);
        // The client implements an emitted interface, so load the contract first.
        self::assertFileExists($interfacePath);
        self::assertFileExists($clientPath);

        require $exceptionPath;
        require $interfacePath;
        require $clientPath;

        self::$clientReflection = new ReflectionClass(self::clientClassName());
    }

    /**
     * `self::NAMESPACE . '...'` is a compile-time literal, so PHPStan will not
     * widen it to plain `class-string`. Looking the same name up in
     * `get_declared_classes()` hands back a genuine, non-literal one, which is
     * also what makes `ReflectionClass<object>` the right type for
     * {@see self::$clientReflection}.
     *
     * @return class-string
     */
    private static function clientClassName(): string
    {
        $suffix = self::NAMESPACE . '\\Generated\\ApiClient';

        foreach (get_declared_classes() as $declared) {
            // `str_ends_with`, not `===`: PHPStan calls a `class-string`
            // vs. one literal `===` comparison unreachable.
            if (str_ends_with($declared, $suffix)) {
                return $declared;
            }
        }

        self::fail("expected a class ending in {$suffix} to be declared after requiring the generated ApiClient.php");
    }

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testTheQueryApiKeySchemeGetsAConstructorArgumentJustLikeTheHeaderVariant(): void
    {
        self::assertStringContainsString('private string $queryKey,', self::$clientSource);
        self::assertStringContainsString('private string $headerKey,', self::$clientSource);
        // `in: cookie` stays unsupported (report-unsupported-security-schemes'
        // job, not this one) — no constructor argument at all for it.
        self::assertStringNotContainsString('$cookieKey', self::$clientSource);
    }

    public function testAnOperationWithNoQueryParamsOfItsOwnStillGetsTheCredentialAppended(): void
    {
        $body = $this->methodSlice('getStatus');

        // The credential is one query key like any other, and unconditional:
        // an active scheme is always sent, so it carries no null branch.
        self::assertStringContainsString("->query('k', \$this->queryKey)", $body);

        $client = $this->buildClient(queryKey: 'a&b=c', headerKey: 'unused');
        $this->invoke($client['client'], 'getStatus');

        self::assertNotNull($client['http']->lastRequest);
        // urlencoded: the raw value contains '&' and '=', which would
        // otherwise break the query string or smuggle a second pair.
        self::assertSame('k=a%26b%3Dc', $client['http']->lastRequest->getUri()->getQuery());
    }

    public function testAnOperationWithItsOwnQueryParametersGetsOneQueryStringNotTwo(): void
    {
        $body = $this->methodSlice('listItems');

        // The credential joins the operation's own keys in one chain, so
        // there is one query string to build rather than two to splice.
        self::assertStringContainsString("->query('limit', \$limit)", $body);
        self::assertStringContainsString("->query('cursor', \$cursor)", $body);
        self::assertStringContainsString("->query('k', \$this->queryKey)", $body);

        $client = $this->buildClient(queryKey: 'sekret', headerKey: 'unused');
        $this->invoke($client['client'], 'listItems', 5, 'abc');

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
        $body = $this->methodSlice('disabledAuth');

        self::assertStringNotContainsString('->query(', $body);
        self::assertStringNotContainsString('queryKey', $body);

        $client = $this->buildClient(queryKey: 'should-not-appear', headerKey: 'unused');
        $this->invoke($client['client'], 'disabledAuth');

        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('', $client['http']->lastRequest->getUri()->getQuery());
    }

    public function testAnOperationLevelRequirementNamingADifferentSchemeOverridesTheGlobalOne(): void
    {
        $body = $this->methodSlice('overrideAuth');

        self::assertStringNotContainsString('queryKey', $body);
        self::assertStringContainsString("->header('X-Different-Key', \$this->headerKey)", $body);

        $client = $this->buildClient(queryKey: 'unused', headerKey: 'header-secret');
        $this->invoke($client['client'], 'overrideAuth');

        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('', $client['http']->lastRequest->getUri()->getQuery());
        self::assertSame('header-secret', $client['http']->lastRequest->getHeaderLine('X-Different-Key'));
    }

    public function testACookieApiKeySchemeStaysUnwiredRatherThanBeingRepurposedAsQuery(): void
    {
        // Regression guard: this task owns `in: query` only. `in: cookie`
        // must stay untouched — still silently unwired, not rerouted
        // into the query string this change adds.
        $body = $this->methodSlice('cookieSchemeUnaffected');

        self::assertStringNotContainsString('->query(', $body);
        self::assertStringNotContainsString('Cookie', $body);

        $client = $this->buildClient(queryKey: 'unused', headerKey: 'unused');
        $this->invoke($client['client'], 'cookieSchemeUnaffected');

        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('', $client['http']->lastRequest->getUri()->getQuery());
    }

    /**
     * @return array{client: object, http: RecordingClient}
     */
    private function buildClient(string $queryKey, string $headerKey): array
    {
        $factory = new Psr17Factory();
        $http = new RecordingClient(new Response(204, [], ''));

        self::assertInstanceOf(ReflectionClass::class, self::$clientReflection);

        $client = self::$clientReflection->newInstanceArgs([
            'transport' => new HttpTransport(
                self::BASE_URI,
                new StubErrorFactory(),
                $http,
                $factory,
                $factory,
            ),
            'queryKey' => $queryKey,
            'headerKey' => $headerKey,
        ]);

        return ['client' => $client, 'http' => $http];
    }

    /**
     * Calls a method on the dynamically-generated client through
     * reflection rather than `$client->$method(...)` — the class is
     * synthesised into a throwaway namespace at test run time, so static
     * analysis has no way to know its method surface.
     */
    private function invoke(object $client, string $method, mixed ...$args): mixed
    {
        self::assertInstanceOf(ReflectionClass::class, self::$clientReflection);

        return self::$clientReflection->getMethod($method)->invoke($client, ...$args);
    }

    /**
     * The full text of one method in the emitted `ApiClient`, from its
     * signature line up to (not including) the blank line PsrPrinter
     * inserts before the next class member.
     */
    private function methodSlice(string $method): string
    {
        $start = strpos(self::$clientSource, "\n    public function {$method}(");
        self::assertNotFalse($start, "method {$method} not found in emitted client");

        $end = strpos(self::$clientSource, "\n\n", $start);

        return substr(self::$clientSource, $start, ($end === false ? strlen(self::$clientSource) : $end) - $start);
    }

}
