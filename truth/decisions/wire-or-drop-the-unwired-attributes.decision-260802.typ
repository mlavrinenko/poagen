#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/schema.context.typ": *

#show: decision.with(
  title: "Delete the three unwired runtime attributes rather than build consumers for them",
  status: accepted(2026, 8, 2),
  contexts: (generation-context, schema-context),
  goals: (
    link("../goals/strict-clean-output.goal.typ"),
    link("../goals/typed-injectable-surface.goal.typ"),
  ),
  standards: (link("../standards/analysis-runs-at-maximum-strictness.standard-260729.typ"),),
)

== Context

#link("attribute-and-phpdoc-driven-serialization.decision-260420.typ")[Attribute + phpdoc-driven marshal/unmarshal; Model classes stay clean] closed the runtime attribute
vocabulary at six members. Three were wired the same day: `WireName`,
`Format` and `Discriminator` are emitted by `ModelAttributeApplier` onto a
promoted constructor parameter and read back by `DescriptorParser` /
`Hydrator`. The other three — `Deprecated`, class-level `Schema`, and
class-level `AdditionalProperties` — were accepted design with nothing
behind them: no emission site ever attached one to a generated #a(Model),
and no runtime reader ever asked a class for one via reflection.

PHPStan's dead-code detector noticed, correctly — each attribute class's
constructor property is never read, because nothing reads it.
`phpstan.neon.dist` carried one `ignoreErrors` entry per class, and its own
comment said what it was: recorded debt against an accepted decision, not
a tool blind spot. `audit-phpstan-generator-exemptions` (2026-08-01)
re-verified all three the same way it verified everything else in that
file — remove the line, run the analyser, confirm a real finding comes
back — and found each still load-bearing. It filed the actual call as a
separate task rather than make it under an audit's own scope:
`wire-or-drop-the-unwired-attributes`.

`analysis-runs-at-maximum-strictness` states the debt list's expected
direction is down, not flat. Three of its five `structural:` entries were
sitting there with no plan beyond the comment. This decision is that plan,
made once per attribute rather than as one ruling for all three, because
the three did not fail the same way.

== Choice

Delete the `Deprecated` attribute, the class-level `Schema` attribute, and
the class-level `AdditionalProperties` attribute. Wire none of them.

The standing rule going forward: an attribute earns a place in the
vocabulary by terminating in a consumer that already exists in the
runtime — code that genuinely changes hydration, marshalling, or a
diagnostic when the attribute is present. An attribute whose only "read"
would be new code written solely to make the attribute count as read is
decoration, not a wired fact, and the debt count is supposed to go down.

=== `Deprecated` — no producer, no consumer

