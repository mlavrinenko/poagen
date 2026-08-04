#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "return a binary 2xx as the stream a done task already promised",
  tags: ("generator", "runtime"),
  priority: 5,
  difficulty: 5,
  status: wip(2026, 8, 4)[Dispatched to a worktree agent off c68c5ce2.],
)

== Summary

represent-non-json-request-and-response-bodies is done, and one of its acceptance criteria says a binary 2xx response returns the stream rather than a decoded value. That criterion was never delivered. ResponseAnalyzer textResponse returns null for any 2xx whose schema declares format binary, and the refusal message says paogen sends a binary request body as a PSR-7 stream but does not yet return one. The request side did land. The gap is the return contract: ReturnSpec has no kind that names a stream, and neither does the runtime ResponseType and ResponseDecoder chain it maps to. This task carries the undelivered half. The done task is not reopened, because it did happen and reopening it would lose that.

== Acceptance criteria

- An operation whose 2xx declares format binary returns a PSR-7 StreamInterface instead of aborting. The existing test that pins the refusal is replaced by one that pins the stream, and the refusal message that named the missing contract goes with it.
- The stream is not read on the way out. A decorator fixture that throws on getContents and \_\_toString survives the round trip, matching how the request side is already pinned.
- ReturnSpec, ResponseTypeEmitter, ResponseType and ResponseDecoder all name the stream kind, so the generated return type and the runtime agree without a cast.
- a-binary-body-is-a-psr-7-stream loses its what would lift the response-side refusal section, because this task lifted it.
- The four examples regenerate and the diff names every operation whose return type changed.

== Non-goals

- Buffering, seeking or content-length handling. The stream is handed over as the transport produced it.
- Binary bodies at any status the document did not declare. That is typed-error-responses' territory.

== Files

- src/Generator/Emit/ResponseAnalyzer.php
- src/Generator/Emit/ResponseTypeEmitter.php
- runtime/src/Contract/ResponseType.php
- runtime/src/Http/ResponseDecoder.php
- truth/decisions/a-binary-body-is-a-psr-7-stream.decision-260803.typ
- tests/
- examples/
