#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/guidance.context.typ": *
#import "../domain/schema.context.typ": *

#show: decision.with(
  title: "Profile::$propertyFormats keys on the emitted class name; its stale-key check does not yet reach a synthesised model",
  status: superseded(2026, 8, 8),
  contexts: (generation-context, guidance-context, schema-context),
  goals: (
    link("../goals/guidance-cannot-mislead.goal.typ"),
    link("../goals/real-world-schemas.goal.typ"),
  ),
  standards: (link("../standards/silence-means-success.standard-260729.typ"),),
)

== Context

`bind-a-format-per-property` gives `Profile::$propertyFormats` the same
two-part dotted key `Profile::$propertyRenames` and `Profile::$phpDocTypes`
already use, keyed `'<RawComponentName>.<wirePropertyName>'` — a raw
`components.schemas` key, checked against the document by
`ComponentPropertyNames` before generation ever writes anything.

`examples/kilbil/` is where that convention runs out. Its `components:`
block carries only `securitySchemes:` — `components.schemas` is empty, so
every model kilbil emits is synthesised from an inline request or response
body, not read off a named schema. `Emit\ModelEmitter`'s own comment already
records the consequence for the two existing fields: called for a
synthesised model, `$rawComponentName` is `''`, "which no document
component name is", so a `propertyRenames` or `phpDocTypes` entry can never
match one. Kilbil's own `price` field — the exact property this task binds
`Money` to, on `SearchClientRequestContentGoodsDataItem` and
`ProcessSaleRequestContentGoodsDataItem` — exists only as a synthesised
model. Keying `$propertyFormats` the same way `$propertyRenames` does would
make the feature unable to reach the one document that motivated it.

== Choice

`$propertyFormats` keys on the *emitted PHP class name* instead —
`$className` inside `Emit\ModelEmitter::emit()`, which is `$shape->phpName`
for a named component and `SynthesisedModel::$name` for a synthesised one.
`Emit\ModelNameLedger` already guarantees this name is unique across the
whole generated tree, named or synthesised, which is what makes it a safe
key: two different rename maps producing the same key can only mean the
same model.

This buys the feature reach into every model poagen emits, including
kilbil's, at the cost of one gap this decision records rather than hides.

=== The gap

A synthesised model's name only exists once `ModelEmitter::emit()` has
already produced it — there is no document to check a stale entry against
beforehand the way `ComponentPropertyNames` lets `PropertyRenameValidator`
and `PhpDocTypeValidator` check theirs. So the check `Emit\PropertyFormatKeys`
runs instead: per model, as it emits, against the wire property names that
model actually declares. Two of its three failure modes work exactly like
the older fields' — a property absent from a model this run does emit, or a
bound class that does not exist, both name the entry and fail the run. The
third does not: a key naming a model this run never emits at all has no
model to run the check against, so it is silently never consulted, and
generation succeeds as if the entry were absent.

Verified rather than assumed, against `tests/fixtures/schemas/scoped-format-3.0.yaml`:

- `'Product.no_such_property'` (a real, named, top-level model; a property it
  does not have) fails the run, naming both.
- `'Product.price'` bound to a nonexistent class fails the run, naming both.
- `'NoSuchModel.price'` (no model by that name anywhere in the run) does
  not fail. `Emit\ModelEmitter::emit()` is simply never called with that
  class name, so nothing ever asks whether the entry matched.
- `'CreateOrderRequestContentItem.no_such_property'` — a *synthesised*
  model that does exist, with the property wrong — also does not fail,
  for a narrower reason: `Emit\SynthesisQueueDrain::drain()` discards
  `ModelEmission::$failures` for every model it drains. It reads
  `$emission->source` and `$emission->children` and nothing else. This is
  not new to this task — the same drop already applied to
  `Emit\PhpDocTypeCompatibility`'s checks on any synthesised model, kilbil's
  included, before this field existed; `$phpDocTypes` never surfaced it
  because its own `''`-keyed check could not match a synthesised model
  either, so the two gaps were invisible together. `$propertyFormats` is
  the first guidance field whose check runs on a synthesised model at all,
  which is what makes the drop observable.

`tests/Integration/PropertyFormatTest.php`'s
`testAKeyNamingAModelThisRunNeverEmitsIsNotCaughtYet` asserts the current,
undesired behaviour rather than hiding it, exactly so a future fix has a
red test to turn green instead of a silent regression to rediscover.

=== Why this is not closed here

Closing the gap needs one of two things this task's boundary did not
include. Either `Emit\SynthesisQueueDrain::drain()` stops discarding
`ModelEmission::$failures` — which needs `ModelPlanner::plan()` to collect
what `drain()` would then return, since today it calls `drain()` for its
side effect on `$writes` alone — or a whole-run pass compares every
`$propertyFormats` key against every class name the run actually claimed,
which needs `ModelNameLedger`'s final contents somewhere `Generator::plan()`
can compare them, and `Generator::plan()` is exactly the file that would
have to grow the comparison. Both routes require editing
`src/Generator/Generator.php` and/or `src/Generator/ModelPlanner.php`, which
this task's file boundary did not open — a sibling task owned them this
wave. Routing around that boundary — an early `throw` from inside
`SynthesisQueueDrain` instead of the collect-everything-then-fail-once
shape `Generator::plan()`'s own docblock commits to — would have traded one
silent gap for a different, inconsistent one: reporting only the first
`$propertyFormats` problem found and none of whatever else the same run
would otherwise have reported in the same pass.

== Consequences

- `Profile::$propertyFormats`'s own docblock and `Emit\PropertyFormatKeys`'s
  class docblock both name this decision, so a reader who hits the gap
  lands on the reasoning rather than re-deriving it.
- The two failure modes that do work — property absent on a model this run
  emits, and a bound class that does not exist — are unaffected and are not
  what this decision is about; only "the model itself was never emitted at
  all" and "a synthesised model's own failures reach nowhere" are open.
- Closing this is future work, not filed as a task here — `truth/tasks/` is
  the orchestrator's, and this decision is not the mechanism for adding to
  it. Whoever picks it up next needs `SynthesisQueueDrain::drain()` to
  return (or accept by reference) the failures it currently discards, and
  `ModelPlanner::plan()` to fold them into the same list `emitObject()`
  already contributes to — both currently out of this task's file boundary,
  both named above by their real symbol.
- Nothing here weakens the two fields this task did not touch.
  `$propertyRenames` and `$phpDocTypes` keep keying on the raw document
  name, unable to reach a synthesised model exactly as before; this
  decision changes nothing about them.

=== Superseded

This decision was superseded on 2026-08-08, the same day, by
#link("synthesised-model-failures-reach-the-run-report.decision-260808.typ")[A synthesised model's emission failures reach the run's report, closing the queue-drain gap].
The boundary named in "Why this is not closed here" above was widened the
same day once the two sibling tasks that had owned `Generator.php` and
`ModelPlanner.php` finished without touching them, and the gap recorded here
was closed rather than left as a documented limitation. The analysis above —
the two verified failure modes, the reasoning for why the boundary blocked a
fix, and the explicit refusal to route around it with an early `throw` — is
left unchanged as a record of what was known and why, the same discipline
`error-response-policy` used when it was superseded.
