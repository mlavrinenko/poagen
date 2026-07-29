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
     * @source truth/specs/operation-generator.typ:38
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
     * @source truth/specs/operation-generator.typ:49
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
     * Scenario: A JSON body whose schema is a list of $ref becomes a typed list parameter
     * @source truth/specs/operation-generator.typ:61
     *
     * Given Schema declares Operation POST /user/createWithList with operationId: createUsersWithListInput
     *   And the request body is application/json with schema type: array and items #/components/schemas/User
     * When Generator runs against Profile
     * Then the emitted Client has a method createUsersWithListInput(array $body) whose $body parameter is annotated @param list<User> $body
     *   And the method JSON-encodes $body and attaches it as the request body
     */
    public function testAJSONBodyWhoseSchemaIsAListOfRefBecomesATypedListParameter(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithId('POST /user/createWithList', 'operationId: createUsersWithListInput');
        $this->steps->givenTheRequestBodyIsApplicationJsonWithSchemaTypeArrayAndItemsRef('#/components/schemas/User');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodCreateUsersWithListInputArrayBodyWhoseBodyParameterIsAnnotatedParamListUserBody();
        $this->steps->thenTheMethodJSONEncodesBodyAndAttachesItAsTheRequestBody();
    }


    /**
     * Rule: Response deserialization
     *
     * Scenario: A 2xx JSON response body is deserialized into the typed Model
     * @source truth/specs/operation-generator.typ:75
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
     * Scenario: A scalar 2xx JSON response is returned as the scalar PHP type without hydration
     * @source truth/specs/operation-generator.typ:84
     *
     * Given Schema declares Operation GET /user/login with operationId: loginUser whose 200 response schema is type: string
     * When Generator runs against Profile
     * Then the emitted Client has a method whose return type is string
     *   And the method body returns (string) $response->getBody() and never invokes self::hydrate
     */
    public function testAScalar2xxJSONResponseIsReturnedAsTheScalarPHPTypeWithoutHydration(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdWhose200ResponseSchemaIsTypeString('GET /user/login', 'operationId: loginUser');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodWhoseReturnTypeIsString();
        $this->steps->thenTheMethodBodyReturnsStringResponseGetBodyAndNeverInvokesSelfHydrate();
    }


    /**
     * Scenario: A 2xx JSON response with `additionalProperties` is returned as a typed associative array
     * @source truth/specs/operation-generator.typ:94
     *
     * Given Schema declares Operation GET /store/inventory with operationId: getInventory whose 200 response schema is type: object with additionalProperties: integer
     * When Generator runs against Profile
     * Then the emitted Client has a method whose return type is array annotated @return array<string, int>
     *   And the method body returns the json_decoded payload directly without invoking self::hydrate
     */
    public function testA2xxJSONResponseWithAdditionalPropertiesIsReturnedAsATypedAssociativeArray(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdWhose200ResponseSchemaIsTypeObjectWithMap('GET /store/inventory', 'operationId: getInventory', 'additionalProperties: integer');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodWhoseReturnTypeIsArrayAnnotatedReturnArrayStringInt();
        $this->steps->thenTheMethodBodyReturnsTheJsonDecodedPayloadDirectlyWithoutInvokingSelfHydrate();
    }


    /**
     * Rule: Query parameters
     *
     * Scenario: An inline enum query parameter becomes a synthesised backed enum method argument
     * @source truth/specs/operation-generator.typ:106
     *
     * Given Schema declares Operation GET /pet/findByStatus with operationId: findPetsByStatus and a required query parameter status whose schema is type: string with [available, pending, sold]
     * When Generator runs against Profile
     * Then a file Generated/Enum/FindPetsByStatusStatus.php is written and the emitted Client has a method findPetsByStatus(FindPetsByStatusStatus $status): array
     *   And calling it with status: FindPetsByStatusStatus::Available sends a request whose URI ends with ?status=available
     */
    public function testAnInlineEnumQueryParameterBecomesASynthesisedBackedEnumMethodArgument(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdAndARequiredQueryParameterStatusWhoseSchemaIsTypeStringWithEnum('GET /pet/findByStatus', 'operationId: findPetsByStatus', '[available, pending, sold]');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenAFileGeneratedEnumFindPetsByStatusStatusPhpIsWrittenAndTheEmittedClientHasAMethodFindPetsByStatusFindPetsByStatusStatusStatusArray();
        $this->steps->thenCallingItWithArgSendsARequestWhoseURIEndsWithQuery('status: FindPetsByStatusStatus::Available', '?status=available');
    }


    /**
     * Scenario: An `explode: true` array query parameter is serialised as repeated `name=value` pairs
     * @source truth/specs/operation-generator.typ:120
     *
     * Given Schema declares Operation GET /pet/findByTags with operationId: findPetsByTags and a required query parameter tags type: array, items.type: string, explode: true
     * When Generator runs against Profile
     * Then the emitted Client has a method findPetsByTags(array $tags): array annotated @param list<string> $tags
     *   And calling it with tags: ['a', 'b'] sends a request whose URI ends with ?tags=a&tags=b instead of tags%5B0%5D=a&tags%5B1%5D=b
     */
    public function testAnExplodeTrueArrayQueryParameterIsSerialisedAsRepeatedNameValuePairs(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdAndARequiredQueryParameterTagsSchema('GET /pet/findByTags', 'operationId: findPetsByTags', 'type: array, items.type: string, explode: true');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodFindPetsByTagsArrayTagsArrayAnnotatedParamListStringTags();
        $this->steps->thenCallingItWithArgSendsARequestWhoseURIEndsWithQueryInsteadOfTags5B05DATags5B15DB('tags: [\'a\', \'b\']', '?tags=a&tags=b');
    }


    /**
     * Rule: Header parameters
     *
     * Scenario: An optional header parameter becomes a nullable typed argument and is attached only when non-null
     * @source truth/specs/operation-generator.typ:132
     *
     * Given Schema declares Operation DELETE /pet/{petId} with operationId: deletePet and an optional header parameter api_key: string
     * When Generator runs against Profile
     * Then the emitted Client has a method deletePet(int $petId, ?string $api_key = null): void
     *   And the method calls $request->withHeader('api_key', $api_key) only when $api_key is not null
     */
    public function testAnOptionalHeaderParameterBecomesANullableTypedArgumentAndIsAttachedOnlyWhenNonNull(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdAndAnOptionalHeaderParameterApiKeyString('DELETE /pet/{petId}', 'operationId: deletePet');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodDeletePetIntPetIdStringApiKeyNullVoid();
        $this->steps->thenTheMethodCallsRequestWithHeaderApiKeyApiKeyOnlyWhenApiKeyIsNotNull();
    }


    /**
     * Rule: Identifier normalisation
     *
     * Scenario: A header parameter whose raw name is not a PHP identifier is normalised but the wire key is preserved
     * @source truth/specs/operation-generator.typ:144
     *
     * Given Schema declares Operation POST /proxy with an optional header parameter named Content-Type
     * When Generator runs against Profile
     * Then the emitted method takes a ?string $contentType = null argument
     *   And the method body attaches the header with the original wire key Content-Type (not contentType)
     */
    public function testAHeaderParameterWhoseRawNameIsNotAPHPIdentifierIsNormalisedButTheWireKeyIsPreserved(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithAnOptionalHeaderParameterNamedContentType('POST /proxy');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedMethodTakesAStringContentTypeNullArgument();
        $this->steps->thenTheMethodBodyAttachesTheHeaderWithTheOriginalWireKeyContentTypeNotContentType();
    }


    /**
     * Scenario: An operationId with non-identifier characters is camelCased into a PHP method name
     * @source truth/specs/operation-generator.typ:159
     *
     * Given Schema declares Operation POST /proxy with operationId: monitoring_get_foo.yml
     * When Generator runs against Profile
     * Then the emitted Client has a method monitoringGetFooYml(...)
     *   And the operation is not silently skipped even though the raw operationId contains a .
     */
    public function testAnOperationIdWithNonIdentifierCharactersIsCamelCasedIntoAPHPMethodName(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithId('POST /proxy', 'operationId: monitoring_get_foo.yml');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodMonitoringGetFooYml();
        $this->steps->thenTheOperationIsNotSilentlySkippedEvenThoughTheRawOperationIdContainsA();
    }


    /**
     * Scenario: Profile.renames overrides an operationId verbatim
     * @source truth/specs/operation-generator.typ:173
     *
     * Given a Profile whose renames map carries 'monitoring_get_foo.yml' => 'forwardProxyRequest'
     * When Generator runs against Profile
     * Then the emitted Client has a method forwardProxyRequest(...) instead of the auto-sanitised monitoringGetFooYml
     */
    public function testProfileRenamesOverridesAnOperationIdVerbatim(): void
    {
        $this->steps->givenAProfileWhoseRenamesMapCarriesMonitoringGetFooYmlForwardProxyRequest();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodForwardProxyRequestInsteadOfTheAutoSanitisedMonitoringGetFooYml();
    }


    /**
     * Scenario: An operation whose body shape is unsupported is reported as a skip rather than dropped silently
     * @source truth/specs/operation-generator.typ:186
     *
     * Given Schema declares Operation operationId: postInlineBody whose application/json request body is an inline type: object (not a $ref) — a shape paogen does not yet synthesise
     * When Generator runs against Profile
     * Then the resulting GenerationPlan carries a skippedOperations entry naming the HTTP method, path, operationId and the reason for the skip
     *   And paogen generate prints the same list to stderr so the user knows which ops did not make it into the client
     */
    public function testAnOperationWhoseBodyShapeIsUnsupportedIsReportedAsASkipRatherThanDroppedSilently(): void
    {
        $this->steps->givenSchemaDeclaresOperationIdWhoseApplicationJsonRequestBodyIsAnInlineTypeObjectNotARefAShapePaogenDoesNotYetSynthesise('operationId: postInlineBody');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheResultingGenerationPlanCarriesASkippedOperationsEntryNamingTheHTTPMethodPathOperationIdAndTheReasonForTheSkip();
        $this->steps->thenPaogenGeneratePrintsTheSameListToStderrSoTheUserKnowsWhichOpsDidNotMakeItIntoTheClient();
    }


    /**
     * Rule: Reference resolution and path-level parameters
     *
     * Scenario: An operation-level `$ref` to a component parameter is resolved to a typed method argument
     * @source truth/specs/operation-generator.typ:203
     *
     * Given Schema declares #/components/parameters/Limit limit: integer, in: query, required: false
     *   And Operation GET /order with operationId: listOrders lists a parameter whose value is #/components/parameters/Limit
     * When Generator runs against Profile
     * Then the emitted Client has a method listOrders(?int $limit = null): array
     *   And the operation is not silently skipped even though the parameter is a $ref
     */
    public function testAnOperationLevelRefToAComponentParameterIsResolvedToATypedMethodArgument(): void
    {
        $this->steps->givenSchemaDeclaresComponentsParametersLimitParam('limit: integer, in: query, required: false');
        $this->steps->givenOperationOpWithIdListsAParameterWhoseValueIsRef('GET /order', 'operationId: listOrders', '#/components/parameters/Limit');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodListOrdersIntLimitNullArray();
        $this->steps->thenTheOperationIsNotSilentlySkippedEvenThoughTheParameterIsARef();
    }


    /**
     * Scenario: An operation-level `$ref` to a header component parameter becomes an optional typed header argument
     * @source truth/specs/operation-generator.typ:214
     *
     * Given Schema declares #/components/parameters/ApiKey api_key: string, in: header, required: false
     *   And Operation GET /order with operationId: listOrders lists a parameter whose value is #/components/parameters/ApiKey
     * When Generator runs against Profile
     * Then the emitted method signature includes ?string $api_key = null
     *   And the method body attaches the api_key header only when $api_key is not null
     */
    public function testAnOperationLevelRefToAHeaderComponentParameterBecomesAnOptionalTypedHeaderArgument(): void
    {
        $this->steps->givenSchemaDeclaresComponentsParametersApiKeyParam('api_key: string, in: header, required: false');
        $this->steps->givenOperationOpWithIdListsAParameterWhoseValueIsRef('GET /order', 'operationId: listOrders', '#/components/parameters/ApiKey');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedMethodSignatureIncludesStringApiKeyNull();
        $this->steps->thenTheMethodBodyAttachesTheApiKeyHeaderOnlyWhenApiKeyIsNotNull();
    }


    /**
     * Scenario: A `$ref` to a component requestBody is resolved to the expected Model body parameter
     * @source truth/specs/operation-generator.typ:225
     *
     * Given Schema declares #/components/requestBodies/CreateOrder with application/json schema #/components/schemas/Order
     *   And Operation POST /order with operationId: placeOrder whose requestBody is a #/components/requestBodies/CreateOrder
     * When Generator runs against Profile
     * Then the emitted Client has a method placeOrder(Order $body): Order
     *   And the operation is not silently skipped even though the request body is declared via $ref
     */
    public function testARefToAComponentRequestBodyIsResolvedToTheExpectedModelBodyParameter(): void
    {
        $this->steps->givenSchemaDeclaresComponentsRequestBodiesCreateOrderWithApplicationJsonSchemaRef('#/components/schemas/Order');
        $this->steps->givenOperationOpWithIdWhoseRequestBodyIsARef('POST /order', 'operationId: placeOrder', '#/components/requestBodies/CreateOrder');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodPlaceOrderOrderBodyOrder();
        $this->steps->thenTheOperationIsNotSilentlySkippedEvenThoughTheRequestBodyIsDeclaredViaRef();
    }


    /**
     * Scenario: A PathItem-level inline parameter is inherited by every operation under that path
     * @source truth/specs/operation-generator.typ:237
     *
     * Given Schema declares a PathItem /store/{storeId}/items with a single PathItem-level parameter storeId: integer, in: path, required: true
     *   And two operations under it — operationId: listStoreItems and operationId: clearStore — do not restate the parameter
     * When Generator runs against Profile
     * Then the emitted Client has listStoreItems(int $storeId): array and clearStore(int $storeId): void
     *   And neither operation is silently skipped even though the parameter lives only on the PathItem
     */
    public function testAPathItemLevelInlineParameterIsInheritedByEveryOperationUnderThatPath(): void
    {
        $this->steps->givenSchemaDeclaresAPathItemStoreStoreIdItemsWithASinglePathItemLevelParameterParam('storeId: integer, in: path, required: true');
        $this->steps->givenTwoOperationsUnderItIdAndIdDoNotRestateTheParameter('operationId: listStoreItems', 'operationId: clearStore');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasListStoreItemsIntStoreIdArrayAndClearStoreIntStoreIdVoid();
        $this->steps->thenNeitherOperationIsSilentlySkippedEvenThoughTheParameterLivesOnlyOnThePathItem();
    }


    /**
     * Scenario: An operation whose PathItem declares a `$ref` parameter is still emitted
     * @source truth/specs/operation-generator.typ:248
     *
     * Given Schema declares #/components/parameters/PetId petId: integer, in: path, required: true
     *   And Operation GET /pet/{petId} with operationId: getPetById inherits a PathItem-level parameter whose value is #/components/parameters/PetId
     * When Generator runs against Profile
     * Then the emitted Client has a method getPetById(int $petId): Pet
     *   And the operation is not silently skipped even though the parameter is declared at the PathItem level via $ref
     */
    public function testAnOperationWhosePathItemDeclaresARefParameterIsStillEmitted(): void
    {
        $this->steps->givenSchemaDeclaresComponentsParametersPetIdParam('petId: integer, in: path, required: true');
        $this->steps->givenOperationOpWithIdInheritsAPathItemLevelParameterWhoseValueIsRef('GET /pet/{petId}', 'operationId: getPetById', '#/components/parameters/PetId');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodGetPetByIdIntPetIdPet();
        $this->steps->thenTheOperationIsNotSilentlySkippedEvenThoughTheParameterIsDeclaredAtThePathItemLevelViaRef();
    }


    /**
     * Scenario: A path parameter whose schema $refs a scalar-VO component is interpolated through toScalar()
     * @source truth/specs/operation-generator.typ:259
     *
     * Given Schema declares #/components/schemas/SshKeyId as type: integer
     *   And Operation GET /keys/{ssh_key_id} with operationId: getSshKeyById and a path parameter ssh_key_id whose schema is #/components/schemas/SshKeyId
     * When Generator runs against Profile
     * Then the emitted method body interpolates the path token via (string) $ssh_key_id->toScalar(), not (string) $ssh_key_id
     *   And the operation is not silently skipped even though the path parameter resolves to a ScalarBinding-implementing class
     */
    public function testAPathParameterWhoseSchemaRefsAScalarVOComponentIsInterpolatedThroughToScalar(): void
    {
        $this->steps->givenSchemaDeclaresComponentsSchemasSshKeyIdAsSchema('type: integer');
        $this->steps->givenOperationOpWithIdAndAPathParameterSshKeyIdWhoseSchemaIsRef('GET /keys/{ssh_key_id}', 'operationId: getSshKeyById', '#/components/schemas/SshKeyId');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedMethodBodyInterpolatesThePathTokenViaStringSshKeyIdToScalarNotStringSshKeyId();
        $this->steps->thenTheOperationIsNotSilentlySkippedEvenThoughThePathParameterResolvesToAScalarBindingImplementingClass();
    }


    /**
     * Rule: Non-JSON request bodies
     *
     * Scenario: A form-urlencoded body becomes typed params serialised with http_build_query
     * @source truth/specs/operation-generator.typ:277
     *
     * Given Schema declares Operation POST /token with operationId: issueToken whose sole request-body content type is application/x-www-form-urlencoded and whose schema is type: object with grantType: string, clientId: string, scope: string and [grantType, clientId]
     * When Generator runs against Profile
     * Then the emitted Client has a method issueToken(string $grantType, string $clientId, ?string $scope = null): void with one method parameter per declared property
     *   And the method body assembles the request body with http_build_query([...]) and sends Content-Type: application/x-www-form-urlencoded
     *   And calling it through a PSR-18 recording client records a request whose body contains grantType=password and clientId=my-app pairs
     */
    public function testAFormUrlencodedBodyBecomesTypedParamsSerialisedWithHttpBuildQuery(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdWhoseSoleRequestBodyContentTypeIsApplicationXWwwFormUrlencodedAndWhoseSchemaIsTypeObjectWithPropsAndRequired('POST /token', 'operationId: issueToken', 'grantType: string, clientId: string, scope: string', '[grantType, clientId]');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasAMethodIssueTokenStringGrantTypeStringClientIdStringScopeNullVoidWithOneMethodParameterPerDeclaredProperty();
        $this->steps->thenTheMethodBodyAssemblesTheRequestBodyWithHttpBuildQueryAndSendsContentTypeApplicationXWwwFormUrlencoded();
        $this->steps->thenCallingItThroughAPSR18RecordingClientRecordsARequestWhoseBodyContainsGrantTypePasswordAndClientIdMyAppPairs();
    }


    /**
     * Scenario: An unsupported body content type aborts the run
     * @source truth/specs/operation-generator.feature-260418.typ:241
     *
     * Given Schema declares Operation POST /pet/{petId}/uploadImage with operationId: uploadFile whose request body content type is application/octet-stream
     * When Generator runs against Profile declaring no skip entry for that Operation
     * Then Generator's run fails and emits no GeneratedFile
     *   And Generator's report names the operationId, the unsupported content type, and the remedy
     */
    public function testAnUnsupportedBodyContentTypeAbortsTheRun(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdWhoseRequestBodyContentTypeIsApplicationOctetStream('POST /pet/{petId}/uploadImage', 'operationId: uploadFile');
        $this->steps->whenGeneratorRunsAgainstProfileDeclaringNoSkipEntryForThatOperation();
        $this->steps->thenTheGeneratorsRunFailsAndEmitsNoGeneratedFile();
        $this->steps->thenTheGeneratorsReportNamesTheOperationIdTheUnsupportedContentTypeAndTheRemedy();
    }

    /**
     * Scenario: An explicitly skipped operation is omitted rather than stubbed
     * @source truth/specs/operation-generator.feature-260418.typ:249
     *
     * Given Schema declares Operation POST /pet/{petId}/uploadImage with operationId: uploadFile whose request body content type is application/octet-stream
     *   And Profile declares a skip entry for that Operation carrying a reason
     * When Generator runs against Profile
     * Then the emitted Client has no uploadFile method at all
     *   And no GeneratedFile contains a method that throws on an unsupported content type
     */
    public function testAnExplicitlySkippedOperationIsOmittedRatherThanStubbed(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdWhoseRequestBodyContentTypeIsApplicationOctetStream('POST /pet/{petId}/uploadImage', 'operationId: uploadFile');
        $this->steps->givenTheProfileDeclaresASkipEntryForThatOperationCarryingAReason();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedClientHasNoUploadFileMethodAtAll();
        $this->steps->thenNoGeneratedFileContainsAMethodThatThrowsOnAnUnsupportedContentType();
    }


    /**
     * Rule: Error responses
     *
     * Scenario: A non-2xx response throws a typed ApiException instead of a generic RuntimeException
     * @source truth/specs/operation-generator.typ:312
     *
     * Given Client is constructed with a PSR-18 HTTP client that returns status 404 with JSON body {"message":"not found"}
     * When getPetById(999) is called on Client
     * Then the call throws Generated\\ApiException
     *   And the exception's getStatusCode() returns 404
     *   And the exception's getDecodedBody() returns the decoded error payload
     */
    public function testANon2xxResponseThrowsATypedApiExceptionInsteadOfAGenericRuntimeException(): void
    {
        $this->steps->givenClientIsConstructedWithAPSR18HTTPClientThatReturnsStatusCodeWithJSONBodyBody(404, '{\"message\":\"not found\"}');
        $this->steps->whenGetpetbyid999IsCalledOnClient();
        $this->steps->thenTheCallThrowsGeneratedApiException();
        $this->steps->thenTheExceptionsGetStatusCodeReturns404();
        $this->steps->thenTheExceptionsGetDecodedBodyReturnsTheDecodedErrorPayload();
    }


    /**
     * Rule: Security schemes
     *
     * Scenario: An apiKey header scheme becomes a constructor arg attached as a header on secured ops
     * @source truth/specs/operation-generator.typ:328
     *
     * Given Schema declares #/components/securitySchemes/apiKey with type: apiKey, in: header, name: X-API-Key
     *   And a top-level security: [{ apiKey: [] }] makes every operation secured by default
     * When Generator runs against Profile
     * Then the emitted ApiClient constructor has a required string $apiKey promoted private argument placed after $baseUri
     *   And each secured operation's method body calls $request = $request->withHeader('X-API-Key', $this->apiKey); before sendRequest
     */
    public function testAnApiKeyHeaderSchemeBecomesAConstructorArgAttachedAsAHeaderOnSecuredOps(): void
    {
        $this->steps->givenSchemaDeclaresComponentsSecuritySchemesApiKeyWithScheme('type: apiKey, in: header, name: X-API-Key');
        $this->steps->givenATopLevelSecurityApiKeyMakesEveryOperationSecuredByDefault();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedApiClientConstructorHasARequiredStringApiKeyPromotedPrivateArgumentPlacedAfterBaseUri();
        $this->steps->thenEachSecuredOperationsMethodBodyCallsRequestRequestWithHeaderXAPIKeyThisApiKeyBeforeSendRequest();
    }


    /**
     * Scenario: An http bearer scheme becomes a $bearerToken ctor arg attached as Authorization
     * @source truth/specs/operation-generator.typ:343
     *
     * Given Schema declares #/components/securitySchemes/bearerAuth with type: http, scheme: bearer
     *   And an operation operationId: placeOrder overrides the default with operation-level security: [{ bearerAuth: [] }]
     * When Generator runs against Profile
     * Then the emitted ApiClient constructor has a required string $bearerToken promoted private argument
     *   And placeOrder's method body calls $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken); before sendRequest
     */
    public function testAnHttpBearerSchemeBecomesABearerTokenCtorArgAttachedAsAuthorization(): void
    {
        $this->steps->givenSchemaDeclaresComponentsSecuritySchemesBearerAuthWithScheme('type: http, scheme: bearer');
        $this->steps->givenAnOperationIdOverridesTheDefaultWithOperationLevelSecurityBearerAuth('operationId: placeOrder');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheEmittedApiClientConstructorHasARequiredStringBearerTokenPromotedPrivateArgument();
        $this->steps->thenPlaceordersMethodBodyCallsRequestRequestWithHeaderAuthorizationBearerThisBearerTokenBeforeSendRequest();
    }


    /**
     * Scenario: An http basic scheme is left as a placeholder pending ADR-002 runtime design
     * @source truth/specs/operation-generator.typ:358
     *
     * Given Schema declares a scheme with type: http, scheme: basic
     * When Generator runs against Profile
     * Then the operation generator must not surface the scheme yet — design deferred to the decorator-layer runtime per ADR-002
     */
    #[\PHPUnit\Framework\Attributes\DoesNotPerformAssertions]
    public function testAnHttpBasicSchemeIsLeftAsAPlaceholderPendingADR002RuntimeDesign(): void
    {
        $this->markTestIncomplete('Scenario is draft');
    }


    /**
     * Scenario: An oauth2 scheme is left as a placeholder pending ADR-002 runtime design
     * @source truth/specs/operation-generator.typ:367
     *
     * Given Schema declares a scheme with type: oauth2, flows: { clientCredentials: ... }
     * When Generator runs against Profile
     * Then the operation generator must not surface the scheme yet — design deferred to the decorator-layer runtime per ADR-002
     */
    #[\PHPUnit\Framework\Attributes\DoesNotPerformAssertions]
    public function testAnOauth2SchemeIsLeftAsAPlaceholderPendingADR002RuntimeDesign(): void
    {
        $this->markTestIncomplete('Scenario is draft');
    }
}
