#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Base64 binding for format byte",
  tags: ("generator", "runtime"),
  priority: 2,
  difficulty: 2,
  status: proposed(2026, 8, 9),
  links: (related("built-in-uuid-and-binary-format-bindings.task-260808.typ"),),
)

== Summary

`format: byte` is OpenAPI's spelling for base64-encoded bytes carried inside a
JSON string. Today it falls through `FormatAdvisor` like any other
unrecognised format: the property keeps its `string` type and the consumer
decodes by hand, or writes a value object to do it for them.

Unlike `uuid`, this one costs nothing to bind. Decoding is `base64_decode()`
with strict mode, encoding is `base64_encode()`, both in PHP core, and the
decoded value is a plain `string` — so poagen can ship the binding without
choosing a library for anyone and without the dependency question that
`built-in-uuid-and-binary-format-bindings` had to answer.

Split out of that task, which is scoped to `uuid` and to deciding that
`format: binary` on a plain property stays advisory. `byte` is the case that
task kept pointing at: a consumer who meant "bytes inside JSON" wrote
`binary` when the format they wanted was this one.

`examples/digitalocean` carries three `format: byte` sites, so there is a real
fixture to prove it against.

== Acceptance criteria

- `format: byte` resolves to a binding that decodes base64 on the way in and
  encodes on the way out, with no profile line required — the dependency-free
  case where a poagen-picked default costs the consumer nothing.
- A payload that is not valid base64 fails with a message naming the property,
  rather than silently yielding a corrupted string. Strict decoding, tested.
- The binding is overridable through `Profile::$formats`, `$propertyFormats`
  and `#[BindsFormat]`, like every other built-in.
- `FormatAdvisor` no longer reports `byte` as unrecognised.
- Whether `examples/digitalocean`'s golden tree adopts it is decided in this
  task and the regeneration, if any, is a commit of its own.
- `just check` and `just check-examples` green end-to-end.

== Non-goals

- `format: binary`. That stays advisory; the reasoning is recorded by
  `built-in-uuid-and-binary-format-bindings`.
- Streaming. A base64 property is a whole string in a JSON document; the
  stream-shaped body path is `BodyMediaType`'s and already ships.

== Files

- `src/Generator/Bindings.php`
- `src/Generator/ScalarFormat.php`
- `src/Generator/Emit/WireValueExpr.php`
- `runtime/src/Format/`
