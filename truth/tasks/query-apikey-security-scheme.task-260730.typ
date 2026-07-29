#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Thread an apiKey security scheme declared in the query string",
  tags: ("generator", "security", "strictness"),
  priority: 8,
  difficulty: 3,
  status: proposed(2026, 7, 30),
)

== Summary

`SecurityScheme::fromCebe()` recognises `apiKey` only when `in: header`, plus
`http` `bearer`. Every other scheme becomes `KIND_UNSUPPORTED`, and
`SecuritySchemeCatalog` then filters unsupported schemes out of both
`constructorSchemes()` and `activeSchemesFor()`. Nothing is reported.

For a document whose only scheme is a query-string `apiKey` applied globally,
the consequence is a client that compiles, passes analysis, takes no credential
in its constructor, and sends every request unauthenticated. The run exits 0.

That is the exact failure `fail-loud-never-silent` was written against, and it
is worse than a dropped operation, because a dropped operation is a missing
method the compiler points at, while this one is a 403 in production.

The kilbil loyalty document is the case:

```
securitySchemes: {"h": {"type": "apiKey", "in": "query", "name": "h"}}
global security:  ["h"]
```

Its own description says so in prose too:
`https://bonus.kilbil.ru/load/{название_функции}?h={ключ}`. There are 36
operations, all inheriting the global requirement, and 6 unrelated query
parameters across the document — so the query-string assembly the emitter
already has is where the key belongs.

Wiring order matters and is the one design constraint. `RequestAssembler`
appends the query string to `$path` before `createRequest()`, then attaches
security as headers afterwards; a query-string credential has to join the
`$query` array instead, which means the active schemes have to reach
`emitQueryAssembly()` rather than only `emitSecurityHeaders()`.

== Acceptance criteria

- An `apiKey` scheme with `in: query` produces a constructor argument on the
  emitted client, exactly as the header variant already does.
- Every operation the scheme applies to appends `<name>=<urlencoded key>` to
  the request query string, and does so whether or not the operation declares
  query parameters of its own.
- The credential is urlencoded, and an operation that also has its own query
  parameters emits one well-formed query string rather than two `?` separators.
- An operation-level `security: []` still disables it, and an operation-level
  requirement naming a different scheme still overrides the global one.
- A test asserts the credential reaches the wire, not merely that the
  constructor argument exists — a generated client whose key is accepted and
  never sent is the bug this task is about.
- `in: cookie` is still not wired, and remains reported by
  `report-unsupported-security-schemes` rather than being silently dropped
  here.

== Non-goals

- `http basic`, `oauth2` and `openIdConnect`. Those stay with
  `report-unsupported-security-schemes`, which decides what an unwireable
  scheme does rather than adding more kinds.
- Moving authentication out of the generated client into a decorator. ADR-002
  settled that transport concerns compose underneath; a declared credential the
  schema names is still the client's to send.
- Credential storage, refresh, or rotation.

== Files

- `src/Generator/Emit/SecurityScheme.php`
- `src/Generator/Emit/SecuritySchemeCatalog.php`
- `src/Generator/Emit/RequestAssembler.php`
- `tests/`
