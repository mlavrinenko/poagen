#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Wire mutation testing, or record why it stays unwired",
  tags: ("quality", "tests"),
  priority: 4,
  difficulty: 6,
  status: wip(2026, 8, 2),
)

== Summary

Task 021 was retired as \`done\` without wiring infection, and the roadmap carries mutation testing as a post-v0.1 follow-up on the grounds that the code surface had not stabilised. It has stabilised considerably since: the transport collapse landed, the runtime contracts are declared, and the generator now refuses rather than degrades.

Mutation testing is the instrument that answers the question a coverage floor cannot. Coverage says a line ran. A surviving mutant says the line ran and nothing would have noticed if it were wrong. On a code generator that is the sharper question, because the suite asserts against emitted strings and a weakened assertion still passes while covering every branch — a failure mode this project has already hit once, in the spec whose step body asserted the opposite of its scenario.

This task either wires it or closes the question in writing. What it must not do is leave a third silent deferral.

== Acceptance criteria

- infection is installed, pinned, and runs against \`src/\` with a recorded configuration.
- A first mutation score index is measured and written into this task's Result section, alongside how long a full run takes.
- The runtime is prioritised over the emitters if the full run proves too slow to gate on: name which parts are covered and which are deferred, rather than sampling silently.
- Whether it joins the gate is decided explicitly. If it is too slow, say so with the measured duration and wire it somewhere it will actually run.
- Surviving mutants are triaged at least once, and any that reveal a genuinely weak assertion are filed as their own task rather than fixed inline here.
- If the conclusion is that mutation testing is not worth its cost on this project, that is an acceptable outcome — recorded as a decision artifact with the measurement behind it, not as another deferral.

== Non-goals

- Reaching any particular mutation score. The first run establishes a baseline; improving it is separate work.
- Fixing every surviving mutant found.
- The coverage floor, which is its own task and measures a different thing.

== Files

- \`composer.json\`
- \`infection.json5\`
- \`Justfile\`
- \`truth/decisions/\`
- \`ROADMAP.md\`
