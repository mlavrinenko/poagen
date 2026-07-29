#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Give the domain entities typed properties instead of empty prop lists",
  tags: ("speconaut", "domain", "debt"),
  priority: 3,
  difficulty: 4,
  status: proposed(2026, 7, 29),
)

== Summary

The speconaut migration declared every paogen domain entity with \`props: ()\` — the DSL's explicit "this entity models no properties yet" form. That was the right move to get the truth tree green in one pass without inventing a data model under time pressure, but it leaves the domain as a list of thirteen bare nouns.

An entity with no properties cannot be referenced at property granularity in a scenario step, so a spec can say a \`Schema\` was loaded but not that its \`openapi\` version field was rejected. The property-ref machinery speconaut added exists precisely to make that distinction checkable, and paogen currently gets none of it.

The work is to model the properties that specs actually want to talk about — not every field of every class, which would make the domain a mirror of the source tree and rot on the first refactor.

== Acceptance criteria

- Every entity in the domain context either declares at least one typed property or carries a comment stating why it is genuinely propertyless.
- At least one scenario step in each spec references a property rather than only the bare entity.
- Property types use the DSL's typed forms rather than free-text strings.
- \`speconaut check\` passes, and the property references resolve to declared properties.

== Non-goals

- Mirroring the PHP class structure into the domain. The domain models the vocabulary the specs need, not the implementation.
- Splitting the single \`paogen\` bounded context into several. That is a separate question and only pays off once the context-dependency matrix is enabled.
- Rewriting existing scenario prose beyond what the property references require.

== Files

- \`truth/domain/paogen.context.typ\`
- \`truth/specs/\*.feature-\*.typ\`
