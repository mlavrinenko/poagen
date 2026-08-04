# Runtime type reflection — library survey

**Status:** exploration note feeding `attribute-and-phpdoc-driven-serialization`
**Date:** 2026-04-20
**Author:** design session with project owner

## Purpose

`attribute-and-phpdoc-driven-serialization` decides that poagen's runtime
will parse PHPStan-style phpdoc annotations to drive hydration and
marshalling, instead of the per-class `PROPERTY_MAP` constant introduced by
`hydration-and-serialization-contract`. This note
captures the library survey that informed the choice between three
candidate approaches, so future sessions do not redo the
investigation:

1. `typhoon/type` + `typhoon/reflection`
2. `phpstan/phpdoc-parser` directly
3. Hand-rolled parser

The headline result: *we use `phpstan/phpdoc-parser` directly.*
Typhoon is elegant but currently mid-rewrite upstream and imposes a
large dependency footprint on every poagen consumer. Hand-rolling a
parser reinvents a wheel the community already maintains well.

## What poagen actually needs at runtime

Enumerated across every phpdoc type the generator emits today in the
petstore and GitHub golden trees, the full surface is:

- `?list<FQCN>` / `list<FQCN>` / `list<string>` / `list<Enum>`
- `?array<string, FQCN>`
- `?array<string, mixed>` / `?array<string, array<string, mixed>>`
- nullable-union prefix

That is it. No `non-empty-string`, no `int<0, max>`, no
`class-string`, no templates, no conditional types. The parser's job
is small.

Structural needs:

- Nullability (from native type or phpdoc union-with-null)
- `list<T>` — element type `T` as a resolvable class name or scalar
- `array<K, V>` — key and value types
- Resolve class aliases against the surrounding `use` clauses

Non-structural facts (format hints, wire-name overrides, discriminator
fields) are carried by PHP attributes and do *not* need the phpdoc
parser — see `attribute-and-phpdoc-driven-serialization`'s attribute
vocabulary.

## Candidate 1: typhoon/type + typhoon/reflection

`typhoon/type` is a pure type-representation library: constructors,
a `TypeVisitor`, and a `stringify()` function. It has *no parser*;
verified by reading the source (0.8.0) and grepping for `parse`,
`Parser`, `fromString` — all absent.

`typhoon/reflection` *does* parse phpdoc, internally wrapping
`phpstan/phpdoc-parser`. Confirmed by a probe against a PHP class
with a variety of phpdoc shapes (see probe output below).

**What worked**

```
dates   -> list<DateTimeImmutable>
map     -> array<string, \stdClass>
counts  -> array<string, int<0, max>>
status  -> non-empty-string refined correctly
```

The Visitor pattern is pleasant: subclass `DefaultTypeVisitor`,
override `list()`, `array()`, `namedObject()`, etc., and reduce a
type to whatever descriptor the caller wants.

**What disqualified it for now**

- Latest *stable* `typhoon/reflection` is `0.4.4`, released
  2023-03-01. It requires `typhoon/type ^0.4.4`, which is
  **incompatible with `typhoon/type ^0.8.x`** — upstream is mid-
  rewrite with no reflection companion yet for the 0.8 line.
- Installing `typhoon/reflection 0.4.4` brings seven transitive
  packages: `typhoon/type`, `typhoon/declaration-id`,
  `typhoon/typed-map`, `typhoon/change-detector`,
  `phpstan/phpdoc-parser`, `psr/simple-cache`, and the reflection
  package itself.
- Every poagen consumer would inherit that footprint in `vendor/`.

If typhoon's upstream settles and ships a reflection companion on the
0.8.x (or later) line with an active release cadence, re-evaluate.
The Visitor pattern is a clean target to migrate to.

## Candidate 2: phpstan/phpdoc-parser directly

`phpstan/phpdoc-parser` is the parser typhoon/reflection wraps. It
is actively maintained, ubiquitous in the PHPStan ecosystem, and
MIT-licensed. Most PHP projects of any size already ship it
transitively.

