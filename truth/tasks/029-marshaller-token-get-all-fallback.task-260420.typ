#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "49c02657-8834-4baf-8b0b-30191e964244",
  title: "Marshaller/Hydrator: token_get_all phpdoc fallback for opcache-stripped comments",
  status: done(2026, 4, 20),
  priority: 5,
  x-paogen: (spec: "truth/specs/model-generator.typ", legacy-id: "T-029"),
)

== Summary

`DescriptorParser` reads constructor `@param` phpdoc through
`ReflectionMethod::getDocComment()`. When opcache is configured with
`opcache.save_comments=0` the call returns `false` and the runtime
treats the constructor as "no phpdoc" — element types in
`list<Tag>` / `array<string, Foo>` are then unknown and the
hydrator silently downgrades the property to a passthrough.

T-028 landed without the token-rescan fallback under the dirty-fix
budget. This task adds it.

== Repro

```bash
php -d opcache.enable_cli=1 -d opcache.save_comments=0 \
    bin/paogen generate examples/petstore/paogen.php
```

Then hydrate a payload whose `Pet.tags` is a list of objects:

```php
$pet = new Hydrator()->hydrate(Pet::class, ['name' => 'x',
  'photoUrls' => [], 'tags' => [['id' => 1, 'name' => 'a']]]);
var_dump($pet->tags[0] instanceof Tag); // expected: true
                                        // observed: false (raw array)
```

== Scope

+ When `ReflectionMethod::getDocComment()` returns `false`, read the
  declaring file from disk (`ReflectionMethod::getFileName()`) and
  re-tokenise via `token_get_all`. Locate the `T_DOC_COMMENT` token
  immediately preceding the `T_FUNCTION` whose name matches.
+ Cache the rescanned doc string per file so each constructor pays
  the cost at most once per process.
+ Add a unit test that loads a fixture compiled with stripped
  comments (write a minimal eval-with-stripped-doc helper or use
  `php_strip_whitespace()` to simulate).
+ Document the fallback in
  #link("../decisions/attribute-and-phpdoc-driven-serialization.decision-260420.typ")[Attribute + phpdoc-driven marshal/unmarshal; Model classes stay clean].

== Non-goals

- A persistent cache file (warm-up across processes). Keep the cache
  in-process; revisit if benchmarks demand it.

== Acceptance criteria

- `just check` green; new unit test exercises the stripped-comment
  path explicitly.
- Petstore Pet hydrates with `Tag` instances on
  `opcache.save_comments=0`.
