#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Return a status-and-body Result from every operation, typed per declared response",
  tags: ("errors", "dx", "generator"),
  priority: 8,
  difficulty: 8,
  status: accepted(
    2026,
    8,
    2,
  )[Unblocked, and the answer is neither branch this task offered. The owner reversed \`error-response-policy\`'s rejected option (c): an operation returns an envelope carrying the status code and the body the document declared for that status, typed. 2xx stops being a special case. The exception survives only for a response the document did not describe. See the ruling below.],
)

== Summary

\`error-response-policy\` chose a single generic \`ApiException\` carrying the status code, the PSR-7 request and response, and a best-effort decoded body. It was the right call for a proof of concept, and it was recorded with an explicit upgrade path: revisit when a real schema justifies it.

kilbil is that real schema, and the project's goals have moved since. \`typed-injectable-surface\` asks for a typed surface with no slacking, and \`getDecodedBody(): mixed\` is the least typed thing the generator emits — a consumer who wants a field from a declared error body has to re-parse an array the generator already knew the shape of.

Against that: a typed exception per declared error schema is where generator complexity balloons. Cross-cutting errors like rate-limiting explode into near-identical classes, and most schema authors type their error responses loosely enough that the generated types would be mostly optional fields.

This task is deliberately deferred until kilbil generates end to end, so the decision is made against a real document rather than a hypothetical one. It exists so the question is not lost.

=== Owner ruling, 2026-08-02

The status code does not change the shape of a response, so it should not
change the shape of the return. Every operation returns one envelope:

+ the HTTP status code,
+ the body, hydrated into the type the document declared for that status.

Nothing about "2xx" is special. A document that says a 454 carries
\`{a: string, b: number}\` gets a model class for that body and an envelope
whose body is that class, exactly as a 200 does. There is no branch in the
generated method, no exception on the declared path, and no
\`getDecodedBody(): mixed\` anywhere.

The phrase "best-effort decoded body" in \`error-response-policy\` was not
describing a schema that cannot be honoured. It was describing the
consequence of \`error-response-policy\`'s own choice: one exception class
for every status meant nothing carried the model
to hydrate into, so the runtime could only run \`json_decode\` and hand back an
array. Under this ruling the model is known per status, so the body is
hydrated, not decoded-and-shrugged-at.

\`error-response-policy\` rejected this as option (c), on the grounds that a \`Ok|Err\` union is
non-idiomatic PHP and forces \`if (\$r instanceof Err)\` at every call site. That
objection does not apply to what is being built here — a single envelope class
is not a sum type, the call site reads \`->status\` and \`->body\`, and a consumer
who only cares about one shape narrows once. The rejection stands as history;
the decision is superseded.

=== What the document says, measured

Both large questions this task was filed to weigh have answers now.

kilbil's response surface, counted directly: 36 of 36 operations declare
exactly two statuses, \`200\` and \`403\`. No \`default\`, no \`2XX\` wildcard, no
operation with two success statuses, no operation with none. All 72 bodies are
\`application/json\`. The document declares no components at all, so every
schema is inline.

The error surface is one schema, byte-identical across all 36 operations:
\`{result_code?: integer, result_text?: string}\`, with no \`required\` list, so
both properties are optional. That is the "loosely typed error body" this task
worried about, confirmed rather than assumed — and it is still strictly more
than \`mixed\`.

The cost this ruling carries is also now measured rather than feared. Thirty-six
identical inline error schemas would emit thirty-six identical model classes
unless identical inline shapes collapse onto one. That is the "complexity
balloons" objection, and it is answered by structural deduplication rather than
by refusing to type the body.

== Acceptance criteria

- An operation returns an envelope carrying the HTTP status code and the
  hydrated body. The envelope also exposes the PSR-7 response, so a consumer
  needing a header or a raw body has a way that does not involve a second
  transport.
- The body's static type is the union of the models the document declares
  across that operation's responses, so \`instanceof\` narrows it at maximum
  PHPStan strictness with no suppression. An operation declaring one response
  shape has that shape as its body type, not a union of one.
- Status matching follows OpenAPI precedence: an exact status key wins, then a
  range key such as \`4XX\`, then \`default\`. This is the only place the ruling
  admits a status-shaped rule, and it decides which model to hydrate, never
  whether to throw.
- A response the document did not describe — a status with no exact, range or
  \`default\` key — raises rather than producing an envelope with an untyped
  body. So does a declared body that fails to hydrate. Both are the wire
  contradicting the document, which is the one thing an envelope cannot
  express honestly, and \`fail-loud-never-silent\` says it stops the run rather
  than degrading. The raised type carries the status, the request, the
  response and the reason.
- No generated method throws for a status the document declared. kilbil's 403
  becomes a body, not an exception, and the emitted tree contains no 2xx-range
  branch.
- Identical inline response schemas collapse onto one emitted model. Proven on
  kilbil: its 36 identical 403 schemas produce exactly one error model, not 36.
- A decision artifact supersedes \`error-response-policy\`, citing the
  measured kilbil surface above as its evidence, and states what the envelope
  costs: every generated method's return type changes, and every consumer
  reads \`->body\` where they used to read a model directly.
- The four examples regenerate and pass the strict analysis configured for
  generated output. \`examples/kilbil/src/\` — the hand-written wrappers — are
  updated to the envelope, and the diff shows what the change costs a real
  consumer.
- The runtime's transport contract carries the change: one call still sends a
  request and returns a value, and a consumer's substitute transport is still
  a single method to implement.

== Non-goals

- Acquiring, retrying, or backing off. Transport, per
  \`operations-delegate-to-an-injected-transport\`.
- Payload-level result envelopes — a failure the vendor reports inside a 200
  body. Ruled the consumer's business; see
  \`payload-level-result-envelopes\`. This task's envelope is about the HTTP
  status, which the document does describe.
- Typed exception classes per error schema. The ruling removes the reason for
  them: a declared error body is a return value now, so nothing is left for an
  exception hierarchy to express.
- Changing how a request is built or how a body is marshalled on the way out.

== Files

- \`truth/decisions/\` (a new decision artifact superseding \`error-response-policy\`)
- \`runtime/src/Contract/TransportInterface.php\`
- \`runtime/src/Contract/ResponseType.php\`
- \`runtime/src/Http/HttpTransport.php\`
- \`runtime/src/Http/ResponseDecoder.php\`
- \`runtime/src/Http/ApiExceptionFactory.php\`
- \`runtime/src/Contract/ApiErrorInterface.php\`
- \`src/Generator/Emit/OperationEmitter.php\`
- \`src/Generator/Emit/ApiExceptionEmitter.php\`
- \`examples/\` (all four trees regenerate; kilbil's hand-written wrappers change)
- \`truth/specs/\`
