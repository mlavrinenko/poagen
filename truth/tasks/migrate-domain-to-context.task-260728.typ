#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Migrate the domain vocabulary to a typed .context.typ artifact",
  tags: ("speconaut",),
  priority: 7,
  difficulty: 4,
  status: done(2026, 8, 1),
)

== Summary

\`speconaut check\` aborts on the first artifact it evaluates: \`\`entity \`Schema\` must declare props (use \`props: ()\` if it has none) or be a value member\`\`. The current speconaut requires every entity to declare typed properties, and classifies domain vocabulary by a \`.context.typ\` filename sub-extension rather than by living under a \`domain/\` directory. paogen declares 13 entities in the old propertyless form, in a file with no sub-extension.

== Acceptance criteria

- The domain file is named with the \`.context.typ\` sub-extension and declares a \`bounded-context()\`.
- All 13 entities declare \`props\`, using \`props: ()\` where the entity genuinely has none and real typed properties where the specs already reference fields.
- Evaluating the domain file alone raises no error.
- Every spec that imports the domain still resolves its \`\#a\` / \`\#an\` / \`\#the\` references.

== Non-goals

- Inventing properties the specs do not already reference; \`props: ()\` is the honest default.
- Splitting the vocabulary into several bounded contexts — one context is correct at this size.
- Touching the spec bodies beyond what the import path rename forces.

== Files

- \`truth/domain/paogen.typ\`
- \`truth/domain.typ\`
- \`truth/specs/\*.typ\` (import paths only)
