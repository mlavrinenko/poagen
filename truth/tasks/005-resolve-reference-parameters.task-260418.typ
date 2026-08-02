#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "7b339f0c-be3a-47dc-a2ec-c89647dacc95",
  title: "Resolve $ref-to-Parameter/Header/RequestBody at the analyzer boundary",
  status: done(2026, 4, 18),
  priority: 9,
  x-paogen: (spec: "truth/specs/operation-generator.typ", legacy-id: "T-005"),
)

== Summary

`OperationAnalyzer::pathParameters()` returns `null` on the first
`Reference` it encounters, causing `OperationEmitter::emit()` to
silently skip the entire operation. Real-world schemas (GitHub,
Kubernetes — both on `schema-fixture-policy`'s validation list) `$ref` common
parameters heavily. Without inline-resolution, most operations vanish.

== Rationale

Pre-release review P0 #4 — release blocker. This is a silent-skip
class: the operation simply doesn't appear in the generated client,
and no one notices until a user tries to call it.

== In scope

+ Add a scenario under the Operation Generator (ships as `stage:
  draft` via the parallel spec-extension task; this task promotes it
  to `unstable` on implementation): an operation whose parameter list
  contains a `$ref` to `#/components/parameters/X` still produces a
  method with the same signature as the resolved parameter.
+ Resolve `Reference` nodes inside the operation + parameter +
  header + requestBody tree at the analyzer boundary (either via
  `Reader::readFromYamlFile(..., resolveReferences: true)` or an
  explicit resolver walk).
+ Cover referenced header parameters (`#/components/headers/X`) in
  addition to path/query parameters.
+ Regenerate any golden fixture that grows operations as a result.

== Non-goals

- Path-item-level parameters (task 006).
- Cross-file `$ref` (external documents) — still out of scope for
  v0.1.
- Reference chains (`$ref` → `$ref`) — resolve at most one hop; if a
  real fixture needs chains, file a follow-up.

== Acceptance criteria

- The spec scenario is promoted from `draft` to `unstable` and
  locked.
- A fixture schema (new or existing) with a `$ref` parameter is
  added under `tests/fixtures/schemas/`, and the corresponding
  generated operation is present in its golden tree.
- No previously-emitted Petstore operations regress.
- `just check` green end-to-end.
