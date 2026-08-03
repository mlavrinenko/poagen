<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use PHPUnit\Framework\TestCase;

/**
 * Feature: Operation Generator
 *
 * Walks Schema's paths and emits one method per OpenAPI Operation onto a single Client class. Path parameters appear as typed method parameters; application/json request bodies carry Model payload; response JSON is deserialized back into the typed Model. Client is emitted as a final readonly class whose constructor takes a TransportInterface together with one argument per credential Schema declares.
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
     * @source truth/specs/operation-generator.feature-260418.typ:21
     *
     * Given Schema declares Operation GET /store/order/{orderId} with operationId: getOrderById and path parameter orderId: integer
     * When Generator runs against Profile
     * Then a file Generated/ApiClient.php is written under Profile's output
     *   And the emitted class is final readonly in Profile's namespace \Generated
     *   And Client has a method getOrderById(int $orderId): Order that interpolates {orderId} into the request path
     */
    public function testAGETOperationWithAPathParameterBecomesATypedClientMethod(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdAndPathParameterParam('GET /store/order/{orderId}', 'operationId: getOrderById', 'orderId: integer');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenFileGeneratedApiClientPhpIsWrittenUnderProfilesOutput();
        $this->steps->thenEmittedClassIsFinalReadonlyInProfilesNamespaceGenerated();
        $this->steps->thenClientHasAMethodGetOrderByIdIntOrderIdOrderThatInterpolatesTokenIntoTheRequestPath('{orderId}');
    }


    /**
     * Scenario: A POST operation with a JSON body takes a typed Model parameter
     * @source truth/specs/operation-generator.feature-260418.typ:32
     *
     * Given Schema declares Operation POST /pet with operationId: addPet
     *   And Operation's request body is application/json with schema #/components/schemas/Pet
     * When Generator runs against Profile
     * Then the emitted Client has a method addPet(Pet $body): Pet
     *   And Client's method JSON-encodes $body and attaches it as the request body
     */
    public function testAPOSTOperationWithAJSONBodyTakesATypedModelParameter(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithId('POST /pet', 'operationId: addPet');
        $this->steps->givenOperationsRequestBodyIsApplicationJsonWithSchemaRef('#/components/schemas/Pet');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasAMethodAddPetPetBodyPet();
        $this->steps->thenClientsMethodJSONEncodesBodyAndAttachesItAsTheRequestBody();
    }


    /**
     * Scenario: A JSON body whose schema is a list of $ref becomes a typed list parameter
     * @source truth/specs/operation-generator.feature-260418.typ:43
     *
     * Given Schema declares Operation POST /user/createWithList with operationId: createUsersWithListInput
     *   And Operation's request body is application/json with schema type: array and items #/components/schemas/User
     * When Generator runs against Profile
     * Then the emitted Client has a method createUsersWithListInput(array $body) whose $body parameter is annotated @param list<User> $body
     *   And Client's method JSON-encodes $body and attaches it as the request body
     */
    public function testAJSONBodyWhoseSchemaIsAListOfRefBecomesATypedListParameter(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithId('POST /user/createWithList', 'operationId: createUsersWithListInput');
        $this->steps->givenOperationsRequestBodyIsApplicationJsonWithSchemaTypeArrayAndItemsRef('#/components/schemas/User');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasAMethodCreateUsersWithListInputArrayBodyWhoseBodyParameterIsAnnotatedParamListUserBody();
        $this->steps->thenClientsMethodJSONEncodesBodyAndAttachesItAsTheRequestBody();
    }


    /**
     * Rule: Response deserialization
     *
     * Scenario: A 2xx JSON response body is deserialized into the typed Model
     * @source truth/specs/operation-generator.feature-260418.typ:56
     *
     * Given Client is constructed with a TransportInterface backed by a PSR-18 HTTP client that returns status 200 with JSON body {"id":42,"status":"placed"}
     * When getOrderById(42) is called on Client
     * Then the return value is Model Order with id = 42 and status = 'placed'
     */
    public function testA2xxJSONResponseBodyIsDeserializedIntoTheTypedModel(): void
    {
        $this->steps->givenClientIsConstructedWithATransportInterfaceBackedByAPSR18HTTPClientThatReturnsStatusCodeWithJSONBodyBody(200, '{\"id\":42,\"status\":\"placed\"}');
        $this->steps->whenGetorderbyid42IsCalledOnClient();
        $this->steps->thenReturnValueIsModelOrderWithId42AndStatusPlaced();
    }


    /**
     * Scenario: A scalar 2xx JSON response is returned as the scalar PHP type without hydration
     * @source truth/specs/operation-generator.feature-260418.typ:65
     *
     * Given Schema declares Operation GET /user/login with operationId: loginUser whose 200 response schema is type: string
     * When Generator runs against Profile
     * Then the emitted Client has a method whose return type is string
     *   And Client's method body names the response shape ResponseType::string(), so the transport reads the body as a scalar instead of hydrating it into a Model
     */
    public function testAScalar2xxJSONResponseIsReturnedAsTheScalarPHPTypeWithoutHydration(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdWhose200ResponseSchemaIsTypeString('GET /user/login', 'operationId: loginUser');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasAMethodWhoseReturnTypeIsString();
        $this->steps->thenClientsMethodBodyNamesTheResponseShapeResponseTypeStringSoTheTransportReadsTheBodyAsAScalarInsteadOfHydratingItIntoAModel();
    }


    /**
     * Scenario: A 2xx JSON response with `additionalProperties` is returned as a typed associative array
     * @source truth/specs/operation-generator.feature-260418.typ:75
     *
     * Given Schema declares Operation GET /store/inventory with operationId: getInventory whose 200 response schema is type: object with additionalProperties: integer
     * When Generator runs against Profile
     * Then the emitted Client has a method whose return type is array annotated @return array<string, int>
     *   And Client's method body names the response shape ResponseType::mapOf(ResponseType::int()), so the transport decodes the payload directly instead of hydrating it into a Model
     */
    public function testA2xxJSONResponseWithAdditionalPropertiesIsReturnedAsATypedAssociativeArray(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdWhose200ResponseSchemaIsTypeObjectWithMap('GET /store/inventory', 'operationId: getInventory', 'additionalProperties: integer');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasAMethodWhoseReturnTypeIsArrayAnnotatedReturnArrayStringInt();
        $this->steps->thenClientsMethodBodyNamesTheResponseShapeResponseTypeMapOfResponseTypeIntSoTheTransportDecodesThePayloadDirectlyInsteadOfHydratingItIntoAModel();
    }


    /**
     * Rule: Non-JSON response bodies
     *
     * Scenario: A response declaring an unsupported content type aborts the run
     * @source truth/specs/operation-generator.feature-260418.typ:87
     *
     * Given Schema declares Operation GET /labels/{id} with operationId: getLabel whose 200 response content type is application/octet-stream
     * When Generator runs against unaccepted Profile
     * Then Generator's run fails and emits no Generated File
     *   And Generator's report names the operationId, the unsupported content type, and the remedy
     */
    public function testAResponseDeclaringAnUnsupportedContentTypeAbortsTheRun(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdWhose200ResponseContentTypeIsApplicationOctetStream('GET /labels/{id}', 'operationId: getLabel');
        $this->steps->whenGeneratorRunsAgainstUnacceptedProfile();
        $this->steps->thenGeneratorsRunFailsAndEmitsNoGeneratedFile();
        $this->steps->thenGeneratorsReportNamesTheOperationIdTheUnsupportedContentTypeAndTheRemedy();
    }


    /**
     * Scenario: An application/xml response aborts the run the same way any other non-JSON response does
     * @source truth/specs/operation-generator.feature-260418.typ:99
     *
     * Given Schema declares Operation GET /xml-label with operationId: getXmlLabel whose 200 response content type is application/xml
     * When Generator runs against unaccepted Profile
     * Then Generator's run fails and emits no Generated File
     *   And Generator's report names the operationId, the unsupported content type, and the remedy
     *   And Generator does not decode the XML body or pass it through raw — see ../decisions/xml-responses-refused-at-generation-time.decision-260801.typ
     */
    public function testAnApplicationXmlResponseAbortsTheRunTheSameWayAnyOtherNonJSONResponseDoes(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdWhose200ResponseContentTypeIsApplicationXml('GET /xml-label', 'operationId: getXmlLabel');
        $this->steps->whenGeneratorRunsAgainstUnacceptedProfile();
        $this->steps->thenGeneratorsRunFailsAndEmitsNoGeneratedFile();
        $this->steps->thenGeneratorsReportNamesTheOperationIdTheUnsupportedContentTypeAndTheRemedy();
        $this->steps->thenGeneratorDoesNotDecodeTheXMLBodyOrPassItThroughRawSeeDecisionsXmlResponsesRefusedAtGenerationTimeDecision260801Typ();
    }


    /**
     * Rule: Query parameters
     *
     * Scenario: An inline enum query parameter becomes a synthesised backed enum method argument
     * @source truth/specs/operation-generator.feature-260418.typ:113
     *
     * Given Schema declares Operation GET /pet/findByStatus with operationId: findPetsByStatus and a required query parameter status whose schema is type: string with [available, pending, sold]
     * When Generator runs against Profile
     * Then a file Generated/Enum/FindPetsByStatusStatus.php is written and the emitted Client has a method findPetsByStatus(FindPetsByStatusStatus $status): array
     *   And calling Client's method with status: FindPetsByStatusStatus::Available sends a request whose URI ends with ?status=available
     */
    public function testAnInlineEnumQueryParameterBecomesASynthesisedBackedEnumMethodArgument(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdAndARequiredQueryParameterStatusWhoseSchemaIsTypeStringWithEnum('GET /pet/findByStatus', 'operationId: findPetsByStatus', '[available, pending, sold]');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenFileGeneratedEnumFindPetsByStatusStatusPhpIsWrittenAndTheEmittedClientHasAMethodFindPetsByStatusFindPetsByStatusStatusStatusArray();
        $this->steps->thenCallingClientsMethodWithArgSendsARequestWhoseURIEndsWithQuery('status: FindPetsByStatusStatus::Available', '?status=available');
    }


    /**
     * Scenario: An `explode: true` array query parameter is serialised as repeated `name=value` pairs
     * @source truth/specs/operation-generator.feature-260418.typ:123
     *
     * Given Schema declares Operation GET /pet/findByTags with operationId: findPetsByTags and a required query parameter tags type: array, items.type: string, explode: true
     * When Generator runs against Profile
     * Then the emitted Client has a method findPetsByTags(array $tags): array annotated @param list<string> $tags
     *   And calling Client's method with tags: ['a', 'b'] sends a request whose URI ends with ?tags=a&tags=b instead of tags%5B0%5D=a&tags%5B1%5D=b
     */
    public function testAnExplodeTrueArrayQueryParameterIsSerialisedAsRepeatedNameValuePairs(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdAndARequiredQueryParameterTagsSchema('GET /pet/findByTags', 'operationId: findPetsByTags', 'type: array, items.type: string, explode: true');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasAMethodFindPetsByTagsArrayTagsArrayAnnotatedParamListStringTags();
        $this->steps->thenCallingClientsMethodWithArgSendsARequestWhoseURIEndsWithQueryInsteadOfTags5B05DATags5B15DB('tags: [\'a\', \'b\']', '?tags=a&tags=b');
    }


    /**
     * Rule: Header parameters
     *
     * Scenario: An optional header parameter becomes a nullable typed argument and is attached only when non-null
     * @source truth/specs/operation-generator.feature-260418.typ:135
     *
     * Given Schema declares Operation DELETE /pet/{petId} with operationId: deletePet and an optional header parameter api_key: string
     * When Generator runs against Profile
     * Then the emitted Client has a method deletePet(int $petId, ?string $apiKey = null): void
     *   And Client's method calls ->header('api_key', $apiKey) unconditionally, with no if in the emitted body — the header is dropped before the request is sent when $apiKey is null
     */
    public function testAnOptionalHeaderParameterBecomesANullableTypedArgumentAndIsAttachedOnlyWhenNonNull(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdAndAnOptionalHeaderParameterApiKeyString('DELETE /pet/{petId}', 'operationId: deletePet');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasAMethodDeletePetIntPetIdStringApiKeyNullVoid();
        $this->steps->thenClientsMethodCallsHeaderApiKeyApiKeyUnconditionallyWithNoIfInTheEmittedBodyTheHeaderIsDroppedBeforeTheRequestIsSentWhenApiKeyIsNull();
    }


    /**
     * Rule: Identifier normalisation
     *
     * Scenario: A header parameter whose raw name is not a PHP identifier is normalised but the wire key is preserved
     * @source truth/specs/operation-generator.feature-260418.typ:147
     *
     * Given Schema declares Operation POST /proxy with an optional header parameter named Content-Type
     * When Generator runs against Profile
     * Then Client's emitted method takes a ?string $contentType = null argument
     *   And Client's method body attaches the header with the original wire key Content-Type (not contentType)
     */
    public function testAHeaderParameterWhoseRawNameIsNotAPHPIdentifierIsNormalisedButTheWireKeyIsPreserved(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithAnOptionalHeaderParameterNamedContentType('POST /proxy');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenClientsEmittedMethodTakesAStringContentTypeNullArgument();
        $this->steps->thenClientsMethodBodyAttachesTheHeaderWithTheOriginalWireKeyContentTypeNotContentType();
    }


    /**
     * Scenario: An operationId with non-identifier characters is camelCased into a PHP method name
     * @source truth/specs/operation-generator.feature-260418.typ:157
     *
     * Given Schema declares Operation POST /proxy with operationId: monitoring_get_foo.yml
     * When Generator runs against Profile
     * Then the emitted Client has a method monitoringGetFooYml(...)
     *   And Operation is not silently skipped even though the raw operationId contains a .
     */
    public function testAnOperationIdWithNonIdentifierCharactersIsCamelCasedIntoAPHPMethodName(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithId('POST /proxy', 'operationId: monitoring_get_foo.yml');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasAMethodMonitoringGetFooYml();
        $this->steps->thenOperationIsNotSilentlySkippedEvenThoughTheRawOperationIdContainsA();
    }


    /**
     * Scenario: Profile.methodRenames overrides an operationId verbatim
     * @source truth/specs/operation-generator.feature-260418.typ:167
     *
     * Given Profile whose methodRenames map carries 'monitoring_get_foo.yml' => 'forwardProxyRequest'
     * When Generator runs against Profile
     * Then the emitted Client has a method forwardProxyRequest(...) instead of the auto-sanitised monitoringGetFooYml
     *   And Profile's renames map does not rename Operation, because it answers a different question — a document may use one string for both a component and an operation, and one map applying to both would put the consumer's answer on the wrong one
     */
    public function testProfileMethodRenamesOverridesAnOperationIdVerbatim(): void
    {
        $this->steps->givenProfileWhoseMethodRenamesMapCarriesMonitoringGetFooYmlForwardProxyRequest();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasAMethodForwardProxyRequestInsteadOfTheAutoSanitisedMonitoringGetFooYml();
        $this->steps->thenProfilesRenamesMapDoesNotRenameOperationBecauseItAnswersADifferentQuestionADocumentMayUseOneStringForBothAComponentAndAnOperationAndOneMapApplyingToBothWouldPutTheConsumersAnswerOnTheWrongOne();
    }


    /**
     * Scenario: An operation whose body shape is unsupported is reported as a skip rather than dropped silently
     * @source truth/specs/operation-generator.feature-260418.typ:177
     *
     * Given Schema declares Operation operationId: createWidget whose request body content type is multipart/form-data, which paogen does not emit
     * When Generator runs against Profile
     * Then the resulting GenerationPlan carries a skippedOperations entry naming Operation's HTTP method, path, operationId and the reason for the skip
     *   And paogen CLI's generate command prints the same list to stderr so the user knows which ops did not make it into the client
     */
    public function testAnOperationWhoseBodyShapeIsUnsupportedIsReportedAsASkipRatherThanDroppedSilently(): void
    {
        $this->steps->givenSchemaDeclaresOperationIdWhoseRequestBodyContentTypeIsMultipartFormDataWhichPaogenDoesNotEmit('operationId: createWidget');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenResultingGenerationPlanCarriesASkippedOperationsEntryNamingOperationsHTTPMethodPathOperationIdAndTheReasonForTheSkip();
        $this->steps->thenPaogenCLIsGenerateCommandPrintsTheSameListToStderrSoTheUserKnowsWhichOpsDidNotMakeItIntoTheClient();
    }


    /**
     * Rule: Reference resolution and path-level parameters
     *
     * Scenario: An operation-level `$ref` to a component parameter is resolved to a typed method argument
     * @source truth/specs/operation-generator.feature-260418.typ:189
     *
     * Given Schema declares #/components/parameters/Limit limit: integer, in: query, required: false
     *   And Operation GET /order with operationId: listOrders lists a parameter whose value is #/components/parameters/Limit
     * When Generator runs against Profile
     * Then the emitted Client has a method listOrders(?int $limit = null): array
     *   And Operation is not silently skipped even though the parameter is a $ref
     */
    public function testAnOperationLevelRefToAComponentParameterIsResolvedToATypedMethodArgument(): void
    {
        $this->steps->givenSchemaDeclaresComponentsParametersLimitParam('limit: integer, in: query, required: false');
        $this->steps->givenOperationOpWithIdListsAParameterWhoseValueIsRef('GET /order', 'operationId: listOrders', '#/components/parameters/Limit');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasAMethodListOrdersIntLimitNullArray();
        $this->steps->thenOperationIsNotSilentlySkippedEvenThoughTheParameterIsARef();
    }


    /**
     * Scenario: An operation-level `$ref` to a header component parameter becomes an optional typed header argument
     * @source truth/specs/operation-generator.feature-260418.typ:200
     *
     * Given Schema declares #/components/parameters/ApiKey api_key: string, in: header, required: false
     *   And Operation GET /order with operationId: listOrders lists a parameter whose value is #/components/parameters/ApiKey
     * When Generator runs against Profile
     * Then Client's emitted method signature includes ?string $apiKey = null
     *   And Client's method body attaches ->header('api_key', $apiKey) unconditionally, with no if in the emitted body — the header is dropped before the request is sent when $apiKey is null
     */
    public function testAnOperationLevelRefToAHeaderComponentParameterBecomesAnOptionalTypedHeaderArgument(): void
    {
        $this->steps->givenSchemaDeclaresComponentsParametersApiKeyParam('api_key: string, in: header, required: false');
        $this->steps->givenOperationOpWithIdListsAParameterWhoseValueIsRef('GET /order', 'operationId: listOrders', '#/components/parameters/ApiKey');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenClientsEmittedMethodSignatureIncludesStringApiKeyNull();
        $this->steps->thenClientsMethodBodyAttachesHeaderApiKeyApiKeyUnconditionallyWithNoIfInTheEmittedBodyTheHeaderIsDroppedBeforeTheRequestIsSentWhenApiKeyIsNull();
    }


    /**
     * Scenario: A `$ref` to a component requestBody is resolved to the expected Model body parameter
     * @source truth/specs/operation-generator.feature-260418.typ:211
     *
     * Given Schema declares #/components/requestBodies/CreateOrder with application/json schema #/components/schemas/Order
     *   And Operation POST /order with operationId: placeOrder whose requestBody is a #/components/requestBodies/CreateOrder
     * When Generator runs against Profile
     * Then the emitted Client has a method placeOrder(Order $body): Order
     *   And Operation is not silently skipped even though the request body is declared via $ref
     */
    public function testARefToAComponentRequestBodyIsResolvedToTheExpectedModelBodyParameter(): void
    {
        $this->steps->givenSchemaDeclaresComponentsRequestBodiesCreateOrderWithApplicationJsonSchemaRef('#/components/schemas/Order');
        $this->steps->givenOperationOpWithIdWhoseRequestBodyIsARef('POST /order', 'operationId: placeOrder', '#/components/requestBodies/CreateOrder');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasAMethodPlaceOrderOrderBodyOrder();
        $this->steps->thenOperationIsNotSilentlySkippedEvenThoughTheRequestBodyIsDeclaredViaRef();
    }


    /**
     * Scenario: A PathItem-level inline parameter is inherited by every operation under that path
     * @source truth/specs/operation-generator.feature-260418.typ:222
     *
     * Given Schema declares a PathItem /store/{storeId}/items with a single PathItem-level parameter storeId: integer, in: path, required: true
     *   And two Operation entries under it — operationId: listStoreItems and operationId: clearStore — do not restate the parameter
     * When Generator runs against Profile
     * Then the emitted Client has listStoreItems(int $storeId): array and clearStore(int $storeId): void
     *   And neither Operation is silently skipped even though the parameter lives only on the PathItem
     */
    public function testAPathItemLevelInlineParameterIsInheritedByEveryOperationUnderThatPath(): void
    {
        $this->steps->givenSchemaDeclaresAPathItemStoreStoreIdItemsWithASinglePathItemLevelParameterParam('storeId: integer, in: path, required: true');
        $this->steps->givenTwoOperationEntriesUnderItIdAndIdDoNotRestateTheParameter('operationId: listStoreItems', 'operationId: clearStore');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasListStoreItemsIntStoreIdArrayAndClearStoreIntStoreIdVoid();
        $this->steps->thenNeitherOperationIsSilentlySkippedEvenThoughTheParameterLivesOnlyOnThePathItem();
    }


    /**
     * Scenario: An operation whose PathItem declares a `$ref` parameter is still emitted
     * @source truth/specs/operation-generator.feature-260418.typ:233
     *
     * Given Schema declares #/components/parameters/PetId petId: integer, in: path, required: true
     *   And Operation GET /pet/{petId} with operationId: getPetById inherits a PathItem-level parameter whose value is #/components/parameters/PetId
     * When Generator runs against Profile
     * Then the emitted Client has a method getPetById(int $petId): Pet
     *   And Operation is not silently skipped even though the parameter is declared at the PathItem level via $ref
     */
    public function testAnOperationWhosePathItemDeclaresARefParameterIsStillEmitted(): void
    {
        $this->steps->givenSchemaDeclaresComponentsParametersPetIdParam('petId: integer, in: path, required: true');
        $this->steps->givenOperationOpWithIdInheritsAPathItemLevelParameterWhoseValueIsRef('GET /pet/{petId}', 'operationId: getPetById', '#/components/parameters/PetId');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasAMethodGetPetByIdIntPetIdPet();
        $this->steps->thenOperationIsNotSilentlySkippedEvenThoughTheParameterIsDeclaredAtThePathItemLevelViaRef();
    }


    /**
     * Scenario: A path parameter whose schema $refs a scalar-VO component is interpolated through toScalar()
     * @source truth/specs/operation-generator.feature-260418.typ:244
     *
     * Given Schema declares #/components/schemas/SshKeyId as type: integer
     *   And Operation GET /keys/{ssh_key_id} with operationId: getSshKeyById and a path parameter ssh_key_id whose schema is #/components/schemas/SshKeyId
     * When Generator runs against Profile
     * Then Client's emitted method body interpolates the path token via (string) $sshKeyId->toScalar(), not (string) $sshKeyId
     *   And Operation is not silently skipped even though the path parameter resolves to a ScalarBinding-implementing class
     */
    public function testAPathParameterWhoseSchemaRefsAScalarVOComponentIsInterpolatedThroughToScalar(): void
    {
        $this->steps->givenSchemaDeclaresComponentsSchemasSshKeyIdAsSchema('type: integer');
        $this->steps->givenOperationOpWithIdAndAPathParameterSshKeyIdWhoseSchemaIsRef('GET /keys/{ssh_key_id}', 'operationId: getSshKeyById', '#/components/schemas/SshKeyId');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenClientsEmittedMethodBodyInterpolatesThePathTokenViaStringSshKeyIdToScalarNotStringSshKeyId();
        $this->steps->thenOperationIsNotSilentlySkippedEvenThoughThePathParameterResolvesToAScalarBindingImplementingClass();
    }


    /**
     * Rule: Non-JSON request bodies
     *
     * Scenario: A form-urlencoded body becomes typed params serialised with http_build_query
     * @source truth/specs/operation-generator.feature-260418.typ:257
     *
     * Given Schema declares Operation POST /token with operationId: issueToken whose sole request-body content type is application/x-www-form-urlencoded and whose schema is type: object with grantType: string, clientId: string, scope: string and [grantType, clientId]
     * When Generator runs against Profile
     * Then the emitted Client has a method issueToken(string $grantType, string $clientId, ?string $scope = null): void with one method parameter per declared property
     *   And Client's method body assembles the request body with http_build_query([...]) and sends Content-Type: application/x-www-form-urlencoded
     *   And calling Client's method through a PSR-18 recording client records a request whose body contains grantType=password and clientId=my-app pairs
     */
    public function testAFormUrlencodedBodyBecomesTypedParamsSerialisedWithHttpBuildQuery(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdWhoseSoleRequestBodyContentTypeIsApplicationXWwwFormUrlencodedAndWhoseSchemaIsTypeObjectWithPropsAndRequired('POST /token', 'operationId: issueToken', 'grantType: string, clientId: string, scope: string', '[grantType, clientId]');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasAMethodIssueTokenStringGrantTypeStringClientIdStringScopeNullVoidWithOneMethodParameterPerDeclaredProperty();
        $this->steps->thenClientsMethodBodyAssemblesTheRequestBodyWithHttpBuildQueryAndSendsContentTypeApplicationXWwwFormUrlencoded();
        $this->steps->thenCallingClientsMethodThroughAPSR18RecordingClientRecordsARequestWhoseBodyContainsGrantTypePasswordAndClientIdMyAppPairs();
    }


    /**
     * Scenario: An unsupported body content type aborts the run
     * @source truth/specs/operation-generator.feature-260418.typ:268
     *
     * Given Schema declares Operation POST /widgets with operationId: createWidget whose request body content type is multipart/form-data
     * When Generator runs against Profile declaring no skip entry for that Operation
     * Then Generator's run fails and emits no Generated File
     *   And Generator's report names the operationId, the unsupported content type, and the remedy
     */
    public function testAnUnsupportedBodyContentTypeAbortsTheRun(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdWhoseRequestBodyContentTypeIsMultipartFormData('POST /widgets', 'operationId: createWidget');
        $this->steps->whenGeneratorRunsAgainstProfileDeclaringNoSkipEntryForThatOperation();
        $this->steps->thenGeneratorsRunFailsAndEmitsNoGeneratedFile();
        $this->steps->thenGeneratorsReportNamesTheOperationIdTheUnsupportedContentTypeAndTheRemedy();
    }


    /**
     * Scenario: An explicitly skipped operation is omitted rather than stubbed
     * @source truth/specs/operation-generator.feature-260418.typ:280
     *
     * Given Schema declares Operation POST /widgets with operationId: createWidget whose request body content type is multipart/form-data
     *   And Profile declares a skip entry for that Operation carrying a reason
     * When Generator runs against Profile
     * Then the emitted Client has no createWidget method at all
     *   And no Generated File contains a method that throws on an unsupported content type
     */
    public function testAnExplicitlySkippedOperationIsOmittedRatherThanStubbed(): void
    {
        $this->steps->givenSchemaDeclaresOperationOpWithIdWhoseRequestBodyContentTypeIsMultipartFormData('POST /widgets', 'operationId: createWidget');
        $this->steps->givenProfileDeclaresASkipEntryForThatOperationCarryingAReason();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientHasNoCreateWidgetMethodAtAll();
        $this->steps->thenNoGeneratedFileContainsAMethodThatThrowsOnAnUnsupportedContentType();
    }


    /**
     * Rule: Error responses
     *
     * Scenario: A non-2xx response throws a typed ApiException instead of a generic RuntimeException
     * @source truth/specs/operation-generator.feature-260418.typ:295
     *
     * Given Client is constructed with a TransportInterface backed by a PSR-18 HTTP client that returns status 404 with JSON body {"message":"not found"}
     * When getPetById(999) is called on Client
     * Then the call on Client throws Generated\\ApiException
     *   And Client's exception's getStatusCode() returns 404
     *   And Client's exception's getDecodedBody() returns the decoded error payload
     */
    public function testANon2xxResponseThrowsATypedApiExceptionInsteadOfAGenericRuntimeException(): void
    {
        $this->steps->givenClientIsConstructedWithATransportInterfaceBackedByAPSR18HTTPClientThatReturnsStatusCodeWithJSONBodyBody(404, '{\"message\":\"not found\"}');
        $this->steps->whenGetpetbyid999IsCalledOnClient();
        $this->steps->thenCallOnClientThrowsGeneratedApiException();
        $this->steps->thenClientsExceptionsGetStatusCodeReturns404();
        $this->steps->thenClientsExceptionsGetDecodedBodyReturnsTheDecodedErrorPayload();
    }


    /**
     * Rule: Security schemes
     *
     * Scenario: An apiKey header scheme becomes a constructor arg attached as a header on secured ops
     * @source truth/specs/operation-generator.feature-260418.typ:308
     *
     * Given Schema declares #/components/securitySchemes/apiKey with type: apiKey, in: header, name: X-API-Key
     *   And a top-level security: [{ apiKey: [] }] makes every Operation secured by default
     * When Generator runs against Profile
     * Then Client's emitted ApiClient constructor has a required string $apiKey promoted private argument placed after $transport
     *   And each secured Operation's method body attaches ->header('X-API-Key', $this->apiKey) to the request it builds and passes it to $this->transport->send(...)
     */
    public function testAnApiKeyHeaderSchemeBecomesAConstructorArgAttachedAsAHeaderOnSecuredOps(): void
    {
        $this->steps->givenSchemaDeclaresComponentsSecuritySchemesApiKeyWithScheme('type: apiKey, in: header, name: X-API-Key');
        $this->steps->givenTopLevelSecurityApiKeyMakesEveryOperationSecuredByDefault();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenClientsEmittedApiClientConstructorHasARequiredStringApiKeyPromotedPrivateArgumentPlacedAfterTransport();
        $this->steps->thenEachSecuredOperationsMethodBodyAttachesHeaderXAPIKeyThisApiKeyToTheRequestItBuildsAndPassesItToThisTransportSend();
    }


    /**
     * Scenario: An http bearer scheme becomes a $bearerToken ctor arg attached as Authorization
     * @source truth/specs/operation-generator.feature-260418.typ:319
     *
     * Given Schema declares #/components/securitySchemes/bearerAuth with type: http, scheme: bearer
     *   And Operation operationId: placeOrder overrides the default with operation-level security: [{ bearerAuth: [] }]
     * When Generator runs against Profile
     * Then Client's emitted ApiClient constructor has a required string $bearerToken promoted private argument
     *   And Client's placeOrder method body attaches ->header('Authorization', 'Bearer ' . $this->bearerToken) to the request it builds and passes it to $this->transport->send(...)
     */
    public function testAnHttpBearerSchemeBecomesABearerTokenCtorArgAttachedAsAuthorization(): void
    {
        $this->steps->givenSchemaDeclaresComponentsSecuritySchemesBearerAuthWithScheme('type: http, scheme: bearer');
        $this->steps->givenOperationIdOverridesTheDefaultWithOperationLevelSecurityBearerAuth('operationId: placeOrder');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenClientsEmittedApiClientConstructorHasARequiredStringBearerTokenPromotedPrivateArgument();
        $this->steps->thenClientsPlaceOrderMethodBodyAttachesHeaderAuthorizationBearerThisBearerTokenToTheRequestItBuildsAndPassesItToThisTransportSend();
    }


    /**
     * Scenario: An http basic scheme is left as a placeholder pending no-inheritance-no-protected-regions runtime design
     * @source truth/specs/operation-generator.feature-260418.typ:330
     *
     * Given Schema declares a scheme with type: http, scheme: basic
     * When Generator runs against Profile
     * Then the operation generator must not surface the scheme yet — design deferred to the decorator-layer runtime per no-inheritance-no-protected-regions
     */
    #[\PHPUnit\Framework\Attributes\DoesNotPerformAssertions]
    public function testAnHttpBasicSchemeIsLeftAsAPlaceholderPendingNoInheritanceNoProtectedRegionsRuntimeDesign(
    ): void
    {
        self::markTestIncomplete('Scenario is draft');
    }


    /**
     * Scenario: An oauth2 scheme is left as a placeholder pending no-inheritance-no-protected-regions runtime design
     * @source truth/specs/operation-generator.feature-260418.typ:339
     *
     * Given Schema declares a scheme with type: oauth2, flows: { clientCredentials: ... }
     * When Generator runs against Profile
     * Then the operation generator must not surface the scheme yet — design deferred to the decorator-layer runtime per no-inheritance-no-protected-regions
     */
    #[\PHPUnit\Framework\Attributes\DoesNotPerformAssertions]
    public function testAnOauth2SchemeIsLeftAsAPlaceholderPendingNoInheritanceNoProtectedRegionsRuntimeDesign(): void
    {
        self::markTestIncomplete('Scenario is draft');
    }


    /**
     * Rule: The caller surface is grained by tag (emit-tagged-subclients-with-interfaces)
     *
     * Scenario: Each tag becomes a sub-client behind an interface declaring exactly its own methods
     * @source truth/specs/operation-generator.feature-260418.typ:350
     *
     * Given Schema declares Operation operationId: getOrderById tagged store and another tagged pet
     * When Generator runs against Profile
     * Then Generated File Generated/StoreClient.php is a final readonly class implementing StoreClientInterface
     *   And emitted Generated File StoreClientInterface.php declares getOrderById and does not declare the pet operation, so a caller depending on it depends on roughly the endpoints it uses
     *   And emitted Generated File interface omits the constructor, because how an implementation acquires its collaborators is not part of the contract a decorator satisfies
     */
    public function testEachTagBecomesASubClientBehindAnInterfaceDeclaringExactlyItsOwnMethods(): void
    {
        $this->steps->givenSchemaDeclaresOperationIdTaggedTagAndAnotherTaggedOther('operationId: getOrderById', 'store', 'pet');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedStoreClientPhpIsAFinalReadonlyClassImplementingStoreClientInterface();
        $this->steps->thenEmittedGeneratedFileStoreClientInterfacePhpDeclaresGetOrderByIdAndDoesNotDeclareThePetOperationSoACallerDependingOnItDependsOnRoughlyTheEndpointsItUses();
        $this->steps->thenEmittedGeneratedFileInterfaceOmitsTheConstructorBecauseHowAnImplementationAcquiresItsCollaboratorsIsNotPartOfTheContractADecoratorSatisfies();
    }


    /**
     * Scenario: The root client hands out sub-clients and carries no flat operation methods
     * @source truth/specs/operation-generator.feature-260418.typ:363
     *
     * Given Schema tags every Operation
     * When Generator runs against Profile
     * Then Client ApiClient has one accessor per tag, each returning that tag's interface
     *   And Client ApiClient declares no operation method of its own, so exactly one way exists to reach any endpoint
     */
    public function testTheRootClientHandsOutSubClientsAndCarriesNoFlatOperationMethods(): void
    {
        $this->steps->givenSchemaTagsEveryOperation();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenClientApiClientHasOneAccessorPerTagEachReturningThatTagsInterface();
        $this->steps->thenClientApiClientDeclaresNoOperationMethodOfItsOwnSoExactlyOneWayExistsToReachAnyEndpoint();
    }


    /**
     * Scenario: A sub-client is constructible without the root
     * @source truth/specs/operation-generator.feature-260418.typ:373
     *
     * Given Generator has emitted a sub-client for a tag
     * When a consumer constructs Client directly
     * Then Client's constructor takes TransportInterface and whatever credential Schema declares — and never root Client
     */
    public function testASubClientIsConstructibleWithoutTheRoot(): void
    {
        $this->steps->givenGeneratorHasEmittedASubClientForATag();
        $this->steps->whenConsumerConstructsClientDirectly();
        $this->steps->thenClientsConstructorTakesTransportInterfaceAndWhateverCredentialSchemaDeclaresAndNeverRootClient();
    }


    /**
     * Scenario: An untagged operation stays on the root and no DefaultApi type is invented
     * @source truth/specs/operation-generator.feature-260418.typ:384
     *
     * Given Schema declares Operation carrying no tag
     * When Generator runs against Profile
     * Then Operation is emitted as a method on Client ApiClient itself
     *   And no Generated File named for a fallback tag is written
     */
    public function testAnUntaggedOperationStaysOnTheRootAndNoDefaultApiTypeIsInvented(): void
    {
        $this->steps->givenSchemaDeclaresOperationCarryingNoTag();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenOperationIsEmittedAsAMethodOnClientApiClientItself();
        $this->steps->thenNoGeneratedFileNamedForAFallbackTagIsWritten();
    }


    /**
     * Scenario: An operation carrying several tags appears on every one of its sub-clients
     * @source truth/specs/operation-generator.feature-260418.typ:394
     *
     * Given Operation carries two tags and Profile sets no tagChoice for it
     * When Generator runs against Profile
     * Then Operation is emitted on both sub-clients, because dropping it from either would be an omission nobody asked for
     *   And Profile key tagChoice narrows it to one, and a choice naming a tag Operation does not carry fails the run
     */
    public function testAnOperationCarryingSeveralTagsAppearsOnEveryOneOfItsSubClients(): void
    {
        $this->steps->givenOperationCarriesTwoTagsAndProfileSetsNoTagChoiceForIt();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenOperationIsEmittedOnBothSubClientsBecauseDroppingItFromEitherWouldBeAnOmissionNobodyAskedFor();
        $this->steps->thenProfileKeyTagChoiceNarrowsItToOneAndAChoiceNamingATagOperationDoesNotCarryFailsTheRun();
    }


    /**
     * Scenario: A tag that is not a legal readable identifier is transliterated deterministically
     * @source truth/specs/operation-generator.feature-260418.typ:404
     *
     * Given Schema tags Operation Клиенты
     * When Generator runs against Profile
     * Then Generated File Generated/KlientyClient.php is written — PHP would accept the Russian word as a class name and the result would be unusable
     *   And same Schema produces same Generated File name on any machine, because the fold is a fixed character table rather than a library whose output tracks an ICU version
     */
    public function testATagThatIsNotALegalReadableIdentifierIsTransliteratedDeterministically(): void
    {
        $this->steps->givenSchemaTagsOperationTag('Клиенты');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedKlientyClientPhpIsWrittenPHPWouldAcceptTheRussianWordAsAClassNameAndTheResultWouldBeUnusable();
        $this->steps->thenSameSchemaProducesSameGeneratedFileNameOnAnyMachineBecauseTheFoldIsAFixedCharacterTableRatherThanALibraryWhoseOutputTracksAnICUVersion();
    }


    /**
     * Scenario: The profile renames a tag, and a rename matching nothing fails the run
     * @source truth/specs/operation-generator.feature-260418.typ:414
     *
     * Given Profile whose tagRenames map carries 'Клиенты' => 'Customers'
     * When Generator runs against Profile
     * Then Generated File Generated/CustomersClient.php is written and Client ApiClient exposes customers()
     *   And an entry naming a tag no Operation carries fails the run, on the same reasoning as a stale skip — guidance that outlives its target is worse than none
     */
    public function testTheProfileRenamesATagAndARenameMatchingNothingFailsTheRun(): void
    {
        $this->steps->givenProfileWhoseTagRenamesMapCarriesКлиентыCustomers();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedCustomersClientPhpIsWrittenAndClientApiClientExposesCustomers();
        $this->steps->thenEntryNamingATagNoOperationCarriesFailsTheRunOnTheSameReasoningAsAStaleSkipGuidanceThatOutlivesItsTargetIsWorseThanNone();
    }


    /**
     * Scenario: A hand-written decorator implements a sub-client interface and delegates
     * @source truth/specs/operation-generator.feature-260418.typ:424
     *
     * Given a consumer's own class implementing emitted Generated File StoreClientInterface and holding the generated implementation
     * When the consumer calls a method on their class, which Client declared
     * Then the call reaches the generated implementation, and their class adds behaviour with no edit to Generated File — no hook, no protected region, no subclass
     *   And their class satisfies the strictest analysis with nothing suppressed, so a regeneration that changed Client surface would fail to compile rather than break the seam quietly
     */
    public function testAHandWrittenDecoratorImplementsASubClientInterfaceAndDelegates(): void
    {
        $this->steps->givenConsumersOwnClassImplementingEmittedGeneratedFileStoreClientInterfaceAndHoldingTheGeneratedImplementation();
        $this->steps->whenConsumerCallsAMethodOnTheirClassWhichClientDeclared();
        $this->steps->thenCallReachesTheGeneratedImplementationAndTheirClassAddsBehaviourWithNoEditToGeneratedFileNoHookNoProtectedRegionNoSubclass();
        $this->steps->thenTheirClassSatisfiesTheStrictestAnalysisWithNothingSuppressedSoARegenerationThatChangedClientSurfaceWouldFailToCompileRatherThanBreakTheSeamQuietly();
    }
}
