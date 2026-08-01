#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Read a JSON Schema type array as a nullable type instead of degrading to mixed",
  tags: ("generator", "strictness", "schema"),
  priority: 8,
  difficulty: 3,
  status: done(2026, 8, 1),
)

== Summary

`TypeResolver::resolve()` narrows on `$node->type` with `is_string()`. When a
schema writes its type as a list — `type: [integer, "null"]`, the JSON Schema
and OpenAPI 3.1 way of saying "nullable integer" — the value is an array, every
`is_string()` guard fails, and the `match` falls through to
`new self(null, 'mixed', null, ...)`. The property lands in the emitted model
with no PHP type at all and a `@param ?mixed` docblock. Nothing is reported.

The kilbil loyalty document is where this was found, and it refutes a premise
the backlog was built on. `examples/kilbil/README.md` and the example's
`.expected-failure` marker both assert that the document declares `3.1.0` and
uses no 3.1 construct — "no `type: [T, "null"]`" in as many words. It uses 87
of them:

```
type shapes across every operation payload in examples/kilbil/schemas/loyalty_v1.yaml
  array:["string","null"]  => 48
  array:["integer","null"] => 26
  array:["array","null"]   => 12
  array:["number","null"]  => 1
  string:string  => 248   string:object  => 146   string:integer => 140
  string:number  =>  77   string:array   =>  43   string:boolean =>   9
```

Reproduce with `cebe\openapi\Reader::readFromYamlFile` and a walk over every
`requestBody`/`responses` schema, reading `$schema->type`; or read the document
directly, e.g. `~/projects/home/paogen/examples/kilbil/schemas/loyalty_v1.yaml`
lines 657–665, where `progressive_scale_type` declares
`type: [integer, "null"]` with `format: int`.

So 87 properties that the vendor typed would reach a consumer as untyped, and
11 inline enums are lost on top of that, because `EnumCatalog::specFromSchema()`
matches on the same `$schema->type` and returns null for an array. That is the
escape-hatch type `strict-clean-output` forbids, arrived at silently, which
`silence-means-success` forbids as well.

This is not the parser swap. `cebe/php-openapi` already hands the list over
verbatim as a PHP array; only paogen's own reading of it is wrong. Nothing in
`composer.json` needs to move, and `swap-openapi-parser-for-31-support` stays
blocked and postponed.

== Acceptance criteria

- A schema whose `type` is a list of exactly one non-`"null"` name plus
  `"null"` resolves to that type, nullable — `type: [integer, "null"]`
  produces `?int`, `type: [array, "null"]` produces a nullable array with the
  same `list<...>` phpdoc a plain `type: array` would get.
- A single-element list — `type: [string]` — resolves exactly as `type: string`
  does.
- An inline enum whose type is written as a list is recognised as a backed enum
  on the non-`"null"` member, rather than being dropped.
- A list naming two or more non-`"null"` types, all of them scalar, becomes a
  PHP union — `type: [string, integer]` produces `string|int`. This criterion
  first read that any such list stops the run; that was too blunt. PHP can say
  `string|int`, and refusing a construct the language expresses would shrink the
  client over something representable, which `silence-means-success` frames as
  the generator's job to avoid. Where the union is also optional the `|null`
  joins the union rather than becoming `?string|int`, which is not a type.
- A list naming two or more non-`"null"` types where at least one is `object` or
  `array` is a construct the generator cannot represent: it stops the run and
  names the schema location, per `abort-on-unrepresentable-constructs`. It does
  not become `mixed`. There is no single class for an inline object member and no
  single item type for an array member, so any type emitted would be a guess.
- A required property whose type list carries `"null"` is nullable but takes no
  default, so it still sorts before every optional parameter. Conflating the two
  facts pushed a required parameter after an optional one, which is deprecated
  since PHP 8.0 and a finding at max level — found on the kilbil tree while
  landing this.
- A schema with no `type` at all still resolves to `mixed`, and emits `mixed`
  as the declared PHP type rather than an absent one — an untyped promoted
  property fails PHPStan at max level.
- `examples/kilbil/README.md` and `examples/kilbil/.expected-failure` no longer
  claim the document uses no 3.1 construct, and state which one it uses and how
  many times.
- The petstore, parameters, composition and contact golden trees are unchanged,
  or regenerated deliberately with the diff explained.

== Non-goals

- Swapping the OpenAPI parser. That stays with
  `swap-openapi-parser-for-31-support`, which stays blocked.
- Any other 3.1 construct — `const`, `prefixItems`, `unevaluatedProperties`,
  `$defs`, plural `examples`. The kilbil document uses none of them and this
  task covers only what it uses.
- Inferring a type from `format` when `type` is absent entirely. An untyped
  schema is genuinely untyped; that is what `report-unrecognised-formats` and
  `#[BindsFormat]` are for.

== Files

- `src/Generator/Emit/SchemaType.php` (new — one reading of `type`, for every site that used to read it inline)
- `src/Generator/Emit/TypeListScanner.php` (new — the document-wide pass that attributes a refusal to an operation or component)
- `src/Generator/Emit/TypeResolver.php`
- `src/Generator/Emit/ComponentCatalog.php`, `OperationAnalyzer.php`, `RequestBodyAnalyzer.php`, `InlinePayloadPlanner.php`, `PropertySynthesiser.php`, `ParameterStringExpr.php`
- `src/Generator/Enum/EnumCatalog.php`
- `src/Generator/Emit/ModelEmitter.php`
- `src/Runtime/Marshal/DescriptorParser.php` (an all-builtin union has no branch to resolve, so it passes through)
- `examples/kilbil/README.md`
- `examples/kilbil/.expected-failure`
- `tests/`
