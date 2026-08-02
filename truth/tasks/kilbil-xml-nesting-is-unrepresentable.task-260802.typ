#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "kilbil xml nesting is unrepresentable",
  tags: ("examples", "xml", "generator"),
  priority: 7,
  difficulty: 5,
  status: accepted(
    2026,
    8,
    2,
  )[Owner ruled 2026-08-02: paogen learns nested XML containers rather than refusing the two operations. Where a document describes a structure, the client carries that structure. Priority raised — this is a wrong request body shipping today, not a missing feature.],
)

== Summary

Confirming the kilbil XML element names against the vendor's own embedded samples (see confirm-kilbil-xml-element-names) surfaced a second, structural gap that naming cannot fix. Both vendor samples nest a container one level deeper: a good element holds an inside element, which in turn holds further good elements. The same shape repeats for goodslist holding inside holding goodlist. paogen's profile has exactly two keys per XML body, one for the document root and one for the repeated item, so it has no way to say that a nested array property is a named container whose children repeat the parent's own item element. The runtime XmlWriter compounds it: appendArray unwraps a nested array by repeating the property's own name, so paogen emits a sequence of sibling inside elements each holding one entry's fields, where the vendor expects one inside element wrapping several good children. That is a wrong body on 2 of 36 operations, and it is currently recorded only as a prose limitation in the example's README and profile comment. A wrong nesting is the same 400 from the vendor that a wrong root element would be, so the honest note is a placeholder, not an answer.

== Acceptance criteria

- The profile can express a nested array property whose entries are wrapped in a named container and repeat a named item element, keyed per property rather than per document.
- The two kilbil XML operations emit a body structurally matching the vendor's own samples at loyalty\_v1.yaml lines 4305 and 4570, proven by comparing the emitted XML against those samples in a test rather than by inspection.
- A nested binding naming a property absent from the schema fails the run with a diagnostic naming it, per fail-loud-never-silent.
- The unrepresentable-nesting note in examples/kilbil/README.md and in the profile comment is removed, because it is no longer true.
- An XML body that needs no nesting emits exactly as today, byte for byte.

== Non-goals

- Inferring the nesting from the schema. OpenAPI carries no xml metadata in this document and a guess that moves between runs is what cheap-regeneration forbids.
- Changing the root or item names that confirm-kilbil-xml-element-names already settled.
- XML response bodies, which xml-responses-refused-at-generation-time owns.
- Making a live request from any gate.

== Files

- src/Generator/Profile.php
- src/Generator/Emit/
- runtime/src/Marshal/XmlWriter.php
- examples/kilbil/paogen.php
- examples/kilbil/README.md
- tests/
