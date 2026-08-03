#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "the freshness manifest enumerates root docs and drifts",
  tags: ("tooling", "gates"),
  priority: 4,
  difficulty: 2,
  status: done(
    2026,
    8,
    3,
  )[Filed and fixed the same day, on evidence rather than on theory. The manifest gained a `./<pattern>` form matching root-level files by name, and the seven enumerated documents were replaced by `./*.md` rather than supplemented by an eighth. Proven by doing, four probes: editing AGENT_HAZARDS.md now goes stale where it did not before, a byte-exact restore returns to fresh, a brand-new root Markdown file goes stale with no manifest edit at all, and removing it returns to fresh. Ordering was already irrelevant — the file list is sorted before hashing.],
)

== Summary

`gate-freshness-misses-the-files-linecop-lints` closed a hole where a Markdown
file linecop lints was absent from `scripts/gate-fresh.inputs`, so an over-cap
edit could record as fresh. Its own criterion says to derive the input set from
what the gate actually reads "rather than maintaining a second list beside it
that drifts."

The fix enumerated seven root-level Markdown files by name. That satisfies the
criterion in letter and reintroduces the drift in substance: the manifest
supports only literal directory and file paths, so a new root-level Markdown
file is silently uncovered, and silence is the whole failure mode.

It took hours to bite. `agent-guide-is-nine-lines-from-its-own-cap` split
`AGENT.md` and created `AGENT_HAZARDS.md`, which linecop lints under the same
300-line cap and which the manifest does not mention. The agent that created it
checked rather than assumed, found the gap, and reported it instead of editing
outside its boundary — which is the only reason this was caught at all rather
than in some later session, on some later file, as a pass that read fresh over
a tree the gate would reject.

Enumerating a set that grows is a list that goes stale silently. That is the
same shape as a copied measurement, and the project already refuses those.

== Acceptance criteria

- Adding a new root-level Markdown file covers it in the freshness input set
  with no edit to `scripts/gate-fresh.inputs`. Proven by creating one, editing
  it past the linecop cap, and observing `scripts/gate-fresh is-fresh` refuse.
- The seven enumerated root documents are replaced by whatever expresses the
  rule, not supplemented by an eighth entry.
- Ordering stays irrelevant to the hash. The manifest's file list is sorted
  before hashing today and any new expansion must not depend on filesystem
  order.
- The manifest's comment says what the new form means, since a reader adding a
  path needs to know which forms exist.

== Non-goals

- Full glob support anywhere in the manifest. The need is root-level files that
  a directory include cannot reach; a general pattern language is more surface
  than the problem justifies.
- Changing what `just check` runs.
- The `truth/tasks` exclusion, which is
  `a-malformed-task-artifact-records-as-fresh`.

== Files

- `scripts/gate-fresh`
- `scripts/gate-fresh.inputs`
