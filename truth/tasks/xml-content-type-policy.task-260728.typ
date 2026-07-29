#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Decide and implement the policy for XML payloads",
  tags: ("generator",),
  priority: 4,
  difficulty: 4,
  status: status("needs-review", 2026, 7, 30),
)

== Summary

The generator understands JSON and form-encoded payloads, stubs multipart and octet-stream with a throwing method, and has no story at all for XML. The kilbil loyalty schema declares two XML responses alongside 104 JSON ones. Today an XML-only operation falls into the silent-skip path, which the fail-loud goal forbids. Whatever the answer is — support it, stub it, or refuse it — it has to be one of the recognised reactions rather than a fourth undocumented one.

== Acceptance criteria

- An XML request or response reaches a documented, tested outcome rather than a silent drop.
- The choice is recorded in a decision citing the goals it serves.
- If it is refused, the message names the operation and the content type.
- An operation offering both JSON and XML prefers JSON and does not warn.

- The choice is recorded in `truth/decisions/xml-request-bodies-are-serialised-not-refused.decision-260730.typ`, citing `real-world-schemas` and `fail-loud-never-silent`. It came out as "serialise, do not refuse": the schemas are fully declared, every response in the corpus is JSON so XML is request-only and bounded, and refusing would have cost two of kilbil's thirty-six operations over the last step of a pipeline that already had every earlier one.
- The element names OpenAPI does not supply — the document root, and the repeated element of a bare-array body — come from `Profile::$xmlElements`, and an XML body with no entry stops the run. A guessed root does not fail visibly; it produces well-formed XML the vendor rejects with a 400.
- Serialisation runs after the marshaller rather than instead of it, so wire names, scalar bindings and date formats are decided once for both content types.
- XML responses stay unimplemented. The corpus has none, and parsing XML back into a model has failure modes serialising out of one does not — inheriting this decision would assume the symmetry rather than establish it.

== Non-goals

- Building a general XML serialisation layer unless the decision explicitly calls for it.

== Files

- `src/Runtime/Marshal/XmlWriter.php` (new)
- `src/Generator/Emit/BodyAttachmentEmitter.php` and `OperationOrder.php` (new — extracted so `RequestAssembler` and `InlinePayloadPlanner` stay under the linecop limit)
- `src/Generator/Emit/BodySpec.php`, `InlinePayloadPlanner.php`, `RequestAssembler.php`, `RequestBodyParameterEmitter.php`
- `src/Generator/Profile.php`
- `truth/decisions/xml-request-bodies-are-serialised-not-refused.decision-260730.typ`
- `examples/kilbil/paogen.php`
- `tests/`
