#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "path parameters run through no shape gate at all",
  tags: ("generator", "strictness", "parameters"),
  priority: 6,
  difficulty: 4,
  status: done(
    2026,
    8,
    3,
  )[Landed as 4920476, merged and re-gated on the integrated HEAD. One shared ParameterShape predicate, per-position subsets kept distinct; all three refusals gained the JSON pointer the criterion wrongly assumed query and header already carried. int|string still resolves on both vendor documents.],
)

== Summary

Found while closing \`scalar-union-path-parameter-degrades-to-mixed\`, and
recorded as a Consequence of that task's decision rather than fixed inside it.
\`OperationAnalyzer\` refuses a query or header parameter whose schema falls
outside its supported subset — \`isSupportedQueryParam()\` and
\`isSupportedHeaderParam()\` both gate on \`SchemaType::isScalar()\` and trip the
unsupported-parameter-shapes abort, naming the parameter, the operation and the
shape. \`pathParameters()\` has no equivalent. It accepts any schema in the
\`path\` position unconditionally and hands it straight to \`TypeResolver\`.

The consequence is that the path position, alone among the three, has no
refusal at all — only whatever \`TypeResolver\` happens to be able to read. When
it can read the shape the result is right; when it cannot, the schema falls
through to the \`mixed\` default at the bottom of \`resolve()\` and the failure
surfaces two layers downstream as a PHPStan error against
\`Endpoint::path()\`'s signature, inside generated code a consumer reads as
their own bug.

The scalar-union fix closed the one shape both large vendor documents actually
exercise. It did not close the gap that let it through. An inline object, a
non-scalar union, an array — any of these in a path parameter still reaches
\`TypeResolver\` with no upstream refusal, and the strictness reversal makes
that a default-deny question rather than a matter of taste:
\`fail-loud-never-silent\` says a construct the generator cannot represent stops
the run and names itself.

Whether the gate belongs in \`OperationAnalyzer\` alongside the other two, or
whether all three positions should share one shape predicate, is part of the
task. Three near-identical gates is the shape duplication already bites.

== Acceptance criteria

- A path parameter whose schema is not representable trips the
  unsupported-parameter-shapes abort, naming the parameter, the operation and
  the schema pointer, in the same form the query and header refusals already
  use.
- No path parameter can reach the \`mixed\` default in \`TypeResolver::resolve()\`
  silently. Prove it by driving a fixture with an inline-object path parameter
  and watching the run stop, not by reading the code.
- The shapes that are representable today keep emitting exactly as they do now,
  byte for byte, including the \`int|string\` scalar union
  \`scalar-union-path-parameters-resolve-not-refuse\` just landed. Both large
  examples regenerate with no new refusals.
- If the three positions end up sharing a predicate, the query and header
  refusals still name themselves as specifically as they do today — a shared
  gate that reports a vaguer message is a regression.

== Non-goals

- Re-opening \`scalar-union-path-parameters-resolve-not-refuse\`. That decision
  stands and its shape stays resolved, not refused.
- Widening what the generator can represent. This task is about refusing
  clearly what it cannot, not about supporting more.
- Query and header parameters' own supported subsets, which are correct today.

== Files

- \`src/Generator/Emit/OperationAnalyzer.php\`
- \`src/Generator/Emit/TypeResolver.php\`
- \`tests/fixtures/\`
