#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "a media type with no schema takes a raw body",
  tags: ("generator", "strictness"),
  priority: 6,
  difficulty: 2,
  status: accepted(
    2026,
    8,
    3,
  )[Split out of resolve-composition-schemas-in-bodies-and-responses, where it was the one case that is not a schema problem at all. One operation, and it is the whole task.],
)

== Summary

GitHub's `repos/get-content` declares an `application/json` request body whose
media type carries `examples` and no `schema` key at all. Confirmed by reading
the document: the `content['application/json']` node exists and its `schema` is
absent, not empty.

`RequestBodyAnalyzer` refuses it, and the skip entry it carries says
"application/json request body with an inline (non-`$ref`) schema" — a reason
naming a schema the document never wrote. The refusal fires purely on the media
type being present.

A body with no declared schema has no shape to represent. Refusing is one
honest answer and it is what happens today; the better one is that the consumer
sends whatever the vendor's prose told them to send, because that is exactly
what the document is saying. `represent-non-json-request-and-response-bodies`
already established the shape of that answer for a body paogen cannot type — a
`StreamInterface` for a binary body, a `string` for a text one. This is the
same move for the case where the type is JSON and the shape is unstated.

One operation, in one document, and no reason to expect it to be the last: a
media type with examples and no schema is a documentation habit, not a defect.

== Acceptance criteria

- A media type declaring no `schema` key emits a raw payload parameter rather
  than refusing the operation. The parameter's type is `array` with a
  `@param array<string, mixed>` docblock for a JSON media type; this is the
  `KIND_JSON_MAP` surface that already exists for a genuinely shapeless object
  body, reached by a different route.
- The run reports it once per site on the notice channel — the stderr one
  `report-unrecognised-formats` established, never moving the exit status —
  saying the document declared no schema, so the body is passed through
  untyped. Silence here would be the widening
  `merge-allof-members-into-one-model` exists to remove.
- A media type declaring a `schema` that paogen cannot represent still refuses,
  unchanged. The distinction is "the document said nothing" versus "the
  document said something paogen cannot type", and only the first passes.
- `repos/get-content`'s skip entry is removed from `examples/github/paogen.php`
  and the operation appears on the emitted client.
- A fixture drives both halves in one run: one media type with no schema that
  generates, one with an unrepresentable schema that refuses.

== Non-goals

- Reading `examples` or `example` to infer a shape. A guess that moves between
  runs is what `cheap-regeneration` forbids, and an example is not a schema.
- The response direction. No document in the corpus declares a response media
  type with no schema, and a response with no shape has nothing to hydrate
  into, which is a different question.
- Changing what `KIND_JSON_MAP` emits. This task routes a second case to it.

== Files

- `src/Generator/Emit/RequestBodyAnalyzer.php`
- `src/Generator/Emit/RequestBodyRefusal.php`
- `examples/github/paogen.php`
- `examples/github/generated/` (regenerated)
- `tests/`
