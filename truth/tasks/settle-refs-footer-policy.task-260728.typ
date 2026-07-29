#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Record the commit trailer policy for task references",
  tags: ("docs",),
  priority: 5,
  difficulty: 1,
  status: status("needs-review", 2026, 7, 29),
)

== Summary

The contributor guide predates MindTape and states no rule for referencing a task from a commit. The operator has since settled on task slugs, but nothing in the repository records that, so the next session has to ask again or guess. The historical tasks also carry their former identifiers in an extension slot, which means two reference vocabularies now coexist and the relationship between them is undocumented.

== Acceptance criteria

- The contributor guide states the trailer format and gives an example.
- It says what to do when a commit has no task, rather than leaving it implied.
- The relationship between a task slug and a historical identifier is stated once.
- The rule is discoverable from the agent guide.

== Non-goals

- Rewriting historical commit messages.
- Enforcing the trailer with a hook; that is a separate decision.

== Files

- \`CONTRIBUTING.md\`
- \`AGENT.md\`
