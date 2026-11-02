#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Ship ready-made uuid bindings and bind a format document-wide from the profile",
  tags: ("generator", "runtime", "dx"),
  priority: 2,
  difficulty: 3,
  status: done(2026, 8, 9),
  links: related(
    "codec-bindings-for-foreign-value-types.task-260809.typ",
  )[the codec contract in that task replaces the boxed bindings this task adds]
    + related(
      "base64-binding-for-format-byte.task-260809.typ",
    )[that task adds the byte binding alongside the uuid ones],
)

== Summary

`date-time` and `date` are the only two format values poagen resolves to a
built-in type (`DateTimeImmutable`, T-010). Every other format, including
`uuid` and `binary` on a plain property, falls through `FormatAdvisor`'s
advisory: the property keeps its base string type and a stderr notice tells
the consumer to bind it themselves via `#[BindsFormat]` on their own value
object. That escape hatch works, but writing a value object per format is
friction, and `uuid` is common enough on real schemas to be worth removing it
for — `examples/digitalocean` alone carries 66 `format: uuid` sites.

This task was originally filed as "give `uuid` a built-in scalar binding, the
same way `date-time` has one". That framing does not survive contact with the
difference between the two formats. `date-time` was free: PHP core ships
`DateTimeImmutable`, so poagen bound it without costing anyone a dependency
and without choosing a library on their behalf. `uuid` has no core PHP type,
so every possible binding is a dependency decision. The original task tried to
have it both ways — its own non-goal said the binding "only needs a canonical
scalar representation, not a dependency on a UUID library" — but the canonical
scalar representation of a UUID *is* a string, which is exactly what poagen
already emits. Satisfied literally, the old task was a no-op.

So the deliverable is reframed. poagen does not write a UUID type and does not
pick one for the consumer. It ships ready-made bindings for the UUID libraries
people already use, and a one-line way to select one — or to select something
else entirely.

== Design

=== Bind a format document-wide from the profile

New `Profile::$formats`: a map of OpenAPI format → binding FQCN, applying
wherever that format appears in the document. The document-wide sibling of
`$propertyFormats` (`bind-a-format-per-property`), which answers the same
question for one property of one model and cannot be scaled to 66 sites.

Precedence, most specific first: `$propertyFormats` → `$formats` →
a scanned `#[BindsFormat]` value object → a poagen built-in. Explicit profile
guidance beats discovery; discovery beats a built-in, which is already true
today and is what lets a consumer swap `DateTimeImmutable` for Carbon.

Entries are validated at load: the class exists and implements
`Runtime\ScalarBinding`. Unlike `$propertyFormats`, which needs the emitted
model names before a key can be checked and so validates in two halves
(`PropertyFormatValidator` plus `Emit\PropertyFormatKeys`), a `$formats` key
is a bare format string with no document knowledge required, so its check is
eager and the failure names the format and the class in one line.

This is the general feature; `uuid` is its first consumer. A consumer binding
any other format document-wide gets it for free.

=== Ready-made bindings in the runtime

`poagen/client-runtime` ships `Poagen\Runtime\Format\RamseyUuid` and
`Poagen\Runtime\Format\SymfonyUuid`, each a `ScalarBinding` wrapping that
library's UUID type. Both libraries go in the runtime's `suggest` and
`require-dev`, never its `require` — a consumer who binds neither pays for
neither, and a consumer who binds one already has that library in their own
`composer.json`.

Wrappers rather than the library type directly, because
`Marshal\PropertyTypeResolver` resolves a binding by reflecting the property's
declared type and testing `is_a($type, ScalarBinding::class)`. Ramsey's
`UuidInterface` and symfony's `Uuid` cannot be the property type as-is, so the
emitted property is the wrapper and the library value hangs off it. Removing
that hop needs a codec kind for foreign types — the property typed
`UuidInterface`, marshalling routed through a registered converter — which
touches `PropertyType`, `Hydrator`, `Marshaller`, `ResponseDecoder`,
`ResponseType`, `WireValueExpr`, `ReturnSpec`, `ScalarFormat` and two
emitters. That generalises well past UUID (Money, Carbon, BigDecimal) and is
worth designing on its own rather than riding in here; see
`codec-bindings-for-foreign-value-types`.

