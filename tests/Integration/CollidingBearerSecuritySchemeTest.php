<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\Emit\SecurityScheme;
use Mlavrinenko\Paogen\Runtime\Http\HttpTransport;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Support\StubErrorFactory;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * security-schemes-sharing-a-ctor-arg-collide (T-260802): two `http bearer`
 * schemes both classify as {@see SecurityScheme::KIND_BEARER},
 * whose default ctorArg is the fixed name `bearerToken` regardless of the
 * scheme's own name. Before `SecuritySchemeCatalog::disambiguateCtorArgs()`,
 * a document declaring two such schemes emitted the same promoted
 * constructor parameter twice, which PHPStan's `arguments.count` check
 * (correctly) flagged fifty times over on the real DigitalOcean document.
 * This fixture reproduces the minimal shape so the regression does not
 * depend on that vendor document.
 *
 * See `truth/decisions/distinct-ctor-args-for-colliding-schemes.decision-260802.typ`
 * for the choice made (distinct ctorArgs, not one shared parameter) and why.
 */
final class CollidingBearerSecuritySchemeTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/colliding-bearer-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\CollidingBearer';
    private const string BASE_URI = 'https://colliding-bearer.example/api/v1';

    private static string $clientSource = '';

    /** @var ReflectionClass<object>|null */
    private static ?ReflectionClass $clientReflection = null;

    public static function setUpBeforeClass(): void
    {
        $result = self::generateRootClient(self::SCHEMA, self::NAMESPACE, 'paogen-collidingbearer-');
        self::$clientSource = $result['source'];
        self::$clientReflection = $result['reflection'];
    }

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testTwoCollidingBearerSchemesGetTwoDistinctConstructorParametersNotOneRepeated(): void
    {
        // The bug: both schemes propose the fixed ctorArg `bearerToken`, and
        // an undeduplicated catalog emitted it twice — the same promoted
        // parameter name repeated, which does not even parse as valid PHP.
        self::assertSame(
            1,
            substr_count(self::$clientSource, 'private string $controlPlaneAuth'),
            'controlPlaneAuth ctorArg must be promoted exactly once',
        );
        self::assertSame(
            1,
            substr_count(self::$clientSource, 'private string $inferenceAuth'),
            'inferenceAuth ctorArg must be promoted exactly once',
        );
        self::assertStringNotContainsString('bearerToken', self::$clientSource);
    }

    public function testEachSchemeForwardsItsOwnCredentialToTheAuthorizationHeaderIndependently(): void
    {
        $controlPlaneBody = self::methodSlice(self::$clientSource, 'getControlPlane');
        self::assertStringContainsString(
            "->header('Authorization', 'Bearer ' . \$this->controlPlaneAuth)",
            $controlPlaneBody,
        );
        self::assertStringNotContainsString('inferenceAuth', $controlPlaneBody);

        $inferenceBody = self::methodSlice(self::$clientSource, 'getInference');
        self::assertStringContainsString(
            "->header('Authorization', 'Bearer ' . \$this->inferenceAuth)",
            $inferenceBody,
        );
        self::assertStringNotContainsString('controlPlaneAuth', $inferenceBody);

        $client = $this->buildClient(controlPlaneAuth: 'oauth-token', inferenceAuth: 'inference-key');

        self::invokeGenerated($this->reflection(), $client['client'], 'getControlPlane');
        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('Bearer oauth-token', $client['http']->lastRequest->getHeaderLine('Authorization'));

        self::invokeGenerated($this->reflection(), $client['client'], 'getInference');
        self::assertNotNull($client['http']->lastRequest);
        self::assertSame('Bearer inference-key', $client['http']->lastRequest->getHeaderLine('Authorization'));
    }

    /**
     * @return array{client: object, http: RecordingClient}
     */
    private function buildClient(string $controlPlaneAuth, string $inferenceAuth): array
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
            'controlPlaneAuth' => $controlPlaneAuth,
            'inferenceAuth' => $inferenceAuth,
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
