#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Abort the run on any construct the generator cannot represent",
  tags: ("strictness", "generator"),
  priority: 9,
  difficulty: 6,
  status: proposed(2026, 7, 28),
)

== Summary

The generator has three different reactions to a construct it cannot handle, and the most common one is silent. An undiscriminated union throws and aborts. A multipart or octet-stream body emits a method that throws when called. Everything else is dropped from the client, reported on stderr, and the run still prints a success line and exits 0. Against the kilbil loyalty schema that means 34 of 36 operations vanish while \`paogen generate\` prints \`generated into ...\` and returns 0. A continuous-integration job cannot tell that apart from success.

== Acceptance criteria

- A schema containing an unsupported construct causes a non-zero exit and writes nothing.
- The message names the construct, the operation or component, and what would make it acceptable.
- The success line is not printed on a run that skipped anything.
- The three existing reactions are unified: undiscriminated unions, unsupported bodies and unsupported content types all fail the same way.
- A profile-level opt-out exists, is explicit, is scoped to named constructs rather than global, and is recorded in the user's profile.
- Regression tests cover: abort by default, opt-out honoured, exit code, and empty output directory on abort.

== Non-goals

- Adding support for any of the constructs themselves; each has its own task.
- Changing the \`--dry-run\` and \`--diff\` exit-code contract beyond making skips visible.

== Files

- \`src/GenerateCommand.php\`
- \`src/Generator/Profile.php\`
- \`src/Generator/GenerationPlan.php\`
- \`src/Generator/Emit/RequestBodyAnalyzer.php\`
- \`truth/specs/cli.typ\`
