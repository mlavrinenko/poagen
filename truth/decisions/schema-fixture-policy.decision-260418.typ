#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": *

#show: decision.with(
  title: "Schema fixture policy: vendor real-world OpenAPI documents under tests/fixtures/schemas/",
  status: accepted(2026, 4, 18),
  contexts: (schema-context,),
  goals: (link("../goals/real-world-schemas.goal.typ"),),
  standards: (link("../standards/fixtures-are-unmodified-vendor-documents.standard-260729.typ"),),
)

== Context

We need real OpenAPI 3.0 #a(Schema) to validate the generator. Synthetic
fixtures miss the wild patterns that real APIs use (deeply nested `$ref`,
`oneOf` without discriminator, recursive types, undocumented edge cases).
Repository size is not a constraint at this stage; we will trim before a
release if it matters.

== Choice

Vendor schemas as plain files under `tests/fixtures/schemas/<vendor>-<version>.yaml`.
Each schema gets one matching `tests/fixtures/profiles/<vendor>.php`. Each
schema gets one matching `tests/fixtures/generated/<vendor>/` directory
containing the committed generator output (golden file).

=== PoC tier

- Petstore 3.0 (#link("https://petstore3.swagger.io/api/v3/openapi.yaml"))
  — canonical, ~200 lines, exercises arrays, refs, enums, nullable,
  nested schemas. The only fixture the PoC must pass against.

=== Validation tier (post-PoC, before v0.1)

- DigitalOcean OpenAPI — clean, modern 3.0.x, big but not insane.
- GitHub REST API (#link("https://github.com/github/rest-api-description"))
  bundled variant — ~5MB, ~1000 endpoints, the industry torture test.

=== Stretch (post-v0.1)

- Stripe and Kubernetes only if we adopt new patterns the above schemas
  don't cover.

== Consequences

- Generator regression tests run against the golden output: any change to
  #a(Schema) or to the generator must accompany a committed regen of
  the fixture tree, and the diff is the test.
- Adding a new schema is a deliberate act: extend this document so we
  know why we picked it.
- Pre-release housekeeping task: audit fixture sizes, prune what we are
  no longer using.
