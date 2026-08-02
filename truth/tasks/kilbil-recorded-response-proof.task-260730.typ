#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Prove the kilbil client against recorded vendor responses",
  tags: ("testing", "examples"),
  priority: 8,
  difficulty: 4,
  status: wip(2026, 8, 2)[milestone: trust the instruments, then use them],
)

== Summary

No request has ever been sent with the generated kilbil client, and nothing in the repository claims otherwise. The tests that carry kilbil in their name — \`tests/Integration/TaggedSubClientTest.php\`, \`OperationIdNamingTest.php\`, \`TypeListTest.php\`, \`UnrecognisedFormatReportTest.php\`, \`QueryApiKeySecuritySchemeTest.php\`, \`XmlRequestBodyTest.php\` — all drive the emitter from kilbil's schema and assert on emitted source. None of them constructs a client, hands it a response, and checks what comes back.

So the whole runtime half of the acceptance target is unverified: hydration of real vendor payloads, the snake\_case property mapping, the \`\#\[BindsFormat\]\` round trip through \`PhoneNumber\` / \`Timestamp\` / \`CalendarDate\`, the nullable type arrays that \`nullable-type-arrays\` just taught the generator to read, and the 87 properties that depended on it.

The claim \`kilbil-loyalty-client-proof\` makes is that paogen produces a working client. Emission is proven. Working is not.

== Acceptance criteria

- Recorded response bodies for a representative set of kilbil operations live under the example, captured from the vendor's own documented samples rather than invented, and are committed as fixtures.
- A test constructs the generated client over a stub PSR-18 client that replays those bodies and asserts on the hydrated objects, not on emitted source.
- The set covers at least: a response with a \`type: \[T, "null"\]\` property that is null and one where it is present, a nested list-of-object response, a property bound to a consumer value object, and an enum-valued property.
- A 403 response produces \`ApiException\` carrying the original request and response.
- The request side is asserted too: the \`h\` credential reaches the query string of an actually-built request.
- The test runs in \`just check\` and needs no network.

== Non-goals

- Calling the live vendor API from any gate. Recorded fixtures only.
- Credentials of any kind in the repository.
- Covering all 36 operations; a representative set that exercises each hydration shape is the target.
- The XML request bodies, whose element names are unconfirmed — see \`confirm-kilbil-xml-element-names\`.

== Files

- \`examples/kilbil/\`
- \`tests/Integration/\`
- \`tests/fixtures/\`
