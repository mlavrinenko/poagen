#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "d7a51a91-c7c4-4d57-bc47-bb430235656b",
  title: "Read the CLI version from Composer metadata instead of a hard-coded const",
  status: done(2026, 4, 18),
  priority: 5,
  x-paogen: (spec: "truth/specs/cli.typ", decision: "truth/decisions/006-cli-tooling.typ", legacy-id: "T-017"),
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
  #link("../specs/cli.feature-260417.typ") to cover the fallback path: running the
  binary outside a Composer install still produces a non-empty
  version line.
+ Document in the CLI help text that the version reflects the
  installed package, not the working copy.

== Non-goals

- Publishing to Packagist (blocked on other tasks).
- Emitting the package name in `--version` output beyond today's
  `paogen <version>` format.
- Build-time stamping via phar-manifest (future, after Packagist
  ships).

== Acceptance criteria

- Existing `--version` scenarios still pass.
- A regression test proves the fallback path (no Composer metadata)
  returns a non-empty string and exits 0.
- `just check` green end-to-end.

== Resolution

- `Cli::VERSION` is replaced by a `Cli::version(string $package =
  self::PACKAGE)` helper that calls
  `Composer\InstalledVersions::getPrettyVersion($package)` and falls
  back to `"dev"` on `\OutOfBoundsException` or a `null` return. The
  optional `$package` argument exists so the fallback path can be
  regression-tested with a deliberately unknown package.
- #link("../specs/cli.feature-260417.typ") grows a "Version falls back to a non-empty
  sentinel when Composer metadata is missing" scenario under the
  Version rule; the generated PHPUnit test calls
  `Cli::version('does-not-exist/nothing')` and asserts the returned
  token is non-empty.
- The `USAGE` block gained a `NOTES` section explaining that the
  printed version reflects the installed package (not the working
  copy) and documenting the `dev` fallback.
