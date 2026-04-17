#import "@local/speconaut:0.1.0": adr, accepted

#show: adr.with(
  number: 2,
  title: "No inheritance, no protected regions, no attributes-in-generated-files",
  status: accepted,
  date: datetime(year: 2026, month: 4, day: 18),
)

== Context

Once we commit to fully-regenerated output (#link("001-profile-driven-generation.typ")[ADR-001]), the
question becomes: how does a user override behaviour or extend the client?
Three patterns are commonly proposed; we reject all of them.

== Decision

paogen's generated client is `final readonly`. The generator never re-reads
its own output. No mechanism that stores user code *inside* the generated
tree is supported.

Specifically, the following are out of scope:

+ *Subclassing the generated client.* Forces it to be non-`final`,
  pollutes the type hierarchy, and offers only per-method overrides — no
  home for cross-cutting concerns.
+ *Protected regions* (parse-old-emit-new). Doubles the generator's
  complexity, every generator bug now corrupts user code, and the markers
  themselves rot.
+ *Attributes embedded in generated files.* Same problem as protected
  regions — they require the generator to read what it previously wrote.
+ *PSR-15-style middleware* baked into the generator. Cross-cutting
  concerns are real, but decorators handle them with no framework.

== What replaces them

- *Decorators.* Users wrap the `final readonly` client to add per-method
  behaviour: `final class CachingApi { public function __construct(
  private GeneratedApiClient $inner) {} … }`.
- *Strategy injection.* Auth, serializer, error mapper are interfaces the
  generator emits and the user binds in their DI container.
- *Profile re-mapping.* To swap a generated type for a richer
  user-owned one, the user adds a binding to the Profile (or annotates
  their class — see #link("003-profile-and-attribute-dx.typ")[ADR-003]) and regenerates.

== Consequences

- The doc `docs/design/extensibility.md` (which floated subclass +
  strategies) is superseded by ADR-001 + this one.
- Generated client classes are `final readonly`. Their methods do not need
  `protected` or virtual indirection.
- Users with truly exotic per-call requirements *write a decorator*. We
  will document this pattern; we will not reintroduce inheritance to
  avoid it.
