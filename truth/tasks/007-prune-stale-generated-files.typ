#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Prune stale files from Generated/ so byte-stability holds on rename",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "critical",
  spec: "truth/specs/model-generator.typ",
  decision: "truth/decisions/001-profile-driven-generation.typ",
)

== Summary

`Generator::generate()` writes every file but never deletes files from
prior runs that no longer correspond to a schema component. Renaming
`Pet` → `Animal` leaves an orphan `Pet.php` on disk, and the
consumer's PHPStan flags it. ADR-001's byte-stability promise holds
only in the add-only direction.

== Rationale

Pre-release review P0 #6 — release blocker. Cheap to implement and
essential for ADR-001's advertised contract. Without it, every rename
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

== Out of scope

- Pruning empty parent directories (cosmetic, can follow).
- `--dry-run` / `--check` reporting of what would be pruned — filed
  as task 019.
- Cross-profile coordination when two profiles write to the same
  `Generated/` directory (unsupported by ADR-001 anyway).

== Acceptance

- New scenario in the byte-stability rule, locked.
- A regression test proves orphan files are deleted under realistic
  schema edits.
- Existing byte-stability scenario still passes (re-running with the
  same schema still writes byte-identical files; no directory churn).
- `just check` green end-to-end.
