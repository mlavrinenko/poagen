#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Bind the kilbil int and double formats in the example",
  tags: ("examples", "dx"),
  priority: 2,
  difficulty: 3,
  status: proposed(2026, 7, 30),
)

== Summary

\`int\` (172 uses) and \`double\` (94) are the two largest unrecognised formats in the kilbil document, and the example leaves both unbound on purpose. \`examples/kilbil/README.md\` and the profile both explain why: the report exists to make the opportunity visible, not to insist it be taken, and demonstrating the mechanism once — via \`PhoneNumber\`, \`Timestamp\`, \`CalendarDate\` — is enough to prove it works.

That reasoning holds. What it leaves out is that \`double\` on a price is the case where an unbound format is actively wrong rather than merely unhelpful: \`goods\_data/items/properties/price\` becomes a PHP \`float\`, and money in a float is a defect the example currently ships as a demonstration.

So this is worth doing, or worth saying out loud that the example ships float money deliberately.

== Acceptance criteria

- Either a \`Money\` value object under \`examples/kilbil/src/ValueObject/\` binds \`double\` and the example regenerates clean, or
- \`examples/kilbil/README.md\` states plainly that \`double\` stays a float and why that is acceptable in an example.
- If a binding lands, the round trip is covered by \`kilbil-recorded-response-proof\` rather than asserted only at emission.
- \`int\` is decided the same way and in the same place, whichever way it goes.

== Non-goals

- Any built-in paogen binding for \`int\` or \`double\`. These are not OpenAPI formats and the generator should keep reporting them.
- Changing the unrecognised-format report itself; \`report-unrecognised-formats\` owns that.

== Files

- \`examples/kilbil/src/ValueObject/\`
- \`examples/kilbil/paogen.php\`
- \`examples/kilbil/README.md\`
- \`examples/kilbil/generated/\`
