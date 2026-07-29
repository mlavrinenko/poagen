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
interim. That interim is over: every #a(Schema) paogen actually wants to
generate against is 3.1, including the kilbil loyalty document that is
the project's acceptance target, and it is rejected at the version gate
today.

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
decision, not an implementation note.

== Consequences

- `composer.json` requires `devizzent/cebe-php-openapi` in place of
  `cebe/php-openapi`; the PHP 8.4 deprecation patch and its composer
  patch wiring are deleted.
- #a(Schema) declaring `openapi: 3.1.0` passes the version gate instead
  of being rejected outright.
- Every construct #the(Generator) cannot represent — including
  JSON Schema 2020-12 constructs the 3.0 pipeline never had to reason
  about — must abort the run by name rather than fall through a
  silent-skip path, because that is the only thing that makes accepting
  a wider, less-audited input surface survivable.
- The kilbil loyalty document, the project's acceptance target, becomes
  generatable for the first time.
