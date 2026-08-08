#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/guidance.context.typ": *
#import "../domain/schema.context.typ": *

#show: decision.with(
  title: "A synthesised model's emission failures reach the run's report, closing the queue-drain gap",
  status: accepted(2026, 8, 8),
  contexts: (generation-context, guidance-context, schema-context),
  goals: (
    link("../goals/guidance-cannot-mislead.goal.typ"),
    link("../goals/real-world-schemas.goal.typ"),
  ),
  standards: (link("../standards/silence-means-success.standard-260729.typ"),),
  supersedes: (link("queue-drained-models-swallow-emission-failures.decision-260808.typ"),),
)

== Context

`queue-drained-models-swallow-emission-failures` recorded two gaps in
`Profile::$propertyFormats`'s stale-key check, both landing on kilbil — the
flagship example, and a document with zero named components, so every model
it emits is synthesised. A key naming a property absent from a synthesised
model, and a key naming a model this run never emits at all, both generated
successfully instead of failing — exactly the outcome
`guidance-cannot-mislead`'s acid test names: "bind a format nothing
declares… fails the run and names the entry that is wrong."

That decision judged closing both gaps out of reach for the task that found
them: it needed `src/Generator/Generator.php`, `src/Generator/ModelPlanner.php`
and `src/Generator/Emit/SynthesisQueueDrain.php`, all owned by sibling work
that wave. Both siblings have since finished and merged nothing into those
three files, freeing them. This decision is the closure, landed once they
were free rather than routed around while they were not.

== Choice

Two separate mechanisms, matching the two separate gaps.

A property absent from a synthesised model now reaches the run's report
because `Emit\SynthesisQueueDrain::drain()` collects `ModelEmission::$failures`
into a new by-reference `$failures` parameter — the same shape its existing
`&$writes` parameter already used — instead of reading only `$emission->source`
and `$emission->children`. `ModelPlanner::plan()` passes its own `$failures`
accumulator into that parameter, so a synthesised model's failures land in
the exact list `emitObject()`'s named-component path already contributed to,
with no new channel for `Generator::plan()` to know about.

A key naming a model this run never emits at all is checked once the whole
plan has run, against every name the run ever claimed: `Emit\ModelNameLedger`
gains `claimedNames()`, and a new `PropertyFormatValidator` — built the same
shape as `PropertyRenameValidator` and `PhpDocTypeValidator`, a run-level
service `Generator`'s constructor holds and `plan()` calls once — compares
`Profile::$propertyFormats`'s keys' model prefixes against that set. It has
to run after `ModelPlanner::plan()` returns, since the ledger is not fully
populated until then; `Generator::plan()` already computed `$ledger` before
that call and simply reads it again afterward, no restructuring needed.

Neither mechanism special-cases `$propertyFormats`. `SynthesisQueueDrain`
now surfaces every synthesised model's failures, whatever check produced
them; `PropertyFormatValidator` is the first of its kind because
`$propertyFormats` is the first guidance field keyed on the emitted class
name rather than a raw document name, but nothing in the shape is specific
to formats.

=== What the blast-radius check found

Verified rather than assumed, per the same discipline
`queue-drained-models-swallow-emission-failures` applied to the gap itself:
before this landed, was any *other* profile's failure being silently
dropped the same way, now that the channel that dropped it is open? The
full test suite ran clean except for the one test asserting the old, now
incorrect behaviour (`PropertyFormatTest::testAKeyNamingAModelThisRunNeverEmitsIsNotCaughtYet`,
rewritten below) — no other fixture, example, or profile in the tree
produced a newly-surfaced failure. That check is not free of blind spots:
the only other source `ModelEmission::$failures` carries today is
`PropertyEmitter`'s `$phpDocTypes`-compatibility check, and that one can
never fire on a synthesised model regardless of this decision — its
override lookup is keyed on `Profile::$phpDocTypes`'s raw-component-name
convention, which is `''` for every synthesised model, the same convention
gap `queue-drained-models-swallow-emission-failures` used to explain why
`$propertyFormats` had to key differently in the first place. So this
decision closes the one channel that was open to check, finds it clean, and
does not claim to have exercised a channel that structurally cannot fire.

== Consequences

- Both failure modes `queue-drained-models-swallow-emission-failures`
  recorded as open are closed and tested:
  `PropertyFormatTest::testAKeyNamingAPropertyAbsentFromASynthesisedModelFailsTheRun`
  and `::testAKeyNamingAModelThisRunNeverEmitsFailsTheRun` assert the run
  now fails, naming the entry, where the superseded decision's test
  asserted the opposite.
- `Emit\PropertyFormatKeys` (per-model) and `PropertyFormatValidator`
  (whole-run) together give `Profile::$propertyFormats` the same
  fail-loud guarantee `PropertyRenameValidator` and `PhpDocTypeValidator`
  give their fields, reaching a synthesised model neither of those two
  fields can.
- `Emit\SynthesisQueueDrain::drain()`'s new `$failures` parameter is a
  generic collection point, not scoped to property-format failures. Any
  future check `Emit\ModelEmitter::emit()` grows now automatically reaches
  a synthesised model's report too, closing the same shape of gap before it
  is found the expensive way a second time.
- A narrower case stays open, not raised by either problem this decision
  closes and not claimed as fixed: a `$propertyFormats` key whose model
  prefix names a real, claimed component that is not object-shaped — a
  scalar VO wrapper, an array wrapper, a union interface — is accepted by
  `PropertyFormatValidator` (the name is claimed) and never reached by
  `Emit\PropertyFormatKeys` (`Emit\ModelEmitter::emit()` is never called
  for that shape). Such an entry has no promoted property for a binding to
  apply to in the first place, so it is a narrow misuse rather than the
  silent-guidance failure mode this decision and its predecessor both
  target; recorded here so a reader who finds it does not mistake it for a
  gap already ruled out.
