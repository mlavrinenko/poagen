#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Fail the run on every silent degradation unless the profile opts out",
  tags: ("generator", "cli", "policy"),
  priority: 9,
  difficulty: 7,
  status: done(2026, 8, 1),
)

== Summary

paogen still has degradation paths that produce output and exit 0. A consumer cannot tell a complete client from a quietly hollowed one, and no gate can either.

Three are known:

- \`OperationAnalyzer::responseReturn()\` returns \`ReturnSpec::void()\` whenever the response declares no \`application/json\`. An \`application/xml\` or \`text/plain\` response becomes a method that compiles, analyses clean at max strictness, runs, and throws the vendor's body away. No skip record, no notice, exit 0.
- \`GenerateCommand\` writes its success line before it reports skips, so a run that dropped work still opens by announcing success.
- \`RequestBodyAnalyzer\` aborts on an XML request body with a message describing a limitation that no longer holds, and names the skip list as the remedy — which drops an operation paogen can now emit.

The first is the shape of the problem: the analyzer's default is to degrade, so every construct nobody thought about degrades silently by construction. The fix is to invert that default, not to patch three sites.

None of this is new policy. \`fail-loud-never-silent\` already states that the default is refusal, that relaxation is explicit and scoped, and that it is "never implied by silence". \`silence-means-success\` already requires that a completed run emitted everything it was asked for, and that "two constructs the generator cannot represent must fail the same way" — the exact case that fails here, since a request body aborts and a response body shrugs. That standard even names \`unsupported-content-type-aborts-run\` among its required cases.

So this task closes a live violation of an accepted standard rather than deciding anything. What is genuinely open is only the shape of the opt-out surface.

abort-on-unrepresentable-constructs closed having unified the request side. This task owns the response side and the general rule.

== Acceptance criteria

- Every degradation path in the generator is enumerated in this task's Result section, with the file and line where it lived.
- The analyzer defaults to refusing an unhandled construct rather than emitting a degraded shape. A construct nobody anticipated fails the run instead of vanishing.
- A response declaring no representable content type aborts, naming the operation, the content types found, and what would make it acceptable.
- The success line is not printed on a run that skipped or degraded anything.
- Opting out is per-construct and names its target. A blanket allow-everything flag is not acceptable: it reintroduces exactly the failure this task removes.
- Each path has a test asserting the non-zero exit and the message content, not merely the exit code.
- A decision artifact records the shape of the opt-out surface, citing \`fail-loud-never-silent\` and \`silence-means-success\`. The default-deny rule itself needs no new decision — it is already accepted, and the artifact says so rather than restating it.
- The \`silence-means-success\` required case \`unsupported-content-type-aborts-run\` is covered by a scenario that fails against today's response path.
- An opt-out that has outlived its cause fails the run, as that standard requires: when a named omission would now generate cleanly, the consumer must remove it.

== Non-goals

- Decoding XML or text/plain response bodies. What an XML response should become is owned by its own task.
- Changing the emitted method signatures, which are the consumer-facing contract.
- Clearing the DigitalOcean and GitHub expected-failure markers.
- Widening the existing skip list, which is a different surface: skip means do not emit, opt-out means emit knowing it degrades.

== Files

- \`src/Generator/Emit/OperationAnalyzer.php\`
- \`src/Generator/Emit/RequestBodyAnalyzer.php\`
- \`src/GenerateCommand.php\`
- \`src/Generator/Profile.php\`
- \`truth/decisions/\`
- \`truth/specs/\`
- \`tests/\`

== Result

Every degradation path found, and what became of it.

#table(
  columns: 2,
  [*Where it lived*], [*What it did, and what it does now*],
  [\`OperationAnalyzer::responseReturn()\`, line 226],
  [Returned \`ReturnSpec::void()\` for any 2xx response without an \`application/json\` entry, an unresolved \`\$ref\`, or an inline array of non-\`\$ref\` items. The logic moved to a new \`ResponseAnalyzer\`, which returns \`null\` for anything unrepresentable and keeps \`void\` only for a genuinely empty response. \`OperationEmitter\` turns that \`null\` into a refusal through the same mechanism an unsupported request body already used.],
  [\`GenerateCommand\`, lines 108-111],
  [Printed the success line before reporting skips. The line is now suppressed entirely whenever anything was skipped, and the skip report comes first.],
  [\`RequestBodyAnalyzer\`, lines 82-141],
  [Claimed paogen supported only JSON and form-urlencoded, which stopped being true when XML request bodies landed, and named the skip list as the remedy for a construct paogen can emit. Now has an XML-specific branch naming the right remedy.],
  [\`Profile::\$skip\` staleness],
  [Already enforced by \`SkipListValidator\` from the request-side work, and it covers the newly-refused response constructs with no new logic. A skip that would now generate cleanly still fails the run.],
)

The inversion is the point rather than the three fixes: the analyzer's default was to degrade, so any construct nobody anticipated vanished by construction. It now refuses by default, and a shape nobody thought about stops the run instead of disappearing.

Verified end to end on the merged tree rather than through the test suite alone. Generating against a schema carrying \`text/plain\`, \`application/xml\`, an unresolvable \`\$ref\` and an inline array of scalars exits 1, writes zero files, prints no success line, and names each construct with its JSON-pointer location and what would make it acceptable:

\`\`\`
paogen generate: 4 problems found; nothing was written:
  - GET /plain-text (getPlainText) — 200 response
    (/paths/~1plain-text/get/responses/200) content type(s) 'text/plain'
    — paogen only decodes application/json responses ...
\`\`\`

One shape this surfaced that had been hiding: a generated-test fixture used an inline \`items: {type: string}\` for a response array, which neither the old nor the new code ever supported. The old code voided it silently, so nobody knew.
