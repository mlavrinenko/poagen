#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Represent non-JSON request and response bodies",
  tags: ("generator", "strictness"),
  priority: 6,
  difficulty: 5,
  status: accepted(2026, 8, 2),
)

== Summary

Six operations across the three vendored profiles are refused for their media
type alone, and the payloads behind them are not exotic:

- Three GitHub operations whose only 2xx content type is `text/html`,
  `text/plain` or a vendor stream type.
- One GitHub operation whose request body is `text/plain, text/x-markdown`.
- One GitHub and one petstore operation with an `application/octet-stream`
  request body — a file upload.

A body the document declares as text is a `string`, and a body it declares as
a binary stream is a stream. Neither needs a model, and neither is ambiguous.
The refusal is not protecting the consumer from anything; it is the absence of
a small amount of plumbing.

`real-world-schemas` is the goal this fails. A vendor that returns Markdown
from one endpoint has not published an unusual document.

== Acceptance criteria

- A request body declared `text/*` takes a `string` argument and is sent with
  that content type. Several text types on one body (GitHub declares
  `text/plain, text/x-markdown` together) do not multiply the method.
- A 2xx response declared `text/*` returns a `string`.
- An `application/octet-stream` request body takes a PSR-7 stream, or a
  resource, and is sent without being loaded into memory whole. The choice
  between them is recorded in the decision, since it is the one place this
  task has a real option.
- A binary 2xx response returns the stream rather than a decoded value.
- The six operations drop out of the three skip lists, entries removed.
- A media type still outside the supported set refuses by name, as today.
- `multipart/form-data` is explicitly out of scope here and stays refused, with
  its own task filed if any document needs it.

== Non-goals

- `multipart/form-data`, which carries per-part content types and encodings and
  is a larger job than every other media type in this task combined.
- XML responses, owned by #link("../decisions/xml-responses-refused-at-generation-time.decision-260801.typ").
- Content negotiation. Where a document declares several content types for one
  body, paogen picks by a documented order, it does not ask the consumer at
  call time.

== Files

- `src/Generator/Emit/RequestBodyAnalyzer.php`
- `src/Generator/Emit/ResponseAnalyzer.php`
- `runtime/src/Contract/EndpointBody.php`
- `runtime/src/Contract/ResponseType.php`
- `runtime/src/Http/ResponseDecoder.php`
- `examples/github/paogen.php`, `examples/petstore/paogen.php`
- `tests/`