=== No default binding for uuid

poagen binds nothing until the profile says so. A default that used a library
would force that package on every consumer, including the ones who already
have a different one; a default that used no library would mean poagen writing
a UUID type, which is the thing this reframe exists to avoid. So the choice
stays with the consumer and costs them one line.

`FormatAdvisor`'s notice for a format poagen ships a binding for changes
accordingly: instead of only "write your own value object", it names the
ready-made binding and the `Profile::$formats` line that selects it. The
generic notice for every other unrecognised format keeps its current wording,
plus the `$formats` route alongside `#[BindsFormat]`.

=== binary stays advisory

`format: binary` on a plain property gets no binding, and the reason is
recorded as a decision rather than left implicit. Three cases, none of which
wants a value object:

- On a request or response body's own content schema it already drives
  behaviour — `BodyMediaType` reads it to give the body a
  `Psr\Http\Message\StreamInterface` shape
  (`represent-non-json-request-and-response-bodies`), and `FormatAdvisor`
  already treats it as recognised there.
- On a property inside a JSON document, `binary` means raw bytes, and PHP's
  `string` already is exactly that type. A wrapper would add a hop and no
  information.
- Base64 inside JSON is `format: byte`, a different format. That one is worth
  a binding and it is dependency-free, but it is a separate task
  (`base64-binding-for-format-byte`), not this one.

== Acceptance criteria

- `Profile::$formats` binds a format document-wide to a `ScalarBinding` FQCN,
  and a schema property carrying that format emits with the bound type on both
  the request and the response path, without the consumer writing a value
  object of their own.
- Precedence holds and is tested: a `$propertyFormats` entry beats a `$formats`
  entry for the same property; a `$formats` entry beats a scanned
  `#[BindsFormat]` value object for the same format; both beat a built-in.
- A `$formats` entry naming a class that does not exist, or one that exists but
  does not implement `ScalarBinding`, fails the run naming the format and the
  class. Both refusals are tested.
- `poagen/client-runtime` ships `Format\RamseyUuid` and `Format\SymfonyUuid`,
  each round-tripping its library's type through `fromScalar()` / `toScalar()`
  under its own unit test. Neither library appears in the runtime's `require`.
- `FormatAdvisor` emits no `uuid` notice for a document whose `uuid` format is
  bound through `$formats`, and its notice for an unbound `uuid` names the
  ready-made bindings and the profile line.
- A fixture profile and golden tree demonstrate a bound `uuid` end to end.
  `examples/digitalocean` stays as it is — 66 sites is a golden-tree rewrite
  this task does not need to carry.
- `format: binary` on a plain property still produces an advisory notice and no
  binding, and the reasoning is recorded in
  `truth/decisions/`.
- `README.md` documents `Profile::$formats`, both ready-made bindings, and the
  shape of a hand-written binding for a third library.
- `just check`, `just check-examples` and `just verify-runtime-standalone`
  green end-to-end.

== Non-goals

- A default binding for `uuid`. Covered above: poagen picks nothing.
- Any format other than `uuid` and `binary`. `$formats` is general, so others
  work, but nothing else ships a ready-made binding here.
- A codec kind that lets a property be typed as a foreign class directly. Own
  task, `codec-bindings-for-foreign-value-types`.
- A `format: byte` base64 binding. Own task, `base64-binding-for-format-byte`.
- Changing how `format: binary` is read on a request or response body's own
  content schema. That is `BodyMediaType`'s job and already ships.

== Files

- `src/Generator/Profile.php`
- `src/Generator/Bindings.php`
- `src/Generator/AttributeScanner.php`
- `src/Generator/Emit/FormatAdvisor.php`
- `runtime/src/Format/RamseyUuid.php`
- `runtime/src/Format/SymfonyUuid.php`
- `runtime/composer.json`
