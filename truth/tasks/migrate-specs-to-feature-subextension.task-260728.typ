#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Rename the four spec files to the .feature sub-extension and rebuild the entry point",
  tags: ("speconaut",),
  priority: 6,
  difficulty: 3,
  status: done(2026, 8, 1),
)

== Summary

speconaut now classifies every artifact by a filename sub-extension rather than by directory, and requires every non-task artifact to be included from the truth entry point. paogen's four spec files are plain \`.typ\` names, and \`truth/main.typ\` still lists the old paths plus three markdown files that the current checker reports as \`file not included\` when they sit under the truth tree unreferenced.

== Acceptance criteria

- The four spec files carry \`.feature-\<yymmdd>.typ\` names.
- \`truth/main.typ\` includes the vision, every goal, every spec, every decision and the domain context, and nothing it lists is missing.
- \`speconaut check\` reports no \`file not included\` findings.
- The markdown notes and review archive either become includable artifacts or move outside the truth tree, decided explicitly rather than by accident.

== Non-goals

- Rewriting scenario bodies or changing spec coverage.
- Resolving the code-reference findings inside the specs; that is its own task.

== Files

- \`truth/specs/\*.typ\`
- \`truth/main.typ\`
- \`truth/notes/\*.md\`
- \`truth/reviews/\*.md\`
