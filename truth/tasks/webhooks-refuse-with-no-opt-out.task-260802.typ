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
