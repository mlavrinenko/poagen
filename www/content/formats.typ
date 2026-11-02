#import "/templates/page.typ": page
#import "/utils/site.typ": u

#let meta = (
  title: "Formats and value objects",
  summary: "Built-in date, date-time and byte handling, opt-in UUID codecs, and your own value objects bound per format or per property.",
)
#metadata(meta) <page-meta>

#show: page.with(..meta)

OpenAPI's `format` is an open string. poagen treats it the same way: a few
values have built-in bindings, a few are opt-in, and everything else keeps its
base type while the run names it on stderr.

= Built in

#table(
  columns: 3,
  table.header([Format], [PHP type], [Where it comes from]),
  [`date-time`], [`DateTimeImmutable`], [`Built in`],
  [`date`], [`DateTimeImmutable`], [`Built in`],
  [`byte`], [`string` holding decoded bytes], [`Built in, via Base64Codec`],
  [`uuid`], [the codec's target type], [`Opt-in: RamseyUuidCodec or SymfonyUuidCodec`],
)

`byte` decodes with `base64_decode()` in strict mode and encodes with
`base64_encode()`. A payload that is not valid base64 fails naming the
property. `uuid` applies only when the profile names a codec, because PHP has
no core UUID type and a binding is a dependency decision.

= Your own value object

Implement `Poagen\Runtime\ScalarBinding` and name the class in the profile:

```php
final readonly class Ulid implements ScalarBinding
{
    public function __construct(public string $value) {}

    public static function fromScalar(mixed $raw): self { /* validate */ }

    public function toScalar(): string { return $this->value; }
}
```

```php
return new Profile(
    // ...
    formats: ['ulid' => Ulid::class],
);
```

A foreign type, one you cannot make implement `ScalarBinding`, binds through
`Poagen\Runtime\Codec` instead. The property is declared as the codec's own
target type, never a wrapper:

```php
final readonly class MoneyCodec implements Codec
{
    public static function targetType(): string { return Money::class; }

    public static function decode(mixed $wire): Money { /* parse */ }

    public static function encode(mixed $value): mixed { /* format */ }
}
```

= Three routes, most specific first

#table(
  columns: 2,
  table.header([Route], [Reach]),
  [`Profile::$propertyFormats`], [`one property of one model, keyed '<ModelClass>.<wireName>'`],
  [`Profile::$formats`], [`every property carrying that format, document-wide`],
  [`#[BindsFormat] + Profile::$discoverIn`], [`same reach, discovered by scanning your namespaces`],
)

All three beat a built-in, so swapping `DateTimeImmutable` for Carbon is one
entry. A per-property entry exists because a format string can cover unrelated
meanings: `double` in one document is a price, a quantity and a percentage.

= Dates without an offset

RFC 3339 requires an offset, and real documents omit it. PHP then resolves the
value against the process timezone, so the same payload means different
instants on your laptop and in a UTC container. Say which zone it means:

```php
$transport = new HttpTransport(
    ApiClient::SERVER_1,
    ApiException::class,
    context: new BindingContext(naiveZone: new DateTimeZone('Europe/Moscow')),
);
```

The zone applies only where the vendor sent no offset. A value carrying
`+05:00` keeps it.

#table(
  columns: 2,
  table.header([Route], [Use when]),
  [`BindingContext` at construction], [`the zone belongs to the installation, not the document`],
  [`Profile::$dateTimeZone`], [`the vendor fixed one zone for the document; emitted as ApiClient::NAIVE_TIMEZONE`],
)

The profile constant is a value you pass to the context. The transport is
yours to construct, so poagen does not apply it for you.
