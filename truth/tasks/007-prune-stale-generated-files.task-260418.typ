#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "0a8fa9a0-381f-42be-b9b3-ef1519564927",
  title: "Prune stale files from Generated/ so byte-stability holds on rename",
  status: done(2026, 4, 18),
  priority: 9,
  x-paogen: (spec: "truth/specs/model-generator.typ", decision: "truth/decisions/001-profile-driven-generation.typ", legacy-id: "T-007"),
)

== Summary

`Generator::generate()` writes every file but never deletes files from
prior runs that no longer correspond to a schema component. Renaming
`Pet` → `Animal` leaves an orphan `Pet.php` on disk, and the
consumer's PHPStan flags it. `profile-driven-generation`'s byte-stability
promise holds only in the add-only direction.

== Rationale

Pre-release review P0 #6 — release blocker. Cheap to implement and
essential for `profile-driven-generation`'s advertised contract. Without it, every rename
is a silent half-migration.

== In scope

+ Extend the Model Generator "Re-running the generator is
  byte-stable" rule with a scenario: when a component is removed or
  renamed, the corresponding generated file is deleted on the next
  run.
+ Implement a prune step after file writes: diff the emitted path set
  against what exists under `Generated/` in the #raw("Profile")'s
  output root, and `unlink` anything not in the emitted set.
+ Guard the prune strictly to the `Generated/` subtree — never touch
  user code under `output/` that sits outside `Generated/`.
+ Add a regression test that runs the generator twice with different
  schemas and asserts the orphan file is gone on the second run.

== Non-goals

- Pruning empty parent directories (cosmetic, can follow).
- `--dry-run` / `--check` reporting of what would be pruned — filed
  as task 019.
- Cross-profile coordination when two profiles write to the same
  `Generated/` directory (unsupported by `profile-driven-generation` anyway).

== Acceptance criteria

- New scenario in the byte-stability rule, locked.
- A regression test proves orphan files are deleted under realistic
  schema edits.
- Existing byte-stability scenario still passes (re-running with the
  same schema still writes byte-identical files; no directory churn).
- `just check` green end-to-end.

== Resolution

`Generator::generate()` now records every emitted path in a local
`$emitted` set and calls a new `pruneStale($rootDir, $emitted)` after
the model and client passes. The prune walks `Generated/` recursively
via `RecursiveDirectoryIterator` and `unlink`s any file not in the
emitted set. The walk is strictly scoped to the `Generated/` subtree,
so user files placed alongside it under the same `output` root are
never touched. The previous ad-hoc ApiClient deletion inside
`emitClient()` is gone — that case now falls out of the generic
prune.

The Model Generator byte-stability rule grew an
"A component removed from the schema is pruned from Generated/ on the
next run" scenario. Its regression test generates a petstore tree
into a temp dir, plants a sibling `user-kept.txt`, re-runs the
generator with a minimal schema that declares only `Tag`, and then
asserts (a) `Generated/Model/Pet.php` is gone, (b) `Tag.php` is
present, and (c) `user-kept.txt` is intact.
