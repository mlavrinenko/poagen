#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Surface OpenAPI securitySchemes as method/constructor arguments",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "high",
  spec: "truth/specs/operation-generator.typ",
)

== Summary

OpenAPI `securitySchemes` / `security` are completely ignored. Users
must decorate the client for auth today — fine as a philosophy
(ADR-002) but the generator should at least read auth headers and
parameters out of the schema so they appear as constructor or method
arguments.

== Rationale

Pre-release review P1 #13 — coverage gap. Auth is the second question
any real API consumer asks; the generator can do a meaningful chunk of
the wiring without implementing any specific auth flow.

== In scope

+ Add a scenario under the Operation Generator: a schema with an
  `apiKey` security scheme (in header) produces a client constructor
  that takes the API key as a required argument, and every
  operation that references the scheme attaches the key as the
  declared header.
+ Add a scenario for `http` `bearer`: the client constructor takes
  a `string $bearerToken`, and every secured operation attaches
  `Authorization: Bearer <token>`.
+ Leave `http` `basic`, `oauth2`, and `openIdConnect` as
  `stage: draft` placeholders — they need decorator-layer design
  that ADR-002 explicitly punts to runtime.
+ Resolve `securitySchemes` via `$ref` (depends on task 005).

== Out of scope

- OAuth 2 flow automation (authorization code, client credentials).
- Token refresh / rotation.
- Per-operation auth overrides beyond the "secured vs not" boolean.
- Scope enforcement (`security: [scheme: [scope]]`).

== Acceptance

- Two scenarios (apiKey + bearer) locked in the Operation Generator
  feature; remaining schemes left as `draft`.
- A fixture schema (new or extended Petstore) exercises apiKey
  and/or bearer auth, with golden output showing the constructor +
  per-operation header attachment.
- `just check` green end-to-end.
