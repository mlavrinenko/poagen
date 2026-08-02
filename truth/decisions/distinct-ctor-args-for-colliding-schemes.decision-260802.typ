#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/schema.context.typ": *

#show: decision.with(
  title: "Colliding security schemes get distinct constructor arguments, not one shared parameter",
  status: accepted(2026, 8, 2),
  contexts: (generation-context, schema-context),
  goals: (
    link("../goals/real-world-schemas.goal.typ"),
    link("../goals/fail-loud-never-silent.goal.typ"),
  ),
  standards: (link("../standards/caller-surface-is-injectable.standard-260729.typ"),),
)

== Context

Every scheme kind {@see SecurityScheme::fromCebe} recognises proposes a
default ctorArg: `apiKey` schemes get a name derived from their own key
under `components.securitySchemes`, and `http bearer` schemes all get the
fixed name `bearerToken` — a deliberate choice, on the reasoning that one
request carries one `Authorization` header, so two bearer schemes in the
same document were expected to be the same credential wearing two names.
`SecuritySchemeCatalog` and `ClientConstructor` never checked that
assumption against a document declaring two, so two same-kind schemes
collided: the same promoted constructor parameter emitted twice, once per
scheme, onto a signature with only one slot for it.

The DigitalOcean document disproves the assumption outright rather than
merely stressing it. It declares `bearer_auth` (an OAuth token
authenticating the control-plane API) and `inference_bearer_auth`, and
says so explicitly in its own prose: "The Inference APIs use API access
keys for authentication, which are separate from the DigitalOcean OAuth
tokens used by the control-plane API." Two schemes, same kind, and by the
vendor's own words two different credentials for two different
audiences — not a document repeating itself.

Two ways to fix the collision were on the table:

- Collapse to one constructor parameter, keeping today's `bearerToken`
  reasoning but making it a real invariant rather than an unchecked
  assumption: every scheme of a colliding kind shares the argument, and a
  consumer supplies one token for all of them.
- Give each colliding scheme its own ctorArg, breaking the tie by the
  scheme's own name — the same source `apiKey` schemes already use, just
  applied uniformly instead of only when the kind's default happens to
  vary by name already.

== Choice

Distinct ctorArgs. `SecuritySchemeCatalog::disambiguateCtorArgs()` counts
how many supported schemes in the document propose the same ctorArg; a
name proposed by exactly one scheme is untouched, and a name proposed by
more than one is replaced, for every scheme in that group, with a name
derived from the scheme's own key — `SecurityScheme::camelize()`, the
same normalisation `apiKey` schemes already apply to their own name. A
document with a single scheme of any kind never has a group larger than
one, so its ctorArg is exactly what it was before this decision existed.

Collapsing was the wrong direction to fix in, not merely a worse fix. A
single parameter for two schemes is a claim that the document names two
things which are actually one, and DigitalOcean's own description says
the opposite of that for its own pair. Forcing a consumer to pass the
same string for both an OAuth token and an Inference API key is not a
convenience the generator can grant — it can't invent equivalence between
credentials the document itself distinguishes. Where two schemes really
are the same credential under two names (a case this generator has no way
to detect, since nothing in OpenAPI says so), a consumer can still pass
the same string to both distinct parameters; nothing forces two values.
The reverse is not available under collapsing: a consumer who needs two
values cannot get them back once emission has already merged the slots.
That asymmetry, not a preference for more parameters over fewer, is what
decided it — `real-world-schemas` measures success against the document
as published, and merging two audiences the vendor named separately is
exactly the kind of change to the document's meaning that goal rules out.
`fail-loud-never-silent` reinforces it from the other side: silently
dropping the distinction between two credentials the schema declared is
the same shape of loss the goal exists to catch, even though nothing here
aborts the run — the failure mode is a signature that compiles and is
quietly wrong, not a diagnostic.

This does not reopen why `http bearer`'s default is a fixed name in the
first place. A document with one bearer scheme still gets `bearerToken`,
unchanged — see the Non-goals `security-schemes-sharing-a-ctor-arg-collide`
names against renaming that case. The fixed default remains a reasonable
first guess for the common shape; this decision only says what happens
once a second scheme of the same kind proves the guess wrong for that
particular document.

== Consequences

- Generating the DigitalOcean tree no longer emits a repeated constructor
  parameter, closing the fifty `arguments.count` findings PHPStan reported
  against it.
- A document with exactly one scheme of any kind — the overwhelming
  majority of real documents — emits byte-for-byte what it emitted before
  this decision; verified directly by regenerating the `parameters`
  fixture (its lone `bearerAuth` scheme) into the committed golden tree
  and finding no diff.
- A colliding scheme's ctorArg is now derived from its own name rather
  than always being the kind's fixed default, so a consumer regenerating
  across a document revision that goes from one scheme of a kind to two
  sees the newly-collision-broken parameter renamed. This is the same
  kind of promoted-parameter churn `real-world-schemas` already accepts
  when a vendor adds a scheme; nothing here is idempotent-breaking within
  one revision of the document, only across a revision that changes the
  scheme count.
- `oauth2` and `openIdConnect` schemes are untouched — they classify as
  `KIND_UNSUPPORTED` before any ctorArg is proposed, so they were never in
  scope and stay that way per this task's own non-goals.
