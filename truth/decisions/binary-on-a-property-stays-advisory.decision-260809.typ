#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/schema.context.typ": *

#show: decision.with(
  title: "format: binary on a plain property stays advisory, and uuid is bound by the profile rather than by default",
  status: accepted(2026, 8, 9),
  contexts: (generation-context, schema-context),
  goals: (
    link("../goals/declared-shapes-become-types.goal.typ"),
    link("../goals/user-code-guides-generation.goal.typ"),
  ),
  standards: (link("../standards/generated-types-are-total.standard-260729.typ"),),
)

== Context

`built-in-uuid-and-binary-format-bindings` was filed asking for `uuid` and
`binary` to resolve to a built-in type the way `date-time` already does. Both
halves needed re-deciding rather than implementing, for different reasons.

`date-time` is the only precedent, and it is not a general one. PHP core ships
`DateTimeImmutable`, so binding it cost no consumer a dependency and took no
side on which library is right. Neither `uuid` nor `binary` is in that
position.

== Choice

=== uuid is bound from the profile, and poagen picks nothing

Any `uuid` binding is a dependency decision. A default that reached for
`ramsey/uuid` would force that package on a consumer who already has
`symfony/uid`, or who wants neither; a default that reached for a UUID type
poagen wrote itself would make poagen the author of a value object four mature
libraries already provide, and would still land on the model of a consumer who
wanted theirs.

So `poagen/client-runtime` ships `Format\RamseyUuid` and `Format\SymfonyUuid`
as candidates, both libraries as `suggest` rather than `require`, and neither
binding applies until a `Profile::$formats` entry names one. The advisory for
an unbound `uuid` names both candidates and their packages instead of telling
the consumer to write a value object.

That leaves the property at its base `string` type for anyone who says nothing
— which is what it was already, so no existing consumer's output changes.
`examples/digitalocean` has 66 `format: uuid` sites and its golden tree is
byte-identical after this change.

=== binary on a plain property stays advisory

`format: binary` reaches three positions, and only one of them is asking for a
type poagen could give it.

On a request or response body's own content schema it already drives
behaviour: `represent-non-json-request-and-response-bodies` made
`Emit\BodyMediaType` read it there to give the whole body a
`Psr\Http\Message\StreamInterface` shape, and `Emit\FormatAdvisor` already
treats it as recognised at exactly those nodes rather than by matching the
string.

On a property inside a JSON document, `binary` means raw bytes. PHP's `string`
already is a byte string — it has no encoding of its own, and no length or
content restriction a value object could add that the schema has not already
said. A wrapper here would cost a hop at every access and carry no information
the base type does not.

The third position is the one consumers actually mean when they write `binary`
on a JSON property: base64-encoded bytes. That is `format: byte`, a different
format, and it does want a binding — decoding is `base64_decode()` in strict
mode, encoding is `base64_encode()`, both in core, so unlike `uuid` it costs
nobody a dependency and poagen can bind it by default. It is filed as
`base64-binding-for-format-byte` rather than folded in here, because binding a
format by default and declining to bind one are opposite decisions and should
not arrive in the same change.

== Consequences

A consumer whose document says `format: binary` on a property keeps getting an
advisory notice on every run, and that is the intended end state, not a gap
waiting to be closed. The notice is what tells them the vendor's annotation
went unread; the alternative — binding it to something — would say poagen
understood the annotation when it did not.

`Profile::$formats` exists as a general facility rather than a `uuid` special
case, so any format a consumer has a value object for can be bound
document-wide in one line, without the value object needing a `#[BindsFormat]`
attribute or a namespace under `$discoverIn`.

The `->value` hop that `Format\RamseyUuid` costs is a consequence of
`Marshal\PropertyTypeResolver` recognising a binding by the property's own
declared type, which a third-party class cannot satisfy.
`codec-bindings-for-foreign-value-types` is where that is answered properly;
this decision does not pretend the wrapper is the end state.
