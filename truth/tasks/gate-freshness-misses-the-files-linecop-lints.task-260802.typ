#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "gate freshness misses the files linecop lints",
  tags: ("tooling", "gates"),
  priority: 3,
  difficulty: 2,
  status: accepted(
    2026,
    8,
    3,
  )[Scheduled by the owner into this session's second wave. It is also the defect that taxes every session's close-out, since writing a note invalidates a pass the note cannot affect.],
)

== Summary

scripts/gate-fresh.inputs does not list AGENT.md, README.md or CONTRIBUTING.md, and just check lints all three: linecop caps Markdown at 300 lines across the whole repo, not just src/.

So editing one of them past the cap breaks the gate without touching anything the freshness hash covers. A pass recorded before the edit still reads as fresh afterwards, and mt flip done accepts it — which is the one thing the predicate exists to prevent: a recorded pass claiming to cover a tree the gate would now reject.

Found while adding two measured parser traps to AGENT.md, which took it to 281 of the 300-line cap. Nothing is broken today; the hole is that nothing would say so.

=== The same mismatch, pointing the other way, 2026-08-03

Met while closing out a session: writing `truth/notes/session-resume-260803b.md`
invalidated a freshly recorded pass, and `mt flip done` then refused three
tasks whose work was merged and green.

That refusal is correct on its own terms — `gate-fresh.inputs` lists `truth`
and excludes only `truth/tasks`, so a note is a hashed input — and it is
pointless, because nothing `just check` runs reads a note. `speconaut check`
validates artifacts under `truth/`; a Markdown note is listed in the entry
point for reachability and never parsed for content.

So the input set is wrong in both directions at once, and they are one defect
rather than two: it hashes `truth/notes`, which the gate does not check, and it
misses `AGENT.md`, `README.md` and `CONTRIBUTING.md`, which linecop does. The
fix is the same in both cases — derive the set from what the gate actually
reads, rather than maintaining a second list beside it that drifts.

Cost when it bites: a full gate re-run to record a pass that was already true,
or an `mt done --force` that records a waiver for a transition nobody should
have had to waive.

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
