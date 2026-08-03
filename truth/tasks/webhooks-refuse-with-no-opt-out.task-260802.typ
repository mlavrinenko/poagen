#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "webhooks refuse with no opt out",
  tags: ("generator", "openapi-31", "strictness"),
  priority: 4,
  difficulty: 4,
  status: accepted(
    2026,
    8,
    3,
  )[Ruled by the owner on 2026-08-03: a webhook is skippable. The recommended ruling below is the one they took, so the shape it describes is now the work.],
)

== Summary

An OpenAPI 3.1 document declaring webhooks aborts the run by name, and nothing can turn that abort off. Landed with swap-openapi-parser-for-31-support, deliberately: UnsupportedKeywordScanner refuses a webhooks entry naming its pointer, method and operationId, because no emitter can represent one.

The gap is the opt-out, not the refusal. Profile skip names an operation under paths or a component, and a webhook is neither, so a consumer whose vendor document happens to declare webhooks cannot generate a client at all — not a smaller one, none. That reading makes skip-is-the-only-opt-out false for this construct: there is no opt-out.

No vendored document in examples declares webhooks, so nothing is blocked today. It is filed because the first real 3.1 document that carries them turns a whole-document refusal into a support question with no answer.

=== Owner ruling, 2026-08-03 — a webhook is skippable

Ruled yes, in the owner's words: skippable, because generating webhooks for a
client makes no sense. Everything below stands as the argument they accepted.

One line of that ruling needs pinning down, because the reason given reaches
further than the answer and the wrong reading of it is a reading this project
has rejected twice in one day. "Generating webhooks makes no sense" is not in
dispute and never was — emitting an inbound surface is already a non-goal
below. The question asked was narrower: whether a consumer can opt out of the
whole-document refusal. Yes is the answer, and it leaves the default alone.

So, precisely: a document declaring webhooks still refuses by default. It
refuses because paogen will not shrink a document silently, not because a
webhook is exotic. What changes is that `$skip` gains a key spelling for one,
so a consumer can write the omission down and get a client from `paths`. An
opt-out the consumer writes is an omission they asked for; the same omission
taken by paogen unasked is the ignore-with-a-notice the owner rejected on the
`anyOf` member and on the scalar-or-list parameter. Skippable is not
ignored-by-default, and a later session reading only the reason could conflate
them.

The argument for skippable, in three parts:

- The other four 2020-12 refusals are already skippable, and webhooks is the
  odd one out for a purely mechanical reason: `$skip` is keyed by operation id
  or component name, and a webhook is neither. That is the key space being too
  narrow, not a judgment that webhooks are different in kind.
- The alternative is a very strong claim — "a document declaring webhooks
  cannot be generated at all" — over a construct that is orthogonal to `paths`.
  A webhook block describes an inbound surface. Refusing to emit an outbound
  client because the vendor also documented what they will send you is a total
  refusal over something the consumer did not ask about. `silence-means-success`
  forbids a silent shrink; it does not ask for a loud refusal of everything.
- `skip-is-the-only-opt-out` reads false for this construct today, and the
  cheapest way to make it true again is to widen the key space rather than to
  write a decision explaining why one construct is exempt from the rule the
  decision states absolutely.

The shape, now settled: `$skip` gains a key spelling for a webhook — keyed by
its key in the `webhooks:` map, distinguishable from an operation id, one map
not two, because a second opt-out map is exactly what `skip-is-the-only-opt-out`
forbids and `record-the-union-pin-as-a-second-opt-out` is already amending it
once for. Skipping every declared webhook generates the client from `paths`
alone; skipping none, or some, still refuses and names the ones left.

Note the ordering this creates: `record-the-union-pin-as-a-second-opt-out`
amends `skip-is-the-only-opt-out` to name `$unionPins` as the second and final
opt-out surface. Widening `$skip`'s key space is not a third one — it is the
same surface accepting a key it should always have accepted, which is the
argument for widening rather than adding. Land this after that amendment and
say so in it, or the amendment reads as closing a door this walks through.

== Acceptance criteria

- A webhook can be named in an opt-out the consumer writes. The default stays a refusal; only an explicit skip turns it off, and a document whose webhooks are not all skipped still refuses and names the ones left.
- If webhooks become skippable, the skip entry names the webhook by its key, the run reports what it dropped, and a stale entry is called stale exactly as an operation skip is.
- A fixture drives a document that declares both paths and webhooks and proves the chosen behaviour end to end.

== Non-goals

- Emitting webhook handlers, receivers, or any inbound surface. paogen generates clients.
- The other 2020-12 refusals (const, prefixItems, unevaluatedProperties, contentMediaType), which name an operation or component and are therefore already skippable.

== Files

- src/Generator/Emit/UnsupportedKeywordScanner.php
- src/Generator/Profile.php
- tests/fixtures/schemas/webhooks-3.1.yaml
- truth/decisions/
