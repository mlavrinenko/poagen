#import "@local/speconaut:0.1.0": *

#show: decision.with(
  title: "The check that closes a task is a machine's, not a human's",
  status: accepted(2026, 8, 1),
  goals: (link("../goals/fail-loud-never-silent.goal.typ"),),
  process-only: "governs how paogen's own work is tracked and closed, not what the generator produces",
)

== Context

paogen's MindTape config shipped with a human review gate: `done` was
reachable only from `needs-review`, so no run of work could close itself.
The reasoning was sound and is documented in the config — agents report
success they have not achieved and rarely catch it themselves.

The measurement bore that out. A fourteen-task audit of the backlog on
2026-08-01 checked 110 acceptance criteria against the tree and found four
that overshot what had landed, including one real defect: a response
declaring no `application/json` resolved to a `void` method that discarded
the vendor's body, silently, at exit 0.

But the gate did not survive contact with throughput. Thirty-eight tasks
accumulated in `needs-review` against a single human reviewer. Every one of
them was already merged and shipping. The state recorded an intention to
review, not a review, and the backlog grew faster than anyone could read it.

That is the failure worth naming: a gate nobody can service does not slow
work down, it just stops describing it. Worse, it is _reassuring_ — the
queue looks like diligence while the code ships unread.

This is the same shape as the failure `fail-loud-never-silent` was written
against, one layer up. That goal refuses to let the generator report success
over work it quietly dropped; this decision refuses to let the tracker report
review over work nobody read. Both say a silent pass is worse than a loud
refusal, and both put the check somewhere it cannot be skipped by inattention.

== Choice

The `needs-review` status is removed. `wip` goes straight to `done`.

What replaces it is not nothing. The `[[on.flip]]` predicate on the way into
`done` is now the only gate, and it must stay a predicate a machine
evaluates. The shipped one is a floor — it refuses a task still carrying the
template's `TODO:` placeholders — and it is meant to be replaced with a
freshness assertion over the project's real gate.

Two properties are what make this work where the human gate did not. It runs
on the thirty-eighth task exactly as it ran on the first. And it fails
closed: a task cannot reach `done` without it passing, where `needs-review`
could be skipped simply by nobody looking.

The audit's judgment-call findings do not disappear; they move. `mt ls
@recent` is the after-the-fact reading, and a wrong decision found there is
filed as a new task rather than reopening the old one. Reversing a decision
while it is cheap is worth more than blocking every decision until someone
reads it.

== Consequences

A defect an automated check cannot see now reaches `done` unchallenged.
That is a real cost and it is accepted deliberately: the alternative on
offer was not a human catching it, but a queue in which nobody caught
anything.

It follows that the `[[on.flip]]` predicate is load-bearing in a way it was
not before. Pointing it at something weak — or reaching for `mt done
--force` — removes the last gate rather than a redundant one. The override
records itself in the status note precisely so that reach is visible.

The four sections every open task must carry (`Summary`, `Acceptance
criteria`, `Non-goals`, `Files`) become more important, not less: acceptance
criteria are what a mechanical check can be pointed at, and vague ones now
close silently instead of stalling in a queue.
