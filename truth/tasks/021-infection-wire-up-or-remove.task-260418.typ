#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "daa1d41a-ec28-413c-aa76-e16c0737568f",
  title: "Wire up infection mutation testing or drop the dev dependency",
  status: done(2026, 4, 18),
  priority: 5,
  x-paogen: (decision: "truth/decisions/004-quality-gates.typ", legacy-id: "T-021"),
)

== Summary

`infection/infection` is listed in `require-dev` but there is no
`infection.json5` and no Justfile recipe to run it. The mention-without-
implementation pattern is exactly what
`quality-gates-at-maximum-strictness` ("quality gates") is supposed to
prevent.

== Rationale

Pre-release review P2 #21 — packaging gap. Either wire it up or
remove it.

== In scope

+ Pick one direction:
  - *Wire up.* Add `infection.json5` with reasonable defaults
    (source `src/`, exclude `tests/fixtures/generated/`, MSI
    target documented, timing/memory tuned for the current
    codebase). Add a `just infection` recipe. Update
    `quality-gates-at-maximum-strictness` to list mutation testing as a
    gate (or explicitly as an "advisory" gate if the MSI target is too
    punishing for the PoC).
  - *Remove.* Drop `infection/infection` from
    `composer.json`'s `require-dev`. Update
    `quality-gates-at-maximum-strictness` to note that mutation testing
    is deferred.
+ No new spec scenarios — policy / tooling change.

== Non-goals

- Tuning MSI or MCC targets beyond "pick a defensible starting
  number".
- Running infection in CI in parallel with phpunit — local-only is
  fine for v0.1.

== Acceptance criteria

- `just infection` works from a fresh clone, *or* the dev-dep is
  gone and `quality-gates-at-maximum-strictness` reflects that.
- `quality-gates-at-maximum-strictness` updated either way.
- `just check` green end-to-end.

== Resolution

Removed. `infection/infection` (and its `infection/extension-installer`
plugin allow-list entry) was dropped from `composer.json`'s
`require-dev`; the "Mutation testing" row is also gone from
`CONTRIBUTING.md`'s Tooling table.
`quality-gates-at-maximum-strictness` needed no amendment — it never
mentioned mutation testing, so there was nothing to flip from
"advisory" to "deferred". If mutation testing is reconsidered, file a
fresh task rather than reopening this one.
