#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Decide and implement the policy for XML payloads",
  tags: ("generator",),
  priority: 4,
  difficulty: 4,
  status: proposed(2026, 7, 28),
)

== Summary

The generator understands JSON and form-encoded payloads, stubs multipart and octet-stream with a throwing method, and has no story at all for XML. The kilbil loyalty schema declares two XML responses alongside 104 JSON ones. Today an XML-only operation falls into the silent-skip path, which the fail-loud goal forbids. Whatever the answer is — support it, stub it, or refuse it — it has to be one of the recognised reactions rather than a fourth undocumented one.

== Acceptance criteria

- An XML request or response reaches a documented, tested outcome rather than a silent drop.
- The choice is recorded in a decision citing the goals it serves.
- If it is refused, the message names the operation and the content type.
- An operation offering both JSON and XML prefers JSON and does not warn.

== Non-goals

- Building a general XML serialisation layer unless the decision explicitly calls for it.

== Files

- \`src/Generator/Emit/RequestBodyAnalyzer.php\`
- \`src/Generator/Emit/ResponseHandler.php\`
- \`truth/decisions/\`
