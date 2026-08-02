#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "c8d76e3b-328b-4dac-aa18-d08a760be2a1",
  title: "Surface OpenAPI securitySchemes as method/constructor arguments",
  status: done(2026, 4, 18),
  priority: 7,
  x-paogen: (spec: "truth/specs/operation-generator.typ", legacy-id: "T-014"),
)

== Summary

OpenAPI `securitySchemes` / `security` are completely ignored. Users
must decorate the client for auth today — fine as a philosophy
(`no-inheritance-no-protected-regions`) but the generator should at least read auth headers and
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
  that `no-inheritance-no-protected-regions` explicitly punts to runtime.
+ Resolve `securitySchemes` via `$ref` (depends on task 005).

== Non-goals

- OAuth 2 flow automation (authorization code, client credentials).
- Token refresh / rotation.
- Per-operation auth overrides beyond the "secured vs not" boolean.
- Scope enforcement (`security: [scheme: [scope]]`).

== Acceptance criteria

- Two scenarios (apiKey + bearer) locked in the Operation Generator
  feature; remaining schemes left as `draft`.
- A fixture schema (new or extended Petstore) exercises apiKey
  and/or bearer auth, with golden output showing the constructor +
  per-operation header attachment.
- `just check` green end-to-end.
