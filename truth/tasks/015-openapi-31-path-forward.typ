#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Pick a path forward for OpenAPI 3.1 support",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "high",
  spec: "truth/specs/model-generator.typ",
  decision: "truth/decisions/008-openapi-31-strategy.typ",
)

== Summary

`docs/design/openapi-3.1-gap.md` is thorough, but the issue is open.
Most modern real-world schemas (GitHub, Stripe, Kubernetes) are 3.1
and the current `cebe/php-openapi` parser does not support them.
ADR-008 (proposed) lays out three options; this task confirms one.

== Rationale

Pre-release review P1 #14 — coverage gap. Without a decision, the
validation tier in ADR-005 cannot be reached. This task produces the
decision *and* a prototype; it does not have to ship the final
implementation.

== In scope

+ Produce a working prototype of the approach recommended in
  ADR-008 (option (b): 3.1 → 3.0 translator shim).
+ Cover, at minimum, the five common 3.1 / 2020-12 divergences:
  nullable (`type: [X, null]`), type arrays
  (`type: [string, integer]`), `exclusiveMinimum` / `exclusiveMaximum`
  as numbers, `const` keyword, and top-level `webhooks` (drop or
  warn — does not need full support).
+ Add a fixture schema under `tests/fixtures/schemas/` authored as
  3.1 and demonstrate that it now generates a consumer-usable client.
+ Update ADR-008's status to `accepted` if (b) works; otherwise
  supersede with the chosen alternative and explain the pivot in
  the ADR body.
+ Add a scenario under the Model Generator: "an OpenAPI 3.1 schema
  with `type: [string, null]` becomes a nullable PHP property"
  (promote from draft on implementation).

== Out of scope

- Full JSON-Schema-2020-12 support. Only cover what OpenAPI 3.1
  actually uses in practice.
- Round-tripping 3.1 → 3.0 → 3.1 losslessly — the shim is one-way.
- Migrating to `devizzent/cebe-php-openapi` as a short-circuit —
  that's option (a) in ADR-008 and is deliberately the *last*
  preference.

== Acceptance

- A prototype translator lands under `src/` (or is discarded with a
  written justification in the ADR).
- ADR-008 status is either `accepted` (with confirmed path) or
  explicitly superseded by the task's findings.
- A new 3.1 fixture schema has golden output committed under
  `tests/fixtures/generated/`.
- `just check` green end-to-end.
