#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Put a coverage floor in the gate instead of a recipe nobody runs",
  tags: ("quality", "tests"),
  priority: 6,
  difficulty: 4,
  status: wip(2026, 8, 1)[in flight],
)

== Summary

\`just test-coverage\` is defined at \`Justfile\` line 188 and called from nowhere — not by \`just check\`, not by the CI workflow, not by any other recipe. It produces an HTML report and a clover file that nothing reads and no one looks at.

That is worse than having no coverage tooling. A recipe that exists implies a number someone is watching, so nobody asks what the number is. Today nobody knows.

ADR-004 dropped codecov deliberately, on the reasoning that a percentage threshold means little on a codegen project whose logic is exercised through generated fixtures. That reasoning still holds against a hosted service and a badge. It does not justify having no floor at all: the argument was against outsourcing the judgement, not against measuring.

The owner wants 80% or better.

== Acceptance criteria

- The current figure is measured and written into this task's Result section, per package or per tier, before any threshold is chosen.
- A floor is enforced by the gate, so a change that drops coverage below it fails rather than being noticed later or never.
- The floor starts at or just under the measured figure and ratchets UP, the mirror of the jscpd thresholds' ratchet-down. Never lower it to admit a regression.
- 80% is the target the ratchet climbs toward; if today's figure is already above it, the floor starts above it rather than being set back down to 80.
- The generated tier is handled deliberately rather than by accident: say in writing whether emitted code counts toward the figure, and why. Counting it inflates the number with code no human wrote; excluding it hides whether the emitter's own branches are exercised.
- Whatever ADR-004 still gets right about hosted coverage services is left standing, and this task's departure from it is recorded rather than silently overriding it.

== Non-goals

- Reinstating codecov or any hosted coverage service. ADR-004 declined those and this task does not reopen it.
- Mutation testing, which measures something different and has its own task.
- Writing tests to hit a number. A floor that is met by asserting nothing is worth less than no floor.

== Files

- \`Justfile\`
- \`phpunit.xml.dist\`
- \`.github/workflows/continuous-integration.yml\`
- \`CONTRIBUTING.md\`
- \`truth/decisions/\`
