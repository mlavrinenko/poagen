#import "@local/speconaut:0.1.0": adr, accepted

#show: adr.with(
  number: 3,
  title: "Profile DX: typed Profile object + attributes co-located on user value objects",
  status: accepted,
  date: datetime(year: 2026, month: 4, day: 18),
)

== Context

ADR-001 commits to declarative profiles. *Where* that data lives is a DX
question. We considered five options:

+ Fluent builder (`Profile::for(...)->mapFormat(...)->...`).
+ Typed config object via named arguments (`new Profile(formats: [...])`).
+ Attributes co-located on user value objects.
+ User-implemented "vocabulary" interfaces.
+ Plain config arrays.

== Decision

Combine *option 3 for class-level bindings* with *option 2 for project-level
config*. The two categories are about different things; splitting them by
concern (not by mechanism) is the honest model.

=== Class-level bindings — attributes on user code

```php
namespace App\ValueObject;

#[BindsFormat('email')]
final readonly class Email {
    public function __construct(public string $value) { /* validate */ }
}
```

- Guidance lives *with* the implementation. Adding a value object is a
  one-file change.
- The attribute is self-documenting at the declaration site.
- AI agents annotate the class they are already editing.

=== Project-level config — typed `Profile` object

```php
return new Profile(
    schema:      'openapi.yaml',
    output:      './generated',
    namespace:   'App\\Generated\\GitHub',
    discoverIn:  ['App\\ValueObject'],
    renames:     ['user_v2_response' => 'UserResponse'],
    excludes:    ['paths./internal/**'],
);
```

- Named arguments → IDE autocomplete and order-independence.
- Pure value, easy to dump for diffing, easy to merge for tests.
- Profile holds *only* what attributes cannot express (where to look,
  namespace, output dir, generated-class renames, exclusions, discriminator
  hints).

== Selector strings

Schema selectors (for `renames`, `excludes`, future bindings) accept the
*simple component name* (`'EmailAddress'`). If a name is ambiguous across
component kinds, the generator errors with the disambiguating JSON Pointer
to copy in. JSON Pointers (`#/components/schemas/EmailAddress`) are also
accepted: a value starting with `#/` is treated as a pointer.

== PoC scope

The PoC ships only:

- Profile fields: `schema`, `output`, `namespace`, `discoverIn`, `renames`.
- One attribute: `#[BindsFormat]`.

`#[BindsSchema]`, `#[BindsPattern]`, `excludes`, `discriminators`, `group`
are *designed* but unimplemented until a real schema needs them.

== Name normalisation — `nameNormaliser` (T-023)

Real-world schemas use kebab-case / snake_case / digit-prefixed
component names that are not valid PHP identifiers. A single
hard-coded sanitiser would be opinionated in ways different teams
disagree about. `Profile` gains an optional `nameNormaliser` field
that holds a `NameNormaliser` (interface under
`Mlavrinenko\Paogen\Generator\Naming`). The pipeline is:

```
normalise(raw) → CompositeNormaliser([
    RenamesNormaliser($profile->renames),   // explicit overrides win
    PascalCaseSanitiser,                    // catch-all auto-convert
])
```

Each strategy has a `normalise(raw, ctx): ?string` method: non-null
is "I handled it", null is "pass to the next". Composites throw if
*every* strategy returns null, with a diagnostic naming the offending
raw input. Strategies may be pattern-gated with an optional PHP-regex
constructor argument so users can scope them to names they care
about.

The default (null `nameNormaliser`) is the two-step pipeline above.
A user who sets `nameNormaliser` to their own `NameNormaliser`
replaces the whole pipeline — `renames` stops being applied
automatically and the user composes it in themselves if they want it.
That explicit handoff keeps simple profiles simple and advanced
profiles fully in control.

Collisions are never silently resolved: if two raw names land on the
same PHP identifier, generation aborts with both raw keys named.
Users disambiguate via `renames`.

== Consequences

- Adding a value object is a one-file change for the user (the VO itself,
  with the binding attribute on it). No edit to `paogen.php` required.
- The profile file stays small and stable. Most projects' `paogen.php` will
  fit on one screen.
- Adding a *new attribute* (`#[BindsSchema]`, etc.) is a code change in
  paogen — it's not extensible by users without a paogen release. This is
  the explicit cost of keeping the surface declarative.
- The `nameNormaliser` field is the user's extension point for
  anything renaming-adjacent that escapes `renames`'s static-map
  form (pattern-based conventions, external lookup tables, etc.) —
  without it, name normalisation would have to grow into paogen-core
  on every new convention.
