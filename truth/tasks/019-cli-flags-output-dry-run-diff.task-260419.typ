#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "348f2008-3e62-4708-a988-356b50a2352a",
  title: "Add --output, --dry-run, and --diff flags to paogen generate",
  status: done(2026, 4, 19),
  priority: 5,
  x-paogen: (spec: "truth/specs/cli.typ", decision: "truth/decisions/006-cli-tooling.typ", legacy-id: "T-019"),
)

== Summary

All customisation today flows through `paogen.php`. A one-shot
`paogen generate ./profile.php --output=./tmp` for CI introspection is
missing, as is a `--dry-run` that prints what would change and a
`--diff` that compares emitted vs. on-disk output.

== Rationale

Pre-release review P2 #19 — packaging gap. These are DX essentials for
CI pipelines that want to run the generator without committing. No
new design territory — `getopt()` already supports long options.

== In scope

+ Promote the draft `--output` scenario under
  #link("../specs/cli.feature-260417.typ") to `stage: unstable` on implementation.
+ Add scenarios for:
  - `--output=<dir>`: writes the generated tree under `<dir>`
    instead of the profile's `output`. The profile's `output` is
    still authoritative for relative-path resolution.
  - `--dry-run`: prints a tree-shaped summary of would-be-written
    files and would-be-deleted files (the latter hooks into task
    007's prune step) to stdout; writes nothing; exits 0.
  - `--diff`: for each would-be-written file, print a unified diff
    against the file currently on disk; exit 0 if no diffs, 1 if
    any, 2 on usage error.
+ Extend `src/Cli.php` dispatch and `Generator` to honour the flags
  without breaking the `paogen.php`-only call path.

== Non-goals

- Coloured diff output (future nicety).
- Filtering diffs by path (`--diff Generated/Model/**`). Leave for
  later.
- Machine-readable diff output (`--diff --format=json`).

== Acceptance criteria

- Three new scenarios locked (one per flag).
- Running the three flags against the Petstore fixture produces the
  expected behaviour (no writes for `--dry-run` / `--diff`; writes
  elsewhere for `--output`).
- A regression test exists for each flag's exit code.
- `just check` green end-to-end.
