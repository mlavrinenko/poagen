#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "08b3db39-6e59-4be5-908f-798035cc8199",
  title: "Silence cebe/php-openapi PHP 8.4 deprecation noise on the 3.0 parser",
  status: done(2026, 4, 19),
  priority: 5,
  x-paogen: (spec: "truth/specs/model-generator.typ", decision: "truth/decisions/008-openapi-31-strategy.typ", legacy-id: "T-016"),
)

== Summary

The whole test suite prints 8 PHP 8.4 deprecations from
`cebe/php-openapi`:
`SpecBaseObject::resolveReferences(): Implicitly marking parameter
$context as nullable is deprecated`. `tests/generated/…` suppresses
them locally via `error_reporting`, but every consumer will see them.
Upstream 1.8.0 has not moved since May 2025.

== Rationale

Pre-release review P2 #15 — packaging gap. `openapi-31-strategy` defers
the 3.1 question post-v0.1 and explicitly *decouples* this deprecation fix
from the parser-strategy question. We are staying on
`cebe/php-openapi` 3.0 for the first release; the deprecation noise
is a user-visible defect that must be silenced before the tag.

== In scope

+ Pick the lowest-risk fix that removes the deprecation notices on
  PHP 8.4:
  - *Preferred:* upstream a patch to `cebe/php-openapi` that adds
    explicit `?` on the affected parameter signatures. If upstream
    merges, pin that minor version in `composer.json`.
  - *Fallback:* vendor a minimal local patch via
    `cweagans/composer-patches` against the same signatures. Document
    the patch provenance in `composer.json` / a `patches/` directory.
+ Remove the `error_reporting` suppression in
  `tests/generated/OperationGeneratorSteps.php:230` once the
  deprecations are silenced.
+ Add a regression test: running `bin/paogen generate <petstore>`
  must produce zero PHP deprecation notices on 8.4.

== Non-goals

- Adding OpenAPI 3.1 *support*. `openapi-31-strategy` defers that
  post-v0.1. If an upstream upgrade delivers 3.1 as a side effect, that
  is a separate follow-up task and a new ADR superseding
  `openapi-31-strategy`.
- Swapping parsers entirely (`devizzent/cebe-php-openapi`, fork,
  etc.). Those were options (a)/(c) in `openapi-31-strategy` and are
  rejected for v0.1.

== Acceptance criteria

- PHPUnit `D` deprecation column disappears from `just check`.
- `error_reporting` suppression removed from the step class.
- `composer.json` reflects the chosen route (upstream pin or local
  composer-patch), with the patch source documented.
- `just check` green end-to-end.
