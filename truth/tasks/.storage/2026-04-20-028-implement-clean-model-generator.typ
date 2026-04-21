#import "@local/speconaut:0.1.0": task, done

#show: task.with(
  id: "1521b30d-0c14-407e-997e-165e4ac533aa",
  title: "Implement ADR-010: clean Model output, attribute + phpdoc-driven Marshaller/Hydrator",
  status: done,
  date: datetime(year: 2026, month: 4, day: 20),
  priority: "high",
  spec: "truth/specs/model-generator.typ",
)

== Summary

Realise ADR-010 end-to-end. Generated Model classes shed their
`PROPERTY_MAP` constant and `JsonSerializable` implementation. A new
runtime `Marshaller`/`Hydrator` drives request/response
(de)serialisation by reading native reflection + phpdoc + a small
set of attributes.

This is the v0.1 credibility fix: *the output of a codegen tool must
be readable on its own terms.*

== Rationale

ADR-010 states the motivation. Quick recap:

- Current Order.php includes a 10-line `PROPERTY_MAP` with a four-
  line PHPStan docblock describing the map's shape. Readers of the
  class body are distracted by the codec before they see the model.
- Duplication between PROPERTY_MAP entries and `@param list<...>`
  phpdoc annotations invites drift.
- `JsonSerializable::jsonSerialize()` is a hidden contract the
  reader has to discover.

The clean version (from ADR-010) is:

```
final readonly class Order
{
    public function __construct(
        public ?int $id = null,
        #[WireName('pet_id')]
        public ?int $petId = null,
        public ?int $quantity = null,
        public ?DateTimeImmutable $shipDate = null,
        /** @var non-empty-string|null */
        public ?string $status = null,
        public ?bool $complete = null,
    ) {}
}
```

== In scope

+ *Runtime attribute classes.* Create
  `src/Runtime/Attribute/WireName.php`,
  `.../Format.php`, `.../Discriminator.php`,
  `.../Deprecated.php`, `.../Schema.php`,
  `.../AdditionalProperties.php`. Each `final readonly`,
  `#[Attribute(...)]`. Small value objects.

+ *Runtime Marshaller.* `src/Runtime/Marshal/Marshaller.php`:
  `marshal(object $model): array`. Reads native types, phpdoc (via
  `phpstan/phpdoc-parser`), attributes; emits a JSON-ready array
  keyed by wire names; wraps `ScalarBinding` VOs via `toScalar()`;
  formats `DateTimeImmutable` via RFC3339 (or the Format attribute's
  hint).

+ *Runtime Hydrator.* `src/Runtime/Marshal/Hydrator.php`:
  `hydrate(string $class, array $data): object`. Inverse of
  Marshaller. Handles nested models, lists, maps, discriminated
  unions, `ScalarBinding::fromScalar()`.

+ *Phpdoc-stripped fallback.* When
  `ReflectionProperty::getDocComment()` returns `false`, read the
  class file from disk and re-extract phpdoc via `token_get_all`.
  The Marshaller/Hydrator detect this transparently — no user-
  visible mode switch.

+ *Composer dependency.* Add
  `phpstan/phpdoc-parser: ^1.33` to `composer.json` `require`
  (not `require-dev`). It flows to every paogen consumer.

+ *ModelEmitter rewrite.* Remove PROPERTY_MAP emission, remove
  `JsonSerializable` + `jsonSerialize()` emission. Emit attributes
  (`#[WireName]` when PHP name ≠ wire key; `#[Format]` when
  OpenAPI format is non-default; class-level `#[Schema]` /
  `#[AdditionalProperties]`). Keep `final readonly` +
  constructor-promoted properties.

+ *ClientEmitter rewrite.* Drop the embedded `hydrate()` static
  method; inject `Hydrator` + `Marshaller` into the generated
  `ApiClient` constructor (both nullable, defaulting to `new
  Hydrator()` / `new Marshaller()`). Request body emission:
  `json_encode($this->marshaller->marshal($model), JSON_THROW_ON_ERROR)`.
  Response hydration: `$this->hydrator->hydrate(Pet::class, $data)`.

+ *Discriminator handling.* When the OpenAPI spec provides
  `discriminator.mapping`, emit it in
  `#[Discriminator(field: 'petType', map: [...])]`. When absent,
  derive from branch schema names and emit the derived map — the
  runtime always sees a uniform input.

+ *`oneOf` without discriminator → generator-time error.* Add a
  Profile escape hatch so users can specify a discriminator
  override when the spec is light.

+ *Golden-tree regeneration.* Petstore, digitalocean, github under
  `examples/`; Petstore + siblings under
  `tests/fixtures/generated/`. `just check` must stay green;
  byte-stability test (T-022) must pass.

+ *Specs updated.* Add scenarios to
  #link("../../specs/model-generator.typ")[Model Generator] and
  #link("../../specs/operation-generator.typ")[Operation Generator] for:
  - Model emits no `PROPERTY_MAP`, no `JsonSerializable`.
  - Marshaller round-trips a scalar-binding VO.
  - Hydrator recurses into `list<Tag>`.
  - Hydrator maps snake_case wire keys to camelCase PHP names via
    `#[WireName]`.
  - Discriminated union hydrates to the correct branch.

== Out of scope (follow-up tasks)

- Runtime performance tuning (static caches beyond a simple per-class
  memoisation, opcache integration, dumped registry). File as a new
  task post-ADR-010.
- Migration guide for users on older paogen builds. Since no paogen
  release has shipped, no user migration applies.
- Revisiting typhoon/reflection. See
  `truth/notes/runtime-type-reflection.md`; re-evaluate if upstream
  aligns.

== Prerequisites

- *T-027* (perf-language audit) completes first so the spec
  language reflects ADR-010 before we write code against it.

== Acceptance

- `just check` green, including `lint-phpstan` and
  `lint-phpstan-generated`, with zero deprecation notices.
- `just check-examples` green (no drift on petstore, digitalocean,
  github).
- `tests/fixtures/generated/petstore/Generated/Model/Order.php`
  contains no `PROPERTY_MAP`, no `implements JsonSerializable`.
- A scenario in `truth/specs/` asserts the Marshaller is
  `ScalarBinding`-aware and the Hydrator recurses into `list<Tag>`.
- `composer.json` lists `phpstan/phpdoc-parser` in `require`.
- Runtime library area exists at `src/Runtime/Marshal/` and
  `src/Runtime/Attribute/`, PHPStan-clean at `level: max`.

== Dirty-fix budget

Per the 2026-04-20 direction, dirty fixes are allowed if *documented
in a follow-up task*. Examples of pre-approved dirty fixes:

- Caching a `ReflectionClass` resolution globally rather than per
  request — acceptable provisionally, file a cleanup task.
- Reading phpdoc via `getDocComment()` only (skipping the token-
  scan fallback) *if* CI and dev environments all keep comments —
  acceptable provisionally, with a documented failure mode and a
  follow-up task to add the fallback.

Dirty fixes that are *not* pre-approved:

- Hand-editing generated trees or `tests/generated/*.php`. Per
  AGENT.md, these are tool-owned.
- Skipping the spec update. ADR-010's acceptance depends on it.
