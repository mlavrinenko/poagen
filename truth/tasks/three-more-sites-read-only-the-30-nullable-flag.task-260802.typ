#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "three more sites read only the 3.0 nullable flag",
  tags: ("generator", "openapi-31", "strictness"),
  priority: 7,
  difficulty: 3,
  status: proposed(2026, 8, 2),
)

== Summary

The same defect \`nullable-type-array-lost-in-property-synthesis\` just closed
survives at three more sites. That task shared the derivation between
\`TypeResolver\` and \`PropertySynthesiser\` as \`SchemaType::nullableOf()\`, which
reads both spellings — the 3.0 \`nullable: true\` flag and the 3.1
\`type: \[T, "null"\]\` array. Three callers still read only the flag, verified
directly against the merged tree rather than taken from a report:

- \`InlineObjectResolver::resolve()\` line 47, the bare flag cast. This one
  matters most, because \`TypeResolver\`'s own \`object\` branch delegates to it for
  typed-map and map-todo inline objects — so \`TypeResolver\` is still not
  correct for that one shape, despite reading both spellings everywhere else.
- \`CompositionResolver::resolveUnion()\` line 58, for a ref-only union.
- \`CompositionResolver::resolveScalarUnion()\` line 102, for a scalar union.

The third is worth naming plainly: it was written this session, by
\`scalar-union-path-parameter-degrades-to-mixed\`, and it copied the narrow
reading from the code beside it. That is the exact failure mode
\`nullable-type-array-lost-in-property-synthesis\` asked to prevent when it said
the duplication should be removed rather than repaired twice — and the sharing
landed one merge too late to stop it. A shared helper only helps the callers
that call it.

The user-visible consequence is unchanged from the original defect: a
spec-compliant server sending JSON \`null\` for a property of one of these shapes
throws \`TypeError\` out of the constructor. No confirmed vendor property
exercises these three today, which is why this is filed rather than hotfixed —
but neither did the two kilbil properties, until someone hydrated a real
payload.

== Acceptance criteria

- All three sites derive nullability through \`SchemaType::nullableOf()\`, and a
  grep for the bare \`(bool)\` cast of a schema's \`nullable\` property across
  \`src/Generator/Emit/\` returns only \`nullableOf()\`'s own body.
- A fixture covers each of the three shapes declared \`type: \[T, "null"\]\` — an
  inline typed map, a ref-only union, and a scalar union — and each hydrates a
  wire \`null\` to null instead of throwing. Required properties, not optional
  ones: \`ModelEmitter\` gives an optional property a blanket \`?\` regardless of
  the bug, so only a required nullable property exercises it.
- Reverting the source fix makes exactly those new assertions fail and nothing
  else, proven the way the closing task proved its own.
- Regenerating every committed example tree changes only properties whose
  schema declares the 3.1 form, and that diff is reviewed before it is
  committed.

== Non-goals

- The 3.1 parser swap, which \`swap-openapi-parser-for-31-support\` owns and
  which is postponed.
- Re-opening \`scalar-union-path-parameters-resolve-not-refuse\`. The union
  resolution is right; only its nullability reading is narrow.
- Any other difference between these resolvers beyond nullability.

== Files

- \`src/Generator/Emit/InlineObjectResolver.php\`
- \`src/Generator/Emit/CompositionResolver.php\`
- \`tests/fixtures/\`
