#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Synthesise a model for an inline array-item response",
  tags: ("generator", "strictness"),
  priority: 6,
  difficulty: 3,
  status: done(
    2026,
    8,
    3,
  )[Landed as b7435ff, merged 92b6b5b. Re-scoped 2026-08-03: the object-item case already worked, so what this delivers is the missing regression test for a profile pin against a list-typed response. The three GitHub operations turned out to declare scalar items and moved to a-response-of-scalars-has-no-return-shape, which waits on the envelope.],
  links: (
    related("a-response-of-scalars-has-no-return-shape.task-260803.typ"),
  ),
)

== Summary

Three GitHub operations are refused because their 2xx response is a JSON array
whose `items` is an inline schema rather than a `$ref`.

The machinery to answer this already exists and is already used twice: the
inline-payload planner synthesises a model for an inline object request body,
and for an inline object response. The array-of-inline-object case is the same
synthesis one level down, and it is wired on the request side but not on this
response path.

So this is a gap in coverage of an existing capability, not a new capability.
It is filed separately from the composition work because it needs none of it.

=== Correction, 2026-08-03: the three operations are not this shape

The paragraph above is right about the capability and wrong about what the
three GitHub operations need, and the error is the same kind this backlog has
now made three times: a claim about a large input file, believed because it was
written down rather than measured.

Read directly out of `examples/github/schemas/api.github.com.yaml`, all three
declare an array of #emph[scalars], not of inline objects:

- `gitignore/get-all-templates` at line 4614 — `items: {type: string}`
- `repos/get-all-status-check-contexts` at line 28744 — `items: {type: string}`
- `meta/get-all-versions` at line 57002 — `items: {type: string, format: date}`

The array-of-inline-object case this task describes already works, with no code
change at all: `InlinePayloadPlanner::planResponse()` already calls
`inlineObjectItemsOf()` and synthesises `{Base}ResponseItem`, and
`OperationEmitter` already prefers the catalogue's answer over
`ResponseAnalyzer`'s fallback. Verified live against a fixture, including that
a profile pin renames the synthesised model.

What the three operations actually need is a list-of-scalar return shape, and
that does not exist anywhere in the pipeline: `ReturnSpec::KIND_LIST`,
`ResponseType::listOf()` and `ResponseDecoder::listOf()` all assume a
hydratable model class. Adding one means changing
`runtime/src/Contract/ResponseType.php`, which the envelope task
`typed-error-responses` is about to replace wholesale. Building it against the
contract being retired is throwaway work, so it moves to its own task —
`a-response-of-scalars-has-no-return-shape` — sequenced after the envelope.

What this task delivers, therefore, is the regression test the object-item path
never had: a profile pin against a list-typed response.

== Acceptance criteria

- A 2xx response declared as an array of inline objects returns a typed list of
  a synthesised model.
- The synthesised name derives from the operation the same way every other
  synthesised name does, and is pinnable from the profile through the same key,
  proven by a committed regression test rather than by inspection.
- An inline array whose items are scalars is unchanged by this task. It refuses,
  as it does today, until `a-response-of-scalars-has-no-return-shape` lands.

== Non-goals

- Composition schemas in responses, which is the larger family and has its own
  task.
- Changing the naming derivation for any existing synthesised model, which
  would move byte-stable output for reasons unrelated to this task.

== Files

- `src/Generator/Emit/InlinePayloadPlanner.php`
- `src/Generator/Emit/ResponseAnalyzer.php`
- `examples/github/paogen.php`
- `tests/`
