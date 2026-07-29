#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Make the domain model what the specs actually talk about",
  tags: ("speconaut", "domain", "debt"),
  priority: 4,
  difficulty: 4,
  status: proposed(2026, 7, 29),
)

== Summary

The speconaut migration declared every paogen domain entity with \`props: ()\` — the DSL's explicit "this entity models no properties yet" form. That was the right move to get the truth tree green in one pass without inventing a data model under time pressure, but it leaves the domain as a list of thirteen bare nouns.

An entity with no properties cannot be referenced at property granularity in a scenario step, so a spec can say a \`Schema\` was loaded but not that its \`openapi\` version field was rejected. The property-ref machinery speconaut added exists precisely to make that distinction checkable, and paogen currently gets none of it.

The migration also proved the vocabulary is missing whole entities, not just properties. The model-generator spec talks constantly about the runtime hydration machinery — \`Hydrator\`, \`Marshaller\`, and the doc-comment recovery path behind them — and none of it is modelled. The only honest anchor available was \`Client\`, so steps ended up phrased as "the Client's runtime Hydrator". That reads acceptably where the machinery genuinely belongs to the emitted client, and badly where it does not: one step now attributes the PHP process and its \`opcache.save_comments\` setting to \`Client\`, which is simply not true of it.

A missing entity does not announce itself. It shows up as prose bending around the gap, which is exactly what happened here, and it will keep happening every time someone writes a scenario about hydration.

The work is therefore twofold: add the entities the specs already discuss, and model the properties those specs want to reference — not every field of every class, which would make the domain a mirror of the source tree and rot on the first refactor.

== Acceptance criteria

- A runtime bounded context exists modelling the hydration machinery the specs already discuss — at minimum \`Hydrator\` and \`Marshaller\` — and the model-generator spec's steps anchor on those instead of borrowing \`Client\`.
- No step attributes something to an entity that does not own it. The \`opcache.save_comments\` step in the model-generator spec is the known offender and is the acceptance case for this.
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
