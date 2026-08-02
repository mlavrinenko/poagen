#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "a scalar union path parameter degrades to mixed instead of aborting",
  tags: ("generator", "strictness", "parameters"),
  priority: 6,
  difficulty: 4,
  status: done(2026, 8, 2),
)

== Summary

Found while attempting clear-example-expected-failures, in both large documents independently. A path parameter typed anyOf or oneOf over scalars resolves to mixed rather than tripping the unsupported-parameter-shapes abort. DigitalOcean's images\_get declares image\_id as anyOf integer or string; GitHub carries the same shape elsewhere. The emitted method then fails PHPStan against Endpoint::path()'s stricter signature, 3 errors on DigitalOcean and 8 on GitHub. Two standards are violated at once. fail-loud-never-silent says a construct the generator cannot represent stops the run and names itself, and this one does not: it is silently widened to mixed and only surfaces downstream as a type error in the generated tier. generated-types-are-total says the emitted surface carries no mixed, and this puts one on a path parameter, the most caller-facing position there is. The abort for unsupported parameter shapes already exists and already fires for other shapes, so this is a gap in what it recognises rather than a missing mechanism.

== Acceptance criteria

- A path parameter whose schema is a scalar union either resolves to a real PHP union type, or trips the existing unsupported-parameter-shapes abort naming the parameter, the operation and the schema pointer. Deciding which is part of this task; a scalar union over integer and string is expressible as int|string in PHP, so refusing it may be the weaker answer.
- Neither large example produces a mixed-typed path parameter, proven by generating both trees and grepping the emitted signatures rather than by reasoning.
- The generated tier's PHPStan config reports zero errors traceable to Endpoint::path()'s signature on either tree.
- A fixture covers the shape directly, so the guarantee does not depend on either large document staying in the repository.

== Non-goals

- Query and header parameters, unless the same code path serves them and fixing one fixes both. Say which it is.
- Non-scalar unions in a parameter position.
- The undiscriminated-union abort, which is a different mechanism.

== Files

- src/Generator/Emit/TypeResolver.php
- src/Generator/Emit/
- runtime/src/Http/Endpoint.php as the constraint, not necessarily a change
- tests/fixtures/
