#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "keep the standalone runtime check from rotting outside the gate",
  tags: ("gates", "release"),
  priority: 5,
  difficulty: 3,
  status: wip(2026, 8, 8)[dispatched to a worktree agent],
)

== Summary

scripts/verify-runtime-standalone proves runtime-package-split's central claim: a generated client installs and runs with poagen/client-runtime alone, generator absent. It sits outside just check on purpose, because it resolves nyholm/psr7 from the network and the offline gate does not assume that. The consequence, measured on 2026-08-05: it had been broken across two separate changes and nobody noticed. security-wiring made petstore's ApiClient take a credential per declared scheme while the harness still constructed it with a transport alone, and typed-error-responses replaced the Pet return with an Envelope while the harness still read the model directly. The harness hand-writes the consumer side, so it tracks the generated API by hand and drifts every time that API moves. A check that proves a release-critical claim and is run by nobody proves nothing.

== Acceptance criteria

- The standalone check runs on a schedule something enforces, or its consumer-side code stops being hand-written, or its staleness becomes detectable from inside the offline gate. Pick one and say why the other two were not it.
- Whatever is chosen, a change to the generated API that the harness does not follow is caught by something other than a human remembering to run a recipe.
- The network dependency is either removed, vendored, or explicitly accepted with the reason recorded - it is the whole justification for the recipe sitting outside the gate, and it has not been re-examined since.

== Non-goals

- Putting the recipe into just check as-is. The network resolution is real and the offline gate's assumption is deliberate; this task is about the gap that creates, not about pretending it does not exist.
- Changing what the check proves.

== Files

- scripts/verify-runtime-standalone
- Justfile
- .github/ if a scheduled run is the answer
