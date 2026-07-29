#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Split unseparated operation identifiers into readable method names",
  tags: ("dx", "generator"),
  priority: 5,
  difficulty: 4,
  status: proposed(2026, 7, 28),
)

== Summary

Operation identifiers are normalised by camel-casing on existing word boundaries. When a schema supplies none, the output is the identifier unchanged: the kilbil loyalty document yields methods named after runs like \`getclientfullbalance\` and \`searchgiftcard\`. These are valid but unpleasant, and unpleasant method names are exactly what drives a consumer to wrap the generated client and hand-maintain the wrapper forever. A user can already supply a custom normalisation pipeline, so the escape hatch exists; what is missing is a decent default and a documented path.

== Acceptance criteria

- A default strategy produces readable names for unseparated lowercase identifiers, using the schema's own vocabulary as the dictionary rather than a hardcoded English word list.
- The strategy is one composable step in the existing normalisation pipeline and can be dropped or replaced from the profile.
- Names remain deterministic and collision-free; a collision fails the run rather than silently suffixing.
- The existing example schemas produce unchanged output, or their golden trees are regenerated deliberately.

== Non-goals

- Natural-language word segmentation with an external dictionary.
- Renaming components; this is about operations and parameters.

== Files

- \`src/Generator/Naming/\`
- \`src/Generator/Emit/OperationAnalyzer.php\`
- \`examples/\`
