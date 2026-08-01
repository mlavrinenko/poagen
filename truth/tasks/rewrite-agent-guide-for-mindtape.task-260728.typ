#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Rewrite the agent guide for the MindTape and goals-based workflow",
  tags: ("docs",),
  priority: 7,
  difficulty: 2,
  status: done(2026, 8, 1),
)

== Summary

The agent guide is written around a workflow that no longer exists. It carries 18 references to speconaut, instructs the reader to treat a release roadmap as the ordered queue, describes a lock-approval hazard procedure, and points at a task directory layout that has been replaced. An agent following it today would look for tasks where there are none and run commands the binary does not have. It is the first file a new session reads, so its staleness is the most expensive staleness in the repository.

== Acceptance criteria

- The guide describes the MindTape backlog as the queue, with the commands that actually drive it.
- It names the vision and goals as the artifacts a design discussion is checked against.
- Speconaut is described at its recovered scope rather than its former one, or not at all until the recovery lands.
- The roadmap is either retired into the backlog or explicitly scoped to release sequencing only.
- Every command the guide names exists and runs.

== Non-goals

- Documenting the speconaut workflow before the recovery tasks land.
- Rewriting the contributor guide, which is a separate audience.

== Files

- \`AGENT.md\`
- \`ROADMAP.md\`
- \`CONTRIBUTING.md\`
