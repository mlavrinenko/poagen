#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Ship the paogen validate subcommand promised by ADR-006",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "normal",
  spec: "truth/specs/cli.typ",
  decision: "truth/decisions/006-cli-tooling.typ",
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
  `truth/specs/cli.typ` to `stage: unstable` on implementation.
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

== Out of scope

- Profile validation (`paogen.php` sanity checks) — filed as a P3
  nice-to-have in the review.
- Cross-ref semantic validation beyond what the parser provides
  (e.g. "does every `$ref` resolve").

== Acceptance

- The draft `validate` scenario is promoted to `unstable`, and
  the error/no-arg scenarios are locked.
- `bin/paogen validate tests/fixtures/schemas/petstore-3.0.yaml`
  exits 0.
- `bin/paogen validate /nonexistent.yaml` exits non-zero with a
  human-readable error.
- `just check` green end-to-end.
