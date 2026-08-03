#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Wire every security scheme that reduces to a credential; refuse the rest by name",
  tags: ("generator", "security", "strictness"),
  priority: 6,
  difficulty: 5,
  status: done(
    2026,
    8,
    3,
  )[Landed as 9f69da9, merged 3dfd3aa after the two dependencies it uncovered were closed. Four buckets: wired, reported, refused by name, refused with instructions. Profile::securitySchemes fills a gap the document left, and petstore wires api\_key instead of skipping two operations.],
  links: (
    depends-on(
      "sub-client-constructors-take-every-scheme-in-the-document.task-260802.typ",
    ),
    depends-on(
      "generated-tier-duplication-ratchet-blocks-new-golden-trees.task-260802.typ",
    ),
  ),
)

== Summary

`SecurityScheme::fromCebe()` classifies anything it does not wire as
`KIND_UNSUPPORTED`, and `SecuritySchemeCatalog::filterSupportedByName()` then
drops it. After `query-apikey-security-scheme` lands, the set still dropped is
`apiKey` `in: cookie`, `http basic`, `http` with any other scheme name,
`oauth2`, and `openIdConnect`.

A dropped scheme is invisible. The emitted client takes no credential, sends no
credential, and the run reports success — so the consumer learns about it from
the vendor's 401, not from the tool. `silence-means-success` says a run that
completes emitted everything it was asked for, and `fail-loud-never-silent` says
a construct the generator cannot represent stops the run and names itself.
Neither is true here today.

What the reaction should be is a real decision rather than an obvious one, and
that is most of this task. `oauth2` genuinely is not the generator's business —
`operations-delegate-to-an-injected-transport` puts token acquisition and
refresh in the transport, and a generated client that took a bearer token it
could not refresh would be worse than one that took nothing. `http basic` and
`apiKey` `in: cookie`, by contrast, are one header each and are dropped only
because nobody wrote them.

So the reaction may differ per kind, but it may not be silence for any of them,
and whatever is chosen has to be one of the reactions the project already
recognises — refuse, or a named omission in `Profile` carrying a reason — not a
fourth undocumented one.

=== Owner ruling, 2026-08-02

The framing above assumed a scheme is either wired or refused, and asked which
side oauth2 falls on. The ruling rejects the framing. paogen never implements
transport, and it never drops anything silently — so for each scheme it emits
whatever the document says that helps the consumer wire their own transport
against a standard library. Where the document is ambiguous, the generator
either picks the default that is right in almost every case, or errors and
says exactly what to configure. It never guesses quietly.

Applied per scheme kind, that resolves to four buckets. The first is much
larger than this task assumed, because almost every scheme in OpenAPI reduces
to one credential attached to one request:

*Wired — one credential, one place on the wire.*

- `apiKey` `in: header` — as today.
- `apiKey` `in: query` — as today.
- `apiKey` `in: cookie` — one constructor argument, sent as a `Cookie` header
  carrying `name=value`.
- `http basic` — two constructor arguments, sent as
  `Authorization: Basic <base64 of user:pass>`.
- `http bearer` — as today.
- `http` with any other scheme token (`token`, a vendor word) — one argument,
  sent verbatim as `Authorization: <SchemeToken> <credential>`. This is the
  "sane default that works in almost every case": RFC 7235 says a credential
  follows the scheme token, and every scheme that is not a challenge-response
  handshake works this way.
- `oauth2`, every flow — one constructor argument holding an access token,
  sent as `Authorization: Bearer <token>`, which is what RFC 6750 says an
  OAuth2 access token looks like on the wire for all four flows. paogen does
  not acquire the token and does not refresh it; it never has to, because the
  emitted client only ever sends one.
- `openIdConnect` — identical to oauth2 at the wire.

  For these last two the generator also emits, as generated constants and
  docblock on the client, the flow metadata the document carries: each flow's
  name, `authorizationUrl`, `tokenUrl`, `refreshUrl`, and the declared scope
  names with their descriptions. That is the "help the consumer wire their own
  transport" half — a consumer reaching for `league/oauth2-client` or any
  other library gets the endpoints and scopes from the client they already
  have, instead of re-reading the vendor's YAML. Where an operation's own
  security requirement names scopes, those scopes appear in that method's
  docblock.

*Reported, nothing to wire.* `mutualTLS` is the one scheme with no
request-level credential at all — the material lives in the TLS handshake, on
the consumer's PSR-18 client. The run generates normally and exits zero,
because nothing shrank, and prints a notice naming the scheme and where the
certificate has to be configured; the same line appears on the emitted
client's docblock. This is the notice channel `report-unrecognised-formats`
established, not a new one.

