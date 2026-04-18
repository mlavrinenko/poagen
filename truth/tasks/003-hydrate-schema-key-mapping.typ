#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Hydrate Models by original schema key, not camelCased PHP name",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "critical",
  spec: "truth/specs/model-generator.typ",
  decision: "truth/decisions/007-hydration-serialization.typ",
)

== Summary

`ModelEmitter::phpName()` rewrites non-identifier OpenAPI keys
(`photo_urls` → `photoUrls`). The hydrator then looks up the
camelCased name in the JSON payload — but the wire still sends
`photo_urls`. The lookup misses, the default wins, and any schema with
snake_case or kebab-case keys produces half-populated Models. Request
bodies have the mirror bug on `json_encode`.

== Rationale

Pre-release review P0 #2 — release blocker. Paired with task 002:
together they form the "hydrator correctness" pair blocking 0.1.

== In scope

+ Add a scenario under the Model Generator "Class emission" rule: a
  property whose OpenAPI name is `photo_urls` is constructed with the
  PHP name `photoUrls` *and* hydrates from / serialises to the wire
  key `photo_urls`.
+ Emit per-Model metadata pairing each PHP property name with its
  original schema key (shape per ADR-007's `PROPERTY_MAP`).
+ Use the metadata in both directions:
  - `hydrate()` consults it when reading from the decoded payload;
  - request-body emission uses it when serialising the typed Model
    back to JSON.
+ Regenerate the Petstore golden fixture.

== Out of scope

- List/item recursion (task 002).
- `ScalarBinding` round-trip for `#[BindsFormat]` VOs (task 004).
- Kebab-case keys that are invalid PHP identifiers *and* invalid as
  schema component names (out of scope for v0.1).

== Acceptance

- Model Generator feature grows the `photo_urls` scenario, locked by
  the implementing agent.
- A regression test proves a payload containing `photo_urls` populates
  `Pet::$photoUrls` correctly, and `json_encode($pet)` restores the
  wire key.
- Petstore golden fixture regenerated under
  `tests/fixtures/generated/petstore/`.
- `just check` green end-to-end.
