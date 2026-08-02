#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "A scalar-union path parameter resolves to a PHP union, rather than tripping the unsupported-shapes abort",
  status: accepted(2026, 8, 2),
  contexts: (generation-context, schema-context),
  goals: (
    link("../goals/fail-loud-never-silent.goal.typ"),
  ),
  standards: (
    link("../standards/generated-types-are-total.standard-260729.typ"),
  ),
)

== Context

DigitalOcean's `images_get` names its `image_id` path parameter as
`anyOf: [{type: integer}, {type: string}]` — an id-or-slug, spelled as
composition rather than as `type: [integer, string]`. GitHub's schema
carries the identical shape on several path parameters (`workflow_id`,
`pages_deployment_id`, among others).

`TypeResolver::resolve()` already turned the list spelling of a scalar
union into a native PHP union — `SchemaType::isScalarUnion()` reads
`type: [integer, string]` and returns `int|string`. It had no equivalent
reading for the composition spelling: `CompositionResolver::resolveUnion()`
only resolved `oneOf`/`anyOf` when every branch was a `$ref` to a named
component, so an `anyOf` of two bare inline scalar schemas matched neither
that path nor the list-spelling path and fell through to the `mixed`
default at the bottom of `TypeResolver::resolve()`. The emitted parameter
was typed `mixed`, and PHPStan then rejected the call site —
`Endpoint::path()` declares `string|int|float|bool|BackedEnum|Stringable`,
and `mixed` is not a subtype of that — 3 errors on DigitalOcean, 8 on
GitHub.

Two standards were violated by the same gap. `fail-loud-never-silent` says
a construct #the(Generator) cannot represent stops the run and names
itself; this one did not — it degraded silently and only surfaced as a
type error two layers downstream, in generated code a consumer would read
as their own bug. `generated-types-are-total` says the emitted surface
carries no `mixed`; this put one on a path parameter, the position with
the least room for imprecision, since every call site must supply it.

The unsupported-parameter-shapes abort already exists — `OperationAnalyzer`
already refuses a query or header parameter whose schema does not fit its
supported subset, naming the parameter, the operation and the schema
shape. Path parameters run through no equivalent shape gate at all before
reaching `TypeResolver`, which is a second, wider gap this decision does
not close — see Consequences.

== Choice

A path parameter (or any other position `TypeResolver::resolve()`
handles) whose schema is `oneOf`/`anyOf` of two or more distinct bare
scalar schemas resolves to the PHP union of those scalars — `int|string`,
in DigitalOcean's and GitHub's case — rather than tripping the abort.
`CompositionResolver::resolveScalarUnion()` implements the composition
reading, `SchemaType::ofMembers()` shares the list-spelling reading's
member-to-PHP-type table so the two spellings produce identical output,
and `TypeResolver::resolve()` tries it right after the `$ref`-union
reading and before falling through to `mixed`.

=== Why resolve rather than refuse

The task behind this decision put the choice in the open on the strength
of one observation: `int|string` is expressible in PHP, so refusing
something the generator can actually represent is the weaker answer. Two
facts confirmed it rather than merely permitting it.

First, `Endpoint::path()`'s declared type,
`string|int|float|bool|BackedEnum|Stringable`, is a strict supertype of
every combination the four JSON scalars can produce. Any scalar union
this decision resolves — two scalars or all four — already satisfies the
call site PHPStan checks it against, so there is no case where accepting
the construct trades a `mixed` error for a different one.

Second, refusing would have been the shape `fail-loud-never-silent` warns
against from the other direction: the goal's acid test asks that refusal
name what would make the construct acceptable, and the honest answer
here — "resolve to `int|string`" — is also the fix. An abort whose own
remedy is "the generator should just do this" is not really informing a
consumer's choice; it is a missing feature wearing a diagnostic's
clothes.

=== Query and header parameters

Query and header parameters do *not* share this fix, and share only part
of the code path that motivated it.

`ParameterAdder::resolveParamType()` calls the same
`TypeResolver::resolve()` for every parameter position, so the
composition-reading half of this change — the part inside `TypeResolver`
and `CompositionResolver` — is genuinely shared: a query or header
parameter whose schema is an `anyOf` of bare scalars would resolve to the
same PHP union if it ever reached that call.

It does not reach it today. `OperationAnalyzer::isSupportedQueryParam()`
and `isSupportedHeaderParam()` gate on
`SchemaType::of($param->schema)->isScalar()`, which reads the `type`
keyword alone and returns false for a schema that carries only `anyOf` —
so a query or header parameter shaped this way already tripped the
unsupported-parameter-shapes abort before this change, and still does
after it. The two positions were never silently mistyped the way path
parameters were, because their shape gate runs before `TypeResolver` is
ever consulted; path parameters had no such gate at all — see
Consequences.

== Consequences

- `TypeResolver::resolve()` treats a bare-scalar `oneOf`/`anyOf` as a
  scalar union for *every* caller, not only path parameters — a model
  property or a request-body field with the same shape now resolves to a
  PHP union instead of `mixed` too. This is the same construct in a
  different position, and `generated-types-are-total` gives no reason to
  answer it differently there.
- Query and header parameters keep refusing this shape today, not because
  it is unrepresentable for them — `Endpoint::query()` and
  `Endpoint::header()` accept the identical scalar union
  `Endpoint::path()` does — but because
  `isSupportedQueryParam()`/`isSupportedHeaderParam()` never learned to
  recognise it. Teaching them is a small, well-scoped follow-up, not a
  side effect of this decision.
- Path parameters still have no shape gate of their own —
  `OperationAnalyzer::pathParameters()` accepts any schema in the `path`
  position unconditionally and lets `TypeResolver` decide. This decision
  closes the one shape that gate's absence let through silently as
  `mixed`; a path parameter shaped some other unrepresentable way (an
  inline object, a non-scalar union) still reaches `TypeResolver` with no
  upstream refusal, and whatever it resolves to — `mixed` or otherwise —
  is untested here. Non-scalar unions in a parameter position are
  explicitly out of scope for the task this decision closes; the absence
  of a general path-parameter shape gate is a separate, wider finding
  worth its own task.
