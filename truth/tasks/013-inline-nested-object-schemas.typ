#import "@local/speconaut:0.1.0": task, done

#show: task.with(
  title: "Emit inline nested object schemas as typed maps or generated classes",
  status: done,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "high",
  spec: "truth/specs/model-generator.typ",
)

== Summary

`TypeResolver::resolve()`'s `object` branch returns
`array<string, mixed>` for any inline object schema without a `$ref`.
Any nested structure is therefore lost at the generator boundary —
users get an untyped map where the schema declared a typed shape.

== Rationale

Pre-release review P1 #12 — coverage gap. Inline objects are common in
wild APIs (GitHub's response envelopes, Stripe's `metadata`) and today
they all collapse to `mixed`.

== In scope

+ Promote the draft "inline nested object schema becomes typed map or
  class" scenario on the Model Generator to `stage: unstable` on
  implementation.
+ Strategy split:
  - If the inline object only has `additionalProperties: <scalar>`
    and no declared properties → emit as
    `array<string, <scalar>>`.
  - If the inline object has declared properties → synthesise an
    anonymous named class under `Generated/Model/` using the owning
    Model and property name as the base (e.g.
    `Pet` + `shipping` → `PetShipping`), recurse.
+ Ensure the hydrator honours the new named class exactly like any
  `$ref` target.
+ Regenerate any affected golden fixtures.

== Out of scope

- Inline objects with both `properties` and non-trivial
  `additionalProperties: <schema>`. Emit a `@todo` and fall back to
  today's `array<string, mixed>` when both appear.
- Renaming strategy for the synthesised class (the user's `Profile`
  `renames` map already covers named components; add a
  `synthesised-object-rename` hook only if a real schema needs it).

== Acceptance

- Draft scenario promoted to `unstable` and locked.
- A fixture schema (new or extended Petstore) exercises an inline
  object with properties, and the golden output now includes the
  synthesised class.
- `just check` green end-to-end.
