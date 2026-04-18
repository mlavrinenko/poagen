#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Silence cebe/php-openapi PHP 8.4 deprecation noise on the 3.0 parser",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 19),
  priority: "normal",
  spec: "truth/specs/model-generator.typ",
  decision: "truth/decisions/008-openapi-31-strategy.typ",
)

== Summary

The whole test suite prints 8 PHP 8.4 deprecations from
`cebe/php-openapi`:
`SpecBaseObject::resolveReferences(): Implicitly marking parameter
$context as nullable is deprecated`. `tests/generated/…` suppresses
them locally via `error_reporting`, but every consumer will see them.
Upstream 1.8.0 has not moved since May 2025.

== Rationale

Pre-release review P2 #15 — packaging gap. ADR-008 defers the 3.1
question post-v0.1 and explicitly *decouples* this deprecation fix
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

== Out of scope

- Adding OpenAPI 3.1 *support*. ADR-008 defers that post-v0.1. If
  an upstream upgrade delivers 3.1 as a side effect, that is a
  separate follow-up task and a new ADR superseding 008.
- Swapping parsers entirely (`devizzent/cebe-php-openapi`, fork,
  etc.). Those were options (a)/(c) in ADR-008 and are rejected for
  v0.1.

== Acceptance

- PHPUnit `D` deprecation column disappears from `just check`.
- `error_reporting` suppression removed from the step class.
- `composer.json` reflects the chosen route (upstream pin or local
  composer-patch), with the patch source documented.
- `just check` green end-to-end.
