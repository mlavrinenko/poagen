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
      traces: ("src/Generator/Generator.php",),
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
      traces: ("src/Generator/Generator.php",),
    )[
      #given[#the(Schema) declares #a(Operation) #p((op: "POST /pet")) with #p((id: "operationId: addPet"))]
      #and_[the request body is `application/json` with schema #p((ref: "#/components/schemas/Pet"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) has a method `addPet(Pet $body): Pet`]
      #and_[the method JSON-encodes `$body` and attaches it as the request body]
    ]
  ]

  #rule("Response deserialization")[
    #scenario(
      "A 2xx JSON response body is deserialized into the typed Model",
      stage: unstable,
      traces: ("src/Generator/Generator.php",),
    )[
      #given[#the(Client) is constructed with a PSR-18 HTTP client that returns status #p((code: "200")) with JSON body #p((body: "{\"id\":42,\"status\":\"placed\"}"))]
      #when[`getOrderById(42)` is called on #the(Client)]
      #then[the return value is #a(Model) `Order` with `id = 42` and `status = 'placed'`]
    ]
  ]
]
