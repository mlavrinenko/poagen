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

== Consequences

- Adding a value object is a one-file change for the user (the VO itself,
  with the binding attribute on it). No edit to `paogen.php` required.
- The profile file stays small and stable. Most projects' `paogen.php` will
  fit on one screen.
- Adding a *new attribute* (`#[BindsSchema]`, etc.) is a code change in
  paogen — it's not extensible by users without a paogen release. This is
  the explicit cost of keeping the surface declarative.
