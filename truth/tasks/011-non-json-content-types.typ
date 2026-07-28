#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "672677ed-1a85-40c5-b819-f7bef1a90a77",
  title: "Support application/x-www-form-urlencoded and stub multipart/form-data",
  status: done(2026, 4, 18),
  priority: 7,
  x-paogen: (spec: "truth/specs/operation-generator.typ", legacy-id: "T-011"),
)

== Summary

Petstore's `uploadFile` (`multipart/form-data`) is silently skipped
today, and `application/x-www-form-urlencoded` bodies never become
method parameters. `application/json` is the only supported content
type. At minimum, form-urlencoded must land before "stable" status.

== Rationale

Pre-release review P1 #10 — coverage gap. This task is deliberately
scoped narrower than the review's full list of content types: ship
form-urlencoded proper, and leave multipart as an explicit
out-of-scope stub.

== In scope

+ Add a scenario under the Operation Generator for an
  `application/x-www-form-urlencoded` body: the operation takes typed
  parameters (one per form field) and the generator emits
  `http_build_query(...)` to assemble the body, with
  `Content-Type: application/x-www-form-urlencoded`.
+ Detect `multipart/form-data` in `OperationAnalyzer` and, instead
  of silently skipping, mark the operation as explicitly unsupported
  with a `// TODO(multipart): see task 011` comment and a
  generator-time warning. The operation *is still emitted* — but its
  body is `throw new \\RuntimeException('multipart not yet supported')`.
+ Extend `tests/fixtures/generated/petstore/` so `uploadFile` is now
  visible (as the throwing stub) rather than absent.
+ Update ADR or task 001's out-of-scope list if the phrasing needs
  alignment.

== Non-goals

- Actual multipart body assembly (files, streams, PSR-7 multipart
  helpers). Future task once a user asks.
- `application/octet-stream` binary bodies.
- Content-type negotiation at runtime; `application/json` is still
  preferred on responses.

== Acceptance criteria

- New scenario for form-urlencoded is locked in the Operation
  Generator feature.
- `uploadFile` appears in the Petstore golden fixture as a stub.
- A regression test covers the form-urlencoded round-trip against a
  fake PSR-18 client.
- `just check` green end-to-end.
