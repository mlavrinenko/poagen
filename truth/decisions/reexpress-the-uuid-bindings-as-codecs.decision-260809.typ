#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/runtime.context.typ": *

#show: decision.with(
  title: "the shipped uuid bindings are re-expressed as codecs, not kept as ScalarBinding wrappers",
  status: accepted(2026, 8, 9),
  contexts: (generation-context, runtime-context),
  goals: (
    link("../goals/declared-shapes-become-types.goal.typ"),
    link("../goals/user-code-guides-generation.goal.typ"),
  ),
  standards: (link("../standards/generated-types-are-total.standard-260729.typ"),),
)

== Context

`built-in-uuid-and-binary-format-bindings` shipped `Format\RamseyUuid` and
`Format\SymfonyUuid` as `ScalarBinding` wrappers: each holds the library's
UUID value one field in, and the emitted property is the wrapper — reading
the real value costs `$account->id->value`, or `(string) $account->id` for
the canonical form. That decision named the hop as a consequence of
`Marshal\PropertyTypeResolver` recognising a binding only by reflecting the
property's own declared type, which a third-party class cannot be made to
satisfy, and pointed at `codec-bindings-for-foreign-value-types` as where a
codec kind would answer this properly — explicitly declining to "pretend the
wrapper is the end state."

That task now ships the codec kind: `Poagen\Runtime\Codec`, a contract a
foreign type does not need to implement, converting on its behalf instead.
Its fourth acceptance criterion asks this task to decide, not leave
ambiguous, whether the two shipped `uuid` bindings move onto it or stay as
they were.

== Choice

`Format\RamseyUuid` and `Format\SymfonyUuid` are deleted. `Format\RamseyUuidCodec`
and `Format\SymfonyUuidCodec` replace them, both implementing `Codec` through
a shared `Format\UuidCodec` base that carries the one thing they still share
— the non-string-payload guard — so the two are a handful of lines each
rather than two near-identical classes
(`quality-gates-at-maximum-strictness`'s duplication ratchet is why this
matters: two structurally identical adapters is exactly the shape that has
tripped it before). A bound `uuid` property is now `public UuidInterface $id`
or `public Uuid $id` directly, and an operation parameter of the same format
converts through the codec's static `encode()` rather than through a method
call on the value.

Three reasons this is the conversion and not the "keep and document as the
boxed alternative" option the parent decision also allowed:

- The wrapper was never claimed as a resting point. The parent decision's own
  words — "this decision does not pretend the wrapper is the end state" —
  named the codec kind as the answer, not as one of two equally valid
  answers. Shipping both would mean a consumer choosing `uuid`'s binding
  faces two shapes with no principled reason to prefer either, which is the
  ambiguity this task was asked to resolve rather than preserve.
- `declared-shapes-become-types` reads directly on this: a UUID property's
  declared shape *is* `ramsey/uuid`'s `UuidInterface` once a consumer names
  that library, and a wrapper around it is a shape the schema never asked
  for. The codec removes it rather than documents around it.
- The blast radius is bounded and already paid for. `codec-bindings-for-
  foreign-value-types` had to build the codec mechanism regardless — the
  runtime resolver, hydrator, marshaller, response decoder, and three
  emitter sites — to satisfy its own acceptance criteria. Re-pointing the
  two shipped bindings onto that mechanism is not new design, only using it
  where it was always going to be exercised in the fixture that proves it
  end to end (`tests/fixtures/profiles/format-binding.php`).

This is a breaking rename, deliberately not staged behind a deprecation:
`poagen/client-runtime` has not reached `0.1.0` (see this repository's own
`CHANGELOG.md`, still `0.1.0 - TBD`), so nothing published depends on
`Format\RamseyUuid`'s or `Format\SymfonyUuid`'s shape yet.

== Consequences

`examples/digitalocean`'s golden tree does not change: it does not bind
`uuid` today (`binary-on-a-property-stays-advisory` recorded that its 66
`format: uuid` sites stay unbound), so nothing in this repository's own
example trees regenerates because of this rename. The `tests/fixtures/
generated/format-binding` golden tree does regenerate, in the same commit —
its whole purpose is pinning what a bound `uuid` emits, and that shape
changed.

A consumer already on `Format\RamseyUuid` before this change has a mechanical
fix on upgrade: swap the import for `Format\RamseyUuidCodec`, drop the
`->value` hop, and swap `(string) $account->id` for
`Format\RamseyUuidCodec::encode($account->id)` (or, more simply, `$account->id->toString()` —
`ramsey/uuid`'s own method — since the property is now the library's own
type rather than a wrapper hiding it).
