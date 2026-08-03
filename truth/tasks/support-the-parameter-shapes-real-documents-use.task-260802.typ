#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Support the parameter shapes real documents use",
  tags: ("generator", "strictness"),
  priority: 7,
  difficulty: 5,
  status: accepted(2026, 8, 2),
)

== Summary

Twenty-three operations across the two large examples are refused because of a
parameter shape, and every one of them is ordinary. Counted from the skip
lists on 2026-08-03: 7 on DigitalOcean, 16 on GitHub. That total still holds
after the union and non-JSON-body work; the four causes below were re-measured
against both documents on the same day and two of them did not survive the
re-reading this task originally gave them.

Three mechanisms cover all twenty-three:

- *The parameter's schema is a `$ref`* — twelve operations. The reader looks
  at the reference node's own `type` keyword, finds none, and calls the shape
  unspecified. Every one of the twelve dereferences to something already
  supported. Eleven point at a scalar component (DigitalOcean's `region`,
  `resource_id`; GitHub's `ecosystem`, `state`, `tool_name`, `ref` — all
  `type: string`). The twelfth is DigitalOcean's `job_names`, whose schema is
  `{type: array, items: {$ref: '#/components/schemas/schema'}}` and whose
  target is `{type: string}` — so it is an array of strings, which
  `ParameterShape::supportsQuery()` already accepts, hidden behind one
  unresolved reference. This task originally described that case as "items are
  not a plain scalar Schema" and attributed `job_names` to GitHub. Both are
  wrong: it is DigitalOcean's, and its items are a plain scalar behind a
  `$ref`. There is no separate array-items cause.
- *The parameter's schema is `string` or a list of strings* — nine operations,
  all GitHub, all spelled `oneOf: [{type: string}, {type: array, items:
  {type: string}}]`. GitHub's `fields` (six operations) and `has` (three, two
  of which enum their items). This task originally said "the scalar-union work
  already resolves this shape elsewhere". It does not:
  `CompositionResolver::resolveScalarUnion()` requires every branch to be a
  bare scalar and returns `null` the moment one is an array. This is a
  scalar-or-list, which is a different shape and needs a ruling — below.
- *A required header parameter* — two operations, both DigitalOcean's
  `X-Dangerous` (`type: boolean`, `required: true`, `in: header`). Refused
  outright by `ParameterShape::supportsHeader()`, whose comment states the
  reason: the emitted signature gives every header a nullable default.

`real-world-schemas` says every operation a published document declares appears
on the client, and these twenty-three do not. None of them is an edge case: a
`$ref`-ed parameter schema is how a document avoids repeating itself, and a
scalar-or-list query parameter is how a vendor lets you filter by one thing or
several.

=== Ruling: a scalar-or-list query parameter is emitted as a list

Written here rather than left open, because it decides nine operations and a
consumer-visible signature.

`string | list<string>` under `style: form, explode: true` — which is what all
nine declare, and the OpenAPI default anyway — serialises a one-element list to
exactly the bytes the scalar branch produces: `?fields=x`. The union therefore
buys the consumer a second spelling of one wire form, and costs them a
`is_string($fields) ? [$fields] : $fields` at every call site.

So the emitted parameter is the list: `?array $fields = null` with
`@param list<string>|null`. Nothing is lost on the wire and the surface has one
type instead of two.

This applies only where the non-array branch's type matches the array's item
type. A `oneOf` of `string` and `list<int>` is not a widening of one shape and
still refuses.

== Acceptance criteria

- A parameter whose schema is a `$ref` resolves through the reference and is
  typed as whatever it points at, in all three positions. Whatever resolves the
  reference does so in one place — a second resolver beside the analyser's
  existing reading is a failure of this task, and of
  `ref-path-parameter-to-a-non-scalar-component-is-ungated`, which wants the
  same resolution for the opposite purpose and should land with or just after
  this.
- DigitalOcean's `job_names` emits as a typed list of strings, serialised per
  its declared `style: form` / `explode: true`. Where a document declares
  neither, the OpenAPI defaults apply and the run says which it used.
- A `oneOf`/`anyOf` of a scalar and a list of that same scalar emits as the
  list, per the ruling above. A `oneOf` mixing item types still refuses by
  name.
- A required header parameter is emitted as a required method argument, ahead
  of the optional ones, in the order the emitter already uses for required
  query parameters.
- All twenty-three entries are removed from both examples' skip lists rather
  than left stale, and `just check-examples` is green.
- A parameter shape still outside the supported set refuses by name, as today.
  Nothing here weakens the gate; it moves shapes across it.
- A fixture covers each of the three mechanisms, so none of them depends on a
  vendor document to stay proven.

== Non-goals

- Cookie parameters, which no vendored document declares.
- `content`-typed parameters (a parameter whose value is a serialised media
  type rather than a primitive), which no vendored document declares either.

== Files

- `src/Generator/Emit/ParameterShape.php`
- `src/Generator/Emit/OperationAnalyzer.php`
- `src/Generator/Emit/ParameterCollector.php`
- `src/Generator/Emit/ParameterAdder.php`
- `src/Generator/Emit/TypeResolver.php`
- `runtime/src/Contract/Endpoint.php`
- `examples/digitalocean/paogen.php`, `examples/github/paogen.php`
- `examples/*/generated/` (regenerated)
- `tests/`
