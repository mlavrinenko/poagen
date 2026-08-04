<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\PathItem;
use Composer\Autoload\ClassLoader;
use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\GenerateCommand;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Emit\SkippedOperation;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Generator\ProfileLoader;
use Mlavrinenko\Paogen\Runtime\Contract\Envelope;
use Mlavrinenko\Paogen\Runtime\Contract\TransportInterface;
use Mlavrinenko\Paogen\Runtime\Http\HttpTransport;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\ApiClient as ParametersClient;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\ApiException as ParametersApiException;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model\Order as ParametersOrder;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model\SshKeyId;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\ApiClient;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\ApiException;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Enum\FindPetsByStatusStatus;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Enum\OrderStatus;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\StoreClient;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\StoreClientInterface;
use Mlavrinenko\Paogen\Tests\Support\PetstoreFixture;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionParameter;

use function dirname;
use function is_array;
use function strlen;

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
    private ?string $abortMessage = null;
    private string $abortOutputDir = '';
    private ?string $expectedSkipOperationId = null;
    private ?string $expectedSkipContentType = null;

    private ?ApiClient $client = null;
    private ?RecordingClient $http = null;

    /** @var Envelope<Order>|null */
    private ?Envelope $orderResult = null;

    private ?ApiException $caught = null;

    /**
     * A status the document declares decodes onto the envelope now instead
     * of throwing (`typed-error-responses`) — `whenGetpetbyid999IsCalledOnClient()`
     * stores the result here rather than assuming every call raises.
     *
     * @var Envelope<Pet|null>|null
     */
    private ?Envelope $result = null;

    /**
     * The "status the document did not declare" scenario cannot use
     * petstore: every petstore operation declares its own `default`
     * response, so no status against it is ever undeclared. The
     * `parameters` fixture's `listOrders` declares only `200`, which is
     * what that scenario needs — a second, differently-typed client and
     * caught exception rather than reusing `$client`/`$caught`.
     */
    private ?ParametersClient $altClient = null;

    private ?RecordingClient $altHttp = null;
    private ?ParametersApiException $altCaught = null;

    public function __construct(TestCase $test)
    {
        $this->test = $test;
    }

    /**
     * Every emitted caller-surface file, concatenated.
     *
     * A scenario says "the emitted Client has a method X"; since
     * emit-tagged-subclients-with-interfaces that method lives on the sub-client
     * for its tag rather than on `ApiClient`, and which tag it was is not what any
     * of these scenarios is about. Reading the whole surface keeps the assertions
     * about the emitted signature — the thing the specs actually claim — instead
     * of about the file it landed in.
     */
    private function callerSurface(): string
    {
        $files = glob($this->outputDir . '/Generated/*.php');
        $out = '';

        foreach ($files === false ? [] : $files as $file) {
            $out .= (string) file_get_contents($file) . "\n";
        }

        return $out;
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
        $this->source = $this->callerSurface();
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

    /**
     * The petstore fixture client, wired to a recording PSR-18 client and
     * otherwise to the runtime's own defaults. The document declares an
     * `api_key` header scheme (through the profile, which fills the gap the
     * document left) and the `petstore_auth` OAuth2 token, so both follow
     * the transport in the emitted signature.
     */
    private function petstoreClient(RecordingClient $http): ApiClient
    {
        $factory = new Psr17Factory();

        return new ApiClient(new HttpTransport(
            'https://petstore.example/api/v3',
            ApiException::class,
            $http,
            $factory,
            $factory,
        ), 'test-api-key', 'test-access-token');
    }

    /**
     * The parameters fixture client, which declares both an apiKey header
     * scheme and a bearer scheme.
     */
    private function parametersClient(RecordingClient $http, string $apiKey, string $bearerToken): ParametersClient
    {
        $factory = new Psr17Factory();

        return new ParametersClient(
            new HttpTransport(
                'https://parameters.example/api/v1',
                ParametersApiException::class,
                $http,
                $factory,
                $factory,
            ),
            $apiKey,
            $bearerToken,
        );
    }

    public function whenGetorderbyid42IsCalledOnClient(): void
    {
        TestCase::assertNotNull($this->client);
        // Operations live on the tag sub-client now; the root hands it out.
        $this->orderResult = $this->client->store()->getOrderById(42);
    }

    private function loadProfile(string $name): Profile
    {
        $profile = new ProfileLoader()->load(dirname(__DIR__, 2) . "/tests/fixtures/profiles/{$name}.php");
        $this->outputDir = $profile->output;

        return $profile;
    }

    private function runGenerator(Profile $profile): void
    {
        new Generator(new AttributeScanner($this->composerLoader()))->generate($profile);
    }

    // ---- emit-tagged-subclients-with-interfaces -------------------------
    //
    // These scenarios need documents whose tags differ from petstore's, and
    // several of them need a run that fails, so each generates into a scratch
    // directory rather than against a committed fixture tree.

    private const PETSTORE_SCHEMA = 'tests/fixtures/schemas/petstore-3.0.yaml';
    private const PARAMETERS_SCHEMA = 'tests/fixtures/schemas/parameters-3.0.yaml';
    private const KILBIL_SCHEMA = 'examples/kilbil/schemas/loyalty_v1.yaml';

    /**
     * Empty since represent-non-json-request-and-response-bodies: petstore's
     * octet-stream upload is a `Psr\Http\Message\StreamInterface` parameter
     * now, so nothing in this document needs accepting and an entry for it
     * would fail the run as stale.
     *
     * @var array<string,string>
     */
    private const PETSTORE_SKIP = [];

    /** @var array<string,string> */
    private const KILBIL_SKIP = [
        'goodsxml' => 'application/xml request body — xml-content-type-policy',
        'goodslistxml' => 'application/xml request body — xml-content-type-policy',
    ];

    private string $tagOutputDir = '';
    private string $multiTagSchema = '';
    private ?StoreClient $subClient = null;
    private ?RecordingStoreClient $seamInner = null;
    private ?CachingStoreClient $seamDecorator = null;

    /** @var Envelope<Order|null>|null */
    private ?Envelope $seamOrder = null;

    /**
     * A profile over one of the tag fixtures, writing to a scratch tree.
     *
     * @param array<string,string> $skip
     * @param array<string,string> $tagRenames
     * @param array<string,string>              $tagChoice
     * @param array<string,array<string,mixed>> $securitySchemes
     */
    private function taggedProfile(
        string $schema,
        array $skip = [],
        array $tagRenames = [],
        array $tagChoice = [],
        array $securitySchemes = [],
    ): Profile {
        $this->tagOutputDir = $this->makeScratchOutputDir('paogen-tagged-');
        $this->outputDir = $this->tagOutputDir;

        return new Profile(
            schema: str_starts_with($schema, '/') ? $schema : dirname(__DIR__, 2) . '/' . $schema,
            output: $this->tagOutputDir,
            namespace: 'Mlavrinenko\\Paogen\\Tests\\Tmp\\TaggedSteps',
            skip: $skip,
            tagRenames: $tagRenames,
            tagChoice: $tagChoice,
            securitySchemes: $securitySchemes,
        );
    }

    /** One emitted file from the scratch tree, by its basename. */
    private function emittedSource(string $basename): string
    {
        $path = $this->tagOutputDir . '/Generated/' . $basename;
        TestCase::assertFileExists($path);

        return (string) file_get_contents($path);
    }

    /**
     * The class names emitted onto the scratch tree's caller surface.
     *
     * @return list<string>
     */
    private function emittedClassNames(): array
    {
        $files = glob($this->tagOutputDir . '/Generated/*.php');
        $names = [];

        foreach ($files === false ? [] : $files as $file) {
            $names[] = basename($file, '.php');
        }

        sort($names, SORT_STRING);

        return $names;
    }

    /**
     * Operation ids the document leaves untagged.
     *
     * @return list<string>
     */
    private function untaggedOperationIds(string $schema): array
    {
        $openApi = Reader::readFromYamlFile(dirname(__DIR__, 2) . '/' . $schema, OpenApi::class, false);
        $untagged = [];

        foreach ($openApi->paths ?? [] as $pathItem) {
            if (!$pathItem instanceof PathItem) {
                continue;
            }

            foreach ($pathItem->getOperations() as $operation) {
                if (($operation->tags ?? []) === []) {
                    $untagged[] = (string) ($operation->operationId ?? '');
                }
            }
        }

        return $untagged;
    }

    /**
     * A document whose `listThings` carries two tags, each of which also has an
     * endpoint of its own.
     *
     * Written here because no committed fixture carries an operation under two
     * tags, and the `tagChoice` half of the scenario needs the other tag to
     * survive the narrowing so its absence of `listThings` is observable.
     */
    private function writeMultiTagSchema(): string
    {
        $dir = $this->makeScratchOutputDir('paogen-multitag-');
        $path = $dir . '/multi-tag-3.0.yaml';

        file_put_contents($path, <<<'YAML'
            openapi: 3.0.3
            info:
              title: Multi-tag
              version: 1.0.0
            paths:
              /things:
                get:
                  operationId: listThings
                  tags: [alpha, beta]
                  responses:
                    '200':
                      description: ok
                      content:
                        application/json:
                          schema:
                            type: string
              /alpha-only:
                get:
                  operationId: alphaOnly
                  tags: [alpha]
                  responses:
                    '200':
                      description: ok
                      content:
                        application/json:
                          schema:
                            type: string
              /beta-only:
                get:
                  operationId: betaOnly
                  tags: [beta]
                  responses:
                    '200':
                      description: ok
                      content:
                        application/json:
                          schema:
                            type: string
            YAML);

        return $path;
    }

    /**
     * A single operation whose 200 response declares `text/plain` and no
     * `application/json` — default-deny-on-degradation's response-side
     * counterpart to `writeMultiTagSchema`'s request-body case. Written here
     * because no committed fixture carries a response with a content type
     * other than `application/json`.
     */
    private function writeResponseContentTypeSchema(): string
    {
        $dir = $this->makeScratchOutputDir('paogen-response-content-type-');
        $path = $dir . '/response-content-type-3.0.yaml';

        file_put_contents($path, <<<'YAML'
            openapi: 3.0.3
            info:
              title: Non-JSON response
              version: 1.0.0
            paths:
              /labels/{id}:
                get:
                  operationId: getLabel
                  parameters:
                    - name: id
                      in: path
                      required: true
                      schema:
                        type: integer
                  responses:
                    '200':
                      description: ok
                      content:
                        application/octet-stream:
                          schema:
                            type: string
                            format: binary
            YAML);

        return $path;
    }

    private function makeScratchOutputDir(string $prefix): string
    {
        $base = (string) tempnam(sys_get_temp_dir(), $prefix);
        unlink($base);
        assert(mkdir($base, 0o755, true));

        return $base;
    }

    private function composerLoader(): ClassLoader
    {
        foreach (spl_autoload_functions() as $fn) {
            if (is_array($fn) && $fn[0] instanceof ClassLoader) {
                return $fn[0];
            }
        }

        TestCase::fail('Composer ClassLoader not found in autoload chain.');
    }

    public function givenSchemaDeclaresOperationOpWithIdWhose200ResponseSchemaIsTypeString(
        string $op,
        string $id,
    ): void {
        TestCase::assertSame('GET /user/login', $op);
        TestCase::assertSame('operationId: loginUser', $id);

        $this->profile = $this->loadProfile('petstore');
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


    public function givenSchemaDeclaresOperationOpWithIdAndAnOptionalHeaderParameterApiKeyString(
        string $op,
        string $id,
    ): void {
        TestCase::assertSame('DELETE /pet/{petId}', $op);
        TestCase::assertSame('operationId: deletePet', $id);

        $this->profile = $this->loadProfile('petstore');
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

        $next = strpos($this->source, "\n    public function ", $methodStart + strlen($needle));

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


    public function givenSchemaDeclaresComponentsParametersApiKeyParam(string $param): void
    {
        TestCase::assertSame('api_key: string, in: header, required: false', $param);
        $this->profile = $this->loadProfile('parameters');
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


    public function givenSchemaDeclaresAPathItemStoreStoreIdItemsWithASinglePathItemLevelParameterParam(
        string $param,
    ): void {
        TestCase::assertSame('storeId: integer, in: path, required: true', $param);
        $this->profile = $this->loadProfile('parameters');
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
        $this->source = $this->callerSurface();
    }


    public function whenGetpetbyid999IsCalledOnClient(): void
    {
        TestCase::assertNotNull($this->client);
        $this->caught = null;
        $this->result = null;

        // A status the document declares no longer throws
        // (`typed-error-responses`) — only a status matching no exact,
        // range or `default` entry, or a declared body that fails to
        // hydrate, reaches `ApiException` now. Both outcomes are stored so
        // the scenario that called this decides which one it expects.
        try {
            $this->result = $this->client->pet()->getPetById(999);
        } catch (ApiException $e) {
            $this->caught = $e;
        }
    }


    public function givenSchemaDeclaresComponentsSecuritySchemesApiKeyWithScheme(string $scheme): void
    {
        TestCase::assertSame('type: apiKey, in: header, name: X-API-Key', $scheme);
        $this->profile = $this->loadProfile('parameters');
    }


    public function givenSchemaDeclaresComponentsSecuritySchemesBearerAuthWithScheme(string $scheme): void
    {
        TestCase::assertSame('type: http, scheme: bearer', $scheme);
        $this->profile = $this->loadProfile('parameters');
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


    public function givenSchemaDeclaresOperationOpWithIdWhoseRequestBodyContentTypeIsMultipartFormData(
        string $op,
        string $id,
    ): void {
        TestCase::assertSame('POST /widgets', $op);
        TestCase::assertSame('operationId: createWidget', $id);

        $this->profile = $this->loadProfile('unrepresentable');
        $this->expectedSkipOperationId = 'createWidget';
        $this->expectedSkipContentType = 'multipart/form-data';
    }


    public function whenGeneratorRunsAgainstProfileDeclaringNoSkipEntryForThatOperation(): void
    {
        $base = $this->loadProfile('unrepresentable');

        // A pristine output directory, so "wrote nothing" is observable. The
        // shared fixture tree is populated by sibling scenarios and would make
        // the assertion vacuous.
        $this->abortOutputDir = sys_get_temp_dir() . '/paogen-abort-' . bin2hex(random_bytes(6));

        // Same fixture profile with the skip entries removed, so the multipart
        // body is left unaccepted and has to stop the run.
        $unaccepted = new Profile(
            schema: $base->schema,
            output: $this->abortOutputDir,
            namespace: $base->namespace,
            discoverIn: $base->discoverIn,
            renames: $base->renames,
            nameNormaliser: $base->nameNormaliser,
            discriminators: $base->discriminators,
            skip: [],
        );

        $this->abortMessage = null;

        try {
            $this->runGenerator($unaccepted);
        } catch (UnrepresentableConstructsException $e) {
            $this->abortMessage = $e->getMessage();
        }
    }


    public function thenNoGeneratedFileContainsAMethodThatThrowsOnAnUnsupportedContentType(): void
    {
        // The throwing-stub emission path is gone, not merely unused: a method
        // that compiles and throws when called is the silent skip relocated.
        TestCase::assertStringNotContainsString('not yet supported: operationId', $this->source);
        TestCase::assertStringNotContainsString(': never', $this->source);
    }


    public function givenSchemaDeclaresOperationOpWithAnOptionalHeaderParameterNamedContentType(string $op): void
    {
        TestCase::assertSame('POST /proxy', $op);
        $this->profile = $this->loadProfile('parameters');
    }


    public function givenSchemaDeclaresOperationIdWhoseRequestBodyContentTypeIsMultipartFormDataWhichPaogenDoesNotEmit(
        string $id,
    ): void {
        TestCase::assertSame('operationId: createWidget', $id);
        $this->profile = $this->loadProfile('unrepresentable');
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


    public function thenFileGeneratedApiClientPhpIsWrittenUnderProfilesOutput(): void
    {
        TestCase::assertFileExists($this->outputDir . '/Generated/ApiClient.php');
    }


    public function thenEmittedClassIsFinalReadonlyInProfilesNamespaceGenerated(): void
    {
        TestCase::assertStringContainsString('final readonly class ApiClient', $this->source);
        TestCase::assertStringContainsString(
            'namespace Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Petstore\\Generated;',
            $this->source,
        );
    }


    public function thenClientHasAMethodGetOrderByIdIntOrderIdEnvelopeAnnotatedReturnEnvelopeOrderThatInterpolatesTokenIntoTheRequestPath(
        string $token,
    ): void {
        TestCase::assertSame('{orderId}', $token);
        TestCase::assertStringContainsString(
            'public function getOrderById(int $orderId): Envelope',
            $this->source,
        );
        TestCase::assertStringContainsString('@return Envelope<Order|null>', $this->source);
        // The token is named and filled where the path is named. Which
        // string operation fills it is the transport's business.
        TestCase::assertStringContainsString(
            "Endpoint::get('/store/order/{orderId}')->path('orderId', \$orderId)",
            $this->source,
        );
    }


    public function givenOperationsRequestBodyIsApplicationJsonWithSchemaRef(string $ref): void
    {
        TestCase::assertSame('#/components/schemas/Pet', $ref);
    }


    public function thenEmittedClientHasAMethodAddPetPetBodyEnvelopeAnnotatedReturnEnvelopePet(): void
    {
        TestCase::assertStringContainsString(
            'public function addPet(Pet $body): Envelope',
            $this->source,
        );
        TestCase::assertStringContainsString('@return Envelope<Pet|null>', $this->source);
    }


    public function thenClientsMethodJSONEncodesBodyAndAttachesItAsTheRequestBody(): void
    {
        // The emitted method says the body is JSON and hands over the model.
        // `addPet` requires `petstore_auth`, so a credential segment sits
        // between the verb and the body — the body segment still comes last,
        // which is the part this step is about.
        TestCase::assertStringContainsString("Endpoint::post('/pet')", $this->source);
        TestCase::assertStringContainsString('->json($body),', $this->source);

        // Proven at the wire rather than in the text:
        // attribute-and-phpdoc-driven-serialization routes bodies through
        // the runtime Marshaller before json_encode, so wire keys,
        // ScalarBindings and date formats are normalised at the boundary
        // instead of inside Model::jsonSerialize.
        $http = new RecordingClient(
            new Response(200, ['Content-Type' => 'application/json'], '{"id":7,"name":"Rex","photoUrls":[]}'),
        );
        $this->petstoreClient($http)->pet()->addPet(new Pet(name: 'Rex', photoUrls: []));

        TestCase::assertNotNull($http->lastRequest);
        TestCase::assertSame('POST', $http->lastRequest->getMethod());
        TestCase::assertSame(
            'https://petstore.example/api/v3/pet',
            (string) $http->lastRequest->getUri(),
        );
        TestCase::assertSame('application/json', $http->lastRequest->getHeaderLine('Content-Type'));
        TestCase::assertSame(
            '{"name":"Rex","photoUrls":[],"category":null,"id":null,"shipping":null,"status":null,"tags":null}',
            (string) $http->lastRequest->getBody(),
        );
    }


    public function givenOperationsRequestBodyIsApplicationJsonWithSchemaTypeArrayAndItemsRef(string $ref): void
    {
        TestCase::assertSame('#/components/schemas/User', $ref);
    }


    public function thenEmittedClientHasAMethodCreateUsersWithListInputArrayBodyWhoseBodyParameterIsAnnotatedParamListUserBody(
    ): void {
        $body = $this->methodSlice('createUsersWithListInput');
        TestCase::assertStringContainsString('public function createUsersWithListInput(array $body)', $body);
        TestCase::assertStringContainsString(
            '@param list<User> $body',
            $body,
        );
    }


    public function thenReturnValueIsEnvelopeWhoseStatusIs200AndWhoseBodyIsModelOrderWithId42AndStatusPlaced(): void
    {
        TestCase::assertNotNull($this->http);
        TestCase::assertNotNull($this->http->lastRequest);
        TestCase::assertSame('GET', $this->http->lastRequest->getMethod());
        TestCase::assertSame(
            'https://petstore.example/api/v3/store/order/42',
            (string) $this->http->lastRequest->getUri(),
        );

        TestCase::assertNotNull($this->orderResult);
        TestCase::assertSame(200, $this->orderResult->status);
        $order = $this->orderResult->body;
        TestCase::assertInstanceOf(Order::class, $order);
        TestCase::assertSame(42, $order->id);
        // `Order.status` declares an inline enum, so it hydrates into the
        // backed enum paogen synthesised for it rather than into the raw
        // string (inline-body-and-response-schemas).
        TestCase::assertSame(OrderStatus::Placed, $order->status);
        TestCase::assertSame('placed', $order->status->value);
    }


    public function thenEmittedClientHasAMethodWhoseReturnTypeIsEnvelopeAnnotatedReturnEnvelopeString(): void
    {
        TestCase::assertStringContainsString(
            'public function loginUser(?string $username = null, ?string $password = null): Envelope',
            $this->source,
        );
        TestCase::assertStringContainsString('@return Envelope<string|null>', $this->source);
    }


    public function thenEmittedClientHasAMethodWhoseReturnTypeIsEnvelopeAnnotatedReturnEnvelopeArrayStringInt(): void
    {
        $body = $this->methodSlice('getInventory');
        TestCase::assertStringContainsString('public function getInventory(): Envelope', $body);
        TestCase::assertStringContainsString('@return Envelope<array<string, int>|null>', $body);
    }


    public function thenFileGeneratedEnumFindPetsByStatusStatusPhpIsWrittenAndTheEmittedClientHasAMethodFindPetsByStatusFindPetsByStatusStatusStatusEnvelope(
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
            'public function findPetsByStatus(FindPetsByStatusStatus $status): Envelope',
            $this->source,
        );
    }


    public function thenCallingClientsMethodWithArgSendsARequestWhoseURIEndsWithQuery(
        string $arg,
        string $query,
    ): void {
        TestCase::assertSame('status: FindPetsByStatusStatus::Available', $arg);
        TestCase::assertSame('?status=available', $query);

        $http = new RecordingClient(
            new Response(200, ['Content-Type' => 'application/json'], '[]'),
        );

        $this->petstoreClient($http)->pet()->findPetsByStatus(
            FindPetsByStatusStatus::Available,
        );

        TestCase::assertNotNull($http->lastRequest);
        TestCase::assertStringEndsWith($query, (string) $http->lastRequest->getUri());
    }


    public function thenEmittedClientHasAMethodFindPetsByTagsArrayTagsEnvelopeAnnotatedParamListStringTags(): void
    {
        $body = $this->methodSlice('findPetsByTags');
        TestCase::assertStringContainsString('public function findPetsByTags(array $tags): Envelope', $body);
        TestCase::assertStringContainsString('@param list<string> $tags', $body);
    }


    public function thenCallingClientsMethodWithArgSendsARequestWhoseURIEndsWithQueryInsteadOfTags5B05DATags5B15DB(
        string $arg,
        string $query,
    ): void {
        TestCase::assertSame("tags: ['a', 'b']", $arg);
        TestCase::assertSame('?tags=a&tags=b', $query);

        $http = new RecordingClient(
            new Response(200, ['Content-Type' => 'application/json'], '[]'),
        );

        $this->petstoreClient($http)->pet()->findPetsByTags(['a', 'b']);

        TestCase::assertNotNull($http->lastRequest);
        $uri = (string) $http->lastRequest->getUri();
        TestCase::assertStringEndsWith($query, $uri);
        TestCase::assertStringNotContainsString('tags%5B', $uri);
    }


    public function thenEmittedClientHasAMethodDeletePetIntPetIdStringApiKeyNullEnvelope(): void
    {
        TestCase::assertStringContainsString(
            'public function deletePet(int $petId, ?string $apiKey = null): Envelope',
            $this->source,
        );
    }


    public function thenClientsEmittedMethodTakesAStringContentTypeNullArgument(): void
    {
        TestCase::assertStringContainsString(
            'public function monitoringGetFooYml(?string $contentType = null, ?string $xTraceId = null): Envelope',
            $this->source,
        );
    }


    public function thenClientsMethodBodyAttachesTheHeaderWithTheOriginalWireKeyContentTypeNotContentType(): void
    {
        $body = $this->methodSlice('monitoringGetFooYml');
        // Wire key `Content-Type` survives verbatim; PHP variable was
        // sanitised to `$contentType` by the CamelCaseSanitiser.
        TestCase::assertStringContainsString("->header('Content-Type', \$contentType)", $body);
        TestCase::assertStringContainsString("->header('X-Trace-ID', \$xTraceId)", $body);
    }


    public function thenEmittedClientHasAMethodMonitoringGetFooYml(): void
    {
        TestCase::assertStringContainsString('public function monitoringGetFooYml(', $this->source);
    }


    public function thenOperationIsNotSilentlySkippedEvenThoughTheRawOperationIdContainsA(): void
    {
        // Pre-T-025 the dot in `monitoring_get_foo.yml` made the emitter
        // skip the op outright. After T-025 the op exists under its
        // sanitised PHP name and the raw form does not leak into the source.
        TestCase::assertStringContainsString('public function monitoringGetFooYml', $this->source);
        TestCase::assertStringNotContainsString('monitoring_get_foo.yml', $this->source);
    }


    public function givenProfileWhoseMethodRenamesMapCarriesMonitoringGetFooYmlForwardProxyRequest(): void
    {
        $base = $this->loadProfile('parameters');
        // Reuse the parameters fixture wiring but override the operationId via
        // Profile::$methodRenames. `$renames` used to serve both because it
        // applied to every symbol kind; each map is now scoped to the kind it
        // names (operationid-word-splitting).
        $this->profile = new Profile(
            schema: $base->schema,
            output: $base->output,
            namespace: $base->namespace,
            discoverIn: $base->discoverIn,
            skip: $base->skip,
            methodRenames: ['monitoring_get_foo.yml' => 'forwardProxyRequest'],
        );
    }


    public function thenEmittedClientHasAMethodForwardProxyRequestInsteadOfTheAutoSanitisedMonitoringGetFooYml(): void
    {
        TestCase::assertStringContainsString('public function forwardProxyRequest(', $this->source);
        TestCase::assertStringNotContainsString('public function monitoringGetFooYml(', $this->source);
    }


    public function thenProfilesRenamesMapDoesNotRenameOperationBecauseItAnswersADifferentQuestionADocumentMayUseOneStringForBothAComponentAndAnOperationAndOneMapApplyingToBothWouldPutTheConsumersAnswerOnTheWrongOne(
    ): void {
        $base = $this->loadProfile('parameters');
        $viaComponentMap = new Profile(
            schema: $base->schema,
            output: $base->output,
            namespace: $base->namespace,
            discoverIn: $base->discoverIn,
            renames: ['monitoring_get_foo.yml' => 'forwardProxyRequest'],
            skip: $base->skip,
        );

        $this->runGenerator($viaComponentMap);
        $source = $this->callerSurface();

        TestCase::assertStringNotContainsString('public function forwardProxyRequest', $source);
        TestCase::assertStringContainsString('public function monitoringGetFooYml', $source);
    }


    public function thenResultingGenerationPlanCarriesASkippedOperationsEntryNamingOperationsHTTPMethodPathOperationIdAndTheReasonForTheSkip(
    ): void {
        TestCase::assertNotNull($this->profile);
        $plan = new Generator(new AttributeScanner($this->composerLoader()))->plan($this->profile);

        $matches = array_values(array_filter(
            $plan->skippedOperations,
            static fn(SkippedOperation $s): bool
                => $s->operationId === 'createWidget',
        ));

        TestCase::assertCount(1, $matches, 'expected exactly one skip for createWidget');
        TestCase::assertSame('post', $matches[0]->httpMethod);
        TestCase::assertSame('/widgets', $matches[0]->pathUri);

        // The reason is now the diagnostic a user would act on rather than a
        // category label: it names the construct, points at the schema
        // location, and says what would make it acceptable.
        TestCase::assertStringContainsString('multipart/form-data request body', $matches[0]->reason);
        TestCase::assertStringContainsString('/paths/~1widgets/post/requestBody', $matches[0]->reason);
        TestCase::assertStringContainsString('application/x-www-form-urlencoded', $matches[0]->reason);
    }


    public function thenPaogenCLIsGenerateCommandPrintsTheSameListToStderrSoTheUserKnowsWhichOpsDidNotMakeItIntoTheClient(
    ): void {
        // Drive the real CLI binary so the round-trip exercises
        // GenerateCommand::reportSkipped() exactly as the user sees it.
        $profilePath = dirname(__DIR__, 2) . '/tests/fixtures/profiles/unrepresentable.php';

        $stdout = tmpfile();
        $stderr = tmpfile();
        TestCase::assertNotFalse($stdout);
        TestCase::assertNotFalse($stderr);

        $exit = GenerateCommand::run(
            [$profilePath, '--dry-run'],
            $this->composerLoader(),
            $stdout,
            $stderr,
        );

        TestCase::assertSame(0, $exit);

        rewind($stderr);
        $stderrContents = (string) stream_get_contents($stderr);
        TestCase::assertStringContainsString('createWidget', $stderrContents);
        TestCase::assertStringContainsString('/widgets', $stderrContents);
        TestCase::assertStringContainsString('skipped', $stderrContents);
    }


    public function thenEmittedClientHasAMethodListOrdersIntLimitNullEnvelope(): void
    {
        TestCase::assertStringContainsString(
            'public function listOrders(?int $limit = null, ?string $apiKey = null): Envelope',
            $this->source,
        );
    }


    public function thenOperationIsNotSilentlySkippedEvenThoughTheParameterIsARef(): void
    {
        TestCase::assertStringContainsString('public function listOrders(', $this->source);
    }


    public function thenClientsEmittedMethodSignatureIncludesStringApiKeyNull(): void
    {
        TestCase::assertStringContainsString(
            'public function listOrders(?int $limit = null, ?string $apiKey = null): Envelope',
            $this->source,
        );
    }


    public function thenEmittedClientHasAMethodPlaceOrderOrderBodyEnvelope(): void
    {
        TestCase::assertStringContainsString(
            'public function placeOrder(Order $body): Envelope',
            $this->source,
        );
    }


    public function thenOperationIsNotSilentlySkippedEvenThoughTheRequestBodyIsDeclaredViaRef(): void
    {
        TestCase::assertStringContainsString('public function placeOrder(', $this->source);
    }


    public function givenTwoOperationEntriesUnderItIdAndIdDoNotRestateTheParameter(string $idA, string $idB): void
    {
        TestCase::assertSame('operationId: listStoreItems', $idA);
        TestCase::assertSame('operationId: clearStore', $idB);
    }


    public function thenEmittedClientHasListStoreItemsIntStoreIdEnvelopeAndClearStoreIntStoreIdEnvelope(): void
    {
        TestCase::assertStringContainsString(
            'public function listStoreItems(int $storeId): Envelope',
            $this->source,
        );
        TestCase::assertStringContainsString(
            'public function clearStore(int $storeId): Envelope',
            $this->source,
        );
    }


    public function thenEmittedClientHasAMethodGetPetByIdIntPetIdEnvelope(): void
    {
        TestCase::assertStringContainsString(
            'public function getPetById(int $petId): Envelope',
            $this->source,
        );
    }


    public function thenOperationIsNotSilentlySkippedEvenThoughTheParameterIsDeclaredAtThePathItemLevelViaRef(): void
    {
        TestCase::assertStringContainsString('public function getPetById(', $this->source);
    }


    public function thenClientsEmittedMethodBodyInterpolatesThePathTokenViaStringSshKeyIdToScalarNotStringSshKeyId(
    ): void {
        $body = $this->methodSlice('getSshKeyById');
        TestCase::assertStringContainsString("->path('ssh_key_id', \$sshKeyId->toScalar())", $body);
        TestCase::assertStringNotContainsString("->path('ssh_key_id', \$sshKeyId)", $body);

        // At the wire, not only in the text: the value object unwraps to its
        // scalar, so the token carries `42` rather than an object cast.
        $http = new RecordingClient(new Response(204, [], ''));
        $this->parametersClient($http, 'unused-here', 'unused-here')
            ->getSshKeyById(new SshKeyId(42));

        TestCase::assertNotNull($http->lastRequest);
        TestCase::assertSame(
            'https://parameters.example/api/v1/keys/42',
            (string) $http->lastRequest->getUri(),
        );
    }


    public function thenOperationIsNotSilentlySkippedEvenThoughThePathParameterResolvesToAScalarBindingImplementingClass(
    ): void {
        TestCase::assertStringContainsString('public function getSshKeyById(', $this->source);
    }


    public function thenEmittedClientHasAMethodIssueTokenStringGrantTypeStringClientIdStringScopeNullEnvelopeWithOneMethodParameterPerDeclaredProperty(
    ): void {
        TestCase::assertStringContainsString(
            'public function issueToken(string $grantType, string $clientId, ?string $scope = null): Envelope',
            $this->source,
        );
    }


    public function thenClientsMethodBodyAssemblesTheRequestBodyWithHttpBuildQueryAndSendsContentTypeApplicationXWwwFormUrlencoded(
    ): void {
        $body = $this->methodSlice('issueToken');
        // Declared fields, named once, in declaration order. The encoding and
        // the content type belong to the transport, and the optional field
        // needs no `if` because a null drops itself there.
        TestCase::assertStringContainsString(
            "->form(['grantType' => \$grantType, 'clientId' => \$clientId, 'scope' => \$scope])",
            $body,
        );
    }


    public function thenCallingClientsMethodThroughAPSR18RecordingClientRecordsARequestWhoseBodyContainsGrantTypePasswordAndClientIdMyAppPairs(
    ): void {
        $http = new RecordingClient(
            new Response(204, [], ''),
        );

        $this->parametersClient($http, 'unused-here', 'unused-here')
            ->issueToken(grantType: 'password', clientId: 'my-app');

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


    public function thenGeneratorsRunFailsAndEmitsNoGeneratedFile(): void
    {
        TestCase::assertNotNull(
            $this->abortMessage,
            'the generator returned instead of refusing an unrepresentable body',
        );

        // Refusal means refusal: planning aborts before anything reaches disk.
        TestCase::assertFileDoesNotExist($this->abortOutputDir . '/Generated/ApiClient.php');
    }


    public function thenGeneratorsReportNamesTheOperationIdTheUnsupportedContentTypeAndTheRemedy(): void
    {
        $message = (string) $this->abortMessage;

        TestCase::assertNotNull($this->expectedSkipOperationId, 'the given step never recorded which operation to expect');
        TestCase::assertNotNull($this->expectedSkipContentType, 'the given step never recorded which content type to expect');
        TestCase::assertStringContainsString($this->expectedSkipOperationId, $message);
        TestCase::assertStringContainsString($this->expectedSkipContentType, $message);
        // A diagnostic that does not say what to do next is a dead end. This
        // remedy is generic — UnrepresentableConstructsException::forProblems()
        // appends it to every problem it reports, request body or response
        // body alike (default-deny-on-degradation: the same discipline
        // applies uniformly).
        TestCase::assertStringContainsString('Profile::$skip', $message);
    }


    public function givenProfileDeclaresASkipEntryForThatOperationCarryingAReason(): void
    {
        $this->profile = $this->loadProfile('unrepresentable');

        TestCase::assertArrayHasKey('createWidget', $this->profile->skip);
        TestCase::assertNotSame('', trim($this->profile->skip['createWidget']));
    }


    public function thenEmittedClientHasNoCreateWidgetMethodAtAll(): void
    {
        TestCase::assertStringNotContainsString('function createWidget(', $this->source);
    }


    public function thenCallOnClientThrowsGeneratedApiException(): void
    {
        TestCase::assertTrue(
            $this->caught instanceof ApiException || $this->altCaught instanceof ParametersApiException,
            'expected the profile\'s ApiException to have been thrown',
        );
    }


    public function thenClientsExceptionsGetStatusCodeReturns500(): void
    {
        TestCase::assertNotNull($this->altCaught);
        TestCase::assertSame(500, $this->altCaught->getStatusCode());
    }


    public function thenClientsExceptionsGetReasonNamesStatus500AsMatchingNoExactRangeOrDefaultResponse(): void
    {
        TestCase::assertNotNull($this->altCaught);
        TestCase::assertStringContainsString(
            'no exact, range or default response declared for status 500',
            $this->altCaught->getReason(),
        );

        // Request and response are the originals carried into the exception.
        TestCase::assertNotNull($this->altHttp);
        TestCase::assertSame($this->altHttp->lastRequest, $this->altCaught->getRequest());
        TestCase::assertSame(500, $this->altCaught->getResponse()->getStatusCode());
    }


    public function givenTopLevelSecurityApiKeyMakesEveryOperationSecuredByDefault(): void
    {
        // The parameters fixture carries `security: [{ apiKey: [] }]` at
        // schema root. No-op: recorded here for scenario readability.
        TestCase::assertNotNull($this->profile);
    }


    public function thenClientsEmittedApiClientConstructorHasARequiredStringApiKeyPromotedPrivateArgumentPlacedAfterTransport(
    ): void {
        // Signature ordering: security args come AFTER the transport, in
        // scheme-name sort order. Regex is tight: literal apiKey first,
        // literal bearerToken second — no room for wrong insertion.
        TestCase::assertMatchesRegularExpression(
            '/private TransportInterface \$transport,\s+private string \$apiKey,\s+private string \$bearerToken,/',
            $this->source,
        );
    }


    public function givenOperationIdOverridesTheDefaultWithOperationLevelSecurityBearerAuth(string $id): void
    {
        TestCase::assertSame('operationId: placeOrder', $id);
    }


    public function thenClientsEmittedApiClientConstructorHasARequiredStringBearerTokenPromotedPrivateArgument(): void
    {
        TestCase::assertStringContainsString(
            'private string $bearerToken,',
            $this->source,
        );
    }


    public function givenSchemaDeclaresOperationIdTaggedTagAndAnotherTaggedOther(
        string $id,
        string $tag,
        string $other,
    ): void {
        TestCase::assertSame('operationId: getOrderById', $id);
        TestCase::assertSame('store', $tag);
        TestCase::assertSame('pet', $other);

        $this->profile = $this->taggedProfile(
            self::PETSTORE_SCHEMA,
            self::PETSTORE_SKIP,
            securitySchemes: PetstoreFixture::SECURITY_SCHEMES,
        );
    }


    public function thenGeneratedFileGeneratedStoreClientPhpIsAFinalReadonlyClassImplementingStoreClientInterface(
    ): void {
        TestCase::assertStringContainsString(
            'final readonly class StoreClient implements StoreClientInterface',
            $this->emittedSource('StoreClient.php'),
        );
    }


    public function thenEmittedGeneratedFileStoreClientInterfacePhpDeclaresGetOrderByIdAndDoesNotDeclareThePetOperationSoACallerDependingOnItDependsOnRoughlyTheEndpointsItUses(
    ): void {
        $interface = $this->emittedSource('StoreClientInterface.php');

        TestCase::assertStringContainsString('public function getOrderById(int $orderId): Envelope;', $interface);

        // Exactly its own: a `pet` endpoint has no business on the store
        // contract, which is what makes the interface a narrower dependency
        // than the whole document.
        TestCase::assertStringNotContainsString('addPet', $interface);
        TestCase::assertStringNotContainsString('findPetsByStatus', $interface);
    }


    public function thenEmittedGeneratedFileInterfaceOmitsTheConstructorBecauseHowAnImplementationAcquiresItsCollaboratorsIsNotPartOfTheContractADecoratorSatisfies(
    ): void {
        TestCase::assertStringNotContainsString('__construct', $this->emittedSource('StoreClientInterface.php'));
    }


    public function givenSchemaTagsEveryOperation(): void
    {
        // Petstore's operations are tagged without exception, which is this
        // scenario's premise — asserted rather than assumed, because an
        // untagged one would land on the root and quietly weaken the `then`.
        $this->profile = $this->taggedProfile(
            self::PETSTORE_SCHEMA,
            self::PETSTORE_SKIP,
            securitySchemes: PetstoreFixture::SECURITY_SCHEMES,
        );

        TestCase::assertSame([], $this->untaggedOperationIds(self::PETSTORE_SCHEMA));
    }


    public function thenClientApiClientHasOneAccessorPerTagEachReturningThatTagsInterface(): void
    {
        $root = $this->emittedSource('ApiClient.php');

        // Each accessor returns the *interface*, not the implementation: that
        // is what lets a consumer hand back a decorator instead.
        TestCase::assertStringContainsString('public function pet(): PetClientInterface', $root);
        TestCase::assertStringContainsString('public function store(): StoreClientInterface', $root);
        TestCase::assertStringContainsString('public function user(): UserClientInterface', $root);

        // One per tag and no more — petstore declares exactly these three.
        TestCase::assertSame(3, preg_match_all('/public function \w+\(\): \w+ClientInterface/', $root));
    }


    public function thenClientApiClientDeclaresNoOperationMethodOfItsOwnSoExactlyOneWayExistsToReachAnyEndpoint(
    ): void {
        $root = $this->emittedSource('ApiClient.php');

        TestCase::assertStringNotContainsString('public function getOrderById', $root);
        TestCase::assertStringNotContainsString('public function addPet', $root);

        // Stronger than naming two absent methods: an operation method is one
        // that reaches the transport, and the root performs no send at all.
        // Two ways to reach an endpoint would let a call site slip past
        // whatever decorator a consumer wrapped the sub-client in.
        TestCase::assertStringNotContainsString('$this->transport->send(', $root);
    }


    public function givenGeneratorHasEmittedASubClientForATag(): void
    {
        // The committed petstore fixture tree is real generator output and is
        // autoloadable, which the next step needs: it constructs the emitted
        // class rather than reading it as text.
        $this->profile = $this->taggedProfile(
            self::PETSTORE_SCHEMA,
            self::PETSTORE_SKIP,
            securitySchemes: PetstoreFixture::SECURITY_SCHEMES,
        );
        $this->runGenerator($this->profile);

        TestCase::assertFileExists($this->tagOutputDir . '/Generated/StoreClient.php');
        TestCase::assertFileExists($this->tagOutputDir . '/Generated/StoreClientInterface.php');
    }


    public function whenConsumerConstructsClientDirectly(): void
    {
        // Directly: a transport plus the credentials this client's OWN
        // operations send, and no root object anywhere in reach. `getInventory`
        // requires `api_key` and nothing else, so that is the whole of it —
        // the `petstore_auth` token the pet endpoints need never reaches here
        // (sub-client-constructors-take-every-scheme-in-the-document).
        $factory = new Psr17Factory();

        $this->subClient = new StoreClient(new HttpTransport(
            'https://petstore.example/api/v3',
            ApiException::class,
            new RecordingClient(new Response(200, ['Content-Type' => 'application/json'], '{}')),
            $factory,
            $factory,
        ), 'test-api-key');
    }


    public function thenClientsConstructorTakesTransportInterfaceAndWhateverCredentialSchemaDeclaresAndNeverRootClient(
    ): void {
        TestCase::assertInstanceOf(StoreClientInterface::class, $this->subClient);

        $constructor = new ReflectionClass(StoreClient::class)->getConstructor();
        TestCase::assertNotNull($constructor);

        $types = array_map(
            static fn(ReflectionParameter $parameter): string => (string) $parameter->getType(),
            $constructor->getParameters(),
        );

        // The transport plus one string per credential THIS client's own
        // operations send — `getInventory` requires `api_key` alone, so the
        // signature names one credential rather than every scheme in the
        // document. The transport's type is the interface, never an
        // implementation: injecting a final class is not substitution.
        TestCase::assertSame([TransportInterface::class, 'string'], $types);

        // And never the root: a sub-client that needed `ApiClient` to exist
        // would not be separately injectable, which is the point of the grain.
        TestCase::assertStringNotContainsString('ApiClient $', $this->emittedSource('StoreClient.php'));
    }


    public function givenSchemaDeclaresOperationCarryingNoTag(): void
    {
        // The parameters fixture tags nothing at all, so every one of its
        // operations is the case under test.
        $this->profile = $this->taggedProfile(self::PARAMETERS_SCHEMA);

        TestCase::assertNotEmpty($this->untaggedOperationIds(self::PARAMETERS_SCHEMA));
    }


    public function thenOperationIsEmittedAsAMethodOnClientApiClientItself(): void
    {
        $root = $this->emittedSource('ApiClient.php');

        TestCase::assertStringContainsString('public function getPetById(', $root);
        TestCase::assertStringContainsString('public function listOrders(', $root);
    }


    public function thenNoGeneratedFileNamedForAFallbackTagIsWritten(): void
    {
        // No `DefaultApi`, no `DefaultClient`, no bucket type of any name: the
        // root already is where an untagged operation belongs, so inventing a
        // tag for it would be a class the document never asked for.
        $subClients = array_values(array_filter(
            $this->emittedClassNames(),
            static fn(string $name): bool => str_ends_with($name, 'Client') && $name !== 'ApiClient',
        ));

        TestCase::assertSame([], $subClients);
    }


    public function givenOperationCarriesTwoTagsAndProfileSetsNoTagChoiceForIt(): void
    {
        // No committed fixture carries an operation under two tags, so the
        // scenario's document is written here rather than reaching outside
        // this file for one.
        $this->multiTagSchema = $this->writeMultiTagSchema();
        $this->profile = $this->taggedProfile($this->multiTagSchema);
    }


    public function thenOperationIsEmittedOnBothSubClientsBecauseDroppingItFromEitherWouldBeAnOmissionNobodyAskedFor(
    ): void {
        TestCase::assertStringContainsString('public function listThings(', $this->emittedSource('AlphaClient.php'));
        TestCase::assertStringContainsString('public function listThings(', $this->emittedSource('BetaClient.php'));

        // Declared on both contracts too, not just on the implementations.
        TestCase::assertStringContainsString('public function listThings(', $this->emittedSource('AlphaClientInterface.php'));
        TestCase::assertStringContainsString('public function listThings(', $this->emittedSource('BetaClientInterface.php'));
    }


    public function thenProfileKeyTagChoiceNarrowsItToOneAndAChoiceNamingATagOperationDoesNotCarryFailsTheRun(): void
    {
        // Narrowing: with a choice the operation lands on that tag alone, and
        // the other sub-client — which has an endpoint of its own — keeps
        // existing without it.
        $narrowed = $this->taggedProfile($this->multiTagSchema, tagChoice: ['listThings' => 'alpha']);
        $this->runGenerator($narrowed);

        TestCase::assertStringContainsString('public function listThings(', $this->emittedSource('AlphaClient.php'));
        TestCase::assertStringContainsString('public function betaOnly(', $this->emittedSource('BetaClient.php'));
        TestCase::assertStringNotContainsString('public function listThings(', $this->emittedSource('BetaClient.php'));

        // A choice can only narrow the tags the document declared. One naming
        // a tag the operation does not carry is guidance that cannot apply, so
        // it fails the run rather than being quietly ignored.
        $bogus = $this->taggedProfile($this->multiTagSchema, tagChoice: ['listThings' => 'gamma']);

        try {
            $this->runGenerator($bogus);
            TestCase::fail('expected a tagChoice naming an uncarried tag to fail the run');
        } catch (UnrepresentableConstructsException $error) {
            TestCase::assertStringContainsString('tagChoice', $error->getMessage());
            TestCase::assertStringContainsString('does not carry', $error->getMessage());
        }
    }


    public function givenSchemaTagsOperationTag(string $tag): void
    {
        TestCase::assertSame('Клиенты', $tag);

        // The kilbil loyalty document is the real thing this exists for: all
        // eleven of its tags are Russian words.
        $this->profile = $this->taggedProfile(self::KILBIL_SCHEMA, self::KILBIL_SKIP);
    }


    public function thenGeneratedFileGeneratedKlientyClientPhpIsWrittenPHPWouldAcceptTheRussianWordAsAClassNameAndTheResultWouldBeUnusable(
    ): void {
        TestCase::assertFileExists($this->tagOutputDir . '/Generated/KlientyClient.php');

        // PHP would happily accept the raw word as a class name, which is the
        // trap: it compiles and is unusable. A readable romanisation is the
        // default, and neither the raw word nor an invented `Tag1` appears.
        TestCase::assertNotContains('КлиентыClient', $this->emittedClassNames());
        TestCase::assertNotContains('Tag1Client', $this->emittedClassNames());
    }


    public function thenSameSchemaProducesSameGeneratedFileNameOnAnyMachineBecauseTheFoldIsAFixedCharacterTableRatherThanALibraryWhoseOutputTracksAnICUVersion(
    ): void {
        $first = $this->emittedClassNames();

        // Same document, a second run, a different output directory: a fold
        // that consulted anything machine-local would have to agree with
        // itself here anyway, so the names are also pinned literally below.
        $second = $this->taggedProfile(self::KILBIL_SCHEMA, self::KILBIL_SKIP);
        $this->runGenerator($second);

        TestCase::assertSame($first, $this->emittedClassNames());

        // Pinned rather than merely stable: these are the exact names the
        // fixed table yields, so a swap to a locale- or ICU-driven fold would
        // fail here instead of drifting silently between machines.
        TestCase::assertContains('KlientyClient', $first);
        TestCase::assertContains('PodarochnyeSertifikatyClient', $first);

        // A tag the vendor already wrote in ASCII is passed through untouched.
        TestCase::assertContains('WalletClient', $first);
    }


    public function givenProfileWhoseTagRenamesMapCarriesКлиентыCustomers(): void
    {
        $this->profile = $this->taggedProfile(
            self::KILBIL_SCHEMA,
            self::KILBIL_SKIP,
            tagRenames: ['Клиенты' => 'Customers'],
        );
    }


    public function thenGeneratedFileGeneratedCustomersClientPhpIsWrittenAndClientApiClientExposesCustomers(): void
    {
        TestCase::assertFileExists($this->tagOutputDir . '/Generated/CustomersClient.php');
        TestCase::assertFileExists($this->tagOutputDir . '/Generated/CustomersClientInterface.php');

        // The rename replaces the romanisation rather than sitting beside it.
        TestCase::assertNotContains('KlientyClient', $this->emittedClassNames());

        TestCase::assertStringContainsString(
            'public function customers(): CustomersClientInterface',
            $this->emittedSource('ApiClient.php'),
        );
    }


    public function thenEntryNamingATagNoOperationCarriesFailsTheRunOnTheSameReasoningAsAStaleSkipGuidanceThatOutlivesItsTargetIsWorseThanNone(
    ): void {
        // `Клиенти` is a near-miss of the real tag — the shape a rename takes
        // once a vendor renames the tag underneath it.
        $stale = $this->taggedProfile(
            self::KILBIL_SCHEMA,
            self::KILBIL_SKIP,
            tagRenames: ['Клиенти' => 'Customers'],
        );

        try {
            $this->runGenerator($stale);
            TestCase::fail('expected a tagRenames entry matching no tag to fail the run');
        } catch (UnrepresentableConstructsException $error) {
            TestCase::assertStringContainsString('tagRenames', $error->getMessage());
            TestCase::assertStringContainsString('no operation carries', $error->getMessage());
        }
    }


    public function givenConsumersOwnClassImplementingEmittedGeneratedFileStoreClientInterfaceAndHoldingTheGeneratedImplementation(
    ): void {
        // Fresh output for this scenario's own read of Generated/StoreClient.php
        // below — the class the seam is built against is still the composer-
        // autoloaded golden fixture, since that FQCN is fixed at PSR-4 mapping
        // time and cannot follow a scratch directory.
        $this->profile = $this->loadProfile('petstore');
        $this->runGenerator($this->profile);

        $this->seamInner = new RecordingStoreClient();
        $this->seamDecorator = new CachingStoreClient($this->seamInner);

        // Type-hinting the contract is the point: consumer code depends on the
        // interface, not on either implementation.
        TestCase::assertInstanceOf(StoreClientInterface::class, $this->seamDecorator);
        TestCase::assertInstanceOf(StoreClientInterface::class, $this->seamInner);
    }


    public function whenConsumerCallsAMethodOnTheirClassWhichClientDeclared(): void
    {
        TestCase::assertNotNull($this->seamDecorator);

        // Twice, so the added behaviour has something to show for itself.
        $this->seamOrder = $this->seamDecorator->getOrderById(42);
        $this->seamDecorator->getOrderById(42);
    }


    public function thenCallReachesTheGeneratedImplementationAndTheirClassAddsBehaviourWithNoEditToGeneratedFileNoHookNoProtectedRegionNoSubclass(
    ): void {
        TestCase::assertNotNull($this->seamOrder);
        TestCase::assertInstanceOf(Order::class, $this->seamOrder->body);
        TestCase::assertSame(42, $this->seamOrder->body->id);

        // Reached once, not twice: the second call was served from the
        // decorator's cache. That is behaviour added without a generated file
        // changing to permit it.
        TestCase::assertNotNull($this->seamInner);
        TestCase::assertSame([42], $this->seamInner->fetched);

        // No subclass: the decorator extends nothing, and could not extend the
        // generated class even if it wanted to, because that class is final.
        TestCase::assertFalse(new ReflectionClass(CachingStoreClient::class)->getParentClass());
        TestCase::assertTrue(new ReflectionClass(StoreClient::class)->isFinal());

        // No hook and no protected region: the generated class exposes no
        // extension point for a consumer to hang behaviour on.
        $generated = (string) file_get_contents($this->outputDir . '/Generated/StoreClient.php');
        TestCase::assertStringNotContainsString('protected', $generated);
        TestCase::assertStringNotContainsString('abstract', $generated);
    }


    public function thenTheirClassSatisfiesTheStrictestAnalysisWithNothingSuppressedSoARegenerationThatChangedClientSurfaceWouldFailToCompileRatherThanBreakTheSeamQuietly(
    ): void {
        $root = dirname(__DIR__, 2);

        // The committed proof: a consumer's decorator living in an example
        // project, against that example's own generated tree.
        $decorator = $root . '/examples/petstore/src/CachingStoreClient.php';
        TestCase::assertFileExists($decorator);

        $source = (string) file_get_contents($decorator);
        TestCase::assertStringContainsString('implements StoreClientInterface', $source);

        // Nothing suppressed — a suppression is exactly how a broken seam
        // would be made to look fine.
        foreach (['@phpstan-ignore', '@psalm-suppress', '@SuppressWarnings', 'phpcs:ignore', '@phan-suppress'] as $suppression) {
            TestCase::assertStringNotContainsString($suppression, $source);
        }

        // "The strictest analysis" is a claim about the gate, so read the
        // gate: `phpstan-generated.neon` is level max with strict rules, and
        // `lint-phpstan-generated` points it at every `examples/*/src`.
        $config = (string) file_get_contents($root . '/phpstan-generated.neon');
        TestCase::assertStringContainsString('level: max', $config);
        TestCase::assertStringContainsString('phpstan-strict-rules', $config);

        $justfile = (string) file_get_contents($root . '/Justfile');
        TestCase::assertStringContainsString('examples/*/src', $justfile);
        TestCase::assertStringContainsString('phpstan analyse -c phpstan-generated.neon', $justfile);
    }


    public function givenClientIsConstructedWithATransportInterfaceBackedByAPSR18HTTPClientThatReturnsStatusCodeWithJSONBodyBody(
        int $code,
        string $body,
    ): void {
        // PHPUnit's argument pipeline strips outer quotes; re-unescape the
        // spec's raw JSON so it becomes valid for the mock response.
        // Same step services both the happy path (200, petstore) and the
        // undeclared-status ApiException scenario (500) — petstore declares
        // its own `default` on every operation, so no status against it is
        // ever undeclared; the `parameters` fixture's `listOrders` does not,
        // which is what the 500 case needs (typed-error-responses).
        $normalized = str_replace('\\"', '"', $body);
        TestCase::assertContains($code, [200, 500]);

        if ($code === 500) {
            $this->profile = $this->loadProfile('parameters');
            $this->runGenerator($this->profile);

            $this->altHttp = new RecordingClient(
                new Response($code, ['Content-Type' => 'application/json'], $normalized),
            );
            $this->altClient = $this->parametersClient($this->altHttp, 'unused-api-key', 'unused-bearer-token');

            return;
        }

        $this->profile = $this->loadProfile('petstore');
        $this->runGenerator($this->profile);

        $this->http = new RecordingClient(
            new Response($code, ['Content-Type' => 'application/json'], $normalized),
        );

        $this->client = $this->petstoreClient($this->http);
    }


    public function thenClientsMethodBodyNamesTheResponseShapeResponseTypeStringForStatus200SoTheTransportReadsTheBodyAsAScalarInsteadOfHydratingItIntoAModel(
    ): void {
        $body = $this->methodSlice('loginUser');
        // The scalar shape is named, so the body is read as a string rather
        // than decoded and hydrated.
        TestCase::assertStringContainsString("['200', ResponseType::string()]", $body);
        TestCase::assertStringNotContainsString('hydrate', $body);

        $http = new RecordingClient(new Response(200, ['Content-Type' => 'text/plain'], 'session-token'));

        TestCase::assertSame(
            'session-token',
            $this->petstoreClient($http)->user()->loginUser('ada', 'pw')->body,
        );
    }


    public function thenClientsMethodBodyNamesTheResponseShapeResponseTypeMapOfResponseTypeIntForStatus200SoTheTransportDecodesThePayloadDirectlyInsteadOfHydratingItIntoAModel(
    ): void {
        $body = $this->methodSlice('getInventory');
        // A map of the declared value type: decoded and handed back, never
        // hydrated into a Model the document did not declare.
        TestCase::assertStringContainsString("['200', ResponseType::mapOf(ResponseType::int())]", $body);
        TestCase::assertStringNotContainsString('hydrate', $body);

        $http = new RecordingClient(
            new Response(200, ['Content-Type' => 'application/json'], '{"available":7,"sold":2}'),
        );

        TestCase::assertSame(
            ['available' => 7, 'sold' => 2],
            $this->petstoreClient($http)->store()->getInventory()->body,
        );
    }


    public function thenClientsMethodCallsHeaderApiKeyApiKeyUnconditionallyWithNoIfInTheEmittedBodyTheHeaderIsDroppedBeforeTheRequestIsSentWhenApiKeyIsNull(
    ): void {
        $body = $this->methodSlice('deletePet');
        // No `if` in the emitted body: the value is passed as it is and a
        // null drops itself at the boundary.
        TestCase::assertStringContainsString("->header('api_key', \$apiKey)", $body);
        TestCase::assertStringNotContainsString('if (', $body);

        $http = new RecordingClient(new Response(204, [], ''));
        $this->petstoreClient($http)->pet()->deletePet(3);

        TestCase::assertNotNull($http->lastRequest);
        TestCase::assertFalse($http->lastRequest->hasHeader('api_key'));

        $http = new RecordingClient(new Response(204, [], ''));
        $this->petstoreClient($http)->pet()->deletePet(3, 'k-9');

        TestCase::assertNotNull($http->lastRequest);
        TestCase::assertSame('k-9', $http->lastRequest->getHeaderLine('api_key'));
    }


    public function thenClientsMethodBodyAttachesHeaderApiKeyApiKeyUnconditionallyWithNoIfInTheEmittedBodyTheHeaderIsDroppedBeforeTheRequestIsSentWhenApiKeyIsNull(
    ): void {
        $body = $this->methodSlice('listOrders');
        TestCase::assertStringContainsString("->header('api_key', \$apiKey)", $body);
        TestCase::assertStringNotContainsString('if (', $body);

        $http = new RecordingClient(new Response(200, ['Content-Type' => 'application/json'], '[]'));
        $this->parametersClient($http, 'unused-here', 'unused-here')->listOrders();

        TestCase::assertNotNull($http->lastRequest);
        TestCase::assertFalse($http->lastRequest->hasHeader('api_key'));
    }


    public function thenEachSecuredOperationsMethodBodyAttachesHeaderXAPIKeyThisApiKeyToTheRequestItBuildsAndPassesItToThisTransportSend(
    ): void {
        // `listOrders` inherits the schema-level requirement and carries
        // the apiKey header; `getPetById` explicitly opts out via
        // `security: []` and must NOT carry it — proves per-op override
        // honours OpenAPI 3.0.3 §4.8.20.
        $listOrders = $this->methodSlice('listOrders');
        TestCase::assertStringContainsString("->header('X-API-Key', \$this->apiKey)", $listOrders);

        $getPetById = $this->methodSlice('getPetById');
        TestCase::assertStringNotContainsString('X-API-Key', $getPetById);
        TestCase::assertStringNotContainsString('$this->apiKey', $getPetById);

        // Live round-trip proof via RecordingClient: the generated client
        // really attaches the header when the transport sends the request.
        $http = new RecordingClient(
            new Response(200, ['Content-Type' => 'application/json'], '[]'),
        );

        $this->parametersClient($http, 'secret-key', 'unused-here')->listOrders();
        TestCase::assertNotNull($http->lastRequest);
        TestCase::assertSame('secret-key', $http->lastRequest->getHeaderLine('X-API-Key'));
    }


    public function thenClientsPlaceOrderMethodBodyAttachesHeaderAuthorizationBearerThisBearerTokenToTheRequestItBuildsAndPassesItToThisTransportSend(
    ): void {
        $body = $this->methodSlice('placeOrder');
        TestCase::assertStringContainsString(
            "->header('Authorization', 'Bearer ' . \$this->bearerToken)",
            $body,
        );
        // Bearer replaces (not augments) the inherited apiKey on placeOrder.
        TestCase::assertStringNotContainsString('X-API-Key', $body);

        // Round-trip via RecordingClient: Authorization header actually
        // reaches the transport, prefixed with the literal "Bearer ".
        $http = new RecordingClient(
            new Response(200, ['Content-Type' => 'application/json'], '{"id":1}'),
        );

        $this->parametersClient($http, 'unused-here', 'tok-abc')->placeOrder(new ParametersOrder(id: 1));

        TestCase::assertNotNull($http->lastRequest);
        TestCase::assertSame('Bearer tok-abc', $http->lastRequest->getHeaderLine('Authorization'));
    }


    public function givenSchemaDeclaresOperationOpWithIdWhose200ResponseContentTypeIsApplicationOctetStream(
        string $op,
        string $id,
    ): void {
        TestCase::assertSame('GET /labels/{id}', $op);
        TestCase::assertSame('operationId: getLabel', $id);

        $schema = $this->writeResponseContentTypeSchema();
        $this->profile = new Profile(
            schema: $schema,
            output: $this->makeScratchOutputDir('paogen-response-content-type-out-'),
            namespace: 'Mlavrinenko\\Paogen\\Tests\\Tmp\\ResponseContentType',
        );
        $this->expectedSkipOperationId = 'getLabel';
        $this->expectedSkipContentType = 'application/octet-stream';
    }


    public function whenGeneratorRunsAgainstUnacceptedProfile(): void
    {
        TestCase::assertNotNull($this->profile);

        // A pristine output directory, so "wrote nothing" is observable.
        $this->abortOutputDir = sys_get_temp_dir() . '/paogen-abort-' . bin2hex(random_bytes(6));
        $unaccepted = $this->profile->with(output: $this->abortOutputDir);

        $this->abortMessage = null;

        try {
            $this->runGenerator($unaccepted);
        } catch (UnrepresentableConstructsException $e) {
            $this->abortMessage = $e->getMessage();
        }
    }



    public function givenSchemaDeclaresOperationOpWithIdWhose200ResponseContentTypeIsApplicationXml(
        string $op,
        string $id,
    ): void {
        TestCase::assertSame('GET /xml-label', $op);
        TestCase::assertSame('operationId: getXmlLabel', $id);

        // Reuses default-deny-on-degradation's shared fixture rather than
        // writing another ad-hoc schema — xml-response-outcome's fixture,
        // since neither committed corpus declares an application/xml
        // response.
        $this->profile = new Profile(
            schema: dirname(__DIR__, 2) . '/tests/fixtures/schemas/response-degradation-3.0.yaml',
            output: $this->makeScratchOutputDir('paogen-xml-response-out-'),
            namespace: 'Mlavrinenko\\Paogen\\Tests\\Tmp\\XmlResponse',
        );
        $this->expectedSkipOperationId = 'getXmlLabel';
        $this->expectedSkipContentType = 'application/xml';
    }


    public function thenGeneratorDoesNotDecodeTheXMLBodyOrPassItThroughRawSeeDecisionsXmlResponsesRefusedAtGenerationTimeDecision260801Typ(
    ): void {
        $message = (string) $this->abortMessage;

        // Refusal, not a silent void and not a raw-body passthrough — the
        // diagnostic names the decision that governs, so a reader cannot
        // mistake this for "XML worked but came back untyped".
        TestCase::assertStringContainsString('refuses an XML response at generation time', $message);
        TestCase::assertDirectoryDoesNotExist($this->abortOutputDir . '/Generated');
    }


    public function givenSchemaDeclaresOperationOpWithIdWhoseResponsesIncludeStatusCodeWithNoBody(
        string $op,
        string $id,
        int $code,
    ): void {
        TestCase::assertSame('GET /pet/{petId}', $op);
        TestCase::assertSame('operationId: getPetById', $id);
        TestCase::assertSame(404, $code);
    }


    public function givenClientIsConstructedWithATransportInterfaceBackedByAPSR18HTTPClientThatReturnsStatusCodeWithAnEmptyBody(
        int $code,
    ): void {
        TestCase::assertSame(404, $code);

        $this->profile = $this->loadProfile('petstore');
        $this->runGenerator($this->profile);

        $this->http = new RecordingClient(
            new Response($code, ['Content-Type' => 'application/json'], ''),
        );
        $this->client = $this->petstoreClient($this->http);
    }


    public function thenCallOnClientDoesNotThrow(): void
    {
        TestCase::assertNull($this->caught);
    }


    public function thenReturnValueIsEnvelopeWhoseStatusIs404AndWhoseBodyIsNull(): void
    {
        TestCase::assertNotNull($this->result);
        TestCase::assertSame(404, $this->result->status);
        TestCase::assertNull($this->result->body);
    }


    public function givenClientIsConstructedWithATransportInterfaceBackedByAPSR18HTTPClientThatReturnsStatusCodeWithABodyThatIsNotValidJSON(
        int $code,
    ): void {
        TestCase::assertSame(200, $code);

        $this->profile = $this->loadProfile('petstore');
        $this->runGenerator($this->profile);

        $this->http = new RecordingClient(
            new Response($code, ['Content-Type' => 'application/json'], 'not json'),
        );
        $this->client = $this->petstoreClient($this->http);
    }


    public function thenClientsExceptionsGetReasonNamesStatus200AndSaysTheDeclaredBodyFailedToHydrate(): void
    {
        TestCase::assertNotNull($this->caught);
        TestCase::assertStringContainsString(
            'declared body for status 200 failed to hydrate',
            $this->caught->getReason(),
        );
    }


    public function givenSchemaDeclaresOperationOpWithIdWhoseResponsesDeclareOnlyStatusCodeNo400No404NoDefault(
        string $op,
        string $id,
        int $code,
    ): void {
        TestCase::assertSame('GET /order', $op);
        TestCase::assertSame('operationId: listOrders', $id);
        TestCase::assertSame(200, $code);
    }


    public function whenListordersIsCalledOnClient(): void
    {
        TestCase::assertNotNull($this->altClient);
        $this->altCaught = null;

        try {
            $this->altClient->listOrders();
        } catch (ParametersApiException $e) {
            $this->altCaught = $e;
        }
    }

}
