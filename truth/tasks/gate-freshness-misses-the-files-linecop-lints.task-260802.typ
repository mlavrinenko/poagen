#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "gate freshness misses the files linecop lints",
  tags: ("tooling", "gates"),
  priority: 3,
  difficulty: 2,
  status: proposed(2026, 8, 2),
)

== Summary

scripts/gate-fresh.inputs does not list AGENT.md, README.md or CONTRIBUTING.md, and just check lints all three: linecop caps Markdown at 300 lines across the whole repo, not just src/.

So editing one of them past the cap breaks the gate without touching anything the freshness hash covers. A pass recorded before the edit still reads as fresh afterwards, and mt flip done accepts it — which is the one thing the predicate exists to prevent: a recorded pass claiming to cover a tree the gate would now reject.

Found while adding two measured parser traps to AGENT.md, which took it to 281 of the 300-line cap. Nothing is broken today; the hole is that nothing would say so.

== Acceptance criteria

- Every path just check reads is either in scripts/gate-fresh.inputs or excluded there on purpose with a comment saying why. The file's own header already states that rule; this makes it true.
- Editing a Markdown file past the linecop cap and then flipping a task to done is refused by the freshness predicate, proven by doing it rather than by reading the inputs list.
- The truth/tasks exclusion stays, for the reason its comment gives.

== Non-goals

- Changing what just check runs.
- Replacing gate-fresh with a memoizing runner.

== Files

- scripts/gate-fresh.inputs
- scripts/gate-fresh
