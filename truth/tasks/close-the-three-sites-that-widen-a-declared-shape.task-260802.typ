#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Close the three sites where a declared shape is widened to mixed",
  tags: ("generator", "strictness"),
  priority: 7,
  difficulty: 5,
  status: wip(2026, 8, 2),
)

== Summary

An audit of every site in the generator that can emit `mixed` or a bare array
found sixteen, and the good news first: on the two committed example trees not
one of them is a real loss. kilbil emits 511 model properties across 107
classes with zero native `mixed`, and its three `mixed`-bearing phpdocs all
trace to fields the vendor genuinely left unconstrained — an array with no
`items`, an object with no properties. petstore is the same. The generator is
honest on the documents it currently generates.

Three code paths are not honest, and they are latent rather than dead: neither
kilbil nor petstore exercises them, and DigitalOcean and GitHub would, but
neither has a committed generated tree to measure.

- A schema declaring `properties` with no `type: object` keyword resolves to
  `mixed`. The component catalogue already handles this shape by checking for
  properties when the keyword is absent; the type resolver does not, so the
  same schema becomes a class in one position and `mixed` in another.

- A schema declaring both `properties` and a non-trivial `additionalProperties`
  becomes `array<string, mixed>` and the declared properties are discarded.
  At model-property granularity this at least emits a `@todo` naming the
  compromise. At top-level payload granularity — a request body or a response —
  nothing is emitted at all: the properties vanish with no comment anywhere in
  the client, and the function's own docblock claims this case never reaches it.
  It reaches it.

- A response whose `additionalProperties` is a `$ref` or a non-scalar schema
  collapses to `mixed`. The request-side sibling resolves both cases fully.
  Two directions of the same construct, two answers.

The first is the same root cause as the composition family: reading the `type`
keyword and nothing else. The third is an asymmetry with a working
implementation ten lines away.

== Acceptance criteria

- A schema with declared `properties` and no `type` keyword resolves to a class
  wherever it appears, matching what the component catalogue already does.
- A schema declaring both `properties` and a non-trivial `additionalProperties`
  emits a model carrying the declared properties as typed properties, plus the
  additional values as a typed map. Nothing declared is discarded. This holds at
  payload granularity as well as property granularity.
- A response whose `additionalProperties` is a `$ref` or a non-scalar schema
  resolves to the same type the request side already produces for it.
- The docblock claiming an inline object with declared properties never reaches
  the response resolver is corrected or removed, since it is false.
- Where the emitted type is still `mixed`, the document genuinely declared
  nothing, and the run reports it — so an unconstrained field is visible rather
  than merely permitted.
- kilbil and petstore regenerate byte-identically, since neither exercises any
  of the three paths. A behaviour change there means the audit was wrong.
- A fixture exercises each of the three shapes directly, since no vendored
  document reaches them today.

== Non-goals

- The `mixed` on the generated exception's decoded body, which the Result
  envelope work removes for a different reason.
- The scalar value object's `fromScalar(mixed)` hydration boundary, which is a
  contract rather than a schema position.
- Composition schemas, which have their own task. The shared root cause is the
  type keyword being read alone, and both tasks touch the reader — sequence
  them rather than running them in parallel.

== Files

- `src/Generator/Emit/TypeResolver.php`
- `src/Generator/Emit/InlineObjectResolver.php`
- `src/Generator/Emit/ResponseAnalyzer.php`
- `src/Generator/Emit/PropertySynthesiser.php`
- `tests/`
