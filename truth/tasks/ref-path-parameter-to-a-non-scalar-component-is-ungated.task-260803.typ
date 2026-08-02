#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "ref path parameter to a non scalar component is ungated",
  tags: ("generator", "strictness", "parameters"),
  priority: 4,
  difficulty: 4,
  status: proposed(2026, 8, 3),
)

== Summary

ParameterShape supportsPath accepts any Reference without resolving it, documented in place at ParameterShape.php lines 110 to 119. A ref pointing at an object component therefore passes the gate and emits a Model class on Endpoint path — a PHPStan error inside generated code, which a consumer reads as their own bug.

Found while closing path-parameters-run-through-no-shape-gate-at-all, and left open there on purpose: that task's criterion is that no path parameter reaches the mixed default in TypeResolver, and this route never does. It is the same user-visible failure by a different path.

Closing it needs reference resolution the analyser deliberately does not do today, which is why it is a separate task rather than a line in that one. Nothing in the corpus hits it — GitHub's alert-number and the fixture's SshKeyId are both type integer — so this is a hole, not a break.

== Acceptance criteria

- A path parameter whose schema is a ref to a non-scalar component trips the unsupported-parameter-shapes abort, naming the parameter, the operation and the schema pointer, in the same sentence shape the three positions already share.
- A ref to a scalar component still resolves and emits its value object, unchanged. DigitalOcean's ssh\_key\_identifier, an anyOf of two scalar refs across three operations, still generates.
- Whatever resolves the reference does so in one place. A second resolver beside the analyser's existing reading is a failure of this task.
- Both large examples regenerate with no new refusals.

== Non-goals

- Widening what a path parameter may be. This refuses more clearly, it does not support more.
- Resolving references anywhere else in the analyser, which is a larger change than this needs.
- Query and header positions, whose subsets are correct.

== Files

- src/Generator/Emit/ParameterShape.php
- tests/fixtures/
