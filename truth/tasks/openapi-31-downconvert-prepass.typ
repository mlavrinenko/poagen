#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Accept OpenAPI 3.1 through a down-convert pre-pass",
  tags: ("generator",),
  priority: 9,
  difficulty: 6,
  status: proposed(2026, 7, 28),
)

== Summary

\`paogen validate\` refuses any 3.1 document with \`Unsupported openapi version: 3.1.0\`, which rules out the kilbil loyalty schema and most schemas published since. The decision on 3.1 strategy catalogued three options — swap the parser, write a shim, fork — and deferred. Probing the parser shows the shim is much the cheapest: it passes \`type: \[string, "null"\]\` straight through as a raw array, which the type resolver then degrades to an untyped value because it requires a string, and it yields a null type for \`const\`. Both are fixable on the decoded document before it ever reaches the parser. The kilbil schema's entire 3.1 surface is 91 occurrences of the nullable-type-array idiom.

== Acceptance criteria

- A 3.1 document is accepted and generates.
- \`type: \[T, "null"\]\` becomes the nullable form of \`T\`; \`const: X\` becomes a single-valued enum; the 3.1 plural examples key is reconciled with the 3.0 singular one.
- Any 3.1 construct the pre-pass does not cover aborts the run and names the construct, per the fail-loud goal.
- The version gate accepts 3.1 rather than being bypassed by rewriting the version string.
- Round-trip tests assert the down-converted document against a fixture for each translated construct.
- The decision on 3.1 strategy is superseded and the README limitation note is removed.

== Non-goals

- Full JSON Schema 2020-12 support: prefix items, unevaluated properties, dynamic references and webhooks are out, and must abort rather than degrade.
- Replacing the parser outright.

== Files

- \`src/Cli.php\`
- \`src/Generator/ProfileLoader.php\`
- \`src/Generator/Schema/\` (new)
- \`truth/decisions/008-openapi-31-strategy.typ\`
- \`tests/fixtures/schemas/\`
- \`README.md\`
