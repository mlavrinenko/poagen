#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Fix speconaut binary / typst package version mismatch",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "high",
)

== Symptom

`speconaut check`, `speconaut extract`, and `speconaut implemented` all
fail with:

```
query error: typst eval failed: SourceDiagnostic { severity: Error,
  message: "unknown variable: unstable", trace: [Import] }
```

Reproduced on a pristine `main` checkout (before any of the recent
Operation Generator work — verified via `git stash`). The failure is
environmental, not spec-side: `typst compile --root . truth/main.typ`
and `typst query --root . truth/main.typ '<speconaut>'` both succeed
and return the expected metadata.

== Likely cause

The prebuilt release binary at
`~/projects/home/speconaut/target/release/speconaut`
(dated 2026-03-30) is older than the installed Typst package at
`~/.local/share/typst/packages/local/speconaut/0.1.0/spec.typ`
(dated 2026-04-16). The binary ships with an embedded Typst version
that doesn't expose `unstable` through the wildcard import the way the
newer package expects.

`speconaut status` keeps working, but — as a consequence — it no longer
compares file hashes, so drift is silently missed. Concretely, after
editing `src/Generator/Generator.php`, `sha256sum` disagrees with the
hash recorded in `.speconaut/state.lock`, but `status` still reports
"ok".

The `bin/speconaut` wrapper in the project points at
`cargo run` in `$SPECONAUT_ROOT`, which fails inside devbox because
the environment has no C toolchain (cc, ar) to build `psm` / `zstd-sys`.

== Consequences

- `just check-specs` and `just check-drift` currently fail in CI-like
  environments, so the pre-commit drift gate is ineffective.
- `speconaut implemented` cannot record scenario confirmations in
  `.speconaut/state.lock`. The newly-added Operation Generator
  scenarios and any Model Generator scenario tracing the modified
  `src/Generator/Generator.php` are therefore stale in the lockfile
  (see task 002).

== Remediation options (pick one)

+ Rebuild the `speconaut` release binary from a commit that pins its
  embedded Typst and the installed package to the same version, then
  refresh both.
+ Downgrade the installed package
  (`~/.local/share/typst/packages/local/speconaut/0.1.0/spec.typ`) to
  the version the binary was built against.
+ Add the C toolchain (at minimum `gcc` and `binutils`) to
  `devbox.json` so `bin/speconaut` (which shells out to `cargo run`)
  can build locally, matching the installed Typst package naturally.
+ Teach `bin/speconaut` to prefer a prebuilt binary under
  `$SPECONAUT_ROOT/target/release/speconaut` when present, falling
  back to `cargo run` only otherwise. Fastest to ship; does not
  address the version-mismatch root cause.

== Verification

- `just check-specs` exits 0.
- After any edit to a traced source file, `just check-drift` fails
  until the affected scenarios are re-confirmed via
  `speconaut implemented -s "<scenario name>"`.
