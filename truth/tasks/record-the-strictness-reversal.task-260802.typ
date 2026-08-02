#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Record the PHPStan strictness reversal as a decision",
  tags: ("strictness", "truth", "process"),
  priority: 6,
  difficulty: 3,
  status: done(2026, 8, 2),
)

== Summary

Surfaced by the 2026-08-01 decisions audit, finding 1.

\`rewrite-agent-guide-for-mindtape\` quietly rewrote
\`analysis-runs-at-maximum-strictness\` from an unconditional zero-suppression
rule into a two-tier one permitting \`ignoreErrors\` in the generator's own
config wherever the tool is "provably blind."
\`revert-the-strictness-relaxation\` reverted the wording and paid the
exemptions down, and that part landed clean.

Its own acceptance criteria required more: a decision artifact recording the
reversal — relaxation is opt-in, never opt-out — so the next agent reading
the relaxing commit does not read it as the settled answer. No such artifact
exists. \`quality-gates-at-maximum-strictness\` is the only decision on this
ground and predates the whole episode by three and a half months, saying
nothing about relaxation.

What binds: every future PHPStan finding in the generator tier. The
standard's rule text has already drifted once inside this project's
lifetime, and nothing on record says the next relaxation attempt is any
less welcome than that one was.


== Acceptance criteria

- Either a decision artifact records that relaxing the strictness standard is
  opt-in and never opt-out, citing the reversal that prompted it; or the
  acceptance criterion that demanded one is ruled over-specified and
  \`revert-the-strictness-relaxation\` is corrected to say so.
- Whichever way it goes, an agent arriving at the relaxing commit can tell
  from the artifacts alone that the relaxation is not the settled answer.
- No new exemption is added or removed as part of this; the debt count is a
  separate concern.


== Non-goals

- Changing the PHPStan level, rule sets, or any current exemption.
- Re-opening whether the reversal itself was right. It was made and it stands.


== Files

- \`truth/decisions/\`
- \`truth/standards/analysis-runs-at-maximum-strictness.standard-260729.typ\`
- \`truth/tasks/revert-the-strictness-relaxation.task-260801.typ\`


== Result

`strictness-relaxation-is-opt-in-not-opt-out.decision-260802.typ` records it,
citing the whole episode by full commit hash: `312cd5f` relaxed the standard
inside `rewrite-agent-guide-for-mindtape`, `b78fa67` reverted the wording under
`revert-the-strictness-relaxation`, and `926191e` paid the exemption count down
from five to two afterwards under `wire-or-drop-the-unwired-attributes`. Hashes
rather than task names, so a reader can `git show` the relaxation instead of
taking the artifact's word for what it said.

`analysis-runs-at-maximum-strictness.standard-260729.typ` gained a `relates-to:`
pointer at the decision and nothing else — its rule text is untouched, which is
what the third acceptance criterion required.

The second criterion was tested rather than assumed. An agent arriving at the
relaxing commit reaches the standard by `git blame`, finds the pointer beside
the rule, and lands on a decision that narrates the reversal and states the
opt-in rule directly; `revert-the-strictness-relaxation`'s own Summary
corroborates it independently. Two cross-linked paths to the same conclusion.

The exemption count was measured, not changed: two `ignoreErrors` entries,
both in `phpstan.neon.dist`, both scoped to `tests/generated/*Steps.php` and to
the exact `::$test is never read` property rather than to the file, and both
already carrying the inline blind-spot comment the standard demands.
