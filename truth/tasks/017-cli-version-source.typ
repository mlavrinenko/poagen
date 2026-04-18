#import "@local/speconaut:0.1.0": *

#show: task.with(
  title: "Read the CLI version from Composer metadata instead of a hard-coded const",
  status: accepted,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "normal",
  spec: "truth/specs/cli.typ",
  decision: "truth/decisions/006-cli-tooling.typ",
)

== Summary

`src/Cli.php:25` hardcodes `VERSION = '0.1.0-dev'`. There is no sync
with git tags, no `composer.json` `version` field. Every release would
need a manual edit + commit, which is error-prone on a tool meant to
be "boring and reliable" (ADR-006).

== Rationale

Pre-release review P2 #17 — packaging gap. Another agent may already
be shipping this; filing anyway so the work item is tracked. Close as
duplicate if so.

== In scope

+ Replace the hard-coded `Cli::VERSION` with a runtime lookup via
  `Composer\\InstalledVersions::getPrettyVersion('paogen/paogen')`
  (or whatever the package name will be), with a sensible fallback
  string ("dev" or the last-known-tag) when Composer metadata is
  unavailable (e.g. phar / vendored scenarios).
+ Update the existing `--version` scenario in
  `truth/specs/cli.typ` to cover the fallback path: running the
  binary outside a Composer install still produces a non-empty
  version line.
+ Document in the CLI help text that the version reflects the
  installed package, not the working copy.

== Out of scope

- Publishing to Packagist (blocked on other tasks).
- Emitting the package name in `--version` output beyond today's
  `paogen <version>` format.
- Build-time stamping via phar-manifest (future, after Packagist
  ships).

== Acceptance

- Existing `--version` scenarios still pass.
- A regression test proves the fallback path (no Composer metadata)
  returns a non-empty string and exits 0.
- `just check` green end-to-end.

== Progress

The core code change has landed: `Cli::VERSION` is replaced by a
`Cli::version()` helper that calls
`Composer\InstalledVersions::getPrettyVersion('mlavrinenko/paogen')`
and falls back to `"dev"` on `\OutOfBoundsException` or a `null`
return. `paogen --version` reports `dev-main` in an in-repo run and
will report the real tag once installed via Packagist.

Still to do before this task can close:

+ Add a new scenario to `truth/specs/cli.typ` that exercises the
  fallback path (e.g. "version line is non-empty when Composer
  metadata is unavailable") and a matching step / test fixture.
+ Expand the `USAGE` block in `src/Cli.php` to note that the printed
  version reflects the installed package, not the working copy.
