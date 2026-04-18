#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Extend ApiClient emitter to cover headers, scalar responses and list bodies",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "normal",
  spec: "truth/specs/operation-generator.typ",
)

== Summary

The Operation Generator PoC emits a method only when the operation's
parameters are all `path` (plus scalar `query`, as of commit
#raw("78f1e40")) and its body/response are `$ref`-to-Model (or absent,
or `list<$ref>` for responses). Operations outside that envelope are
silently skipped. The Petstore fixture still has known gaps; this task
closes them one scenario at a time.

== Rationale

Each skipped op leaves a real-world Petstore endpoint unreachable from
the generated client and is a small, self-contained spec-first slice.

== In scope

Each bullet gets its own scenario under
`truth/specs/operation-generator.typ`:

+ *Header parameters.* Emit typed method parameters; attach via
  `withHeader` only when non-null. Cover `deletePet`'s optional
  `api_key` header.
+ *Scalar responses.* e.g. `loginUser` → `string`. Return
  `(string) $response->getBody()` directly without hydration.
+ *List-of-Model request bodies.* e.g. `createUsersWithListInput` →
  `list<User> $body`. `json_encode` is already recursive so the wire
  side works; the method signature and the body phpdoc are what need
  doing.
+ *Map responses* (`additionalProperties`). e.g. `getInventory` →
  `array<string, int>`. Return the decoded array with a narrowing
  `@return` phpdoc.
+ *Array query parameters* (`findPetsByTags` — `type: array`,
  `explode: true`). Build the query string manually (`tags=a&tags=b`)
  instead of relying on `http_build_query`'s default `tags[0]=a`
  syntax.

== Out of scope (file a follow-up task if they start to matter)

- Form-encoded bodies (`application/x-www-form-urlencoded`).
- Binary bodies (`application/octet-stream`, `multipart/form-data`).
- Content-type negotiation; `application/json` is always picked.
- Error-response handling. Non-2xx currently lands in `hydrate()` and
  throws on non-array data — a future scenario should formalise what
  to throw on 4xx / 5xx.

== Acceptance

- Every bullet above has a dedicated scenario in the Operation
  Generator feature, confirmed via `speconaut implemented -s …`.
- Petstore golden fixture at
  `tests/fixtures/generated/petstore/Generated/ApiClient.php`
  regenerated with every previously-skipped operation now emitted.
- `OperationEmitter.php` stays under ADR-004's 250-line limit
  (split into `RequestAssembler` / `ResponseHandler` if needed).
- `just check` green end-to-end.
