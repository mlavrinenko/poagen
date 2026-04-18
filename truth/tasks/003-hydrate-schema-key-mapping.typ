#import "@local/speconaut:0.1.0": task, done

#show: task.with(
  title: "Hydrate Models by original schema key, not camelCased PHP name",
  status: done,
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

== Resolution

Landed together with task 002 (same PROPERTY_MAP work).

- The task's original framing — that `ModelEmitter::phpName()`
  camelCases plain snake_case names such as `photo_urls` → `photoUrls`
  — turns out not to match current behavior: the name regex
  `/^[a-zA-Z_]\w*$/` already accepts `photo_urls` as-is, so snake_case
  names pass through unchanged and the hydrator lookup already
  matches the wire key. The actual risk is with *non*-PHP-identifier
  keys (kebab-case, dotted names, etc.), where the camelCase fallback
  *does* fire and historically produced the documented half-populated
  Models.
- `tests/fixtures/schemas/contact-3.0.yaml` grew a kebab-case
  `display-name` (required string) and a snake_case `org_id`
  (optional integer). The kebab-case case exercises PHP-name
  mangling; the snake_case case documents the identity-passthrough.
- `Contact::PROPERTY_MAP` pairs `'displayName' => ['display-name',
  null]` and `'org_id' => ['org_id', null]`. `jsonSerialize()` emits
  them keyed by the wire name, so `json_encode($contact)` round-trips
  to `display-name` on the wire regardless of the PHP property name.
- Regression under Model Generator > "Hydration and serialization
  contract (ADR-007)": `A property with a non-identifier schema key
  round-trips through PROPERTY_MAP`. Locked.
- `tests/fixtures/generated/contact/*` regenerated to include the
  new property and the emitted `PROPERTY_MAP` / `jsonSerialize()`.
- `BindsFormat` scalar VOs (Email etc.) still do not round-trip
  correctly — still tracked by task 004. The new regression test
  pre-constructs an `Email` instance when exercising hydration so it
  does not depend on task 004's completion.
