#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Resolve the cebe/php-openapi deprecation-noise and 3.1 question",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
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

Pre-release review P2 #15 — packaging gap. Entangled with the 3.1
decision (ADR-008); this task lands the fix ADR-008 picks, regardless
of which option wins.

== In scope

+ Depending on the decision confirmed under ADR-008:
  - If (b) shim stays the chosen path: upstream a patch to
    `cebe/php-openapi` removing the implicit-nullable deprecations,
    *or* vendor a minimal composer-patch (e.g. via
    `cweagans/composer-patches`) that fixes the signatures locally.
  - If (c) fork: stand up the fork, retarget autoload via a
    `composer.json` `repositories` entry.
  - If (a) swap: migrate to `devizzent/cebe-php-openapi` and update
    every `use` site.
+ Remove the `error_reporting` suppression in
  `tests/generated/OperationGeneratorSteps.php:230` once the
  deprecations are silenced upstream / in-fork.
+ Add a regression test: running `bin/paogen generate <petstore>`
  must produce zero PHP deprecation notices on 8.4.

== Out of scope

- Adding full 3.1 *support* — that is task 015's job. This task
  only removes the deprecation noise from whatever parser we end up
  on.
- Switching parsers entirely if ADR-008's pick says "don't".

== Acceptance

- PHPUnit `D` deprecation column disappears from `just check`.
- `error_reporting` suppression removed from the step class.
- `composer.json` reflects the chosen route (patch, fork, or
  swap).
- `just check` green end-to-end.