Nothing in `src/` reads OpenAPI's `deprecated` keyword. `rg -i deprecated
src/` returns nothing outside the attribute's own class. Wiring this one
means inventing both ends: a generator-side reader that has never existed,
and a runtime-side consumer that has never existed either. The natural
place to carry a per-property fact from `DescriptorParser` through to
`Hydrator` / `Marshaller` is the `PropertyDescriptor` value object — the
same carrier `Discriminator` already rides. A diagnostic that instead
reflected the class a second time, independently of `PropertyDescriptor`,
would only duplicate `DescriptorParser`'s own reflection pass to reach the
same fact by a parallel route — the exact "inventing a consumer" this
decision declines. Marking a property deprecated is a real thing a
consumer might want; it is a feature with a producer, a carrier and a
reader to design, not a constructor property left switched off.

=== Class-level `AdditionalProperties` — a generator-side fact with no runtime home

Unlike `Deprecated`, `additionalProperties` is not unread — the generator
already consults it in `InlineObjectResolver`, `PropertySynthesiser`,
`ResponseAnalyzer`, `TypeListScanner` and `FormatAdvisor`, to shape a
property's PHPDoc and to decide a response's return spec. But all of that
is generation-time bookkeeping about *types*, not a wire-time behaviour.
`Hydrator::hydrate()` builds its argument list strictly from
`DescriptorParser`'s per-property descriptors and silently drops any wire
key that is not one of them — declared or not, an unknown key never
reaches #the([constructed], Model). #A(Model) whose schema mixes declared
properties with non-trivial `additionalProperties` already falls back to
an `@todo` PHPDoc comment (`PropertySynthesiser.php`) rather than a typed
slot. Making the attribute mean something at runtime — collecting
undeclared wire keys somewhere a caller can reach them — needs a place on
the generated class to hold them, and deciding that is
`PropertySynthesiser`'s job: which properties #a(Model) gets. An
open/extensible-object hydration feature is a design decision on its own,
with its own consequences for #the(Model) surface — not a side effect of
closing out three dead constructor properties.

=== Class-level `Schema` — trivially emittable, never consumed

The component name behind `Schema` is the easiest of the three to emit:
#the(ModelEmitter) already knows it, since the class name it prints is
derived from it. But nothing in the runtime would ever read it back. The
attribute's own docblock named two hypothetical consumers — "discriminator
wiring" and "doc generation." Discriminator wiring does not need it:
`ModelAttributeApplier::applyDiscriminator` resolves every union branch to
a fully-qualified class name at generation time and bakes the finished
`field => class` map into the literal array attached to the property, so
`Hydrator::branchFromDiscriminator` only ever does an array lookup — it
never re-derives a class from a schema name at runtime, and a `Schema`
attribute on the target class would sit unread beside it. "Doc generation"
names a tool this runtime does not have. With no existing consumer on
either path, wiring `Schema` means building one from nothing, same as
`Deprecated`.

== Consequences

- The `Deprecated`, class-level `Schema` and class-level
  `AdditionalProperties` attribute classes are deleted. The vocabulary #link("attribute-and-phpdoc-driven-serialization.decision-260420.typ")[Attribute + phpdoc-driven marshal/unmarshal; Model classes stay clean] closed
  at six now stands at three: `WireName`, `Format`, `Discriminator`. That
  decision is amended, not rewritten, to say so.
- `phpstan.neon.dist` loses all three `ignoreErrors` entries these classes
  needed. No new exemption replaces them — the finding is gone because the
  dead code is gone, not because it is hidden again.
- `analysis-runs-at-maximum-strictness`'s `structural:` slot drops from
  five entries to two: only the `tests/generated/*Steps.php` pair remains,
  which is genuine tool blindness in speconaut-emitted output, not debt
  against a poagen decision.
- Re-opening the vocabulary at any point needs a new decision that names,
  up front, the runtime consumer the new attribute will terminate in — not
  just the schema construct it would describe.

=== Alternatives rejected

- *Build the open/extensible-object feature `AdditionalProperties` implies,
  as part of this change.* Rejected: it needs a storage decision inside
  `PropertySynthesiser` about which properties a Model gets, and conflates
  a genuine feature (typed access to undeclared wire data) with a dead-code
  cleanup. If a consumer needs this, it is its own task with its own
  acceptance criteria.
- *Add a diagnostic for `Deprecated` by having `Hydrator` reflect the class
  a second time, independent of `DescriptorParser`.* Rejected: reaches the
  same fact through a second, parallel reflection pass instead of reusing
  the one that already exists, which is inventing a consumer wearing the
  costume of reusing one.
- *Keep the three `ignoreErrors` entries and leave the task for later
  again.* Rejected: `audit-phpstan-generator-exemptions` already re-verified
  these findings once; leaving them a second time with no new plan is the
  flat debt count `analysis-runs-at-maximum-strictness` says not to keep.
- *Silence the findings with a trivial read (a getter nobody calls, a debug
  dump) just to flip PHPStan's verdict.* Rejected: satisfies the tool
  without satisfying the standard the tool is enforcing — nothing would
  meaningfully consume the value, so the property would still be dead in
  every sense that matters.
