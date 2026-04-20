#import "@local/speconaut:0.1.0": adr, accepted

#show: adr.with(
  number: 10,
  title: "Attribute + phpdoc-driven marshal/unmarshal; Model classes stay clean",
  status: accepted,
  date: datetime(year: 2026, month: 4, day: 20),
)

== Context

ADR-007 locked a marshal/unmarshal *contract* but explicitly left the
*representation* open: "array-of-arrays vs. attribute-based registry
vs. emitted `__propertyMap()` method is left to the implementing
task(s)". The representation we shipped is a per-Model
`public const PROPERTY_MAP` plus `JsonSerializable`. A real Order looks
like this:

```
final readonly class Order implements JsonSerializable
{
    public const array PROPERTY_MAP = [
        'complete' => ['complete', null],
        'id' => ['id', null],
        'petId' => ['petId', null],
        'quantity' => ['quantity', null],
        'shipDate' => ['shipDate', ['datetime', null]],
        'status' => ['status', null],
    ];

    public function __construct(
        public ?bool $complete = null,
        public ?int $id = null,
        // ...
    ) {}

    public function jsonSerialize(): array { /* ... */ }
}
```

Problems with this representation:

+ *Noisy output.* The `PROPERTY_MAP` shape is PHPStan-annotated with a
  four-line `@var array{0: string, 1: null|class-string|array{...}}`
  that scares readers and competes with the actual class body for
  attention. On simple schemas (Petstore's Order) the map is pure
  ceremony — wire names already match PHP names.
+ *Duplication.* `list<Tag>` class names appear in both
  `@param list<\Tag> $tags` phpdoc *and* the PROPERTY_MAP tuple. Two
  sources of truth for the same fact invite drift.
+ *`JsonSerializable` is load-bearing.* The hidden contract is that the
  model's `jsonSerialize()` maps PHP names back to wire keys. Readers
  of the class body see `json_encode($order)` "just work" without
  understanding why, and any hand-constructed array representation of
  the same data emits *different* JSON.
+ *Noise where attributes would compose.* Per-property metadata
  (`WireName`, `Format`, `Deprecated`, discriminator info) is
  fundamentally multi-faceted; pivoting through one dense constant
  forces every facet into the same tuple shape.

ADR-007 considered `#[\\SerializedName]`-style attributes and rejected
them with the reason "attributes scatter the map across the class body
and are harder to introspect in bulk". That reason collapses the
moment we have a small reflection-backed registry on the runtime side:
"in bulk" is cached, not re-introspected each call. ADR-007 also
rejected phpdoc-at-runtime parsing because it "adds a phpdoc parser to
the consumer's runtime". Under the same scrutiny, one MIT-licensed
parser that most PHP projects already have transitively
(`phpstan/phpdoc-parser`) is not a meaningful cost.

The 2026-04-19 design review with the project owner concluded that
*clean output is the v0.1 priority* and *runtime performance concerns
are not gating*. Any regression is fixable later by a static cache,
generator-time inlining, or reversion to a hybrid representation. We
are optimising the reader's experience first.

== Decision

*Model classes become lean DTOs. The wire contract is split into two
complementary channels, both honest and both localised to the
property they describe:*

+ *phpdoc is authoritative for structural types.* Element types of
  lists, key/value types of maps, and nullability use ordinary
  `@var` / `@param` annotations. A runtime `Hydrator` parses these
  via `phpstan/phpdoc-parser` and walks the resulting AST.
+ *Attributes carry non-structural metadata only.* The attribute
  vocabulary is deliberately small:
    - `#[WireName(string $name)]` — present only when the PHP property
      name differs from the wire key.
    - `#[Format(string $format)]` — OpenAPI format hint
      (`'date-time'`, `'uuid'`, etc.); drives scalar codec selection.
    - `#[Discriminator(string $field, ?array $map = null)]` — the
      wire field whose value selects a branch of a PHP union type.
      `$map` carries OpenAPI's explicit `discriminator.mapping` when
      the spec provides one; when omitted, the generator derives the
      map from the branch classes' schema names and still emits it,
      so the runtime always sees a uniform input.
    - `#[Deprecated(?string $replacement = null)]` — passthrough from
      the spec.
    - Class-level `#[Schema(?string $name = null)]` and
      `#[AdditionalProperties(string|false $valueClass = false)]` for
      open objects.
+ *Scalar value objects are detected by the `ScalarBinding` interface*
  (unchanged from ADR-007). No attribute is needed on the property —
  the PHP type itself carries the information.
+ *`JsonSerializable` is removed from generated models.* Serialisation
  is the `Marshaller`'s job. `ApiClient` request body emission goes
  through `$this->marshaller->marshal($model)` rather than
  `json_encode($model)`.
+ *Reading phpdoc is the runtime's job.* `Hydrator` and `Marshaller`
  each obtain property metadata via `phpstan/phpdoc-parser` against
  `ReflectionProperty::getDocComment()`. When `getDocComment()`
  returns `false` because opcache stripped comments, the runtime
  reads the class file from disk and re-tokenises via
  `token_get_all` (`MethodDocScanner::docFor()`; per-file cache so
  each class pays at most one rescan per process). *There is no
  build-time precompilation step to avoid this cost.*

== Scope + priority policy

*Clean interface and output come first; runtime cost is a separate
concern.* The implementing task is allowed to choose the simplest
correct approach at every fork even when a more complex one would be
faster. Performance regressions versus the ADR-007 representation are
*not* blockers for merge; they are follow-up tasks, not design
objections.

*Dependencies pull their weight.* Adding `phpstan/phpdoc-parser` to
the runtime is explicitly endorsed. Future decisions should treat
well-maintained MIT/BSD libraries as a valid tool, not a last resort.

== What `Order.php` becomes

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

And for the interesting case — a Pet with a list of nested Tag models:

```
final readonly class Pet
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?Category $category = null,
        /** @var list<string>|null */
        public ?array $photoUrls = null,
        /** @var list<Tag>|null */
        public ?array $tags = null,
        public ?string $status = null,
    ) {}
}
```

== Consequences

- Every generated Model class loses its `PROPERTY_MAP` constant and
  `JsonSerializable` implementation. Golden trees (petstore,
  digitalocean, github) regenerate.
- A new runtime package area is introduced:
  `Mlavrinenko\\Paogen\\Runtime\\Marshal\\{Marshaller,Hydrator}` plus
  the attribute classes under
  `Mlavrinenko\\Paogen\\Runtime\\Attribute\\*`. The `ScalarBinding`
  interface stays where it is.
- `ClientEmitter::hydrate()` is retired. `ApiClient` gains a
  constructor-injected `Hydrator` and `Marshaller`, both optional with
  sensible defaults (`new Hydrator()` / `new Marshaller()`).
- `composer.json` gains `phpstan/phpdoc-parser: ^1.33` as a runtime
  dependency. This flows to every paogen consumer — documented in
  README.
- ADR-007's `PROPERTY_MAP` representation choice is *superseded*. The
  *contract* ADR-007 states (marshal/unmarshal is explicit, not
  reflection-and-guess; bound scalars round-trip; lists recurse) is
  *retained* — this ADR simply chooses a different shape that
  materialises it.
- `oneOf` / `anyOf` without a discriminator is treated as a
  generator-time error; users resolve it either by fixing the spec
  or by adding a profile-level discriminator override. Structural
  fallback is *not* implemented — silent mis-hydration is worse than
  a loud refusal.
- Performance: runtime hydration is no longer O(1) constant-read. It
  parses phpdoc via `phpstan/phpdoc-parser` and caches the resulting
  descriptor per class in a `static` map on the `Hydrator` /
  `Marshaller`. The cache is per-process and per-class; warm-up cost
  is a single parse. Consumers who need sub-microsecond hydration are
  not paogen's target audience in v0.1; if this becomes painful, a
  follow-up ADR revisits representation.

== Alternatives rejected

- *Keep `PROPERTY_MAP`.* Rejected: optimises the runtime at the cost
  of everything a human touches. The "ugly output" feedback from the
  project owner is load-bearing: if a codegen tool's output is
  embarrassing to read, the tool loses credibility regardless of
  correctness.
- *Generate a static registry file alongside the models (path taken
  by Symfony Serializer's dumped metadata).* Rejected: moves the
  duplication from inside the Model to a sibling file, but the
  duplication itself remains. Simpler to have one authoritative
  source (phpdoc + attributes) and read it at runtime.
- *Typhoon/type + typhoon/reflection for type representation and
  parsing.* Explored; rejected for now. Latest stable
  `typhoon/reflection` is `0.4.4` from 2023, incompatible with
  `typhoon/type ^0.8.x`, and adds seven transitive packages.
  `phpstan/phpdoc-parser` alone gives us the parser typhoon wraps
  internally, at 1/7 the dependency footprint. Full exploration is
  captured at `truth/notes/runtime-type-reflection.md`. If typhoon's
  upstream aligns on a single supported line, re-evaluate.
- *Hand-rolled phpdoc parser (to avoid the one dep).* Rejected on the
  "dependencies pull their weight" principle above. We are not in the
  business of reinventing a parser that the community maintains.
- *Attribute-only (no phpdoc reading) — e.g. `#[ItemType(Tag::class)]`.*
  Rejected: duplicates information phpdoc already carries, and the
  class-name duplication is exactly the noise we are trying to delete.
