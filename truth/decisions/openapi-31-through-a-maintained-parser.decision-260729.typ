#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "OpenAPI 3.1 through a maintained parser fork",
  status: accepted(2026, 7, 29),
  contexts: (schema-context, generation-context),
  goals: (link("../goals/real-world-schemas.goal.typ"),),
  standards: (link("../standards/silence-means-success.standard-260729.typ"),),
  supersedes: (link("openapi-31-strategy.decision-260419.typ"),),
)

== Context

#link("openapi-31-strategy.decision-260419.typ")[Strategy for OpenAPI 3.1 support] deferred 3.1 support and named an external pre-processor as the
interim. That interim is over: #the(Schema) documents poagen wants to
generate against have moved to 3.1.

Two things this decision originally asserted were false, and are corrected
here rather than left to mislead whoever implements it. There is no version
gate — #the(Generator) never inspects #a(Schema) document's declared version
and never validates it, so a 3.1 document is read structurally like any other
and nothing rejects it. And the kilbil loyalty document, the project's
acceptance target, uses no 3.1 construct at all: it is a 3.0-shaped document
carrying a 3.1 version string. Serving kilbil therefore does not depend on this
decision.

That removes the urgency without removing the reason.

Options weighed:

- Swap to the maintained fork `devizzent/cebe-php-openapi`.
- Write an in-tree 3.1-to-3.0 down-convert pre-pass.
- Fork the parser ourselves.
- Keep deferring.

== Choice

Swap to `devizzent/cebe-php-openapi`. It declares `replace:
cebe/php-openapi`, keeps the identical `cebe\openapi\` PSR-4 namespace,
and fixes the PHP 8.4 deprecations upstream, so the swap is a composer
change and `patches/cebe-php-openapi-php84-nullable.patch` disappears
entirely.

The cost, stated honestly: a 3.1-native parser hands #the(Generator)'s
emitters JSON Schema 2020-12 constructs they have never seen, and a
down-convert pre-pass would have concentrated that refusal in one
auditable place. The native parser scatters it instead.

The containment: this decision lands only after unrepresentable
constructs abort the run. With that in place a construct the emitters
cannot handle is a named failure rather than a quietly smaller client,
which is what makes the scattering survivable. Ordering is part of the
decision, not an implementation note. That prerequisite is now satisfied.

The real hazard the swap addresses is not rejection but silent misreading.
A 3.0-shaped parser handed a type declared as a list of a type and `"null"`
does not refuse it, and whatever it does instead is invisible in the emitted
output. Refusing a construct is safe; misinterpreting one is the failure this
project exists to eliminate.

Implementation is deferred until the acceptance target is served, because
nothing about serving it needs the fork. When work resumes this is the first
thing that lands, ahead of anything that reasons about 2020-12 constructs.

== Consequences

- `composer.json` requires `devizzent/cebe-php-openapi` in place of
  `cebe/php-openapi`; the PHP 8.4 deprecation patch and its composer
  patch wiring are deleted.
- Every construct #the(Generator) cannot represent — including
  JSON Schema 2020-12 constructs the 3.0 pipeline never had to reason
  about — must abort the run by name rather than fall through a
  silent-skip path, because that is the only thing that makes accepting
  a wider, less-audited input surface survivable.
- #A(Schema) using a 2020-12 construct is read correctly or refused by
  name. What must not survive is the third outcome: read, misinterpreted,
  and emitted as something else.
- The acceptance target is unaffected either way, so this decision is not
  on the path to it and must not be treated as blocking it.
