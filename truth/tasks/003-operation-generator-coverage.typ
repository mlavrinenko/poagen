#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Extend ApiClient emitter to cover query params, arrays and scalars",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "normal",
  spec: "truth/specs/operation-generator.typ",
)

== Context

The Operation Generator PoC only emits a method when every condition
below holds:

- every `parameters[*].in` is `path` (optional `header` parameters are
  silently dropped);
- the request body is either absent or an `application/json` media type
  whose schema is a `$ref` to a component in `components.schemas`;
- the 2xx response is either absent, a `$ref` to a Model, or an array
  of `$ref`-to-Model.

Anything else is silently skipped, so the Petstore fixture currently
emits only 11 of ~19 operations (see diff in
`tests/fixtures/generated/petstore/Generated/ApiClient.php`).

== In scope

Extend `OperationAnalyzer` / `OperationEmitter` so the following stop
being skipped. Each bullet should get its own scenario under
`truth/specs/operation-generator.typ` (spec-first):

+ *Query parameters.* Emit typed method parameters after the path
  params; assemble the query string via `http_build_query` appended
  with `?`. Required params → required PHP params; optional params →
  nullable with default `null`, skipped from the query string when
  null. Cover `explode: true` with array items
  (`findPetsByStatus`, `findPetsByTags` are the test cases).
+ *Header parameters.* Emit typed method parameters; attach via
  `withHeader`. Cover `deletePet`'s optional `api_key` header.
+ *Scalar responses.* e.g. `loginUser` → `string`. Return
  `(string) $response->getBody()` directly without hydration.
+ *List-of-Model request bodies.* e.g. `createUsersWithListInput` →
  `list<User> $body`. `json_encode` is already recursive so the
  request side works; the method signature is what needs doing.
+ *Map responses* (`additionalProperties`). e.g.
  `getInventory` → `array<string, int>`. Return the decoded array
  with a narrowing `@return` phpdoc.

== Out of scope (file as follow-ups if needed)

- Form-encoded bodies (`application/x-www-form-urlencoded`).
- Binary bodies (`application/octet-stream`,
  `multipart/form-data`).
- Non-trivial content-type negotiation; we pick `application/json`
  unconditionally.
- Error-response handling. Non-2xx responses currently produce
  undefined behaviour (the hydrator throws on non-array body). A
  separate scenario should formalise what to throw on 4xx/5xx.

== Verification

- New scenarios added to `truth/specs/operation-generator.typ` and
  confirmed via `speconaut implemented -s …`.
- Petstore golden fixture regenerated with every previously-skipped
  operation now emitted. Line-count budget: may push
  `OperationEmitter.php` past ADR-004's 250-line limit — plan to
  split into `RequestAssembler` and `ResponseHandler` at the time of
  implementation.
- `just check` green end-to-end.
