#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/schema.context.typ": *

#show: decision.with(
  title: "A binary body is a PSR-7 stream, in both directions",
  status: accepted(2026, 8, 3),
  contexts: (generation-context, schema-context),
  goals: (
    link("../goals/declared-shapes-become-types.goal.typ"),
    link("../goals/real-world-schemas.goal.typ"),
  ),
  standards: (link("../standards/generated-types-are-total.standard-260729.typ"),),
)

== Context

Six operations across three vendored documents were refused for their media
type alone — text bodies, and `application/octet-stream` file uploads. Nothing
about them is ambiguous: a body the document declares as text is a `string`,
and a body it declares as binary is a stream. The refusal was the absence of
plumbing, not a judgment.

Representing the text half raised no question. The binary half raised one, and
`represent-non-json-request-and-response-bodies` named it as the single real
option the task contained: a PHP `resource`, or a PSR-7 `StreamInterface`.

The owner delegated the choice on 2026-08-03 with one condition — that whichever
way it goes, the reason is written down and applied consistently. This is that
reason.

There is an apparent conflict to dispose of first. The owner also ruled that
the response envelope carries a status, a hydrated body and headers, with no
PSR-7 object on it. A binary response body typed `StreamInterface` puts a PSR-7
type in the envelope's body slot, which looks like the same thing and is not.

== Choice

`Psr\Http\Message\StreamInterface`, for a binary request body and a binary
response body alike. This decides the *type* once, for both directions — it
is not a claim that both directions are wired. Only the request side has
landed; see "What would lift the response-side refusal" under Consequences
for what is actually true on the tree today.

The deciding fact is not preference. PHP has no `resource` type declaration —
a resource cannot be written into a property type or a return type at all. A
resource-typed body would therefore be `mixed` with a docblock beside it, and
`declared-shapes-become-types` forbids exactly that: a shape the document
declared becoming `mixed` in the emitted surface. `resource` does not lose on
taste; it loses to a goal, and `generated-types-are-total` says the same thing
from the other side.

The rest merely agrees. `runtime/composer.json` already requires
`psr/http-message`, `psr/http-client` and `psr/http-factory`, so nothing is
added to what a consumer installs. A runtime-owned stream wrapper would
duplicate a standard interface and buy no guarantee the interface does not
already give, while costing every consumer a conversion at the boundary.

=== Why this does not contradict the envelope ruling

"No PSR-7 object on the envelope" is a statement about transport plumbing: the
envelope does not expose the PSR-7 response, so a consumer reading `->status`
and `->body` is not handed the machinery that produced them, and PSR-7 can be
added later as an accessor without breaking anything.

A body typed `StreamInterface` is not plumbing leaking through. It is the
declared shape of that body — the document said the payload is a binary
stream, and a stream is what the consumer gets. The two claims are about
different things, and only the first was ruled out.

== Consequences

- On the request side, an `application/octet-stream` request body is handed
  to the request as it stands. Nothing on that path casts it or calls
  `getContents()`, so a large upload is never read into memory whole. This is
  pinned by a decorator fixture whose `__toString()` and `getContents()` both
  throw while chunked `read()` delegates normally, so a later `(string)` cast
  fails with a message naming what went wrong rather than quietly buffering a
  file.
- On the response side, nothing has landed. `ResponseAnalyzer::textResponse()`
  still refuses any 2xx response whose schema declares `format: binary`, and
  the operation aborts generation rather than falling back to a decoded value
  (`default-deny-on-degradation`) — `ResponseRefusal` names the gap in the
  message it prints: "paogen sends a binary request body as a PSR-7 stream
  but does not yet return one." Both sides are pinned by an integration test:
  one proving the request stream is sent unread, the other,
  `testABinaryResponseStillAbortsBecauseTheReturnContractCannotNameAStream`,
  proving the response still aborts — so the request side's landing cannot
  silently start reading as the response side's too.
- Binary is decided by the schema, not the media type: any `format: binary`
  schema is binary under whatever subtype the vendor named it. That is why
  DigitalOcean's `application/pdf` works without being enumerated, and why
  GitHub's `application/octocat-stream` — whose schema says `type: string` —
  is correctly a string despite its name.
- Several text types on one body do not multiply the emitted method. Where a
  document declares more than one, paogen picks by declaration order and says
  so; it does not negotiate at call time.
- `multipart/form-data` stays refused, now with a reason naming its own shape
  rather than a content-type list. It carries per-part content types and
  encodings and is a larger job than every other media type here combined.

=== What would lift the response-side refusal

`ReturnSpec` has eight kinds — void, model, list, scalar, scalar list, map,
mixed and union — and none of them means "hand back the body unread".
`ResponseTypeEmitter` maps every `ReturnSpec` kind onto the runtime
`ResponseType` one-to-one, and `ResponseType` has the identical gap, so
`ResponseDecoder` has nothing to decode a stream kind into either. Lifting
the refusal means adding a stream-carrying kind across that whole chain —
`ReturnSpec`, `ResponseTypeEmitter`, `ResponseType`, `ResponseDecoder`, and
the emitted method's own return type — not a change local to
`ResponseAnalyzer`.

No task in `truth/tasks/` currently does this work.
`represent-non-json-request-and-response-bodies`, the task that landed the
request side, listed "a binary 2xx response returns the stream rather than a
decoded value" as one of its own acceptance criteria, but closed without
delivering it; the gap this section describes is that unmet criterion,
still open. Closing it needs a task of its own before `ResponseAnalyzer`'s
refusal can move — this decision only says what the type would be once that
task lands, the same `Psr\Http\Message\StreamInterface` the request side
already uses.
