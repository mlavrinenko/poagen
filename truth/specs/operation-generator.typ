// Feature: Operation Generator
// Emit a single `final readonly ApiClient` class with one method per OpenAPI
// operation. Path parameters become typed method parameters; JSON request
// bodies are serialized from the typed Model; 2xx JSON responses are
// deserialized back into the typed Model.

#import "@local/speconaut:0.1.0": *
#import "../domain.typ": *

#feature(
  "Operation Generator",
  traces: (
    "src/Generator/Emit/ClientEmitter.php",
    "src/Generator/Emit/OperationAnalyzer.php",
    "src/Generator/Emit/OperationEmitter.php",
    "src/Generator/Emit/ParameterCollector.php",
    "src/Generator/Emit/RequestAssembler.php",
    "src/Generator/Emit/ResponseHandler.php",
    "src/Generator/Emit/ReturnSpec.php",
    "src/Generator/Generator.php",
  ),
  description: [
    Walks #the(Schema)'s `paths` and emits one method per OpenAPI
    #a(Operation) onto a single #the(Client) class. Path parameters appear
    as typed method parameters; `application/json` request bodies carry
    #a(Model) payload; response JSON is deserialized back into the typed
    #a(Model). #the(Client) is emitted as a `final readonly` class whose
    constructor takes a PSR-18 `ClientInterface` together with PSR-17
    request and stream factories, and a base URI string.
  ],
)[

  #rule("Emitting operations as client methods")[
    #scenario(
      "A GET operation with a path parameter becomes a typed client method",
      stage: unstable,
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "GET /store/order/{orderId}")) with #p((id: "operationId: getOrderById")) and path parameter #p((param: "orderId: integer"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[a file `Generated/ApiClient.php` is written under #the(Profile)'s `output`]
      #and_[the emitted class is `final readonly` in #the(Profile)'s namespace `\Generated`]
      #and_[the class has a method `getOrderById(int $orderId): Order` that interpolates #p((token: "{orderId}")) into the request path]
    ]

    #scenario(
      "A POST operation with a JSON body takes a typed Model parameter",
      stage: unstable,
      traces: ("src/Generator/Emit/BodySpec.php",),
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "POST /pet")) with #p((id: "operationId: addPet"))]
      #and_[the request body is `application/json` with schema #p((ref: "#/components/schemas/Pet"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `addPet(Pet $body): Pet`]
      #and_[the method JSON-encodes `$body` and attaches it as the request body]
    ]

    #scenario(
      "A JSON body whose schema is a list of $ref becomes a typed list parameter",
      stage: unstable,
      traces: ("src/Generator/Emit/BodySpec.php",),
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "POST /user/createWithList")) with #p((id: "operationId: createUsersWithListInput"))]
      #and_[the request body is `application/json` with schema `type: array` and items #p((ref: "#/components/schemas/User"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `createUsersWithListInput(array $body)` whose `$body` parameter is annotated `@param list<User> $body`]
      #and_[the method JSON-encodes `$body` and attaches it as the request body]
    ]
  ]

  #rule("Response deserialization")[
    #scenario(
      "A 2xx JSON response body is deserialized into the typed Model",
      stage: unstable,
    )[
      #given[#the(Client) is constructed with a PSR-18 HTTP client that returns status #p((code: "200")) with JSON body #p((body: "{\"id\":42,\"status\":\"placed\"}"))]
      #when[`getOrderById(42)` is called on #the(Client)]
      #then[the return value is #a(Model) `Order` with `id = 42` and `status = 'placed'`]
    ]

    #scenario(
      "A scalar 2xx JSON response is returned as the scalar PHP type without hydration",
      stage: unstable,
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "GET /user/login")) with #p((id: "operationId: loginUser")) whose 200 response schema is `type: string`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method whose return type is `string`]
      #and_[the method body returns `(string) $response->getBody()` and never invokes `self::hydrate`]
    ]

    #scenario(
      "A 2xx JSON response with `additionalProperties` is returned as a typed associative array",
      stage: unstable,
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "GET /store/inventory")) with #p((id: "operationId: getInventory")) whose 200 response schema is `type: object` with #p((map: "additionalProperties: integer"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method whose return type is `array` annotated `@return array<string, int>`]
      #and_[the method body returns the `json_decode`d payload directly without invoking `self::hydrate`]
    ]
  ]

  #rule("Query parameters")[
    #scenario(
      "Query parameters become typed method parameters and are attached as a query string",
      stage: unstable,
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "GET /pet/findByStatus")) with #p((id: "operationId: findPetsByStatus")) and a required query parameter #p((param: "status: string"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method with signature `findPetsByStatus(string $status): array`]
      #and_[calling it with #p((arg: "status: 'available'")) sends a request whose URI ends with #p((query: "?status=available"))]
    ]

    #scenario(
      "An `explode: true` array query parameter is serialised as repeated `name=value` pairs",
      stage: unstable,
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "GET /pet/findByTags")) with #p((id: "operationId: findPetsByTags")) and a required query parameter `tags` #p((schema: "type: array, items.type: string, explode: true"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `findPetsByTags(array $tags): array` annotated `@param list<string> $tags`]
      #and_[calling it with #p((arg: "tags: ['a', 'b']")) sends a request whose URI ends with #p((query: "?tags=a&tags=b")) instead of `tags%5B0%5D=a&tags%5B1%5D=b`]
    ]
  ]

  #rule("Header parameters")[
    #scenario(
      "An optional header parameter becomes a nullable typed argument and is attached only when non-null",
      stage: unstable,
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "DELETE /pet/{petId}")) with #p((id: "operationId: deletePet")) and an optional header parameter `api_key: string`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `deletePet(int $petId, ?string $api_key = null): void`]
      #and_[the method calls `$request->withHeader('api_key', $api_key)` only when `$api_key` is not `null`]
    ]
  ]

  #rule("Reference resolution and path-level parameters")[
    #scenario(
      "An operation-level `$ref` to a component parameter is resolved to a typed method argument",
      stage: unstable,
    )[
      #given[#the(Schema) declares `#/components/parameters/Limit` #p((param: "limit: integer, in: query, required: false"))]
      #and_[#a(Operation) #p((op: "GET /order")) with #p((id: "operationId: listOrders")) lists a parameter whose value is #p((ref: "#/components/parameters/Limit"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `listOrders(?int $limit = null): array`]
      #and_[the operation is *not* silently skipped even though the parameter is a `$ref`]
    ]

    #scenario(
      "An operation-level `$ref` to a header component parameter becomes an optional typed header argument",
      stage: unstable,
    )[
      #given[#the(Schema) declares `#/components/parameters/ApiKey` #p((param: "api_key: string, in: header, required: false"))]
      #and_[#a(Operation) #p((op: "GET /order")) with #p((id: "operationId: listOrders")) lists a parameter whose value is #p((ref: "#/components/parameters/ApiKey"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted method signature includes `?string $api_key = null`]
      #and_[the method body attaches the `api_key` header only when `$api_key` is not `null`]
    ]

    #scenario(
      "A `$ref` to a component requestBody is resolved to the expected Model body parameter",
      stage: unstable,
      traces: ("src/Generator/Emit/BodySpec.php",),
    )[
      #given[#the(Schema) declares `#/components/requestBodies/CreateOrder` with `application/json` schema #p((ref: "#/components/schemas/Order"))]
      #and_[#a(Operation) #p((op: "POST /order")) with #p((id: "operationId: placeOrder")) whose `requestBody` is a #p((ref: "#/components/requestBodies/CreateOrder"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `placeOrder(Order $body): Order`]
      #and_[the operation is *not* silently skipped even though the request body is declared via `$ref`]
    ]

    #scenario(
      "A PathItem-level inline parameter is inherited by every operation under that path",
      stage: unstable,
    )[
      #given[#the(Schema) declares a PathItem `/store/{storeId}/items` with a single PathItem-level parameter #p((param: "storeId: integer, in: path, required: true"))]
      #and_[two operations under it — #p((id: "operationId: listStoreItems")) and #p((id: "operationId: clearStore")) — do not restate the parameter]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has `listStoreItems(int $storeId): array` and `clearStore(int $storeId): void`]
      #and_[neither operation is silently skipped even though the parameter lives only on the PathItem]
    ]

    #scenario(
      "An operation whose PathItem declares a `$ref` parameter is still emitted",
      stage: unstable,
    )[
      #given[#the(Schema) declares `#/components/parameters/PetId` #p((param: "petId: integer, in: path, required: true"))]
      #and_[#a(Operation) #p((op: "GET /pet/{petId}")) with #p((id: "operationId: getPetById")) inherits a PathItem-level parameter whose value is #p((ref: "#/components/parameters/PetId"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `getPetById(int $petId): Pet`]
      #and_[the operation is *not* silently skipped even though the parameter is declared at the PathItem level via `$ref`]
    ]
  ]

  #rule("Error responses")[
    #scenario(
      "A non-2xx response throws a typed ApiException instead of a generic RuntimeException",
      stage: draft,
    )[
      #given[#the(Client) is constructed with a PSR-18 HTTP client that returns status #p((code: "404")) with JSON body #p((body: "{\"message\":\"not found\"}"))]
      #when[`getPetById(999)` is called on #the(Client)]
      #then[the call throws `Generated\\ApiException`]
      #and_[the exception's `getStatusCode()` returns `404`]
      #and_[the exception's `getDecodedBody()` returns the decoded error payload]
    ]
  ]
]
