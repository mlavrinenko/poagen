<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use Composer\Autoload\ClassLoader;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Generator\ProfileLoader;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\ApiClient;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\ApiException;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;

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
    private ?ApiException $caught = null;

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
        // Reused by the JSON body scenarios (POST /pet, POST /user/createWithList)
        // *and* the operationId-normalisation scenario (POST /proxy with the
        // dotted DigitalOcean-style operationId on the parameters fixture).
        TestCase::assertContains($op, ['POST /pet', 'POST /user/createWithList', 'POST /proxy']);
        TestCase::assertContains($id, [
            'operationId: addPet',
            'operationId: createUsersWithListInput',
            'operationId: monitoring_get_foo.yml',
        ]);

        $this->profile = $op === 'POST /proxy'
            ? $this->loadProfile('parameters')
            : $this->loadProfile('petstore');
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
        // ADR-010: bodies route through the runtime Marshaller before
        // json_encode so wire keys, ScalarBindings, and date formats
        // are normalised at the boundary instead of inside Model::jsonSerialize.
        TestCase::assertStringContainsString(
            '\\json_encode($this->marshaller->marshal($body), \\JSON_THROW_ON_ERROR)',
            $this->source,
        );
    }

    public function givenClientIsConstructedWithAPSR18HTTPClientThatReturnsStatusCodeWithJSONBodyBody(
        int $code,
        string $body,
    ): void {
        // PHPUnit's argument pipeline strips outer quotes; re-unescape the
        // spec's raw JSON so it becomes valid for the mock response.
        // Same step services both the happy path (200) and the
        // non-2xx ApiException scenario (404).
        $normalized = str_replace('\\"', '"', $body);
        TestCase::assertContains($code, [200, 404]);

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

    public function thenCallingItWithArgSendsARequestWhoseURIEndsWithQuery(string $arg, string $query): void
    {
        TestCase::assertSame('status: FindPetsByStatusStatus::Available', $arg);
        TestCase::assertSame('?status=available', $query);

        $factory = new Psr17Factory();
        $http = new RecordingClient(
            new Response(200, ['Content-Type' => 'application/json'], '[]'),
        );

        $client = new ApiClient(
            httpClient: $http,
            requestFactory: $factory,
            streamFactory: $factory,
            baseUri: 'https://petstore.example/api/v3',
        );

        $client->findPetsByStatus(
            \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Enum\FindPetsByStatusStatus::Available,
        );

        TestCase::assertNotNull($http->lastRequest);
        TestCase::assertStringEndsWith($query, (string) $http->lastRequest->getUri());
    }

    private function loadProfile(string $name): Profile
    {
        $profile = new ProfileLoader()->load(\dirname(__DIR__, 2) . "/tests/fixtures/profiles/{$name}.php");
        $this->outputDir = $profile->output;

        return $profile;
    }

    private function runGenerator(Profile $profile): void
    {
        new Generator(new AttributeScanner($this->composerLoader()))->generate($profile);
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

    public function givenTheRequestBodyIsApplicationJsonWithSchemaTypeArrayAndItemsRef(string $ref): void
    {
        TestCase::assertSame('#/components/schemas/User', $ref);
    }


    public function thenTheEmittedClientHasAMethodCreateUsersWithListInputArrayBodyWhoseBodyParameterIsAnnotatedParamListUserBody(
    ): void {
        $body = $this->methodSlice('createUsersWithListInput');
        TestCase::assertStringContainsString('public function createUsersWithListInput(array $body)', $body);
        TestCase::assertStringContainsString(
            '@param list<\\Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Petstore\\Generated\\Model\\User> $body',
            $body,
        );
    }


    public function givenSchemaDeclaresOperationOpWithIdWhose200ResponseSchemaIsTypeString(
        string $op,
        string $id,
    ): void {
        TestCase::assertSame('GET /user/login', $op);
        TestCase::assertSame('operationId: loginUser', $id);

        $this->profile = $this->loadProfile('petstore');
    }


    public function thenTheEmittedClientHasAMethodWhoseReturnTypeIsString(): void
    {
        TestCase::assertStringContainsString(
            'public function loginUser(?string $username = null, ?string $password = null): string',
            $this->source,
        );
    }


    public function thenTheMethodBodyReturnsStringResponseGetBodyAndNeverInvokesSelfHydrate(): void
    {
        $body = $this->methodSlice('loginUser');
        TestCase::assertStringContainsString('return (string) $response->getBody();', $body);
        TestCase::assertStringNotContainsString('self::hydrate', $body);
    }


    public function givenSchemaDeclaresOperationOpWithIdWhose200ResponseSchemaIsTypeObjectWithMap(
        string $op,
        string $id,
        string $map,
    ): void {
        TestCase::assertSame('GET /store/inventory', $op);
        TestCase::assertSame('operationId: getInventory', $id);
        TestCase::assertSame('additionalProperties: integer', $map);

        $this->profile = $this->loadProfile('petstore');
    }


    public function thenTheEmittedClientHasAMethodWhoseReturnTypeIsArrayAnnotatedReturnArrayStringInt(): void
    {
        $body = $this->methodSlice('getInventory');
        TestCase::assertStringContainsString('public function getInventory(): array', $body);
        TestCase::assertStringContainsString('@return array<string, int>', $body);
    }


    public function thenTheMethodBodyReturnsTheJsonDecodedPayloadDirectlyWithoutInvokingSelfHydrate(): void
    {
        $body = $this->methodSlice('getInventory');
        TestCase::assertStringContainsString('\\json_decode((string) $response->getBody()', $body);
        TestCase::assertStringContainsString('return $data;', $body);
        TestCase::assertStringNotContainsString('self::hydrate', $body);
    }


    public function givenSchemaDeclaresOperationOpWithIdAndARequiredQueryParameterTagsSchema(
        string $op,
        string $id,
        string $schema,
    ): void {
        TestCase::assertSame('GET /pet/findByTags', $op);
        TestCase::assertSame('operationId: findPetsByTags', $id);
        TestCase::assertSame('type: array, items.type: string, explode: true', $schema);

        $this->profile = $this->loadProfile('petstore');
    }


    public function thenTheEmittedClientHasAMethodFindPetsByTagsArrayTagsArrayAnnotatedParamListStringTags(): void
    {
        $body = $this->methodSlice('findPetsByTags');
        TestCase::assertStringContainsString('public function findPetsByTags(array $tags): array', $body);
        TestCase::assertStringContainsString('@param list<string> $tags', $body);
    }


    public function thenCallingItWithArgSendsARequestWhoseURIEndsWithQueryInsteadOfTags5B05DATags5B15DB(
        string $arg,
        string $query,
    ): void {
        TestCase::assertSame("tags: ['a', 'b']", $arg);
        TestCase::assertSame('?tags=a&tags=b', $query);

        $factory = new Psr17Factory();
        $http = new RecordingClient(
            new Response(200, ['Content-Type' => 'application/json'], '[]'),
        );

        $client = new ApiClient(
            httpClient: $http,
            requestFactory: $factory,
            streamFactory: $factory,
            baseUri: 'https://petstore.example/api/v3',
        );

        $client->findPetsByTags(['a', 'b']);

        TestCase::assertNotNull($http->lastRequest);
        $uri = (string) $http->lastRequest->getUri();
        TestCase::assertStringEndsWith($query, $uri);
        TestCase::assertStringNotContainsString('tags%5B', $uri);
    }


    public function givenSchemaDeclaresOperationOpWithIdAndAnOptionalHeaderParameterApiKeyString(
        string $op,
        string $id,
    ): void {
        TestCase::assertSame('DELETE /pet/{petId}', $op);
        TestCase::assertSame('operationId: deletePet', $id);

        $this->profile = $this->loadProfile('petstore');
    }


    public function thenTheEmittedClientHasAMethodDeletePetIntPetIdStringApiKeyNullVoid(): void
    {
        TestCase::assertStringContainsString(
            'public function deletePet(int $petId, ?string $api_key = null): void',
            $this->source,
        );
    }


    public function thenTheMethodCallsRequestWithHeaderApiKeyApiKeyOnlyWhenApiKeyIsNotNull(): void
    {
        $body = $this->methodSlice('deletePet');
        TestCase::assertStringContainsString(
            "if (\$api_key !== null) { \$request = \$request->withHeader('api_key', \$api_key); }",
            $body,
        );
    }

    /**
     * Slice the source covering one public method, including any
     * preceding `@param`/`@return` PHPDoc block. Lets per-method
     * assertions stay scoped — e.g. "no `self::hydrate` in this method"
     * — without being fooled by other methods on the same generated
     * class.
     */
    private function methodSlice(string $name): string
    {
        $needle = 'public function ' . $name;
        $methodStart = strpos($this->source, $needle);
        TestCase::assertNotFalse($methodStart, "Method {$name} not found in generated source");

        // Pull in the preceding PHPDoc block when it sits directly above
        // the method (whitespace only between `*/` and `public function`).
        $start = $methodStart;
        $docStart = strrpos(substr($this->source, 0, $methodStart), '/**');

        if ($docStart !== false) {
            $between = substr($this->source, $docStart, $methodStart - $docStart);

            if (preg_match('#^\s*/\*\*[\s\S]*?\*/\s*$#', $between) === 1) {
                $start = $docStart;
            }
        }

        $next = strpos($this->source, "\n    public function ", $methodStart + \strlen($needle));

        return $next === false
            ? substr($this->source, $start)
            : substr($this->source, $start, $next - $start);
    }

    public function givenSchemaDeclaresComponentsParametersLimitParam(string $param): void
    {
        TestCase::assertSame('limit: integer, in: query, required: false', $param);
        $this->profile = $this->loadProfile('parameters');
    }


    public function givenOperationOpWithIdListsAParameterWhoseValueIsRef(string $op, string $id, string $ref): void
    {
        TestCase::assertSame('GET /order', $op);
        TestCase::assertSame('operationId: listOrders', $id);
        TestCase::assertContains($ref, [
            '#/components/parameters/Limit',
            '#/components/parameters/ApiKey',
        ]);
    }


    public function thenTheEmittedClientHasAMethodListOrdersIntLimitNullArray(): void
    {
        TestCase::assertStringContainsString(
            'public function listOrders(?int $limit = null, ?string $api_key = null): array',
            $this->source,
        );
    }


    public function thenTheOperationIsNotSilentlySkippedEvenThoughTheParameterIsARef(): void
    {
        TestCase::assertStringContainsString('public function listOrders(', $this->source);
    }


    public function givenSchemaDeclaresComponentsParametersApiKeyParam(string $param): void
    {
        TestCase::assertSame('api_key: string, in: header, required: false', $param);
        $this->profile = $this->loadProfile('parameters');
    }


    public function thenTheEmittedMethodSignatureIncludesStringApiKeyNull(): void
    {
        TestCase::assertStringContainsString(
            'public function listOrders(?int $limit = null, ?string $api_key = null): array',
            $this->source,
        );
    }


    public function thenTheMethodBodyAttachesTheApiKeyHeaderOnlyWhenApiKeyIsNotNull(): void
    {
        $body = $this->methodSlice('listOrders');
        TestCase::assertStringContainsString(
            "if (\$api_key !== null) { \$request = \$request->withHeader('api_key', \$api_key); }",
            $body,
        );
    }


    public function givenSchemaDeclaresComponentsRequestBodiesCreateOrderWithApplicationJsonSchemaRef(
        string $ref,
    ): void {
        TestCase::assertSame('#/components/schemas/Order', $ref);
        $this->profile = $this->loadProfile('parameters');
    }


    public function givenOperationOpWithIdWhoseRequestBodyIsARef(string $op, string $id, string $ref): void
    {
        TestCase::assertSame('POST /order', $op);
        TestCase::assertSame('operationId: placeOrder', $id);
        TestCase::assertSame('#/components/requestBodies/CreateOrder', $ref);
    }


    public function thenTheEmittedClientHasAMethodPlaceOrderOrderBodyOrder(): void
    {
        TestCase::assertStringContainsString(
            'public function placeOrder(Order $body): Order',
            $this->source,
        );
    }


    public function thenTheOperationIsNotSilentlySkippedEvenThoughTheRequestBodyIsDeclaredViaRef(): void
    {
        TestCase::assertStringContainsString('public function placeOrder(', $this->source);
    }


    public function givenSchemaDeclaresAPathItemStoreStoreIdItemsWithASinglePathItemLevelParameterParam(
        string $param,
    ): void {
        TestCase::assertSame('storeId: integer, in: path, required: true', $param);
        $this->profile = $this->loadProfile('parameters');
    }


    public function givenTwoOperationsUnderItIdAndIdDoNotRestateTheParameter(string $idA, string $idB): void
    {
        TestCase::assertSame('operationId: listStoreItems', $idA);
        TestCase::assertSame('operationId: clearStore', $idB);
    }


    public function thenTheEmittedClientHasListStoreItemsIntStoreIdArrayAndClearStoreIntStoreIdVoid(): void
    {
        TestCase::assertStringContainsString(
            'public function listStoreItems(int $storeId): array',
            $this->source,
        );
        TestCase::assertStringContainsString(
            'public function clearStore(int $storeId): void',
            $this->source,
        );
    }


    public function thenNeitherOperationIsSilentlySkippedEvenThoughTheParameterLivesOnlyOnThePathItem(): void
    {
        TestCase::assertStringContainsString('public function listStoreItems(', $this->source);
        TestCase::assertStringContainsString('public function clearStore(', $this->source);
    }


    public function givenSchemaDeclaresComponentsParametersPetIdParam(string $param): void
    {
        TestCase::assertSame('petId: integer, in: path, required: true', $param);
        $this->profile = $this->loadProfile('parameters');
    }


    public function givenOperationOpWithIdInheritsAPathItemLevelParameterWhoseValueIsRef(
        string $op,
        string $id,
        string $ref,
    ): void {
        TestCase::assertSame('GET /pet/{petId}', $op);
        TestCase::assertSame('operationId: getPetById', $id);
        TestCase::assertSame('#/components/parameters/PetId', $ref);
    }


    public function thenTheEmittedClientHasAMethodGetPetByIdIntPetIdPet(): void
    {
        TestCase::assertStringContainsString(
            'public function getPetById(int $petId): Pet',
            $this->source,
        );
    }


    public function thenTheOperationIsNotSilentlySkippedEvenThoughTheParameterIsDeclaredAtThePathItemLevelViaRef(
    ): void {
        TestCase::assertStringContainsString('public function getPetById(', $this->source);
    }


    public function givenSchemaDeclaresOperationOpWithIdAndARequiredQueryParameterStatusWhoseSchemaIsTypeStringWithEnum(
        string $op,
        string $id,
        string $enum,
    ): void {
        TestCase::assertSame('GET /pet/findByStatus', $op);
        TestCase::assertSame('operationId: findPetsByStatus', $id);
        TestCase::assertSame('[available, pending, sold]', $enum);

        $this->profile = $this->loadProfile('petstore');
        $this->runGenerator($this->profile);
        $this->source = (string) file_get_contents($this->outputDir . '/Generated/ApiClient.php');
    }


    public function thenAFileGeneratedEnumFindPetsByStatusStatusPhpIsWrittenAndTheEmittedClientHasAMethodFindPetsByStatusFindPetsByStatusStatusStatusArray(
    ): void {
        TestCase::assertFileExists($this->outputDir . '/Generated/Enum/FindPetsByStatusStatus.php');

        $enumSource = (string) file_get_contents(
            $this->outputDir . '/Generated/Enum/FindPetsByStatusStatus.php',
        );
        TestCase::assertStringContainsString('enum FindPetsByStatusStatus: string', $enumSource);
        TestCase::assertStringContainsString("case Available = 'available';", $enumSource);
        TestCase::assertStringContainsString("case Pending = 'pending';", $enumSource);
        TestCase::assertStringContainsString("case Sold = 'sold';", $enumSource);

        TestCase::assertStringContainsString(
            'public function findPetsByStatus(FindPetsByStatusStatus $status): array',
            $this->source,
        );
    }


    public function whenGetpetbyid999IsCalledOnClient(): void
    {
        TestCase::assertNotNull($this->client);

        try {
            $this->client->getPetById(999);
            TestCase::fail('Expected ApiException to be thrown.');
        } catch (ApiException $e) {
            $this->caught = $e;
        }
    }


    public function thenTheCallThrowsGeneratedApiException(): void
    {
        TestCase::assertInstanceOf(ApiException::class, $this->caught);
    }


    public function thenTheExceptionsGetStatusCodeReturns404(): void
    {
        TestCase::assertNotNull($this->caught);
        TestCase::assertSame(404, $this->caught->getStatusCode());
    }


    public function thenTheExceptionsGetDecodedBodyReturnsTheDecodedErrorPayload(): void
    {
        TestCase::assertNotNull($this->caught);
        // Raw decoded array — never a Model instance, even if the schema
        // declared a 4xx $ref-to-Model body (T-012 acceptance). The
        // exact-shape `assertSame` itself proves the value is `array`,
        // not an instance of `Pet` or any other Model class.
        $decoded = $this->caught->getDecodedBody();
        TestCase::assertSame(['message' => 'not found'], $decoded);

        // Round-trips: cached after first call, same value on every call.
        TestCase::assertSame($decoded, $this->caught->getDecodedBody());

        // Request and response are the originals carried into the exception.
        TestCase::assertNotNull($this->http);
        TestCase::assertSame($this->http->lastRequest, $this->caught->getRequest());
        TestCase::assertSame(404, $this->caught->getResponse()->getStatusCode());
    }


    public function givenSchemaDeclaresComponentsSecuritySchemesApiKeyWithScheme(string $scheme): void
    {
        TestCase::assertSame('type: apiKey, in: header, name: X-API-Key', $scheme);
        $this->profile = $this->loadProfile('parameters');
    }


    public function givenATopLevelSecurityApiKeyMakesEveryOperationSecuredByDefault(): void
    {
        // The parameters fixture carries `security: [{ apiKey: [] }]` at
        // schema root. No-op: recorded here for scenario readability.
        TestCase::assertNotNull($this->profile);
    }


    public function thenTheEmittedApiClientConstructorHasARequiredStringApiKeyPromotedPrivateArgumentPlacedAfterBaseUri(
    ): void {
        // Signature ordering: security args come AFTER baseUri, in
        // scheme-name sort order. Regex is tight: literal apiKey first,
        // literal bearerToken second — no room for wrong insertion.
        TestCase::assertMatchesRegularExpression(
            '/private string \$baseUri,\s+private string \$apiKey,\s+private string \$bearerToken,/',
            $this->source,
        );
    }


    public function thenEachSecuredOperationsMethodBodyCallsRequestRequestWithHeaderXAPIKeyThisApiKeyBeforeSendRequest(
    ): void {
        // `listOrders` inherits the schema-level requirement and carries
        // the apiKey header; `getPetById` explicitly opts out via
        // `security: []` and must NOT carry it — proves per-op override
        // honours OpenAPI 3.0.3 §4.8.20.
        $listOrders = $this->methodSlice('listOrders');
        TestCase::assertStringContainsString(
            "\$request = \$request->withHeader('X-API-Key', \$this->apiKey);",
            $listOrders,
        );

        $getPetById = $this->methodSlice('getPetById');
        TestCase::assertStringNotContainsString('X-API-Key', $getPetById);
        TestCase::assertStringNotContainsString('$this->apiKey', $getPetById);

        // Live round-trip proof via RecordingClient: the generated client
        // really attaches the header when `sendRequest` runs.
        $factory = new Psr17Factory();
        $http = new RecordingClient(
            new Response(200, ['Content-Type' => 'application/json'], '[]'),
        );
        $client = new \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\ApiClient(
            httpClient: $http,
            requestFactory: $factory,
            streamFactory: $factory,
            baseUri: 'https://parameters.example/api/v1',
            apiKey: 'secret-key',
            bearerToken: 'unused-here',
        );

        $client->listOrders();
        TestCase::assertNotNull($http->lastRequest);
        TestCase::assertSame('secret-key', $http->lastRequest->getHeaderLine('X-API-Key'));
    }


    public function givenSchemaDeclaresComponentsSecuritySchemesBearerAuthWithScheme(string $scheme): void
    {
        TestCase::assertSame('type: http, scheme: bearer', $scheme);
        $this->profile = $this->loadProfile('parameters');
    }


    public function givenAnOperationIdOverridesTheDefaultWithOperationLevelSecurityBearerAuth(string $id): void
    {
        TestCase::assertSame('operationId: placeOrder', $id);
    }


    public function thenTheEmittedApiClientConstructorHasARequiredStringBearerTokenPromotedPrivateArgument(): void
    {
        TestCase::assertStringContainsString(
            'private string $bearerToken,',
            $this->source,
        );
    }


    public function thenPlaceordersMethodBodyCallsRequestRequestWithHeaderAuthorizationBearerThisBearerTokenBeforeSendRequest(
    ): void {
        $body = $this->methodSlice('placeOrder');
        TestCase::assertStringContainsString(
            "\$request = \$request->withHeader('Authorization', 'Bearer ' . \$this->bearerToken);",
            $body,
        );
        // Bearer replaces (not augments) the inherited apiKey on placeOrder.
        TestCase::assertStringNotContainsString('X-API-Key', $body);

        // Round-trip via RecordingClient: Authorization header actually
        // reaches the transport, prefixed with the literal "Bearer ".
        $factory = new Psr17Factory();
        $http = new RecordingClient(
            new Response(200, ['Content-Type' => 'application/json'], '{"id":1}'),
        );
        $client = new \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\ApiClient(
            httpClient: $http,
            requestFactory: $factory,
            streamFactory: $factory,
            baseUri: 'https://parameters.example/api/v1',
            apiKey: 'unused-here',
            bearerToken: 'tok-abc',
        );

        $order = new \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model\Order(id: 1);
        $client->placeOrder($order);

        TestCase::assertNotNull($http->lastRequest);
        TestCase::assertSame('Bearer tok-abc', $http->lastRequest->getHeaderLine('Authorization'));
    }


    public function givenSchemaDeclaresOperationOpWithIdWhoseSoleRequestBodyContentTypeIsApplicationXWwwFormUrlencodedAndWhoseSchemaIsTypeObjectWithPropsAndRequired(
        string $op,
        string $id,
        string $props,
        string $required,
    ): void {
        TestCase::assertSame('POST /token', $op);
        TestCase::assertSame('operationId: issueToken', $id);
        TestCase::assertSame('grantType: string, clientId: string, scope: string', $props);
        TestCase::assertSame('[grantType, clientId]', $required);

        $this->profile = $this->loadProfile('parameters');
    }


    public function thenTheEmittedClientHasAMethodIssueTokenStringGrantTypeStringClientIdStringScopeNullVoidWithOneMethodParameterPerDeclaredProperty(
    ): void {
        TestCase::assertStringContainsString(
            'public function issueToken(string $grantType, string $clientId, ?string $scope = null): void',
            $this->source,
        );
    }


    public function thenTheMethodBodyAssemblesTheRequestBodyWithHttpBuildQueryAndSendsContentTypeApplicationXWwwFormUrlencoded(
    ): void {
        $body = $this->methodSlice('issueToken');
        TestCase::assertStringContainsString(
            "->withHeader('Content-Type', 'application/x-www-form-urlencoded')",
            $body,
        );
        TestCase::assertStringContainsString('\\http_build_query(', $body);
        TestCase::assertStringContainsString('\\PHP_QUERY_RFC1738', $body);
    }


    public function thenCallingItThroughAPSR18RecordingClientRecordsARequestWhoseBodyContainsGrantTypePasswordAndClientIdMyAppPairs(
    ): void {
        $factory = new Psr17Factory();
        $http = new RecordingClient(
            new Response(204, [], ''),
        );
        $client = new \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\ApiClient(
            httpClient: $http,
            requestFactory: $factory,
            streamFactory: $factory,
            baseUri: 'https://parameters.example/api/v1',
            apiKey: 'unused-here',
            bearerToken: 'unused-here',
        );

        $client->issueToken(grantType: 'password', clientId: 'my-app');

        TestCase::assertNotNull($http->lastRequest);
        TestCase::assertSame(
            'application/x-www-form-urlencoded',
            $http->lastRequest->getHeaderLine('Content-Type'),
        );

        // Tolerant assertion: `http_build_query` ordering is stable but
        // key order in the emitted array could shift with future
        // refactors. Parse the pairs back out and match as a set.
        $raw = (string) $http->lastRequest->getBody();
        parse_str($raw, $parsed);
        TestCase::assertSame('password', $parsed['grantType'] ?? null);
        TestCase::assertSame('my-app', $parsed['clientId'] ?? null);
        // Optional field omitted: not in the body at all.
        TestCase::assertArrayNotHasKey('scope', $parsed);
    }


    public function givenSchemaDeclaresOperationOpWithIdWhoseRequestBodyContentTypeIsApplicationOctetStream(
        string $op,
        string $id,
    ): void {
        TestCase::assertSame('POST /pet/{petId}/uploadImage', $op);
        TestCase::assertSame('operationId: uploadFile', $id);

        $this->profile = $this->loadProfile('petstore');
    }


    public function thenTheEmittedClientHasAMethodUploadFileIntPetIdStringAdditionalMetadataNullThatIsNotSilentlySkipped(
    ): void {
        // The whole point of T-011: the op is no longer silently dropped.
        TestCase::assertStringContainsString(
            'public function uploadFile(int $petId, ?string $additionalMetadata = null):',
            $this->source,
        );
    }


    public function thenTheMethodBodyThrowsARuntimeExceptionWhoseMessageMentionsTheOperationIdAndTheUnsupportedContentType(
    ): void {
        $body = $this->methodSlice('uploadFile');
        TestCase::assertStringContainsString('throw new \\RuntimeException(', $body);
        TestCase::assertStringContainsString('uploadFile', $body);
        TestCase::assertStringContainsString('application/octet-stream', $body);

        // Round-trip: calling the generated stub raises the expected
        // RuntimeException rather than executing a (wrong) request.
        $factory = new Psr17Factory();
        $http = new RecordingClient(
            new Response(200, ['Content-Type' => 'application/json'], '{}'),
        );
        $client = new ApiClient(
            httpClient: $http,
            requestFactory: $factory,
            streamFactory: $factory,
            baseUri: 'https://petstore.example/api/v3',
        );

        // Method has `: never` return, so a RuntimeException must fire.
        $caught = null;
        try {
            $client->uploadFile(123);
        } catch (\RuntimeException $e) {
            $caught = $e;
        }

        TestCase::assertInstanceOf(\RuntimeException::class, $caught);
        TestCase::assertStringContainsString('uploadFile', $caught->getMessage());
        TestCase::assertStringContainsString('application/octet-stream', $caught->getMessage());

        // Stub must not touch the transport.
        TestCase::assertNull($http->lastRequest);
    }


    public function givenSchemaDeclaresOperationOpWithAnOptionalHeaderParameterNamedContentType(string $op): void
    {
        TestCase::assertSame('POST /proxy', $op);
        $this->profile = $this->loadProfile('parameters');
    }


    public function thenTheEmittedMethodTakesAStringContentTypeNullArgument(): void
    {
        TestCase::assertStringContainsString(
            'public function monitoringGetFooYml(?string $contentType = null, ?string $xTraceId = null): void',
            $this->source,
        );
    }


    public function thenTheMethodBodyAttachesTheHeaderWithTheOriginalWireKeyContentTypeNotContentType(): void
    {
        $body = $this->methodSlice('monitoringGetFooYml');
        // Wire key `Content-Type` survives verbatim; PHP variable was
        // sanitised to `$contentType` by the CamelCaseSanitiser.
        TestCase::assertStringContainsString(
            "if (\$contentType !== null) { \$request = \$request->withHeader('Content-Type', \$contentType); }",
            $body,
        );
        TestCase::assertStringContainsString(
            "if (\$xTraceId !== null) { \$request = \$request->withHeader('X-Trace-ID', \$xTraceId); }",
            $body,
        );
    }


    public function thenTheEmittedClientHasAMethodMonitoringGetFooYml(): void
    {
        TestCase::assertStringContainsString('public function monitoringGetFooYml(', $this->source);
    }


    public function thenTheOperationIsNotSilentlySkippedEvenThoughTheRawOperationIdContainsA(): void
    {
        // Pre-T-025 the dot in `monitoring_get_foo.yml` made the emitter
        // skip the op outright. After T-025 the op exists under its
        // sanitised PHP name and the raw form does not leak into the source.
        TestCase::assertStringContainsString('public function monitoringGetFooYml', $this->source);
        TestCase::assertStringNotContainsString('monitoring_get_foo.yml', $this->source);
    }


    public function givenAProfileWhoseRenamesMapCarriesMonitoringGetFooYmlForwardProxyRequest(): void
    {
        $base = $this->loadProfile('parameters');
        // Reuse the parameters fixture wiring but override the
        // operationId via Profile::$renames — the same map that
        // overrides schema-component class names (T-023, T-025).
        $this->profile = new Profile(
            schema: $base->schema,
            output: $base->output,
            namespace: $base->namespace,
            discoverIn: $base->discoverIn,
            renames: ['monitoring_get_foo.yml' => 'forwardProxyRequest'],
        );
    }


    public function thenTheEmittedClientHasAMethodForwardProxyRequestInsteadOfTheAutoSanitisedMonitoringGetFooYml(
    ): void {
        TestCase::assertStringContainsString('public function forwardProxyRequest(', $this->source);
        TestCase::assertStringNotContainsString('public function monitoringGetFooYml(', $this->source);
    }


    public function givenSchemaDeclaresOperationIdWhoseApplicationJsonRequestBodyIsAnInlineTypeObjectNotARefAShapePaogenDoesNotYetSynthesise(
        string $id,
    ): void {
        TestCase::assertSame('operationId: postInlineBody', $id);
        $this->profile = $this->loadProfile('parameters');
    }


    public function thenTheResultingGenerationPlanCarriesASkippedOperationsEntryNamingTheHTTPMethodPathOperationIdAndTheReasonForTheSkip(
    ): void {
        TestCase::assertNotNull($this->profile);
        $plan = new Generator(new AttributeScanner($this->composerLoader()))->plan($this->profile);

        $matches = array_values(array_filter(
            $plan->skippedOperations,
            static fn(\Mlavrinenko\Paogen\Generator\Emit\SkippedOperation $s): bool
                => $s->operationId === 'postInlineBody',
        ));

        TestCase::assertCount(1, $matches, 'expected exactly one skip for postInlineBody');
        TestCase::assertSame('post', $matches[0]->httpMethod);
        TestCase::assertSame('/inline-body', $matches[0]->pathUri);
        TestCase::assertSame(
            \Mlavrinenko\Paogen\Generator\Emit\SkippedOperation::REASON_UNSUPPORTED_BODY,
            $matches[0]->reason,
        );
    }


    public function thenPaogenGeneratePrintsTheSameListToStderrSoTheUserKnowsWhichOpsDidNotMakeItIntoTheClient(): void
    {
        // Drive the real CLI binary so the round-trip exercises
        // GenerateCommand::reportSkipped() exactly as the user sees it.
        $profilePath = \dirname(__DIR__, 2) . '/tests/fixtures/profiles/parameters.php';

        $stdout = tmpfile();
        $stderr = tmpfile();
        TestCase::assertNotFalse($stdout);
        TestCase::assertNotFalse($stderr);

        $exit = \Mlavrinenko\Paogen\GenerateCommand::run(
            [$profilePath, '--dry-run'],
            $this->composerLoader(),
            $stdout,
            $stderr,
        );

        TestCase::assertSame(0, $exit);

        rewind($stderr);
        $stderrContents = (string) stream_get_contents($stderr);
        TestCase::assertStringContainsString('postInlineBody', $stderrContents);
        TestCase::assertStringContainsString('/inline-body', $stderrContents);
        TestCase::assertStringContainsString('skipped', $stderrContents);
    }


    public function givenSchemaDeclaresComponentsSchemasSshKeyIdAsSchema(string $schema): void
    {
        TestCase::assertSame('type: integer', $schema);
        $this->profile = $this->loadProfile('parameters');
    }


    public function givenOperationOpWithIdAndAPathParameterSshKeyIdWhoseSchemaIsRef(
        string $op,
        string $id,
        string $ref,
    ): void {
        TestCase::assertSame('GET /keys/{ssh_key_id}', $op);
        TestCase::assertSame('operationId: getSshKeyById', $id);
        TestCase::assertSame('#/components/schemas/SshKeyId', $ref);
    }


    public function thenTheEmittedMethodBodyInterpolatesThePathTokenViaStringSshKeyIdToScalarNotStringSshKeyId(): void
    {
        $body = $this->methodSlice('getSshKeyById');
        TestCase::assertStringContainsString(
            "\\str_replace('{ssh_key_id}', (string) \$ssh_key_id->toScalar(), \$path)",
            $body,
        );
        TestCase::assertStringNotContainsString(
            "\\str_replace('{ssh_key_id}', (string) \$ssh_key_id, \$path)",
            $body,
        );
    }


    public function thenTheOperationIsNotSilentlySkippedEvenThoughThePathParameterResolvesToAScalarBindingImplementingClass(): void
    {
        TestCase::assertStringContainsString('public function getSshKeyById(', $this->source);
    }


}
