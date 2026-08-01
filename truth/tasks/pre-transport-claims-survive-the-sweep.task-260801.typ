#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "The truth tree still describes the pre-transport call shape in seven places",
  tags: ("truth", "specs", "drift"),
  priority: 9,
  difficulty: 5,
  status: done(2026, 8, 1),
)

== Summary

operations-delegate-to-an-injected-transport retired the emitted call sequence. Seven artifacts still describe the retired one, and every gate is green over them.

In \`truth/specs/operation-generator.feature-260418.typ\`:

- \`:72\` and \`:82\` say the method body "never invokes \`self::hydrate\`" — vacuous now; nothing emits hydrate at all.
- \`:116\` says the method calls \`withHeader('api\_key', ...)\` "only when \`\\\$apiKey\` is not \`null\`".
- \`:290\` and \`:301\` say the body calls \`\\\$request = \\\$request->withHeader(...)\` "before \`sendRequest\`".
- \`:60\` and \`:273\` say the Client is constructed with a PSR-18 HTTP client. It takes a transport; the PSR-18 client is one level down inside the transport.

A search for \`sendRequest\`, \`withHeader\` and \`self::hydrate\` across every emitted and fixture tree returns zero matches.

Worse than stale: the step bodies assert the opposite. \`tests/generated/OperationGeneratorSteps.php:961\` asserts the emitted body contains \`->header('api\_key', \\\$apiKey)\` and does NOT contain \`if (\`, under a comment reading "No \`if\` in the emitted body" — the direct negation of the scenario it implements, whose derived method name still ends \`...OnlyWhenApiKeyIsNotNull\`. Same shape at \`:590\` and \`:1384\`, whose names still end \`...BeforeSendRequest\`.

So the suite is green on a false spec. A reader of the feature file learns a call sequence that no longer exists, and the tests agree with the code while their names agree with the spec.

These scenarios are \`unstable\` and therefore lockable, and the lock was refreshed on 2026-07-31. The false text is now the drift baseline the gate enforces.

Why the earlier sweep missed it: two-more-pre-transport-claims recorded its search terms — PSR-18, PSR-17, hydration, base URI, factories, credential, ClientInterface, RequestFactory, StreamFactory, PSR-7, "constructor takes". None of \`sendRequest\`, \`withHeader\`, \`\\\$request\` or \`self::hydrate\` was on it. Its acceptance criterion — that a search turns up no other scenario describing the pre-transport surface — was satisfied by a search that could not have found these.

== Acceptance criteria

- All seven passages describe the shape the generator actually emits, verified against a fixture tree rather than against the step body.
- No scenario asserts a conditional the emitter does not produce. Where a null argument drops itself at the boundary, the scenario says so.
- No step body contradicts the scenario it implements. Where a derived method name encodes a retired claim, the scenario text is fixed so the regenerated name follows.
- The two vacuous \`never invokes self::hydrate\` clauses either name something the generator could still get wrong, or go.
- The search that closes this task is recorded in the Result section by its exact terms, and covers call-shape vocabulary — method names, operators, and emitted fragments — not only type and collaborator names.
- \`speconaut lock --check\` is re-locked after the text changes, so the baseline stops enforcing the retired shape.
- \`caller-surface-is-injectable\`'s rule prose is reconciled with its own \`structural:\` slot, which already names the transport.

== Non-goals

- Changing what the generator emits. The code is right; the description is wrong.
- Re-opening operations-delegate-to-an-injected-transport, which decided this correctly and is accepted.
- Rewriting scenarios that were already corrected — the constructor scenario at \`:351\` and the feature description at \`:15\` are both accurate and stay.

== Files

- \`truth/specs/operation-generator.feature-260418.typ\`
- \`truth/standards/caller-surface-is-injectable.standard-260729.typ\`
- \`tests/generated/\`
- \`.speconaut/state.lock\`
