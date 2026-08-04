#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/schema.context.typ": *

#show: decision.with(
  title: "Every security scheme that reduces to a credential is wired; the rest refuse by name",
  status: accepted(2026, 8, 3),
  contexts: (generation-context, schema-context),
  goals: (
    link("../goals/real-world-schemas.goal.typ"),
    link("../goals/fail-loud-never-silent.goal.typ"),
    link("../goals/typed-injectable-surface.goal.typ"),
  ),
  standards: (
    link("../standards/silence-means-success.standard-260729.typ"),
    link("../standards/caller-surface-is-injectable.standard-260729.typ"),
  ),
)

== Context

`SecurityScheme` classified anything it did not wire as unsupported and the
catalogue then dropped it. A dropped scheme was invisible: the emitted client
took no credential, sent no credential, and the run reported success. The
consumer learned about it from the vendor's 401.

That is two rules broken at once. `silence-means-success` says a run that
completes emitted everything it was asked for. `fail-loud-never-silent` says a
construct the generator cannot represent stops the run and names itself. A
silently credential-less client is neither.

The question this decision was filed to answer was which side `oauth2` falls
on — wired, or refused as the transport's business. That framing was rejected.
poagen never implements transport, and it never drops anything silently, so
the question is not "wire or refuse" but "what does the document say that helps
a consumer wire their own transport, and how does poagen hand it over".

Almost every scheme in OpenAPI reduces to one credential attached to one
request. That is the observation the framing missed, and it makes the wired
set far larger than the task assumed.

== Choice

Four buckets, decided by what the scheme is on the wire rather than by how
complicated the protocol around it is.

*Wired.* `apiKey` in header, query or cookie; `http basic`; `http bearer`;
`http` with any other scheme token, sent verbatim as
`Authorization: <SchemeToken> <credential>` per RFC 7235; `oauth2` in every
flow and `openIdConnect`, each taking one access token sent as
`Authorization: Bearer <token>` per RFC 6750. For the last two poagen also
emits the flow metadata the document carries — flow names, `authorizationUrl`,
`tokenUrl`, `refreshUrl`, scope names and descriptions — as constants and
docblock, and puts an operation's required scopes on that operation's
docblock.

*Reported, nothing to wire.* `mutualTLS`. The material lives in the TLS
handshake on the consumer's PSR-18 client, so there is no request-level
credential to emit. The run generates normally, exits zero, and prints a
notice naming the scheme and where the certificate is configured. It never
aborts and never stays silent.

*Refused by name.* `http digest` and `http negotiate` need a challenge and a
second request before a credential exists; poagen will not run a protocol.
Anything a later specification revision adds that poagen does not recognise
lands here too — unknown means refused, never ignored.

*Refused, and says what to configure.* A requirement naming a scheme the
document never declares. `Profile::$securitySchemes` supplies the declaration
the document is missing, keyed by the requirement name, and the abort names
that key.

=== Why oauth2 is wired, against a decision that appears to say otherwise

`operations-delegate-to-an-injected-transport` puts token acquisition and
refresh in the transport, and an earlier reading of this task took that to mean
oauth2 is not the generator's business at all. It does not. Obtaining a token
and sending one are different jobs, and only the second is the client's.

Obtaining is a multi-party protocol against endpoints the document names.
Sending is one header. RFC 6750 fixes that header identically for all four
flows, so there is exactly one thing to emit and no flow-dependent branching to
get wrong. A client that refused to accept the token would not avoid the
transport boundary — it would force the consumer to reach past the generated
surface to add a header the document already specified, which is precisely
what `typed-injectable-surface` exists to prevent.

The metadata half follows from the same split. poagen emits the endpoints and
scope vocabulary *because* it does not acquire the token: a consumer reaching
for their own OAuth library gets what it needs from the client they already
have, instead of reopening the vendor's YAML.

== Consequences

- A scheme declared but required by no operation and no global requirement is
  not reported. An unused declaration costs the consumer nothing.
- The petstore example wires `api_key` instead of skipping the two operations
  that required it. The vendored document is invalid — it requires a scheme it
  never declares — and `fixtures-are-unmodified-vendor-documents` forbids
  editing it, so the profile is where the gap is filled.
- Guidance under `Profile::$securitySchemes` is checked like every other entry:
  declaring a scheme the document already declares, or one nothing requires,
  fails the run the way a stale `$skip` does.
- Wiring anything at all made `sub-client-constructors-take-every-scheme-in-the-document`
  mandatory rather than optional. Before this decision no sub-client took a
  credential, so the uniform-wiring defect had nothing to show; wiring two
  produced three `property.onlyWritten` findings under a config with no
  baseline. The two tasks have a hard ordering that neither recorded.
- `oauth2` and `openIdConnect` now propose a constructor argument, so they
  participate in the collision disambiguation
  `distinct-ctor-args-for-colliding-schemes` describes. That decision's closing
  bullet said they never would; it is corrected in place.
