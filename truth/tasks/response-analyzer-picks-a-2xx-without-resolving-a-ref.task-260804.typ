#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "response analyzer picks a 2xx without resolving a ref",
  tags: ("generator",),
  priority: 5,
  difficulty: 3,
  status: proposed(2026, 8, 4),
)

== Summary

SchemaWalk now resolves a response that is a ref to components.responses, so the pre-scan and the advisors see its content. ResponseAnalyzer::pick2xx has the same blindness independently: it does not go through SchemaWalk, it tests instanceof Response directly, and a ref response falls through as if the operation declared no 2xx body. DigitalOcean's invoice\_pdf is the live case. Its schema is now visible to everything the walk feeds, and the method paogen emits for it still returns void, because the emitter that decides the return type never resolved the reference.

== Acceptance criteria

- An operation whose 2xx response is a ref to components.responses gets the same return type as the identical response written inline. A fixture pair proves it, one operation each way, same content.
- DigitalOcean's invoice\_pdf no longer returns void. Whatever return the resolved schema earns, it is the one an inline copy would have earned.
- The regeneration diff across the four examples is stated: which operations change return type, and that nothing else moved.
- Reverting the fix fails the new test.

== Non-goals

- Widening what response shapes the generator accepts. A resolved ref that lands on a refused shape is refused exactly as an inline copy of it would be.
- Routing ResponseAnalyzer through SchemaWalk, unless that turns out to be the smaller change.

== Files

- src/Generator/Emit/ResponseAnalyzer.php
- tests/
- examples/
