<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use Composer\Autoload\ClassLoader;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Generator\ProfileLoader;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\ApiClient;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Step implementations for OperationGenerator.
 *
 * Strategy:
 *   - scenarios 1 & 2 exercise the generator against the Petstore fixture,
 *     then inspect the emitted `ApiClient.php` source as text;
 *   - scenario 3 constructs the *generated* ApiClient with nyholm PSR-17
 *     factories and a captured-request mock PSR-18 client, calls
 *     `getOrderById(42)`, and asserts the deserialized return value.
 *
 * This file is yours — speconaut only appends new step stubs.
 */
final class OperationGeneratorSteps
{
    private readonly TestCase $test;

    private ?Profile $profile = null;
    private string $outputDir = '';
    private string $source = '';

    private ?ApiClient $client = null;
    private ?RecordingClient $http = null;
    private ?Order $orderResult = null;

    public function __construct(TestCase $test)
    {
        $this->test = $test;
    }

    public function givenSchemaDeclaresOperationOpWithIdAndPathParameterParam(
        string $op,
        string $id,
        string $param,
    ): void {
        TestCase::assertSame('GET /store/order/{orderId}', $op);
        TestCase::assertSame('operationId: getOrderById', $id);
        TestCase::assertSame('orderId: integer', $param);

        $this->profile = $this->loadProfile('petstore');
    }

    public function whenGeneratorRunsAgainstProfile(): void
    {
        TestCase::assertNotNull($this->profile);
        $this->runGenerator($this->profile);
        $this->source = (string) file_get_contents($this->outputDir . '/Generated/ApiClient.php');
    }

    public function thenAFileGeneratedApiClientPhpIsWrittenUnderProfilesOutput(): void
    {
        TestCase::assertFileExists($this->outputDir . '/Generated/ApiClient.php');
    }

    public function thenTheEmittedClassIsFinalReadonlyInProfilesNamespaceGenerated(): void
    {
        TestCase::assertStringContainsString('final readonly class ApiClient', $this->source);
        TestCase::assertStringContainsString(
            'namespace Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Petstore\\Generated;',
            $this->source,
        );
    }

    public function thenTheClassHasAMethodGetOrderByIdIntOrderIdOrderThatInterpolatesTokenIntoTheRequestPath(
        string $token,
    ): void {
        TestCase::assertSame('{orderId}', $token);
        TestCase::assertStringContainsString(
            'public function getOrderById(int $orderId): Order',
            $this->source,
        );
        TestCase::assertStringContainsString(
            "\\str_replace('{orderId}', (string) \$orderId, \$path)",
            $this->source,
        );
    }

    public function givenSchemaDeclaresOperationOpWithId(string $op, string $id): void
    {
        TestCase::assertSame('POST /pet', $op);
        TestCase::assertSame('operationId: addPet', $id);

        $this->profile = $this->loadProfile('petstore');
    }

    public function givenTheRequestBodyIsApplicationJsonWithSchemaRef(string $ref): void
    {
        TestCase::assertSame('#/components/schemas/Pet', $ref);
    }

    public function thenTheEmittedClientHasAMethodAddPetPetBodyPet(): void
    {
        TestCase::assertStringContainsString(
            'public function addPet(Pet $body): Pet',
            $this->source,
        );
    }

    public function thenTheMethodJSONEncodesBodyAndAttachesItAsTheRequestBody(): void
    {
        TestCase::assertStringContainsString("'POST', \\rtrim(\$this->baseUri, '/') . \$path", $this->source);
        TestCase::assertStringContainsString(
            "->withHeader('Content-Type', 'application/json')",
            $this->source,
        );
        TestCase::assertStringContainsString(
            '\\json_encode($body, \\JSON_THROW_ON_ERROR)',
            $this->source,
        );
    }

    public function givenClientIsConstructedWithAPSR18HTTPClientThatReturnsStatusCodeWithJSONBodyBody(
        int $code,
        string $body,
    ): void {
        // PHPUnit's argument pipeline strips outer quotes; re-unescape the
        // spec's raw JSON so it becomes valid for the mock response.
        $normalized = str_replace('\\"', '"', $body);
        TestCase::assertSame(200, $code);

        $this->profile = $this->loadProfile('petstore');
        $this->runGenerator($this->profile);

        $factory = new Psr17Factory();
        $this->http = new RecordingClient(
            new Response($code, ['Content-Type' => 'application/json'], $normalized),
        );

        $this->client = new ApiClient(
            httpClient: $this->http,
            requestFactory: $factory,
            streamFactory: $factory,
            baseUri: 'https://petstore.example/api/v3',
        );
    }

    public function whenGetorderbyid42IsCalledOnClient(): void
    {
        TestCase::assertNotNull($this->client);
        $this->orderResult = $this->client->getOrderById(42);
    }

    public function thenTheReturnValueIsModelOrderWithId42AndStatusPlaced(): void
    {
        TestCase::assertNotNull($this->http);
        TestCase::assertNotNull($this->http->lastRequest);
        TestCase::assertSame('GET', $this->http->lastRequest->getMethod());
        TestCase::assertSame(
            'https://petstore.example/api/v3/store/order/42',
            (string) $this->http->lastRequest->getUri(),
        );

        TestCase::assertInstanceOf(Order::class, $this->orderResult);
        TestCase::assertSame(42, $this->orderResult->id);
        TestCase::assertSame('placed', $this->orderResult->status);
    }

    private function loadProfile(string $name): Profile
    {
        $profile = new ProfileLoader()->load(\dirname(__DIR__, 2) . "/tests/fixtures/profiles/{$name}.php");
        $this->outputDir = $profile->output;

        return $profile;
    }

    private function runGenerator(Profile $profile): void
    {
        $loader = $this->composerLoader();
        $prev = error_reporting();
        error_reporting($prev & ~E_DEPRECATED & ~E_USER_DEPRECATED);

        try {
            new Generator(new AttributeScanner($loader))->generate($profile);
        } finally {
            error_reporting($prev);
        }
    }

    private function composerLoader(): ClassLoader
    {
        foreach (spl_autoload_functions() as $fn) {
            if (\is_array($fn) && isset($fn[0]) && $fn[0] instanceof ClassLoader) {
                return $fn[0];
            }
        }

        TestCase::fail('Composer ClassLoader not found in autoload chain.');
    }
}

/**
 * PSR-18 mock that returns a fixed response and records the last request.
 */
final class RecordingClient implements ClientInterface
{
    public ?RequestInterface $lastRequest = null;

    public function __construct(private readonly ResponseInterface $response) {}

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->lastRequest = $request;

        return $this->response;
    }
}
