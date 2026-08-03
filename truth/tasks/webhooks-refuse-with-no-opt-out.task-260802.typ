#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "webhooks refuse with no opt out",
  tags: ("generator", "openapi-31", "strictness"),
  priority: 4,
  difficulty: 4,
  status: proposed(2026, 8, 2),
)

== Summary

An OpenAPI 3.1 document declaring webhooks aborts the run by name, and nothing can turn that abort off. Landed with swap-openapi-parser-for-31-support, deliberately: UnsupportedKeywordScanner refuses a webhooks entry naming its pointer, method and operationId, because no emitter can represent one.

The gap is the opt-out, not the refusal. Profile skip names an operation under paths or a component, and a webhook is neither, so a consumer whose vendor document happens to declare webhooks cannot generate a client at all — not a smaller one, none. That reading makes skip-is-the-only-opt-out false for this construct: there is no opt-out.

No vendored document in examples declares webhooks, so nothing is blocked today. It is filed because the first real 3.1 document that carries them turns a whole-document refusal into a support question with no answer.

=== Recommended ruling, awaiting the owner — make a webhook skippable

Written so the owner rules yes or no rather than starting from a blank page.
This task stays `proposed` until they do; nothing below is settled.

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

Shape, if the ruling is yes: `$skip` gains a key spelling for a webhook — keyed
by its key in the `webhooks:` map, distinguishable from an operation id, one
map not two, because a second opt-out map is exactly what
`skip-is-the-only-opt-out` forbids and `record-the-union-pin-as-a-second-opt-out`
is already amending it once for. Skipping every declared webhook generates the
client from `paths` alone; skipping none, or some, still refuses and names the
ones left.

Shape, if the ruling is no: a decision records that a document carrying
webhooks is out of scope, says why the inbound surface makes the whole document
unrepresentable rather than partially so, and names what would reopen it.

== Acceptance criteria

- Either a webhook can be named in an opt-out the consumer writes, or the refusal is recorded as deliberate in a decision that says why a document carrying webhooks cannot be generated. Argue it; do not leave it undecided.
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
