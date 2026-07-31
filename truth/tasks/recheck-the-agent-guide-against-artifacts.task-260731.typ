#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Re-check the agent guide against the artifacts it describes",
  tags: ("speconaut",),
  priority: 5,
  difficulty: 3,
  status: status("needs-review", 2026, 7, 31),
)

== Summary

Two claims in the project's own guidance are false, and both were true when written.

\`AGENT.md:103-105\` tells agents not to reach for the in-tree speconaut build because it is older than the system install. The system install IS the in-tree build: the nix shim execs \`~/projects/home/speconaut/target/debug/speconaut\`.

\`Justfile:16-30\` attributes the four disabled speconaut recipes to speconaut reading \`.mindtape/config.toml\` through a stale embedded mindtape. The real cause was an unresolvable workspace — four path dependencies pointing at crates that had moved — which froze the binary at its 4 July build.

Third instance of this pattern: the jscpd option list and the \`\*Steps.php\` header were the first two, each time the artifact said what was true and a summary was trusted instead.

== Acceptance criteria

- every factual claim in \`AGENT.md\` is re-derived from the artifact it describes, not from a prior summary; say in the report which claims were checked and against what
- the two known-false claims are corrected
- the copy-the-tree-to-/tmp validation workaround is replaced by what the healed toolchain actually needs, or deleted if it needs nothing
- the Justfile header no longer states a cause that is not the cause

== Non-goals

- does not restructure the knowledge-tree or task-placement sections beyond factual correction
- does not document a workflow this milestone decided against, notably the session FSM

== Files

- \`AGENT.md\`
- \`Justfile\`
