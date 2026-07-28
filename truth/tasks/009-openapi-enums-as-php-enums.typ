#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "9f800feb-9617-48c3-b072-e759aca328ab",
  title: "Emit OpenAPI enums as PHP 8.1 backed enums",
  status: done(2026, 4, 19),
  priority: 7,
  x-paogen: (spec: "truth/specs/model-generator.typ", legacy-id: "T-009"),
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

== Non-goals

- Open enums (`x-extensible-enum`, `x-ms-enum`) — emit a `@todo`
  comment and keep today's `string` behaviour.
- `nullable: true` enum semantics beyond `?Status` — test one case
  and stop.

== Acceptance criteria

- The draft enum scenario is promoted to `unstable`, locked.
- `findPetsByStatus` in the Petstore fixture now takes a
  `Status` (or similarly-named) enum parameter, with matching
  golden output committed.
- `just check` green end-to-end, including PHPStan max on the
  generated enum.

== Implementation notes

- New subpackage `src/Generator/Enum/` hosts the catalog + spec;
  `src/Generator/Emit/EnumEmitter.php` renders one backed-enum file
  via Nette's PhpGenerator. The existing `Generated/Model/` layout
  is extended with `Generated/Enum/` alongside it.
- Case names are PascalCased (`available` → `Available`); rejected
  alternatives were `UPPER_SNAKE` (noisier) and raw-value-as-case
  (breaks on non-identifier values). Collisions within a single
  enum fall back to a positional suffix.
- Inline enums on operation parameters are synthesised:
  `<PascalCase(operationId)><PascalCase(paramName)>`
  (e.g. `FindPetsByStatusStatus`). The call site uses
  `$status->value` when building the query string.
- Inline enums on *model properties* (Petstore's `Pet.status`,
  `Order.status`) are intentionally left as `?string` — promoting
  them would change the Petstore golden surface beyond this task's
  scope. Promote in a follow-up if the need arises.
- Named enum components (tested via a new `Status` component on the
  `parameters` fixture) become `Generated/Enum/Status.php` and are
  referenced via a typed `?Status` property whose PROPERTY_MAP shape
  is `['enum', Status::class]`. `ApiClient::hydrate` gains a branch
  that calls `Status::from($value)`.
- Non-ScalarBinding user `#[BindsFormat]` VOs still beat the
  built-in enum resolution when the component `$ref` is present —
  consistency with ADR-003's user-wins lookup order.
