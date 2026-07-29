#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Report unrecognised format annotations instead of degrading silently",
  tags: ("strictness", "generator"),
  priority: 6,
  difficulty: 3,
  status: proposed(2026, 7, 28),
)

== Summary

An unknown \`format\` falls through to the bare base type with no diagnostic. Real schemas make this common and consequential: the kilbil loyalty document carries 172 occurrences of \`format: int\`, 94 of \`format: double\`, 15 of \`format: "date time"\` with a space where a hyphen belongs, three of \`format: "data time"\` which is a typo for the same thing, plus \`phone\` and \`data\`. Several sit on a string type rather than a numeric one. Every one of these is a place a user could bind their own value object and get a typed field, and today nothing tells them the opportunity exists.

== Acceptance criteria

- The plan reports every format annotation the generator did not recognise, with the component or operation and property that carried it, and a count.
- The report names the mechanism for binding a value object to that format.
- Recognised built-ins and user-bound formats are not reported.
- Whether an unrecognised format is a hard failure follows the profile policy established by the abort-on-unrepresentable-constructs task, rather than inventing a second policy here.

== Non-goals

- Guessing what a misspelled format meant; the generator reports, the user binds.
- Shipping built-in bindings for vendor-specific formats.

== Files

- \`src/Generator/Emit/TypeResolver.php\`
- \`src/Generator/GenerationPlan.php\`
- \`src/GenerateCommand.php\`