Adding it to poagen's runtime is a **+1 package** increment. It ships
an AST (`PhpDocNode`, `PhpDocTagNode`, `TypeNode` and subtypes like
`IdentifierTypeNode`, `GenericTypeNode`, `UnionTypeNode`,
`NullableTypeNode`). A small visitor (~50 LOC) pattern-matches these
into poagen's internal descriptor shape.

**Recommended integration sketch (for the Hydrator / Marshaller):**

1. `ReflectionProperty::getDocComment()` returns the raw phpdoc (or
   `false` if opcache stripped comments).
2. If comments are stripped: open `ReflectionClass::getFileName()`,
   tokenise with `token_get_all`, and extract the phpdoc preceding
   the target property. Same strategy typhoon uses internally.
3. Tokenise the phpdoc with `Lexer`, parse with `PhpDocParser`,
   iterate `@var` / `@param` tags, walk the `TypeNode` AST.
4. Resolve identifier nodes against the class's `use` imports (via
   `ReflectionClass::getFileName()` token scan, cached per file).
5. Cache the resulting descriptor per class in a `static` map inside
   the Hydrator. One parse per class per process.

**Tradeoffs**

- Pro: one dep, active upstream, well-documented AST.
- Pro: exactly the set of features we need — PHPStan's documented
  grammar is a superset.
- Con: we own the AST → descriptor translation. ~50 LOC of visitor
  code to write and test.
- Con: `use` import resolution is not a freebie — tokenising the
  source file is part of the job.

## Candidate 3: Hand-rolled parser

Given how narrow our real grammar is (`?list<T>`, `?array<K,V>`,
nullable-union), a hand-rolled parser is maybe 80 LOC. Zero deps.

Rejected on principle: we are not in the business of owning a parser
the community maintains. The "dependencies pull their weight"
policy in `attribute-and-phpdoc-driven-serialization` rules this out.

## Conclusion

Adopt **`phpstan/phpdoc-parser` directly**. It is the right-sized
dependency; it is the parser typhoon wraps internally; it is
actively maintained; it supports the full PHPStan grammar without
our needing to care which subset we emit.

If typhoon's upstream stabilises on a single supported line and
ships a reflection companion for `typhoon/type ^0.8.x` (or later),
revisit — the Visitor pattern is a clean migration target and
typhoon's type-tree representation is nicer to work with than raw
phpdoc-parser `TypeNode`s.

## Probe appendix (reproducible)

The following probes were run during exploration and then removed.
They are documented here so a future session can recreate them
quickly.

### Probe 1: confirm typhoon/reflection parses phpdoc

```
// composer require typhoon/reflection:^0.4.4

use Typhoon\Reflection\TyphoonReflector;

final class Probe
{
    /** @var list<DateTimeImmutable>|null */
    public ?array $dates = null;

    /** @var array<string, \stdClass>|null */
    public ?array $map = null;

    /** @var non-empty-string|null */
    public ?string $status = null;
}

$reflector = TyphoonReflector::build();
$class = $reflector->reflectClass(Probe::class);
foreach ($class->properties() as $name => $prop) {
    echo "$name -> " . stringify($prop->type()) . "\n";
}
```

Output:

```
dates  -> list<DateTimeImmutable>|null
map    -> array<string, \stdClass>|null
status -> (non-empty-string)|null
```

### Probe 2: introspect via the TypeVisitor

A `DefaultTypeVisitor` subclass reduces a `Type` into a descriptor
array. Key methods to override:

- `list(Type $type, Type $valueType, array $elements): mixed`
- `array(Type $type, Type $keyType, Type $valueType, array $elements): mixed`
- `namedObject(Type $type, NamedClassId|AnonymousClassId $classId, array $typeArguments): mixed`
- `union(Type $type, array $ofTypes): mixed` (flatten the null branch
  to extract nullability)

Output against a typical model:

```
dates: {"kind":"list","item":{"kind":"object","class":"DateTimeImmutable"},"nullable":true}
map:   {"kind":"map","key":"string","value":{"kind":"object","class":"stdClass"},"nullable":true}
when:  {"kind":"object","class":"DateTimeImmutable","nullable":true}
```

This is the shape the poagen Hydrator / Marshaller wants. With
`phpstan/phpdoc-parser` we synthesise the same descriptor directly
without going through typhoon's intermediate representation.
