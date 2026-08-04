#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "path parameter skip leaks its payload model the same way",
  tags: ("generator", "strictness"),
  priority: 3,
  difficulty: 3,
  status: done(2026, 8, 4),
)

== Summary

The sibling of skipped-operation-still-emits-its-payload-model, found while closing it and deliberately left open there.

That task filtered the inline payload planner on the document-wide schema-scan refusals, which Generator plan computes before payload naming runs. So an operation refused for its schema shape no longer claims a payload model. But OperationEmitter emit can also drop an operation for an unresolvable path parameter, at OperationEmitter.php line 119, and that decision happens at emission time — after model planning has already run.

An operation refused that way, whose body or response is otherwise synthesisable, still leaks its payload model into the tree. Same bug class, same user-visible consequence: a model nothing references, in a tree the consumer never edits.

It was left open because closing it honestly needs either OperationEmitter, which another agent held at the time, or a reordering of Generator plan's model and client emission phases — and that reordering changes registry-claim order across every committed golden fixture, which is a large blast radius for a leak nothing currently triggers.

== Acceptance criteria

- An operation dropped for an unresolvable path parameter emits no payload model of its own, exactly as a schema-refused operation now does.
- A model that operation shares with a surviving operation still emits. Reachability decides, as it does in the sibling task.
- Whatever makes the refusal visible earlier does so in one place. Two lists of refused operation ids, computed at two different phases, is the defect this task should not leave behind.
- Every committed golden and example tree regenerates byte-identically, or each changed file is reviewed and the reason recorded. Registry-claim order is the risk; prove it did not move.

== Non-goals

- Widening or narrowing which path parameters are representable. ParameterShape decides that and it is correct.
- Re-opening the sibling task's filter, which is right for the refusals it can see.

== Files

- src/Generator/Emit/InlinePayloadPlanner.php
- src/Generator/Emit/OperationEmitter.php
- src/Generator/Generator.php
- tests/
