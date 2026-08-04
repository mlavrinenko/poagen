#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "thread the validated nested container map into the generated client",
  tags: ("generator",),
  priority: 5,
  difficulty: 4,
  status: done(
    2026,
    8,
    4,
  )[The profile entry is now the only place a nested XML container name is written. XmlWriterInterface::renderList takes the binding as its own argument, so the writer the transport holds - default or consumer substitute alike - is always the one that renders; PsrRequestBuilder lost its special case entirely rather than gaining a failure path. kilbil's README drops its hand-built XmlWriter recipe. A no-binding XML body is byte-identical and the absent-property diagnostic still fires. Gated on the merged HEAD: 535 tests, both floors held.],
)

== Summary

kilbil-xml-nesting-is-unrepresentable gave the profile a per-property nested container binding and taught XmlWriter to honour it. The generator validates those entries against the schema and then does nothing with them. Endpoint xmlList carries only the root and item names, so nothing between the generated call and the wire knows about a nested container, and a consumer who wants the vendor's shape has to rebuild the same map by hand when constructing their transport, keyed by element name rather than by operation id. The profile entry and the consumer's map say the same thing in two places, and only one of them is checked against the document.

== Acceptance criteria

- A consumer who declares the nested binding in the profile gets the nested shape without writing a second map. Whatever carries it, the profile entry is the only place the container name is written.
- The kilbil example stops shipping a hand-built XmlWriter recipe in its README, because the profile entry is enough.
- An XML body with no nested binding emits byte for byte as it does today.
- The existing diagnostic for a binding naming an absent property still fires.

== Non-goals

- Inferring nesting from the schema. kilbil-xml-nesting-is-unrepresentable already ruled that out and the reasoning has not changed.
- Widening what the runtime XmlWriter can express. It can already do this; the gap is that the generated side never tells it to.

== Files

- src/Generator/Emit/
- runtime/src/Contract/Endpoint.php
- examples/kilbil/
- tests/
