#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Settle what an XML response body becomes",
  tags: ("generator", "xml", "policy"),
  priority: 7,
  difficulty: 5,
  status: proposed(2026, 8, 1),
)

== Summary

xml-content-type-policy closed carrying two criteria that contradict each other, and the contradiction is still live in the tree.

One required that an XML request or response reach a documented, tested outcome rather than a silent drop. Another said XML responses stay unimplemented. On the current code path an \`application/xml\`-only 2xx response resolves to \`ReturnSpec::void()\` and the run exits 0 with no diagnostic — so the first criterion fails and the second passes, and nothing in the truth tree records which one governs.

XML request bodies are implemented and tested. Responses are not, and the gap is invisible: the kilbil and petstore corpora carry zero XML responses, so every instrument pointed at this — the gate, the example drift check, the generated-tier analyser — is green and stays green. An emitted \`void\` method is perfectly well-typed.

This needs a decision before it needs code.

== Acceptance criteria

- A decision artifact records which of the three outcomes governs — decode to a typed model, refuse the operation at generation time, or return the raw body — citing the goal and standard it rests on.
- The decision names which of the two contradicting criteria it supersedes, and says so in writing.
- The chosen outcome is implemented and covered by a test that fails if the behaviour reverts to a silent \`void\`.
- A fixture carrying an XML response exists, so the corpus can exercise the path the vendor schemas currently never reach.
- The operation-generator feature states the resolved behaviour, replacing the scenario text that assumed responses stay unimplemented.

== Non-goals

- Rewriting XML request body handling, which landed and works.
- The general default-deny rule for unhandled constructs, owned by its own task. This one settles XML responses specifically, and should land against that rule rather than around it.
- Adding an XML parser dependency if the decision is to refuse rather than decode.

== Files

- \`truth/decisions/\`
- \`truth/specs/operation-generator.feature-260418.typ\`
- \`src/Generator/Emit/OperationAnalyzer.php\`
- \`src/Runtime/\`
- \`tests/\`
