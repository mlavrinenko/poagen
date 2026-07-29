#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Write the standards library the accepted decisions must cite",
  tags: ("speconaut",),
  priority: 5,
  difficulty: 5,
  status: proposed(2026, 7, 28),
)

== Summary

speconaut's standard on decision grounding requires every accepted decision to cite at least one goal it advances and either a standard it honours or a process-only reason naming why no testable rule applies. paogen now has goals but no standards, so the ten decisions cannot satisfy the contract without either a standards library or a blanket process-only escape that would make the check meaningless.

== Acceptance criteria

- The durable, portable rules paogen actually applies are written as standard artifacts with the \`.standard-\<yymmdd>.typ\` sub-extension.
- Each carries a rule statement and the cases it requires.
- Every accepted decision cites at least one of them, or declares process-only with a stated reason.
- No decision cites a standard invented purely to satisfy the check.

== Non-goals

- Importing speconaut's own standards; they govern a different project.
- Writing a standard for every decision one-to-one — several decisions honouring one standard is the expected shape.

== Files

- \`truth/standards/\`
- \`truth/decisions/\*.typ\`
