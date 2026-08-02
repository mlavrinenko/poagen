#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Support the parameter shapes real documents use",
  tags: ("generator", "strictness"),
  priority: 7,
  difficulty: 5,
  status: accepted(2026, 8, 2),
)

== Summary

Twenty-three operations across the two large examples are refused because of a
parameter shape, and every one of them is ordinary. Counted from the skip
lists: 7 on DigitalOcean, 16 on GitHub.

Four distinct causes hide behind the one message:

- A parameter whose `schema` is itself a `$ref`. The reader looks at the
  reference node's own `type` keyword, finds none, and calls the shape
  unspecified. Dereferencing it would find an ordinary string or integer.
- A parameter whose schema is a `oneOf`/`anyOf` with no literal `type`. The
  scalar-union work already resolves this shape elsewhere; the parameter path
  does not use it.
- An array-valued query parameter whose items are not a plain scalar Schema —
  GitHub's `job_names` is the named example.
- A `required` header parameter, refused outright.

`real-world-schemas` says every operation a published document declares appears
on the client, and these twenty-three do not. None of them is an edge case: an
array query parameter is how every list endpoint filters, and a `$ref`-ed
parameter schema is how a document avoids repeating itself.

== Acceptance criteria

- A parameter whose schema is a `$ref` resolves through the reference and is
  typed as whatever it points at.
- A parameter whose schema is a scalar union resolves through the same reader
  the rest of the generator uses, rather than a second one.
- An array-valued query parameter is emitted as a typed list and serialised
  per its declared `style` and `explode`. Where the document declares neither,
  the OpenAPI defaults apply and the run says which it used.
- A required header parameter is emitted as a required constructor or method
  argument.
- The twenty-three operations drop out of both examples' skip lists, and the
  entries are removed rather than left stale.
- A parameter shape still outside the supported set refuses by name, as today.
  Nothing here weakens the gate; it moves shapes across it.

== Non-goals

- `path-parameters-run-through-no-shape-gate-at-all`, which adds the missing
  refusal on the path position. That one closes a hole; this one widens what
  passes. They touch the same file and should land in sequence, not together.
- Cookie parameters, which no vendored document declares.
- `content`-typed parameters (a parameter whose value is a serialised media
  type rather than a primitive), which no vendored document declares either.

== Files

- `src/Generator/Emit/OperationAnalyzer.php`
- `src/Generator/Emit/TypeResolver.php`
- `runtime/src/Contract/Endpoint.php`
- `examples/digitalocean/paogen.php`, `examples/github/paogen.php`
- `tests/`
