#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "retighten the generated duplication ceilings",
  tags: ("generator", "gates"),
  priority: 4,
  difficulty: 5,
  links: (related("typed-error-responses.task-260729.typ"),),
  status: wip(2026, 8, 8)[dispatched to a worktree agent],
)

== Summary

The envelope changed what the emitter represents per operation - every operation now emits the document's responses object where before it emitted a single response type. Emitted duplication rose past every generated-tier ceiling. The redundant spelling was collapsed first, which took petstore from 8.2 to 4.4 percent and GitHub from 24.1 to 22.3, but the residual is real repeated content: two operations declaring identical response shapes emit identical maps. The owner ruled on 2026-08-04 to loosen the floors and prioritise functionality, completeness and stability, with the tightening deferred to this task. The loosened numbers and the reasoning are in scripts/jscpd-generated-baselines and its decision artifact. This task exists so a deliberate, temporary loosening does not become the permanent state by nobody revisiting it.

== Acceptance criteria

- Every generated-tier ceiling is measured again and moved DOWN from the loosened figures, or this task records why a given tree's floor is genuinely where it is and cannot fall further.
- The collapse route that was rejected in 2026-08-04's decision is re-weighed against whatever the tree looks like then, not assumed still rejected. Two of petstore's four clones were cross-file, which a per-class helper cannot reach; if that is still true it is stated with fresh numbers.
- Any structural deduplication proposed here is checked against the owner ruling of 2026-08-02 on inline models, which rejected merging on structural identity because two endpoints with the same shape are not returning the same thing.
- scripts/jscpd-generated-baselines carries the new measurements and its RATCHET paragraph is left honest about what moved and why.

== Non-goals

- Weakening what the generated tier measures, adding an ignorePattern that hides a clone, or excluding a tree. The gate stays; only the numbers are in question.
- Changing the envelope's semantics to make the numbers nicer.

== Files

- scripts/jscpd-generated-baselines
- Justfile, the lint-jscpd-generated recipe
- src/Generator/Emit/
- truth/decisions/
