#import "@local/speconaut:0.1.0": task, done

#show: task.with(
  title: "examples/ folder: user-facing demonstrations with check-examples recipe",
  status: done,
  date: datetime(year: 2026, month: 4, day: 19),
  priority: "normal",
  spec: "truth/specs/cli.typ",
  decision: "truth/decisions/005-schema-fixture-policy.typ",
)

== Summary

Add a top-level `examples/` folder whose sub-directories each look
like a standalone consumer project: own `composer.json`, own
`README.md`, own `paogen.php`, own `schemas/`, own committed
`generated/` tree. Land three examples at creation:

- `examples/petstore` — the ADR-005 PoC fixture, fully working.
- `examples/digitalocean` — the ADR-005 validation-tier schema
  (2.7 MB, 722 components, 2 invalid PHP names). Marked
  `expected-failure` until T-023 lands.
- `examples/github` — the ADR-005 validation-tier schema (8.8 MB,
  918 components, 818 invalid PHP names). Marked `expected-failure`
  until T-023 lands.

Add a `just check-examples` recipe that walks every `examples/*/`,
invokes the generator, and reports pass/fail. The recipe is *not*
part of `just check` — broken examples are deliberately committed as
"this is what we want to work next", and must not gate unrelated
changes.

== Rationale

- ADR-005's validation-tier schemas have been listed as post-v0.1
  follow-ups for weeks. Landing the scaffolding early means the
  smallest possible diff the day T-023 unblocks them: flip a marker,
  regenerate, commit the golden tree.
- Users opening the repo today get a `tests/fixtures/` tree that is
  optimised for generator regression testing, not for "what does
  consuming paogen feel like in my own project". Separate-project
  scaffolding answers the second question directly.
- `check-examples` makes broken examples loudly visible during
  ordinary development (anyone curious can run it) without blocking
  the main build. It also documents progress: the day T-023 lands,
  `check-examples` goes all-green and nobody has to remember which
  examples were still broken.

== In scope

+ Create `examples/README.md` that indexes the examples and explains
  the "separate-project" convention.
+ For each example directory:
  - `README.md` — what the example demonstrates, any known
    blockers (file links to `truth/tasks/NNN-*.typ`), how to run.
  - `composer.json` — references the parent paogen repo via a
    `path` composer repository so `composer install` in the
    sub-directory produces a runnable CLI. No network dependency.
  - `paogen.php` — the Profile.
  - `schemas/<vendor>-<version>.yaml` — the vendored schema
    (bundled variant, no external `$ref`s).
  - `generated/` — committed output when the example passes;
    absent when `expected-failure`.
  - `.expected-failure` — a file whose presence marks the example
    as known-broken and optionally explains why (contents shown
    by `check-examples`).
+ `just check-examples` Justfile recipe:
  - Iterates `examples/*/paogen.php`.
  - For a passing example, runs
    `paogen generate --diff paogen.php`; non-zero is drift.
  - For an `expected-failure` example, runs
    `paogen generate --dry-run paogen.php` and *inverts* the exit
    code — success becomes a loud warning that the marker is now
    stale.
  - Summarises at the end. Returns non-zero only on *unexpected*
    outcomes (genuine drift, or stale `expected-failure` markers).
+ Wire a short paragraph in the root `README.md` pointing at
  `examples/` as the canonical "what does using paogen look like"
  entry point.
+ Add an entry under the "Post-v0.1 follow-ups" section of
  `ROADMAP.md` (or move this task under a phase once T-023 is
  scheduled there).

== Out of scope

- Running `just check-examples` from `just check` or from CI. We may
  promote it post-T-023 — until then keep it manual-only.
- Publishing the `examples/*/composer.json` as real Packagist
  packages. They are demonstrations, not libraries.
- Re-bundling the vendored schemas with redocly or similar. Vendor
  whatever the upstream publishes as its pre-bundled artifact.
- Byte-stability assertions against the example trees. T-022 already
  asserts the stronger invariant against `petstore`; covering the
  examples would be duplicative.
- Any content under `examples/` that isn't a direct demonstration
  of generator usage (tutorials, walkthroughs, etc. — separate
  effort if desired).

== Acceptance

- `examples/petstore` passes `just check-examples` (no drift vs
  committed golden tree).
- `examples/digitalocean` and `examples/github` fail generation at
  the expected point; `just check-examples` reports them as
  `expected-failure` and exits zero.
- Removing a `.expected-failure` marker (or adding one to a
  currently-passing example) makes `just check-examples` fail,
  proving the inversion works.
- The top-level `README.md` links to `examples/README.md`.
- The three example directories each stand alone: copying any one
  to a sibling path and running `composer install` + the generator
  works without referencing anything outside that directory and
  the parent paogen path.
