#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Reconcile paogen's Justfile with the current speconaut lock/status contract",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "high",
  decision: "truth/decisions/004-quality-gates.typ",
)

== Summary

Two tooling gaps make the speconaut workflow fight the developer in
this repo:

+ *`just check-drift` is broken under the current speconaut.* The
  recipe pipes `speconaut status --format json` into a `php -r` that
  counts `content_mismatches`. Newer speconaut exits 1 whenever
  `has_debt` is true — i.e. whenever any proposed task or ADR is
  open. With `set -euo pipefail` on, the pipeline dies before the
  count is inspected, so the recipe reports drift even when there
  is none. The recipe must either strip `pipefail`, redirect the
  status through a tempfile, or use the new `speconaut status
  --quiet --exit-code` semantics explicitly.
+ *`speconaut lock --approve` refuses when any draft remains.*
  `has_blockers` returns true for every draft (and WIP,
  modified-mature) scenario in the spec tree, so incremental work
  that only updates traces or adds a single new unstable scenario
  cannot be locked while the 7 pre-imported drafts (task-006, 008,
  009, 012, 013, 015, 018) still exist. The most recent release-
  prep commit (`c422ca3`) worked around this by hand-editing
  `.speconaut/state.lock`, which is fragile and error-prone.

== Rationale

Until the tooling matches reality, every change that touches
traced source files either (a) breaks `just check` (drift recipe
false-positive) or (b) forces the implementing agent to
hand-compute sha256 + zstd + base64 snapshots to patch
`.speconaut/state.lock` by hand. Both paths silently risk
corrupting the lockfile.

== In scope

+ Rework `check-drift` so it tolerates a non-zero exit from
  `speconaut status`. Either drop `pipefail` for that single
  pipeline, or stash the JSON into a tempfile first and inspect
  the file. Add a smoke test that runs `just check-drift` against
  a tree with an open task but no content mismatches.
+ Decide on a policy for the draft-blocks-approval constraint.
  Options:
  - Upstream a `--partial` (or "ignore pre-existing drafts") flag
    in `speconaut lock` so incremental work does not need to resolve
    unrelated drafts first.
  - Move all paogen drafts into `stage: pending` (speconaut already
    excludes pending from lock classification) and only promote to
    `draft` when the implementing agent is ready to work on it.
  - Document the hand-edit workflow in `AGENT.md` with an explicit
    checklist (compute content hash, produce zstd+base64 snapshot,
    insert alphabetically, bump trace hashes) so at least it is not
    tribal knowledge.
+ Either outcome: the implementing agent MUST be able to run
  `speconaut lock --approve` on routine changes without touching
  the lockfile by hand.

== Out of scope

- Any change to speconaut's core lock semantics beyond what the
  paogen repo needs to move forward.
- Replacing the whole `just` recipe suite with a shell library or
  PHP harness — not warranted yet.

== Acceptance

- `just check-drift` passes on a clean tree with pending tasks
  (regression for the `pipefail` false-positive).
- Adding a new unstable scenario and updating a traced source file
  ends with a successful `speconaut lock --approve`, no manual
  edits to `.speconaut/state.lock`.
- `just check` green end-to-end.
