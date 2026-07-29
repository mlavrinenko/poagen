#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Decide whether declared error schemas become typed exceptions",
  tags: ("errors", "dx", "generator", "deferred"),
  priority: 4,
  difficulty: 6,
  status: proposed(2026, 7, 29),
)

== Summary

ADR-009 chose a single generic \`ApiException\` carrying the status code, the PSR-7 request and response, and a best-effort decoded body. It was the right call for a proof of concept, and it was recorded with an explicit upgrade path: revisit when a real schema justifies it.

kilbil is that real schema, and the project's goals have moved since. \`typed-injectable-surface\` asks for a typed surface with no slacking, and \`getDecodedBody(): mixed\` is the least typed thing the generator emits — a consumer who wants a field from a declared error body has to re-parse an array the generator already knew the shape of.

Against that: a typed exception per declared error schema is where generator complexity balloons. Cross-cutting errors like rate-limiting explode into near-identical classes, and most schema authors type their error responses loosely enough that the generated types would be mostly optional fields.

This task is deliberately deferred until kilbil generates end to end, so the decision is made against a real document rather than a hypothetical one. It exists so the question is not lost.

== Acceptance criteria

- The kilbil document's declared error responses are enumerated: how many distinct error schemas, how many operations share each, how well typed each one is.
- A decision artifact is recorded that either supersedes ADR-009 or reaffirms it, citing a goal and a standard, and citing that enumeration as its evidence.
- If the decision is to type them, the emitted exception surface is implemented and the generated tree stays clean at PHPStan max level.
- If the decision is to reaffirm the generic exception, the reasoning names what would change the answer later.

== Non-goals

- Changing how non-2xx statuses are detected or how the exception is thrown. Only what type is thrown is in question.
- Result-type returns. ADR-009 already rejected that and nothing has changed.
- Retry or backoff behaviour, which belongs to the transport, not the generated client.

== Files

- \`truth/decisions/\` (a new decision artifact)
- \`src/Generator/Emit/ApiExceptionEmitter.php\`
- \`src/Generator/Emit/ResponseHandler.php\`
