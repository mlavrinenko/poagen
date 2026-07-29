#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "001c5b17-bd65-4350-926e-e063c56822c8",
  title: "Ship the paogen validate subcommand promised by ADR-006",
  status: done(2026, 4, 18),
  priority: 5,
  x-paogen: (spec: "truth/specs/cli.typ", decision: "truth/decisions/006-cli-tooling.typ", legacy-id: "T-018"),
)

== Summary

ADR-006 lists `paogen validate <schema>` as part of the tiny CLI
surface. Only `generate`, `help`, and `version` exist today. Either
ship `validate` or retire the promise — the review says ship it.

== Rationale

Pre-release review P2 #18 — packaging gap. The validate subcommand is
already in the advertised CLI surface; its absence is a 3/4 gap that
will bite early adopters.

== In scope

+ Promote the draft `validate` scenario under
  #link("../specs/cli.feature-260417.typ") to `stage: unstable` on implementation.
+ Implement `paogen validate <schema>`:
  - Accepts a path to an OpenAPI schema (YAML or JSON).
  - Runs the parser (`cebe/php-openapi` today; whatever task 016
    picks tomorrow) and reports any spec-level issues.
  - Exits 0 on success, 1 on validation errors, 2 on usage errors
    (matching the existing exit-code pattern in `src/Cli.php`).
+ Add at least three cli scenarios:
  - `validate` on a valid fixture schema exits 0.
  - `validate` on a malformed YAML exits 1 with the underlying
    parse error on stderr.
  - `validate` with no argument exits 2 and prints usage on
    stderr.

== Non-goals

- Profile validation (`paogen.php` sanity checks) — filed as a P3
  nice-to-have in the review.
- Cross-ref semantic validation beyond what the parser provides
  (e.g. "does every `$ref` resolve").

== Acceptance criteria

- The draft `validate` scenario is promoted to `unstable`, and
  the error/no-arg scenarios are locked.
- `bin/paogen validate tests/fixtures/schemas/petstore-3.0.yaml`
  exits 0.
- `bin/paogen validate /nonexistent.yaml` exits non-zero with a
  human-readable error.
- `just check` green end-to-end.

== Resolution

- `Cli::run()` dispatches `validate` to a new
  `Cli::validate(array $args, $stdout, $stderr): int`. Exit codes:
  2 on missing argument (usage error), 1 on missing file, parse
  failure, or `OpenApi::validate()` returning false, 0 on success.
  The success line is `paogen: <path> is a valid OpenAPI document`
  on stdout. The implementation auto-picks JSON vs YAML by file
  extension and passes `resolveReferences: false` — matching the
  `Generator` path — because cebe rejects relative paths even with
  resolution off, so the CLI `realpath()`s the input before
  handing it to `Reader`.
- `USAGE` grew a `validate <schema>` row.
- `bin/paogen` now silences `E_DEPRECATED` / `E_USER_DEPRECATED` at
  the CLI entry point so users do not see cebe's PHP 8.4 nullable-
  type deprecations. Scoped to the CLI process, does not affect
  phpunit (which has its own suppression in `tests/bootstrap.php`)
  or the library API when consumed as a Composer dep.
- #link("../specs/cli.feature-260417.typ") rule "Validate subcommand" now has three
  scenarios (valid / malformed / no-arg), all `stage: unstable`,
  locked. The malformed scenario uses `<that-path>` as a sentinel
  substituted at test time with a `tempnam()`-created file, so the
  suite does not depend on `/tmp/broken.yaml` being available or
  writable.
