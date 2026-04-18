#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Emit OpenAPI enums as PHP 8.1 backed enums",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "high",
  spec: "truth/specs/model-generator.typ",
)

== Summary

Petstore's `findPetsByStatus` declares `enum: [available, pending,
sold]` on the `status` query parameter. paogen emits `string $status`.
PHP 8.1 backed enums are the obvious lowering — small change, big DX
win, and type-safety at the call site.

== Rationale

Pre-release review P1 #8 — coverage gap. Listed in the review's
"suggested ordering toward a credible 0.1.0 tag" as low-effort /
high-value.

== In scope

+ Promote the draft "enum schema becomes backed enum" scenario on the
  Model Generator to `stage: unstable` on implementation.
+ When a schema with `enum: […]` is named (component) *or* reused
  across operations, emit a dedicated `enum`:
  - `string` schemas → `: string` backed enum;
  - `integer` schemas → `: int` backed enum;
  - case name = PHP-safe normalisation of the enum value;
  - emitted file lives under `Generated/Enum/<Name>.php`.
+ Inline enums on operation parameters (not declared as components)
  still become typed — emit them as synthetic enums named after the
  operation + parameter (e.g. `FindPetsByStatusStatus`), or keep
  them as `@phpstan-param 'a'|'b'` union tags on `string` if the
  implementing agent prefers a lighter touch.
+ Teach the hydrator to instantiate via `Enum::from($value)` and
  `json_encode` to unwrap via `$enum->value` (PHP handles this
  natively for `BackedEnum`, so mostly a Model-emission change).
+ Regenerate the Petstore golden fixture.

== Out of scope

- Open enums (`x-extensible-enum`, `x-ms-enum`) — emit a `@todo`
  comment and keep today's `string` behaviour.
- `nullable: true` enum semantics beyond `?Status` — test one case
  and stop.

== Acceptance

- The draft enum scenario is promoted to `unstable`, locked.
- `findPetsByStatus` in the Petstore fixture now takes a
  `Status` (or similarly-named) enum parameter, with matching
  golden output committed.
- `just check` green end-to-end, including PHPStan max on the
  generated enum.
