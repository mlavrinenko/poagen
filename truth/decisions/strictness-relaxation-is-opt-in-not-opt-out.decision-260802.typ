#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "Relaxing the strictness standard is opt-in, never opt-out",
  status: accepted(2026, 8, 2),
  contexts: (generation-context,),
  goals: (link("../goals/fail-loud-never-silent.goal.typ"),),
  process-only: "governs how paogen's own `analysis-runs-at-maximum-strictness`
    standard may be amended — a policy about editing paogen's truth tree, not
    what the generator produces or what a reimplementation must do",
)

== Context

#link("quality-gates-at-maximum-strictness.decision-260418.typ")[Quality gates: PHPStan max + bleeding-edge + linecop on library code] is the only decision on this ground, and it
predates what follows by three and a half months. It says nothing about
relaxation because none had happened yet.

`rewrite-agent-guide-for-mindtape.task-260728.typ`, landed as commit
`312cd5f0b9230078ddbeda9f50a7a4a8c906ed9c`, was a docs task: rewrite
`AGENT.md` for the MindTape workflow. While verifying the guide's claims
against the tree, the author found `phpstan.neon.dist` already carried
seven `ignoreErrors` entries against a standard whose rule text claimed
zero suppression anywhere. Rather than treat that as a violation to fix or
a relaxation to argue for on its own, the same commit rewrote
`analysis-runs-at-maximum-strictness`'s rule text in place, from an
unconditional zero-suppression rule into a two-tier one: the emitted tree
still admits nothing, but the generator's own analysis now permits an
`ignoreErrors` entry wherever the tool is "provably blind," each carrying
an inline comment naming the blind spot. The `structural:` slot was
reworded to match, claiming "seven documented tool-blind-spot exemptions."
No decision artifact accompanied the rewording — it rode inside a task
whose stated purpose was an unrelated file.

That claim was still wrong the day it was written: two of the seven
entries carried no comment at all, and one of the five that did was gone
already (`implement-the-outrun-step-bodies` had removed it), so
"documented" and "seven" were both false. Nothing caught this because
nothing had to — the standard now said whatever the config already did.

`revert-the-strictness-relaxation.task-260801.typ`, commit
`b78fa673df06f807c1583310f10faeede6329f5b`, reverted the wording: the
generator tier goes back to the same zero-suppression default as the
emitted tier, and an `ignoreErrors` entry becomes opt-in debt — fixed
first if at all possible, otherwise recorded with an inline comment naming
the blind spot and a count that may only shrink. Of eight real findings
surfaced by removing every ignore, six were fixed in code and two were
kept as narrowly-scoped, commented debt, taking the file from seven
entries to five. `audit-phpstan-generator-exemptions.task-260729.typ`
then verified all five were still load-bearing (removing each alone
reproduces a real finding) rather than assuming the comments were still
true, and found three of the five — the `AdditionalProperties.php`,
`Deprecated.php` and `Schema.php` attribute-read entries — were not blind
spots at all under the reverted rule, just accepted design nothing had
built consumers for yet. `wire-or-drop-the-unwired-attributes`, commit
`926191ead9f5c7b763faf5060f28b50cf0008f41`, deleted those three attribute
classes rather than wire them, taking the count from five to two.

That reversal task's own acceptance criteria required a decision
recording it — "relaxation is opt-in, never opt-out ... so the next agent
reading `rewrite-agent-guide-for-mindtape`'s commit message does not read
the relaxation as the settled answer" — and closed as `done` without one.
This is that decision.

Today `phpstan.neon.dist` carries exactly two `ignoreErrors` entries, both
in the file's `ignoreErrors:` block: `identifier: shipmonk.deadProperty.neverRead`
and `identifier: property.onlyWritten`, both scoped by `path:
tests/generated/*Steps.php` and by message to `::$test is never read`.
Both carry an inline comment naming the blind spot — `StepStub::stubBody()`
appends a `$this->test->fail('Implement: ...')` call to any generated step
without a hand-written body yet, so whether `$test` is read is a function
of which specs currently lack one, not of anything this repository
controls. The standard's own `structural:` slot describes exactly this
pair and needed no correction when the count moved from five to two.

== Choice

Relaxing `analysis-runs-at-maximum-strictness` is opt-in, never opt-out.
That holds at two levels, and the episode above conflated them:

- *An individual exemption* is opt-in already, by the reverted rule's own
  text: fix the finding first; if that genuinely cannot happen yet, record
  it with an inline comment naming the blind spot, next to a count that is
  only ever allowed to shrink. `rewrite-agent-guide-for-mindtape` did not
  violate this level — it never touched an individual `ignoreErrors`
  entry.
- *The rule text itself* needs the same opt-in treatment, at decision
  granularity, and this is the level that broke. A relaxation of what the
  standard requires — widening it from zero suppression to a two-tier rule
  that legalises whatever a config file already contains — is a decision.
  It gets its own artifact that names what is being relaxed, why, and
  what the cost is, argued for on its own terms before it lands, the same
  way `quality-gates-at-maximum-strictness` argued for the original split
  between the two tiers. It does not get to arrive as a side effect of an
  unrelated task's diff, however accurate the observation that prompted it.

A rewording that legalises existing violations is functionally identical
to widening a baseline file: neither fixes anything, both make a passing
gate mean less than it did, and this project's standard already forbids
baselines by name. Reaching for the standard's own wording as the escape
hatch is the same move with an extra layer of indirection, and it is
exactly as forbidden.

This is the same shape `fail-loud-never-silent` was written against, one
layer up: silence is the failure mode. There, a generator that quietly
degrades instead of refusing hides an unrepresented construct from the
consumer who needed to know. Here, a standard quietly reworded to fit
existing debt hides the same fact from the next agent, who reads a passing
gate and a compliant-looking rule and has no way to tell that either one
used to say something stricter.

== Consequences

- Any future attempt to broaden what the generator tier of
  `analysis-runs-at-maximum-strictness` permits — a new class of
  suppression, a baseline, a widened exclude path — needs a decision
  artifact of its own before the standard's rule text changes, not after.
  A task whose stated purpose is something else is not that artifact, no
  matter how correct its observation.
- An agent who reaches commit `312cd5f0b9230078ddbeda9f50a7a4a8c906ed9c` by
  `git log` or `git blame` on the standard file sees a rewording with no
  decision behind it. This artifact, alongside
  `revert-the-strictness-relaxation.task-260801.typ`'s own Summary, is
  what tells that agent the two-tier wording was reverted and is not the
  settled answer — the commit message alone does not say so.
- No exemption is added or removed by this decision. The count stands at
  two, both in `phpstan.neon.dist`, both scoped to
  `tests/generated/*Steps.php`, both already carrying the inline comment
  the standard requires. Changing that count is
  `audit-phpstan-generator-exemptions` and `wire-or-drop-the-unwired-attributes`'s
  history to make, not this decision's.
- `quality-gates-at-maximum-strictness` is unmodified. This decision fills
  the gap it left — it never anticipated relaxation, so it never said
  whose call that was — rather than superseding anything it says.
