#import "@local/speconaut:0.1.0": task, done

#show: task.with(
  title: "Enforce a coverage threshold in CI or drop the codecov pretence",
  status: done,
  date: datetime(year: 2026, month: 4, day: 19),
  priority: "normal",
  decision: "truth/decisions/004-quality-gates.typ",
)

== Summary

`continuous-integration.yml` uploads coverage to codecov but sets no
minimum threshold. `codecov.yml` is 400 bytes and enforces nothing.
The review is explicit: enforce (80%+ for `src/`) or delete to stop
pretending.

== Rationale

Pre-release review P2 #20 — packaging gap. Either decision is fine;
the anti-pattern is "we have codecov wired but the number doesn't
matter". ADR-004 governs quality gates; a coverage threshold belongs
there once chosen.

== In scope

+ Pick one direction:
  - *Enforce.* Set a `src/` line-coverage threshold (suggested: 80%
    to start, with a documented step-up to 90% by v0.1) in
    `codecov.yml` *and* in the CI workflow (so the PR check is
    red, not just the codecov widget). Document the threshold in
    ADR-004.
  - *Drop.* Remove `codecov.yml`, remove the coverage upload step
    from `continuous-integration.yml`, and note in ADR-004 that
    coverage is not a v0.1 gate.
+ Whichever direction is chosen, update ADR-004's "Consequences"
  section to reflect it.
+ No new spec scenarios needed — this is pure CI / policy.

== Out of scope

- Branch coverage (line coverage only for v0.1).
- Mutation testing — filed separately as task 021.
- Per-file coverage rules.

== Acceptance

- ADR-004 reflects the chosen direction (and status stays
  `accepted`).
- `.github/workflows/continuous-integration.yml` and
  `codecov.yml` match the chosen direction.
- `just check` green end-to-end.

NOTE: This task modifies `.github/workflows/` — coordinate with
whoever is editing that directory in parallel before starting.
