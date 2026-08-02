#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Confirm the kilbil XML root and item element names against vendor samples",
  tags: ("examples", "xml"),
  priority: 6,
  difficulty: 2,
  status: done(2026, 8, 2),
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

== Result

The task's premise was wrong, and correcting it settled the question outright.
The committed vendor document embeds a literal XML sample under each of the two
XML request bodies — `loyalty_v1.yaml` around line 4305 for `/load/goodsxml` and
around line 4570 for `/load/goodslistxml` — so the names were confirmable
against a vendor artefact all along, without a live call. Three of the four
guesses held: root `goods` with item `good`, and root `goodslist`. The fourth
was wrong. The profile keyed `goodslistxml.item` to `good` where the vendor's
own sample says `goodlist`, which would have been a malformed body on one of the
two XML operations. That entry is corrected and the tree regenerated; the blast
radius was exactly one literal in `CatalogueClient.php`'s `xmlList` call. Both
the profile comment and the README now cite the file and line region behind each
name.

Confirming the names surfaced a second gap that naming cannot close. Both
samples nest a container one level deeper — a `good` holds an `inside` which
holds further `good` elements — and neither the profile's flat root/item keying
nor `XmlWriter::appendArray`, which unwraps a nested array by repeating the
property's own name, can express it. paogen would emit a run of sibling
`inside` elements where the vendor expects one `inside` wrapping several
children. That is recorded honestly in the profile and README rather than
implied to work, and filed as `kilbil-xml-nesting-is-unrepresentable`.
