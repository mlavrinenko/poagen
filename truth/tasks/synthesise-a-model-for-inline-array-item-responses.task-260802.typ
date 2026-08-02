#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Synthesise a model for an inline array-item response",
  tags: ("generator", "strictness"),
  priority: 6,
  difficulty: 3,
  status: accepted(2026, 8, 2),
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

== Acceptance criteria

- A 2xx response declared as an array of inline objects returns a typed list of
  a synthesised model.
- The synthesised name derives from the operation the same way every other
  synthesised name does, and is pinnable from the profile through the same key.
- The three GitHub operations drop out of the skip list, entries removed.
- An inline array whose items are scalars still returns a typed list of that
  scalar, unchanged.

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
