<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use PHPUnit\Framework\TestCase;

/**
 * Feature: Operation Generator
 *
 * Walks Schema's paths and emits one method per OpenAPI Operation onto a single Client class. Path parameters appear as typed method parameters; application/json request bodies carry Model payload; response JSON is deserialized back into the typed Model. Client is emitted as a final readonly class whose constructor takes a PSR-18 ClientInterface together with PSR-17 request and stream factories, and a base URI string.
 */
final class OperationGeneratorTest extends TestCase
{
    private OperationGeneratorSteps $steps;


    protected function setUp(): void
    {
        $this->steps = new OperationGeneratorSteps($this);
    }


    /**
     * Rule: Emitting operations as client methods
     *
     * Scenario: A GET operation with a path parameter becomes a typed client method
     * @source truth/specs/operation-generator.typ:27
     *
     * Given Schema declares Operation GET /store/order/{orderId} with operationId: getOrderById and path parameter orderId: integer
     * When Generator runs against Profile
     * Then a file Generated/ApiClient.php is written under Profile's output
     *   And the emitted class is final readonly in Profile's namespace \Generated
     *   And the class has a method getOrderById(int $orderId): Order that interpolates {orderId} into the request path
     */
    public function testAGETOperationWithAPathParameterBecomesATypedClientMethod(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdAndPathParameterParam('GET /store/order/{orderId}', 'operationId: getOrderById', 'orderId: integer');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenAFileGeneratedApiClientPhpIsWrittenUnderProfilesOutput();
        $this->steps->thenTheEmittedClassIsFinalReadonlyInProfilesNamespaceGenerated();
        $this->steps->thenTheClassHasAMethodGetOrderByIdIntOrderIdOrderThatInterpolatesTokenIntoTheRequestPath('{orderId}');
    }


    /**
     * Scenario: A POST operation with a JSON body takes a typed Model parameter
     * @source truth/specs/operation-generator.typ:39
     *
     * Given Schema declares Operation POST /pet with operationId: addPet
     *   And the request body is application/json with schema #/components/schemas/Pet
     * When Generator runs against Profile
     * Then the emitted Client has a method addPet(Pet $body): Pet
     *   And the method JSON-encodes $body and attaches it as the request body
     */
    public function testAPOSTOperationWithAJSONBodyTakesATypedModelParameter(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithId('POST /pet', 'operationId: addPet');
        $this->steps->givenTheRequestBodyIsApplicationJsonWithSchemaRef('#/components/schemas/Pet');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodAddPetPetBodyPet();
        $this->steps->thenTheMethodJSONEncodesBodyAndAttachesItAsTheRequestBody();
    }


    /**
     * Rule: Response deserialization
     *
     * Scenario: A 2xx JSON response body is deserialized into the typed Model
     * @source truth/specs/operation-generator.typ:53
     *
     * Given Client is constructed with a PSR-18 HTTP client that returns status 200 with JSON body {"id":42,"status":"placed"}
     * When getOrderById(42) is called on Client
     * Then the return value is Model Order with id = 42 and status = 'placed'
     */
    public function testA2xxJSONResponseBodyIsDeserializedIntoTheTypedModel(): void
    {
        $this->steps->givenClientIsConstructedWithAPSR18HTTPClientThatReturnsStatusCodeWithJSONBodyBody(200, '{\"id\":42,\"status\":\"placed\"}');
        $this->steps->whenGetorderbyid42IsCalledOnClient();
        $this->steps->thenTheReturnValueIsModelOrderWithId42AndStatusPlaced();
    }


    /**
     * Rule: Query parameters
     *
     * Scenario: Query parameters become typed method parameters and are attached as a query string
     * @source truth/specs/operation-generator.typ:65
     *
     * Given Schema declares Operation GET /pet/findByStatus with operationId: findPetsByStatus and a required query parameter status: string
     * When Generator runs against Profile
     * Then the emitted Client has a method with signature findPetsByStatus(string $status): array
     *   And calling it with status: 'available' sends a request whose URI ends with ?status=available
     */
    public function testQueryParametersBecomeTypedMethodParametersAndAreAttachedAsAQueryString(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdAndARequiredQueryParameterParam('GET /pet/findByStatus', 'operationId: findPetsByStatus', 'status: string');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodWithSignatureFindPetsByStatusStringStatusArray();
        $this->steps->thenCallingItWithArgSendsARequestWhoseURIEndsWithQuery('status: \'available\'', '?status=available');
    }
}
