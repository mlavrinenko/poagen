#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Prove the kilbil client against recorded vendor responses",
  tags: ("testing", "examples"),
  priority: 8,
  difficulty: 4,
  status: wip(2026, 8, 2),
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

== Result

Not finished. The agent building it hit a session limit mid-task, and what
exists is preserved on branch `kilbil-response-proof` at `1a7d580` rather than
merged: the harness and the defect probes, but not the recorded bodies. Nothing
in it runs yet — `examples/kilbil/fixtures/responses/` was never written, and
PHPStan does not know the `Acme\Kilbil\Generated` namespace the tests import.
Treat the branch as a starting point, not a partial pass.

It did establish the one thing this task existed to find out, and the answer is
no. The generated kilbil client does not correctly hydrate a spec-compliant
vendor payload. `PropertySynthesiser` computes a property's nullability from the
OpenAPI 3.0 `nullable` flag alone and never consults the 3.1 `type: [T, "null"]`
form that `TypeResolver` already reads, so a wire `null` for the `searchClient`
response's `state` or `special_days_types` throws `TypeError` out of the
constructor. Confirmed independently against both source sites before this was
written. That is the gap `nullable-type-arrays` was meant to close, missed
because it was fixed in one of the two paths and no test had ever hydrated a
real payload — which is exactly this task's premise. Filed as
`nullable-type-array-lost-in-property-synthesis`.

The harness design is worth keeping as-is: it wires the real committed
`ApiClient` over the real `HttpTransport` against a PSR-18 stub, so
`PsrRequestBuilder`, `Marshaller`, `Hydrator` and `ResponseDecoder` all run end
to end. The proof does not substitute a test runtime for the real one.

Left to do: write the response bodies from the vendor's own 386 documented
`example:` values, teach PHPStan the example's generated namespace via
`scanDirectories` rather than by loosening types in the harness, and assert the
remaining shapes — the nested list-of-object response, the value-object binding,
the enum property, the 403 carrying request and response, and the `h` credential
reaching the query string.
