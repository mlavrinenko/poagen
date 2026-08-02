#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "a response of scalars has no return shape",
  tags: ("generator", "runtime", "strictness"),
  priority: 5,
  difficulty: 4,
  links: (
    related("typed-error-responses.task-260729.typ"),
    related(
      "synthesise-a-model-for-inline-array-item-responses.task-260802.typ",
    ),
  ),
  status: wip(2026, 8, 3),
)

== Summary

A 2xx response declared as an array of scalars cannot be represented, and refuses. Three GitHub operations sit in the skip list for it: gitignore/get-all-templates and repos/get-all-status-check-contexts declare items of type string, meta/get-all-versions declares items of type string with format date. Read out of the vendored document at lines 4614, 28744 and 57002.

Split out of synthesise-a-model-for-inline-array-item-responses on 2026-08-03. That task was filed believing the three were arrays of inline objects, which is a shape paogen already synthesises a model for. They are not. Measured directly rather than taken from the skip message, which says inline non-ref schema and is true but reads as the object case.

The gap is that a list return shape assumes a hydratable model class throughout: ReturnSpec KIND\_LIST, ResponseType listOf and ResponseDecoder listOf all resolve a class name and hydrate it. There is no way to say list of string. A scalar in a response is not otherwise unrepresentable — a scalar property hydrates fine — so this is a hole in the return contract specifically.

This was first filed as depending on typed-error-responses, on the belief that the envelope replaces the return contract wholesale. Checked against the code, that is wrong and the link is now related rather than depends-on: ResponseType is a body-shape descriptor carrying a kind, and the envelope wraps a status and headers around the body it describes. A new kind is additive to it either way. What is real is contention, not dependency — the two tasks write the same two files, so they must not run at the same time.

== Acceptance criteria

- A 2xx response declared as an array of scalars returns a typed list of that scalar, hydrated without a model class.
- The scalar format bindings a property already honours apply to a list item too, so items of type string with format date arrive as whatever a date-formatted string binds to elsewhere, not as a raw string.
- The three GitHub operations drop out of examples/github/paogen.php's skip list, entries removed, and the run no longer names them.
- An array of a ref'd model still returns a typed list of that model, byte-identical to today.
- An array whose items declare nothing is reported as unconstrained by the existing advisor rather than silently becoming a list of mixed.

== Non-goals

- The array-of-inline-object case, which already works and whose regression test synthesise-a-model-for-inline-array-item-responses added.
- Nested lists of lists, which no vendored document declares.
- Changing how a scalar property hydrates outside a response body.

== Files

- runtime/src/Contract/ResponseType.php
- runtime/src/Http/ResponseDecoder.php
- src/Generator/Emit/ReturnSpec.php
- src/Generator/Emit/ResponseAnalyzer.php
- src/Generator/Emit/ResponseTypeEmitter.php
- examples/github/paogen.php
- tests/
