#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "No inheritance, no protected regions, no attributes-in-generated-files",
  status: accepted(2026, 4, 18),
  contexts: (generation-context,),
  goals: (link("../goals/never-edit-generated.goal.typ"),),
  standards: (link("../standards/generated-types-are-total.standard-260729.typ"),),
)

== Context

Once we commit to fully-regenerated output
(#link("profile-driven-generation.decision-260418.typ")[Profile-driven generation]), the question becomes: how does a
user override behaviour or extend #the(Client)? Three patterns are
commonly proposed; we reject all of them.

== Choice

poagen's #a(Client) is `final readonly`. #The(Generator) never re-reads
its own output. No mechanism that stores user code inside #a(GeneratedFile)
is supported.

Specifically, the following are out of scope:

+ *Subclassing #the(Client).* Forces it to be non-`final`, pollutes the
  type hierarchy, and offers only per-method overrides — no home for
  cross-cutting concerns.
+ *Protected regions* (parse-old-emit-new). Doubles #the(Generator)'s
  complexity, every generator bug now corrupts user code, and the markers
  themselves rot.
+ *Attributes embedded in #a(GeneratedFile).* Same problem as protected
  regions — they require #the(Generator) to read what it previously wrote.
+ *PSR-15-style middleware* baked into #the(Generator). Cross-cutting
  concerns are real, but decorators handle them with no framework.

=== What replaces them

- *Decorators.* Users wrap the `final readonly` client to add per-method
  behaviour: `final class CachingApi { public function __construct(
  private GeneratedApiClient $inner) {} … }`.
- *Strategy injection.* Auth, serializer, error mapper are interfaces
  #the(Generator) emits and the user binds in their DI container.
- *Profile re-mapping.* To swap a generated type for a richer
  user-owned one, the user adds a binding to the profile (or annotates
  their class — see
  #link("typed-profile-and-colocated-attributes.decision-260418.typ")[Profile DX: typed Profile object + attributes co-located on user value objects]) and regenerates.

== Consequences

- The doc `docs/design/extensibility.md` (which floated subclass plus
  strategies) is superseded by
  #link("profile-driven-generation.decision-260418.typ")[Profile-driven generation] and this one.
- Generated client classes are `final readonly`. Their methods do not need
  `protected` or virtual indirection.
- Users with truly exotic per-call requirements write a decorator. We
  will document this pattern; we will not reintroduce inheritance to
  avoid it.
