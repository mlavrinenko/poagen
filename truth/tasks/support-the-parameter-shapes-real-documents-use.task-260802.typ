#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Support the parameter shapes real documents use",
  tags: ("generator", "strictness"),
  priority: 7,
  difficulty: 5,
  status: done(
    2026,
    8,
    4,
  )[Landed as 6e6dc6e, merged and re-gated on the integrated HEAD. Skip list 43 to 20, the full 23 entries, 7 DigitalOcean and 16 GitHub, counted by removed key. One resolver serves path, query and header. The scalar-or-list ruling is honoured natively, with the PHPStan annotation carrying what native PHP loses. Two criteria were unimplemented when the interrupted work was audited: nothing read style or explode at all, so a serialisation refusal plus a generation-time notice naming every list-valued query parameter that relies on the OpenAPI default were built to make the claim literally true rather than incidentally true.],
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

=== Ruling: a scalar-or-list query parameter keeps both, native union plus a
PHPStan annotation

Owner ruling, 2026-08-03, reversing what this task said when it was filed. An
earlier draft normalised the union away to a plain list, on the argument that a
one-element list serialises to the same bytes as the scalar. The owner rejected
that: paogen supports what PHPStan supports, and the annotation carries the
detail the native type cannot.

So both branches survive. The native type is the union the engine can express;
the docblock says what it actually is:

```php
/**
 * @param string|list<string>|null $fields
 */
public function projectsListItemsForOrg(
    string $org,
    string|array|null $fields = null,
): ProjectsListItemsForOrgResponse
```

`string|array` is as far as native PHP goes — `array` cannot be parameterised —
and `string|list<string>` is what the document declared. Both are emitted. This
is the same division of labour the generator already uses for a list body,
where the parameter is `array` and the `@param list<User>` carries the element
type; the difference is only that the native side is a union here.

The rule generalises past these nine: emit the widest native type the branches
share, and let the annotation carry every detail native PHP loses. A branch set
whose native union cannot be spelled at all still refuses.

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
- A `oneOf`/`anyOf` of a scalar and a list emits the native union plus the
  precise PHPStan annotation, per the ruling above. Serialisation handles both
  arms: a scalar sends one key, a list sends the repeated key its `style` and
  `explode` call for. A fixture asserts the wire form of each arm, since they
  differ for every value except a one-element list.
- The generated tier's PHPStan config accepts the annotation without
  suppression, and a call site passing either arm narrows cleanly.
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