*Refused by name.* `http digest` and `http negotiate` need a challenge and a
second request before a credential exists. paogen will not run a protocol.
The run aborts naming the scheme and every operation that requires it, and
says the opt-out is skipping those operations. Anything a future
specification revision adds that paogen does not recognise lands here too:
unknown means refused, never ignored.

*Refused, and says what to configure.* A security requirement that names a
scheme the document never declares. This is not hypothetical — the vendored
petstore document requires `api_key` on two operations and declares only
`petstore_auth`, so the emitted client authenticates neither. The document is
invalid, the fixture may not be edited (`fixtures-are-unmodified-vendor-documents`),
and the consumer does know what `api_key` is. So the generator errors, names
the requirement and the operations, and asks for the missing declaration in
the profile — which means `Profile` grows a map of scheme declarations that
fill a gap the document left. That is the shape `real-world-schemas` calls for
where a document is genuinely ambiguous: ask for guidance, say exactly what is
needed.

=== Two dependencies nobody recorded, found by doing the work, 2026-08-03

Both surfaced only once a scheme was actually wired onto a tagged document,
and both make this task un-landable on its own. Recorded here because neither
is visible from either task's text.

`sub-client-constructors-take-every-scheme-in-the-document` becomes mandatory
the moment anything is wired. Before this task, petstore had no wired scheme
at all, so no sub-client took a credential and the uniform-wiring defect had
nothing to show. Wiring `api_key` and `petstore_auth` produces three
`property.onlyWritten` findings — `StoreClient::$petstoreAuth`,
`UserClient::$apiKey`, `UserClient::$petstoreAuth` — under a generated-tier
config with no baseline and no `ignoreErrors`. That is verbatim the other
task's second acceptance criterion, and there is no in-scope way to land this
green without it.

`generated-tier-duplication-ratchet-blocks-new-golden-trees` blocks it for a
different reason. The criterion above requiring an operation's scopes on that
operation's docblock costs 112 duplicated lines, because the petstore document
requires the identical scope pair on all seven pet operations and the same
output is committed twice. That takes the generated tier from 16.41% to
18.55% against a 16.5% threshold. Measured by disabling that one call and
regenerating; everything else in the change is green at 16.41%.

The second is the more interesting failure: jscpd counts doc comments, so the
gate penalises the generator for documenting its output faithfully — for
emitting exactly what an acceptance criterion demands.

== Acceptance criteria

- Every scheme kind in the wired bucket above is emitted and attached to the
  request, each proven by a fixture asserting the exact header or query
  parameter the request carries.
- `oauth2` and `openIdConnect` clients carry the flow metadata the document
  declares — flow names, all three URLs, scope names and descriptions — as
  generated constants readable without the schema in hand, and an operation's
  required scopes appear on that operation's docblock.
- `mutualTLS` produces a notice, exit status zero, and a docblock line on the
  emitted client. It never produces an abort and never produces silence.
- `http digest`, `http negotiate`, and any unrecognised scheme type abort the
  run naming the scheme key, its type, and every operation that requires it —
  globally-applied schemes named as such.
- A security requirement naming an undeclared scheme aborts the run naming the
  requirement and its operations, and the message names the profile key that
  fixes it.
- `Profile` accepts a declaration for a scheme the document omitted, keyed by
  the requirement name, and the petstore example uses it to wire `api_key`
  rather than skipping the two operations that require it.
- A scheme that is declared but required by no operation and no global
  requirement is not reported. An unused declaration costs the consumer
  nothing.
- The four buckets and their reasoning are recorded in a decision citing the
  goals and standards they serve, and that decision states plainly why oauth2
  is wired despite `operations-delegate-to-an-injected-transport` putting
  token acquisition in the transport: sending a token and obtaining one are
  different jobs, and only the first is the client's.
- No schema anywhere produces a client that reports success and sends no
  credential where the document required one.

== Non-goals

- Acquiring, refreshing, storing, or validating any credential. paogen emits
  the argument and puts it on the request; everything before that is the
  consumer's transport, per `operations-delegate-to-an-injected-transport`.
- Running any challenge-response handshake.
- Re-opening `query-apikey-security-scheme`, which wires the query variant.
- `sub-client-constructors-take-every-scheme-in-the-document`, which fixes
  which sub-client receives which credential. This task decides what a
  credential is; that one decides who gets one.

== Files

- `src/Generator/Emit/SecurityScheme.php`
- `src/Generator/Emit/SecuritySchemeCatalog.php`
- `src/Generator/Emit/SecurityEmitter.php`
- `src/Generator/Emit/ClientConstructor.php`
- `src/Generator/Profile.php`
- `src/Generator/GenerationPlan.php`
- `examples/petstore/`
- `truth/decisions/`
