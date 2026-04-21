#import "@local/speconaut:0.1.0": task, done

#show: task.with(
  id: "daa1d41a-ec28-413c-aa76-e16c0737568f",
  title: "Wire up infection mutation testing or drop the dev dependency",
  status: done,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "normal",
  decision: "truth/decisions/004-quality-gates.typ",
)

== Summary

`infection/infection` is listed in `require-dev` but there is no
`infection.json5` and no Justfile recipe to run it. The mention-without-
implementation pattern is exactly what ADR-004 ("quality gates") is
supposed to prevent.

== Rationale

Pre-release review P2 #21 — packaging gap. Either wire it up or
remove it.

== In scope

+ Pick one direction:
  - *Wire up.* Add `infection.json5` with reasonable defaults
    (source `src/`, exclude `tests/fixtures/generated/`, MSI
    target documented, timing/memory tuned for the current
    codebase). Add a `just infection` recipe. Update ADR-004 to
    list mutation testing as a gate (or explicitly as an
    "advisory" gate if the MSI target is too punishing for the
    PoC).
  - *Remove.* Drop `infection/infection` from
    `composer.json`'s `require-dev`. Update ADR-004 to note that
    mutation testing is deferred.
+ No new spec scenarios — policy / tooling change.

== Out of scope

- Tuning MSI or MCC targets beyond "pick a defensible starting
  number".
- Running infection in CI in parallel with phpunit — local-only is
  fine for v0.1.

== Acceptance

- `just infection` works from a fresh clone, *or* the dev-dep is
  gone and ADR-004 reflects that.
- ADR-004 updated either way.
- `just check` green end-to-end.

== Resolution

Removed. `infection/infection` (and its `infection/extension-installer`
plugin allow-list entry) was dropped from `composer.json`'s
`require-dev`; the "Mutation testing" row is also gone from
`CONTRIBUTING.md`'s Tooling table. ADR-004 needed no amendment — it
never mentioned mutation testing, so there was nothing to flip from
"advisory" to "deferred". If mutation testing is reconsidered, file a
fresh task rather than reopening this one.
