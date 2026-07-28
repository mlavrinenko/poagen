#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Emit an interface for the generated client",
  tags: ("dx",),
  priority: 8,
  difficulty: 5,
  status: proposed(2026, 7, 28),
)

== Summary

The generator emits a final class and no interface. A consumer who wants to add retries, token refresh, a friendlier signature or a paginated iterator has nowhere to stand: they cannot extend the final class, cannot substitute their own type anywhere the generated one is named, and cannot fake it in a test without going through the transport layer. This is the concrete blocker for the layered architecture the project is aiming at, where the generated tree is never edited and all convenience lives in hand-written code. It is a change in one emitter.

== Acceptance criteria

- An interface is emitted alongside the client, declaring every operation with the same signatures.
- The generated client declares that it implements it.
- A hand-written class implementing the same interface and delegating to the generated one compiles and satisfies the project's strict analysis.
- A test double implementing the interface can replace the client with no transport involved.
- The interface is regenerated and pruned with the rest of the tree.
- A worked example of the wrapper pattern ships under the examples tree.

== Non-goals

- Splitting the client by tag; that is a separate task.
- Emitting interfaces for models — data types stay concrete.

== Files

- \`src/Generator/Emit/ClientEmitter.php\`
- \`src/Generator/Emit/OperationEmitter.php\`
- \`examples/\`
- \`truth/specs/operation-generator.typ\`
