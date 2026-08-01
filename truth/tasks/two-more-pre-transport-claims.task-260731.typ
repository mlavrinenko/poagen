#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Two more pre-transport claims survive in the operation-generator feature",
  tags: ("speconaut",),
  priority: 5,
  difficulty: 3,
  status: done(2026, 8, 1),
)

== Summary

A sweep for survivors of the runtime-transport refactor found two beyond the scenario already corrected, both in \`truth/specs/operation-generator.feature-260418.typ\`. Searched for: PSR-18, PSR-17, hydration, base URI / baseUri / \$baseUri, factories, credential, ClientInterface, RequestFactory, StreamFactory, message factories, stream factory, request factory, PSR-7, \`constructor takes\`.

\`:15-16\`, the feature's \`description:\` block, still says the constructor "takes a PSR-18 \`ClientInterface\` together with PSR-17 request and stream factories, and a base URI string". Feature-level prose rather than a scenario, so the earlier task's scope did not reach it.

\`:289\`, the scenario "An apiKey header scheme becomes a constructor arg attached as a header on secured ops", asserts the argument is "placed after \`\$baseUri\`". There is no \`\$baseUri\` any more. The step body backing it — \`tests/generated/OperationGeneratorSteps.php:783-792\` — already asserts the correct order (transport, then apiKey, then bearerToken), so only the wording is wrong.

The second one is why this is its own task: rewording that Then changes the derived step-method name from \`...PlacedAfterBaseUri\` to \`...PlacedAfterTransport\`. Step methods come from the specs, so renaming one means regeneration must carry the hand-written body across.

== Acceptance criteria

- the feature description names the constructor the generator emits
- the apiKey scenario no longer refers to \`\$baseUri\`
- the renamed step method keeps its hand-written body; say in the report how that was verified rather than assumed
- \`just check\` and \`speconaut check truth/\` both pass

== Non-goals

- does not change the emitter
- does not restage any scenario
- does not touch the standards' structural text, written against the real enforcers

== Files

- \`truth/specs/operation-generator.feature-260418.typ\`
