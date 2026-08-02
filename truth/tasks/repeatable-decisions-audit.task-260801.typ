#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Make the decisions audit a repeatable command instead of an improvisation",
  tags: ("process", "mindtape"),
  priority: 7,
  difficulty: 5,
  status: done(2026, 8, 2),
)

== Summary

The human review gate was removed because thirty-eight tasks reached it and none left. What actually worked in its place, on 2026-08-01, was two audits run over already-closed work:

One took fourteen tasks and checked each acceptance criterion against the tree, returning met / not-met / needs-judgment with evidence. It found four criteria that overshot what had landed, one of them a live defect the gate could not see.

The other took twenty-four tasks and extracted only the decisions — a choice made in passing without an artifact, a convention now binding, a spec bent to match code, a threshold set by fiat — ranked by consequence. The owner read the ranked list and ruled on all of it in one sitting.

Both were improvised. Neither is in the repository, so neither can be run again, and the next backlog gets whatever the next session happens to think of.

The distinction that made the second one usable is the one to preserve: the owner does not want to review code, and cannot review a thousand files. He wants to review decisions. An audit that returns diffs has failed no matter how thorough it is.

== Acceptance criteria

- A command runs the audit over a set of tasks selected by filter, so \`\@recent\` or any other view can be its input.
- It returns decisions, not diffs: a choice between defensible alternatives, a convention that now binds future work, an artifact contradicting another, a threshold or exemption set without recorded rationale, a spec weakened rather than corrected.
- Findings are ranked by consequence, and each carries what was decided, what the alternatives were, and who it binds — enough to rule on in one reading.
- A task that settled nothing produces one honest line saying so. Padding a report to look thorough is the failure mode that makes an audit unreadable.
- It states plainly what it cannot check, rather than reporting a judgment call as a verified fact.
- The output distinguishes findings needing the owner's input from those an implementer may accept, so a reading can stop early.
- Running it over the 2026-08-01 backlog reproduces the substance of what the improvised audits found. If it misses the pre-transport spec drift, it is not finished.

== Non-goals

- Reinstating a status a task must pass through before closing. That was decided against and recorded; this audit reads after the fact.
- Gating anything. It informs a human, it does not block a flip — the flip predicate is separate work.
- Reviewing code quality, style, or test coverage. Other instruments own those, and mixing them in is what made review unusable before.

== Files

- \`.mindtape/config.toml\`
- \`Justfile\`
- \`AGENT.md\`
- \`truth/decisions/\`

== Result

Two artifacts, because the audit is a reading and only its input can be made
mechanical. \`scripts/audit-decisions\` gathers that input for any \`mt\` filter,
defaulting to \`\@recent\`: slug, title, status, the Summary / Acceptance criteria
/ Result sections, the commits whose \`Refs: \` trailer names the task, and which
\`truth/\` decisions, standards or specs those commits touched. It reads only —
never writes, never gates, exits 0 whatever it finds. \`just audit-decisions\`
wraps it.

The rubric that turns a brief into a ranked report lives in
\`truth/notes/decisions-audit-procedure.md\`, not in the agent guide: that file
was already at 299 lines against linecop's 300-line cap, measured before writing
rather than discovered by tripping the gate, and \`truth/notes/\` is where this
project already puts process documentation that is not a decision.
\`--help\` points at it.

Validated against the 58 tasks closed on 2026-08-01, with the report committed
at \`truth/reviews/2026-08-01-decisions-audit.md\`. It met the pass condition the
task set: it surfaced the pre-transport spec drift. \`two-more-pre-transport-
claims\` closed carrying an acceptance criterion that demanded proof its renamed
step method kept its hand-written body, and none of its four commits touch
\`tests/generated/\` at all — the regeneration happened later, inside a different
task. Its hand-picked search vocabulary also missed seven of the nine stale
passages the same-day follow-up caught, one of them a step body asserting the
literal negation of the scenario it implemented.

Two further findings, both verified against the current tree rather than
inferred from the brief: the PHPStan strictness reversal was never recorded as
the decision its own acceptance criteria demanded, and
\`standards-stop-naming-implementation-files\` left its required scope question
unanswered while the detection gap that caused it — a code-ref check blind to a
bare implementation-file basename — is still open. 54 of the 58 tasks settled
nothing new, and the report says so in one line each rather than padding.

All three findings are now tasks: \`record-the-strictness-reversal\`,
\`code-refs-blind-to-bare-basenames\` and
\`structural-sweep-for-retired-call-shapes\`. Filing them is the audit's output;
ruling on the first two is the owner's.

One limit worth recording, since the audit states what it cannot check: \`mt\`'s
filter grammar has no field for the date a status was reached, so "everything
closed on a given day" is not expressible as a filter. The validation set was
derived once from \`mt ls \@recent --format json\` and passed explicitly; the
report carries the reproducing command.
