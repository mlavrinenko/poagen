<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Runtime\Http\HttpTransport;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Support\StubErrorFactory;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionParameter;

use function basename;

/**
 * sub-client-constructors-take-every-scheme-in-the-document: a client asks for
 * the credentials its own operations send, and for nothing else.
 *
 * Before this, every sub-client took every scheme declared anywhere in the
 * document. A consumer building one directly had to supply a secret for an
 * audience that client never talks to, and the emitted class carried a
 * promoted property nothing read — `property.onlyWritten` on a caller-facing
 * surface, which is the opposite of what `caller-surface-is-injectable` asks
 * an injection point to say.
 *
 * The fixture is deliberately not the DigitalOcean document: two tags, two
 * different credentials, and the three ways OpenAPI 3.0.3 4.8.20 resolves an
 * operation's `security` against the document default.
 */
final class ScopedSubClientCredentialsTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/scoped-security-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\ScopedSecurity';
    private const string BASE_URI = 'https://scoped-security.example/v2';

    /** @var array<string,string> emitted source, keyed by the class it declares */
    private static array $sources = [];

    private static string $output = '';

    public static function setUpBeforeClass(): void
    {
        self::$output = self::makeSandboxDir('paogen-scoped-');

        $plan = self::generator()->generate(new Profile(
            schema: self::SCHEMA,
            output: self::$output,
            namespace: self::NAMESPACE,
        ));

        foreach ($plan->writes as $path => $source) {
            self::$sources[basename($path, '.php')] = $source;
        }
    }

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testEachSubClientTakesOnlyTheCredentialsItsOwnOperationsSend(): void
    {
        // `vault` inherits the document default on one operation and replaces
        // it on the other, so it needs both keys.
        self::assertSame(
            ['transport', 'sharedKey', 'vaultKey'],
            $this->constructorParams('VaultClient'),
        );

        // `ledger` names its own token on one operation and clears security on
        // the other, so the document default never reaches it — and neither
        // does the vault's key.
        self::assertSame(['transport', 'bearerToken'], $this->constructorParams('LedgerClient'));
    }

    public function testTheRootHoldsEveryCredentialItHandsOutAndGivesEachChildOnlyItsShare(): void
    {
        // The composition root is the one client built with the full set.
        self::assertSame(
            ['transport', 'bearerToken', 'sharedKey', 'vaultKey'],
            $this->constructorParams('ApiClient'),
        );

        $root = self::$sources['ApiClient'];

        self::assertStringContainsString(
            'return new VaultClient($this->transport, $this->sharedKey, $this->vaultKey);',
            $root,
        );
        self::assertStringContainsString('return new LedgerClient($this->transport, $this->bearerToken);', $root);
    }

    public function testASchemeNoOperationRequiresReachesNoConstructorAtAll(): void
    {
        // `neverRequired` is declared and wired-capable, and nothing asks for
        // it. An unused declaration costs the consumer nothing.
        foreach (self::$sources as $source) {
            self::assertStringNotContainsString('neverRequired', $source);
            self::assertStringNotContainsString('X-Never-Required', $source);
        }
    }

    public function testAnOperationLevelRequirementReplacesTheDocumentDefaultRatherThanAddingToIt(): void
    {
        $http = $this->send('VaultClient', 'vaultReplacesDefault', [
            'sharedKey' => 'shared-secret',
            'vaultKey' => 'vault-secret',
        ]);

        self::assertNotNull($http->lastRequest);
        self::assertSame('vault-secret', $http->lastRequest->getHeaderLine('X-Vault-Key'));
        // The union of both would have sent this one too.
        self::assertSame('', $http->lastRequest->getHeaderLine('X-Shared-Key'));
    }

    public function testAnOperationThatDeclaresNoSecurityInheritsTheDocumentDefault(): void
    {
        $http = $this->send('VaultClient', 'vaultInheritsDefault', [
            'sharedKey' => 'shared-secret',
            'vaultKey' => 'vault-secret',
        ]);

        self::assertNotNull($http->lastRequest);
        self::assertSame('shared-secret', $http->lastRequest->getHeaderLine('X-Shared-Key'));
        self::assertSame('', $http->lastRequest->getHeaderLine('X-Vault-Key'));
    }

    public function testAnEmptySecurityArrayClearsTheDocumentDefaultAndSendsNothing(): void
    {
        $http = $this->send('LedgerClient', 'ledgerClearsSecurity', [
            'bearerToken' => 'ledger-token',
        ]);

        self::assertNotNull($http->lastRequest);
        self::assertSame('', $http->lastRequest->getHeaderLine('X-Shared-Key'));
        self::assertSame('', $http->lastRequest->getHeaderLine('Authorization'));
    }

    /**
     * @return list<string>
     */
    private function constructorParams(string $class): array
    {
        $constructor = $this->reflect($class)->getConstructor();
        self::assertNotNull($constructor);

        return array_map(
            static fn(ReflectionParameter $p): string => $p->getName(),
            $constructor->getParameters(),
        );
    }

    /**
     * Build one client with the credentials it declares, call one method, and
     * hand back the PSR-18 client that recorded what went out.
     *
     * @param array<string,string> $credentials named for the promoted parameters they fill
     */
    private function send(string $class, string $method, array $credentials): RecordingClient
    {
        $factory = new Psr17Factory();
        $http = new RecordingClient(new Response(204, [], ''));
        $transport = new HttpTransport(self::BASE_URI, new StubErrorFactory(), $http, $factory, $factory);

        $reflection = $this->reflect($class);
        $client = $reflection->newInstanceArgs(['transport' => $transport, ...$credentials]);
        self::invokeGenerated($reflection, $client, $method);

        return $http;
    }

    /**
     * @return ReflectionClass<object>
     */
    private function reflect(string $class): ReflectionClass
    {
        $dir = self::$output . '/Generated/';

        require_once $dir . 'ApiException.php';
        require_once $dir . $class . 'Interface.php';
        require_once $dir . $class . '.php';

        return new ReflectionClass(self::declaredClassEnding(self::NAMESPACE . '\\Generated\\' . $class));
    }
}
