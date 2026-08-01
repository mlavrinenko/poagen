#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": schema-context, Schema, Operation
#import "../domain/guidance.context.typ": guidance-context, Profile
#import "../domain/generation.context.typ": generation-context, Generator, Client, Model, GeneratedFile
#import "../domain/cli.context.typ": cli-context, PaogenCli

#feature(
  "Operation Generator",
  description: [
    Walks #the(Schema)'s `paths` and emits one method per OpenAPI
    #a(Operation) onto a single #the(Client) class. Path parameters appear
    as typed method parameters; `application/json` request bodies carry
    #a(Model) payload; response JSON is deserialized back into the typed
    #a(Model). #the(Client) is emitted as a `final readonly` class whose
    constructor takes a `TransportInterface` together with one argument per
    credential #the(Schema) declares.
  ],
)[

  #rule("Emitting operations as client methods")[
    #scenario(
      "A GET operation with a path parameter becomes a typed client method",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "GET /store/order/{orderId}")) with #p((id: "operationId: getOrderById")) and path parameter #p((param: "orderId: integer"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[a file `Generated/ApiClient.php` is written under #the(Profile)'s `output`]
      #and_[the emitted class is `final readonly` in #the(Profile)'s namespace `\Generated`]
      #and_[#the(Client) has a method `getOrderById(int $orderId): Order` that interpolates #p((token: "{orderId}")) into the request path]
    ]

    #scenario(
      "A POST operation with a JSON body takes a typed Model parameter",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "POST /pet")) with #p((id: "operationId: addPet"))]
      #and_[#the(Operation)'s request body is `application/json` with schema #p((ref: "#/components/schemas/Pet"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `addPet(Pet $body): Pet`]
      #and_[#the(Client)'s method JSON-encodes `$body` and attaches it as the request body]
    ]

    #scenario(
      "A JSON body whose schema is a list of $ref becomes a typed list parameter",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "POST /user/createWithList")) with #p((id: "operationId: createUsersWithListInput"))]
      #and_[#the(Operation)'s request body is `application/json` with schema `type: array` and items #p((ref: "#/components/schemas/User"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `createUsersWithListInput(array $body)` whose `$body` parameter is annotated `@param list<User> $body`]
      #and_[#the(Client)'s method JSON-encodes `$body` and attaches it as the request body]
    ]
  ]

  #rule("Response deserialization")[
    #scenario(
      "A 2xx JSON response body is deserialized into the typed Model",
      stage: "unstable",
    )[
      #given[#the(Client) is constructed with a `TransportInterface` backed by a PSR-18 HTTP client that returns status #p((code: "200")) with JSON body #p((body: "{\"id\":42,\"status\":\"placed\"}"))]
      #when[`getOrderById(42)` is called on #the(Client)]
      #then[the return value is #a(Model) `Order` with `id = 42` and `status = 'placed'`]
    ]

    #scenario(
      "A scalar 2xx JSON response is returned as the scalar PHP type without hydration",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "GET /user/login")) with #p((id: "operationId: loginUser")) whose 200 response schema is `type: string`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method whose return type is `string`]
      #and_[#the(Client)'s method body names the response shape `ResponseType::string()`, so the transport reads the body as a scalar instead of hydrating it into a Model]
    ]

    #scenario(
      "A 2xx JSON response with `additionalProperties` is returned as a typed associative array",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "GET /store/inventory")) with #p((id: "operationId: getInventory")) whose 200 response schema is `type: object` with #p((map: "additionalProperties: integer"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method whose return type is `array` annotated `@return array<string, int>`]
      #and_[#the(Client)'s method body names the response shape `ResponseType::mapOf(ResponseType::int())`, so the transport decodes the payload directly instead of hydrating it into a Model]
    ]
  ]

  #rule("Query parameters")[
    #scenario(
      "An inline enum query parameter becomes a synthesised backed enum method argument",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "GET /pet/findByStatus")) with #p((id: "operationId: findPetsByStatus")) and a required query parameter `status` whose schema is `type: string` with #p((enum: "[available, pending, sold]"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[a file `Generated/Enum/FindPetsByStatusStatus.php` is written and the emitted #the(Client) has a method `findPetsByStatus(FindPetsByStatusStatus $status): array`]
      #and_[calling #the(Client)'s method with #p((arg: "status: FindPetsByStatusStatus::Available")) sends a request whose URI ends with #p((query: "?status=available"))]
    ]

    #scenario(
      "An `explode: true` array query parameter is serialised as repeated `name=value` pairs",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "GET /pet/findByTags")) with #p((id: "operationId: findPetsByTags")) and a required query parameter `tags` #p((schema: "type: array, items.type: string, explode: true"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `findPetsByTags(array $tags): array` annotated `@param list<string> $tags`]
      #and_[calling #the(Client)'s method with #p((arg: "tags: ['a', 'b']")) sends a request whose URI ends with #p((query: "?tags=a&tags=b")) instead of `tags%5B0%5D=a&tags%5B1%5D=b`]
    ]
  ]

  #rule("Header parameters")[
    #scenario(
      "An optional header parameter becomes a nullable typed argument and is attached only when non-null",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "DELETE /pet/{petId}")) with #p((id: "operationId: deletePet")) and an optional header parameter `api_key: string`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `deletePet(int $petId, ?string $apiKey = null): void`]
      #and_[#the(Client)'s method calls `->header('api_key', $apiKey)` unconditionally, with no `if` in the emitted body — the header is dropped before the request is sent when `$apiKey` is `null`]
    ]
  ]

  #rule("Identifier normalisation")[
    #scenario(
      "A header parameter whose raw name is not a PHP identifier is normalised but the wire key is preserved",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "POST /proxy")) with an optional header parameter named `Content-Type`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Client)'s emitted method takes a `?string $contentType = null` argument]
      #and_[#the(Client)'s method body attaches the header with the original wire key `Content-Type` (not `contentType`)]
    ]

    #scenario(
      "An operationId with non-identifier characters is camelCased into a PHP method name",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "POST /proxy")) with #p((id: "operationId: monitoring_get_foo.yml"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `monitoringGetFooYml(...)`]
      #and_[#the(Operation) is *not* silently skipped even though the raw operationId contains a `.`]
    ]

    #scenario(
      "Profile.methodRenames overrides an operationId verbatim",
      stage: "unstable",
    )[
      #given[#the(Profile) whose `methodRenames` map carries `'monitoring_get_foo.yml' => 'forwardProxyRequest'`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `forwardProxyRequest(...)` instead of the auto-sanitised `monitoringGetFooYml`]
      #and_[#the(Profile)'s `renames` map does *not* rename #an(Operation), because it answers a different question — a document may use one string for both a component and an operation, and one map applying to both would put the consumer's answer on the wrong one]
    ]

    #scenario(
      "An operation whose body shape is unsupported is reported as a skip rather than dropped silently",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #a(Operation) #p((id: "operationId: uploadFile")) whose request body content type is `application/octet-stream`, which paogen does not emit]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the resulting `GenerationPlan` carries a `skippedOperations` entry naming #the(Operation)'s HTTP method, path, operationId and the reason for the skip]
      #and_[#the(PaogenCli)'s `generate` command prints the same list to stderr so the user knows which ops did not make it into the client]
    ]
  ]

  #rule("Reference resolution and path-level parameters")[
    #scenario(
      "An operation-level `$ref` to a component parameter is resolved to a typed method argument",
      stage: "unstable",
    )[
      #given[#the(Schema) declares `#/components/parameters/Limit` #p((param: "limit: integer, in: query, required: false"))]
      #and_[#a(Operation) #p((op: "GET /order")) with #p((id: "operationId: listOrders")) lists a parameter whose value is #p((ref: "#/components/parameters/Limit"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `listOrders(?int $limit = null): array`]
      #and_[#the(Operation) is *not* silently skipped even though the parameter is a `$ref`]
    ]

    #scenario(
      "An operation-level `$ref` to a header component parameter becomes an optional typed header argument",
      stage: "unstable",
    )[
      #given[#the(Schema) declares `#/components/parameters/ApiKey` #p((param: "api_key: string, in: header, required: false"))]
      #and_[#a(Operation) #p((op: "GET /order")) with #p((id: "operationId: listOrders")) lists a parameter whose value is #p((ref: "#/components/parameters/ApiKey"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Client)'s emitted method signature includes `?string $apiKey = null`]
      #and_[#the(Client)'s method body attaches `->header('api_key', $apiKey)` unconditionally, with no `if` in the emitted body — the header is dropped before the request is sent when `$apiKey` is `null`]
    ]

    #scenario(
      "A `$ref` to a component requestBody is resolved to the expected Model body parameter",
      stage: "unstable",
    )[
      #given[#the(Schema) declares `#/components/requestBodies/CreateOrder` with `application/json` schema #p((ref: "#/components/schemas/Order"))]
      #and_[#a(Operation) #p((op: "POST /order")) with #p((id: "operationId: placeOrder")) whose `requestBody` is a #p((ref: "#/components/requestBodies/CreateOrder"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `placeOrder(Order $body): Order`]
      #and_[#the(Operation) is *not* silently skipped even though the request body is declared via `$ref`]
    ]

    #scenario(
      "A PathItem-level inline parameter is inherited by every operation under that path",
      stage: "unstable",
    )[
      #given[#the(Schema) declares a PathItem `/store/{storeId}/items` with a single PathItem-level parameter #p((param: "storeId: integer, in: path, required: true"))]
      #and_[two #the(Operation) entries under it — #p((id: "operationId: listStoreItems")) and #p((id: "operationId: clearStore")) — do not restate the parameter]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has `listStoreItems(int $storeId): array` and `clearStore(int $storeId): void`]
      #and_[neither #the(Operation) is silently skipped even though the parameter lives only on the PathItem]
    ]

    #scenario(
      "An operation whose PathItem declares a `$ref` parameter is still emitted",
      stage: "unstable",
    )[
      #given[#the(Schema) declares `#/components/parameters/PetId` #p((param: "petId: integer, in: path, required: true"))]
      #and_[#a(Operation) #p((op: "GET /pet/{petId}")) with #p((id: "operationId: getPetById")) inherits a PathItem-level parameter whose value is #p((ref: "#/components/parameters/PetId"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `getPetById(int $petId): Pet`]
      #and_[#the(Operation) is *not* silently skipped even though the parameter is declared at the PathItem level via `$ref`]
    ]

    #scenario(
      "A path parameter whose schema $refs a scalar-VO component is interpolated through toScalar()",
      stage: "unstable",
    )[
      #given[#the(Schema) declares `#/components/schemas/SshKeyId` as #p((schema: "type: integer"))]
      #and_[#a(Operation) #p((op: "GET /keys/{ssh_key_id}")) with #p((id: "operationId: getSshKeyById")) and a path parameter `ssh_key_id` whose schema is #p((ref: "#/components/schemas/SshKeyId"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Client)'s emitted method body interpolates the path token via `(string) $sshKeyId->toScalar()`, not `(string) $sshKeyId`]
      #and_[#the(Operation) is *not* silently skipped even though the path parameter resolves to a `ScalarBinding`-implementing class]
    ]
  ]

  #rule("Non-JSON request bodies")[
    #scenario(
      "A form-urlencoded body becomes typed params serialised with http_build_query",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "POST /token")) with #p((id: "operationId: issueToken")) whose sole request-body content type is `application/x-www-form-urlencoded` and whose schema is `type: object` with #p((props: "grantType: string, clientId: string, scope: string")) and #p((required: "[grantType, clientId]"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `issueToken(string $grantType, string $clientId, ?string $scope = null): void` with one method parameter per declared property]
      #and_[#the(Client)'s method body assembles the request body with `http_build_query([...])` and sends `Content-Type: application/x-www-form-urlencoded`]
      #and_[calling #the(Client)'s method through a PSR-18 recording client records a request whose body contains `grantType=password` and `clientId=my-app` pairs]
    ]

    #scenario(
      "An unsupported body content type aborts the run",
      stage: "unstable",
      case: "unsupported-content-type-aborts-run",
      standards: (link("../standards/silence-means-success.standard-260729.typ"),),
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "POST /pet/{petId}/uploadImage")) with #p((id: "operationId: uploadFile")) whose request body content type is `application/octet-stream`]
      #when[#the(Generator) runs against #a(Profile) declaring no skip entry for that #a(Operation)]
      #then[#the(Generator)'s run fails and emits no #a(GeneratedFile)]
      #and_[#the(Generator)'s report names the operationId, the unsupported content type, and the remedy]
    ]

    #scenario(
      "An explicitly skipped operation is omitted rather than stubbed",
      stage: "unstable",
      case: "explicit-skip-omits-without-stub",
      standards: (link("../standards/silence-means-success.standard-260729.typ"),),
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "POST /pet/{petId}/uploadImage")) with #p((id: "operationId: uploadFile")) whose request body content type is `application/octet-stream`]
      #and_[#the(Profile) declares a skip entry for that #a(Operation) carrying a reason]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has no `uploadFile` method at all]
      #and_[no #a(GeneratedFile) contains a method that throws on an unsupported content type]
    ]
  ]

  #rule("Error responses")[
    #scenario(
      "A non-2xx response throws a typed ApiException instead of a generic RuntimeException",
      stage: "unstable",
    )[
      #given[#the(Client) is constructed with a `TransportInterface` backed by a PSR-18 HTTP client that returns status #p((code: "404")) with JSON body #p((body: "{\"message\":\"not found\"}"))]
      #when[`getPetById(999)` is called on #the(Client)]
      #then[the call on #the(Client) throws `Generated\\ApiException`]
      #and_[#the(Client)'s exception's `getStatusCode()` returns `404`]
      #and_[#the(Client)'s exception's `getDecodedBody()` returns the decoded error payload]
    ]
  ]

  #rule("Security schemes")[
    #scenario(
      "An apiKey header scheme becomes a constructor arg attached as a header on secured ops",
      stage: "unstable",
    )[
      #given[#the(Schema) declares `#/components/securitySchemes/apiKey` with #p((scheme: "type: apiKey, in: header, name: X-API-Key"))]
      #and_[a top-level `security: [{ apiKey: [] }]` makes every #the(Operation) secured by default]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Client)'s emitted `ApiClient` constructor has a required `string $apiKey` promoted private argument placed after `$transport`]
      #and_[each secured #the(Operation)'s method body attaches `->header('X-API-Key', $this->apiKey)` to the request it builds and passes it to `$this->transport->send(...)`]
    ]

    #scenario(
      "An http bearer scheme becomes a $bearerToken ctor arg attached as Authorization",
      stage: "unstable",
    )[
      #given[#the(Schema) declares `#/components/securitySchemes/bearerAuth` with #p((scheme: "type: http, scheme: bearer"))]
      #and_[#an(Operation) #p((id: "operationId: placeOrder")) overrides the default with operation-level `security: [{ bearerAuth: [] }]`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Client)'s emitted `ApiClient` constructor has a required `string $bearerToken` promoted private argument]
      #and_[#the(Client)'s `placeOrder` method body attaches `->header('Authorization', 'Bearer ' . $this->bearerToken)` to the request it builds and passes it to `$this->transport->send(...)`]
    ]

    #scenario(
      "An http basic scheme is left as a placeholder pending ADR-002 runtime design",
      stage: "draft",
    )[
      #given[#the(Schema) declares a scheme with #p((scheme: "type: http, scheme: basic"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the operation generator must not surface the scheme yet — design deferred to the decorator-layer runtime per ADR-002]
    ]

    #scenario(
      "An oauth2 scheme is left as a placeholder pending ADR-002 runtime design",
      stage: "draft",
    )[
      #given[#the(Schema) declares a scheme with #p((scheme: "type: oauth2, flows: { clientCredentials: ... }"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the operation generator must not surface the scheme yet — design deferred to the decorator-layer runtime per ADR-002]
    ]
  ]

  #rule("The caller surface is grained by tag (emit-tagged-subclients-with-interfaces)")[
    #scenario(
      "Each tag becomes a sub-client behind an interface declaring exactly its own methods",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #an(Operation) #p((id: "operationId: getOrderById")) tagged #p((tag: "store")) and another tagged #p((other: "pet"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/StoreClient.php` is a `final readonly` class implementing `StoreClientInterface`]
      #and_[#the([emitted], GeneratedFile) `StoreClientInterface.php` declares `getOrderById` and does *not* declare the `pet` operation, so a caller depending on it depends on roughly the endpoints it uses]
      #and_[#the([emitted], GeneratedFile) interface omits the constructor, because how an implementation acquires its collaborators is not part of the contract a decorator satisfies]
    ]

    #scenario(
      "The root client hands out sub-clients and carries no flat operation methods",
      stage: "unstable",
    )[
      #given[#the(Schema) tags every #a(Operation)]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Client) `ApiClient` has one accessor per tag, each returning that tag's interface]
      #and_[#the(Client) `ApiClient` declares no operation method of its own, so exactly one way exists to reach any endpoint]
    ]

    #scenario(
      "A sub-client is constructible without the root",
      stage: "unstable",
    )[
      #given[#the(Generator) has emitted a sub-client for a tag]
      #when[a consumer constructs #the(Client) directly]
      #then[#the(Client)'s constructor takes `TransportInterface` and whatever credential #the(Schema) declares — and never #the([root], Client)]
    ]

    #scenario(
      "An untagged operation stays on the root and no DefaultApi type is invented",
      stage: "unstable",
    )[
      #given[#the(Schema) declares #an(Operation) carrying no tag]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Operation) is emitted as a method on #the(Client) `ApiClient` itself]
      #and_[no #a(GeneratedFile) named for a fallback tag is written]
    ]

    #scenario(
      "An operation carrying several tags appears on every one of its sub-clients",
      stage: "unstable",
    )[
      #given[#an(Operation) carries two tags and #the(Profile) sets no `tagChoice` for it]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Operation) is emitted on both sub-clients, because dropping it from either would be an omission nobody asked for]
      #and_[#the(Profile) key `tagChoice` narrows it to one, and a choice naming a tag #the(Operation) does not carry fails the run]
    ]

    #scenario(
      "A tag that is not a legal readable identifier is transliterated deterministically",
      stage: "unstable",
    )[
      #given[#the(Schema) tags #an(Operation) #p((tag: "Клиенты"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/KlientyClient.php` is written — PHP would accept the Russian word as a class name and the result would be unusable]
      #and_[#the([same], Schema) produces #the([same], GeneratedFile) name on any machine, because the fold is a fixed character table rather than a library whose output tracks an ICU version]
    ]

    #scenario(
      "The profile renames a tag, and a rename matching nothing fails the run",
      stage: "unstable",
    )[
      #given[#the(Profile) whose `tagRenames` map carries `'Клиенты' => 'Customers'`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/CustomersClient.php` is written and #the(Client) `ApiClient` exposes `customers()`]
      #and_[an entry naming a tag no #a(Operation) carries fails the run, on the same reasoning as a stale `skip` — guidance that outlives its target is worse than none]
    ]

    #scenario(
      "A hand-written decorator implements a sub-client interface and delegates",
      stage: "unstable",
    )[
      #given[a consumer's own class implementing #the([emitted], GeneratedFile) `StoreClientInterface` and holding the generated implementation]
      #when[the consumer calls a method on their class, which #the(Client) declared]
      #then[the call reaches the generated implementation, and their class adds behaviour with no edit to #a(GeneratedFile) — no hook, no protected region, no subclass]
      #and_[their class satisfies the strictest analysis with nothing suppressed, so a regeneration that changed #the(Client) surface would fail to compile rather than break the seam quietly]
    ]
  ]
]
