#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "skipped operation still emits its payload model",
  tags: ("generator", "strictness"),
  priority: 6,
  difficulty: 3,
  status: wip(2026, 8, 3),
)

== Summary

A skip entry naming an operation removes the method but not the model synthesised from that operation's inline request payload. Found while landing swap-openapi-parser-for-31-support, on a pre-existing fixture the parser swap did not touch: generating tests/fixtures/schemas/type-lists-3.0.yaml with skip: \['refusedShapes' => ...\] still writes RefusedShapesRequest.php into the emitted tree.

The decision skip-is-the-only-opt-out says a skip entry means the method or model does not exist on the emitted client. Component skips honour that — a skipped component emits no model. Operation skips do not: the operation's synthesised payload models survive it. So the same opt-out means two different things depending on what it names, and a consumer who skips an operation still gets its request model in their tree, referencing types they may also have skipped.

== Acceptance criteria

- An operation named in Profile skip emits neither the method nor any model synthesised solely for that operation's request or response payload.
- A model synthesised for a skipped operation that is ALSO reachable from a surviving operation or component still emits. Reachability decides, not the skip entry alone.
- A fixture proves both directions: one payload model that disappears with its only operation, one that survives because a second operation shares it.
- The emitted tree carries no dangling reference after an operation skip, proven by the generated-tier PHPStan config, which has no baseline and no ignoreErrors.

== Non-goals

- Component skips, which already behave correctly.
- The cascade problem for skipped components, which skipped-component-leaves-dangling-references owns.
- Widening what skip can name.

== Files

- src/Generator/Emit/InlinePayloadPlanner.php
- src/Generator/Emit/InlinePayloadCatalog.php
- src/Generator/Generator.php
- tests/
