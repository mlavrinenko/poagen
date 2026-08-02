#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Confirm the kilbil XML root and item element names against vendor samples",
  tags: ("examples", "xml"),
  priority: 6,
  difficulty: 2,
  status: wip(2026, 8, 2)[milestone: trust the instruments, then use them],
)

== Summary

\`examples/kilbil/paogen.php\` supplies four \`xmlElements\` entries — \`goodsxml => goods\`, \`goodsxml.item => good\`, \`goodslistxml => goodslist\`, \`goodslistxml.item => good\` — and its own comment says they are inferred from the vendor's prose rather than confirmed: "Confirm them against the vendor's XML samples before sending a live request — paogen cannot, and the example makes no live call."

The document carries no \`xml:\` metadata at all, so OpenAPI names nothing for the document root or for the repeated element of a bare array. paogen correctly refuses to invent either. But the example then invents them anyway, in the profile, and ships them as if they were answers.

A wrong root element is a 400 from the vendor on 2 of 36 operations. Right now nobody knows which it is, and the example reads as though somebody does.

== Acceptance criteria

- Either the four names are confirmed against a vendor artefact — a published XML sample, the vendor's own documentation, or a captured request — and the profile comment cites where, or
- they are marked unconfirmed in \`examples/kilbil/README.md\` and in the profile comment, in terms a reader cannot mistake for a settled answer.
- Whichever way it lands, \`examples/kilbil/README.md\` and the profile agree with each other.

== Non-goals

- Changing how paogen reads or emits \`xmlElements\`; \`xml-content-type-policy\` owns that.
- Making a live request from any gate.

== Files

- \`examples/kilbil/paogen.php\`
- \`examples/kilbil/README.md\`
