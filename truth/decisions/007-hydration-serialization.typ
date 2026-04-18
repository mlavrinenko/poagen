#import "@local/speconaut:0.1.0": adr, proposed

#show: adr.with(
  number: 7,
  title: "Hydration and serialization contract between the Client, Models, and bound VOs",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
)

== Context

The pre-release review (2026-04-18) flagged three tightly-coupled
correctness bugs in the emitted `ApiClient::hydrate()`:

+ *P0 #1 — list-typed properties are not recursed.* Reflection reports the
  builtin `array` type for `?array $tags`, so items are left as raw
  associative arrays instead of the `Tag` class declared in the
  `@param list<Tag>` phpdoc. Consumers crash at the first
  `$pet->tags[0]->name`.

+ *P0 #2 — hydrator uses PHP parameter names, not schema keys.*
  `ModelEmitter::phpName()` camelCases non-identifier OpenAPI names
  (`photo_urls` → `photoUrls`). The wire key stays `photo_urls`, so the
  lookup misses and the default wins. Any schema with snake_case or
  kebab-case keys produces half-populated models.

+ *P0 #3 — `BindsFormat` scalar VOs do not round-trip.* Wrapping a scalar
  in `Email { public string $value }` and binding it with
  `#[BindsFormat('email')]` causes `json_encode($contact)` to emit
  #raw("{\"email\":{\"value\":\"...\"}}") instead of
  #raw("{\"email\":\"...\"}"). Response hydration has the mirror bug.

The three share the same root cause: the generator has no explicit
marshal/unmarshal contract. Reflection is being used as a substitute for
per-property metadata, and that substitute breaks at the first
non-trivial shape.

== Decision

Adopt a single, spec-visible marshal/unmarshal contract that the emitter
materialises per Model:

+ *Per-Model `PROPERTY_MAP`.* Emit a `private const PROPERTY_MAP` that
  pairs each PHP property name with (a) the original schema key and
  (b) the runtime shape — scalar / model-ref / list-of-model /
  list-of-scalar / map-of-\*. The hydrator consults this map instead of
  reflecting types.

+ *`ScalarBinding` interface for bound VOs.* Introduce a tiny interface
  the user's `#[BindsFormat]` target may implement:

  ```
  interface ScalarBinding {
      public static function fromScalar(mixed $raw): self;
      public function toScalar(): string|int|float|bool;
  }
  ```

  The generator treats any VO implementing it as transparent at the wire
  boundary — `json_encode` and `hydrate()` both route through
  `toScalar()` / `fromScalar()`. VOs that do not implement it fall back
  to today's whole-object (de)serialization and are considered "object
  bindings" for complex formats.

+ *Hydrator + request body marshaller share the map.* The same
  `PROPERTY_MAP` feeds both directions. `hydrate()` maps wire keys → PHP
  names and unwraps scalar bindings; request body emission maps PHP names
  → wire keys and wraps scalar bindings via `toScalar()`. List and map
  shapes recurse via the map entry, not via reflection.

The exact shape of `PROPERTY_MAP` (array-of-arrays vs. attribute-based
registry vs. emitted `__propertyMap()` method) is left to the
implementing task(s); this ADR only locks the *contract*.

== Consequences

- Every generated Model grows a compile-time property map — ~N lines
  for N properties. Golden fixtures for Petstore regrow accordingly.
- `ClientEmitter::hydrate()` becomes data-driven rather than
  reflection-driven, removing the "builtin means stop" failure mode.
- Users who implement `ScalarBinding` on their VOs get transparent
  round-tripping for free; users who don't keep today's object-wrap
  semantics.
- The generator gains a small runtime support layer (the interface
  definition, and possibly a shared hydration helper). ADR-002's
  "no-inheritance" stance still holds: the support layer is an
  interface + free functions, not a base class.

== Alternatives rejected

- *Parse `@param list<Foo>` phpdoc at runtime.* Works, but adds a phpdoc
  parser to the consumer's runtime and breaks if the user strips
  comments. Rejected.
- *`#[\\SerializedName]`-style attribute on every property.* Viable;
  kept as a fallback implementation shape for the `PROPERTY_MAP` step.
  Not picked as the headline design because attributes scatter the map
  across the class body and are harder to introspect in bulk.
- *Force users to subclass a generator-provided `Model` base.* Rejected
  by ADR-002.
- *Status quo (reflect-and-guess).* Rejected — documented broken.
