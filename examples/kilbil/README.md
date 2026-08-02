# kilbil loyalty — acceptance target

The vendor's OpenAPI document for the kilbil loyalty API, committed exactly as
published at <https://docs.kilbil.ru/openapi/loyalty_v1.yaml>. It is not
reformatted, trimmed, or bundled through a normaliser — see the
`fixtures-are-unmodified-vendor-documents` standard.

This example exists because it is hard in the specific ways real documents are
hard, and paogen's claim to work is measured against it rather than against
Petstore.

## What makes it a real test

**Declares OpenAPI 3.1 and uses exactly one 3.1 construct, 87 times.** The
construct is `type: [T, "null"]`, JSON Schema's way of saying nullable:

```
array:["string","null"]  => 48    string:string  => 248   string:object  => 146
array:["integer","null"] => 26    string:integer => 140   string:number  =>  77
array:["array","null"]   => 12    string:array   =>  43   string:boolean =>   9
array:["number","null"]  =>  1
```

Nothing else from 3.1 appears: no `const`, no `prefixItems`, no
`unevaluatedProperties`, no `$defs`, no plural `examples`, and no 3.0-style
`nullable:` either.

Two earlier versions of this file got this wrong in opposite directions, and
both wrong versions informed the backlog, so it is worth being precise about
which part of the original claim held.

The part that held: paogen has no version gate. It never inspects
`$openApi->openapi` and never calls `validate()`, so the document parses
cleanly and reaches the emitters. The parser swap is not what blocks this
client, and `swap-openapi-parser-for-31-support` stays postponed.

The part that did not: this file previously asserted "no `type: [T, "null"]`"
in as many words, and structurally called it a 3.0 document. It is not one.
`cebe/php-openapi` hands the list over verbatim as a PHP array while declaring
`Schema::$type` as `string`, so every `is_string($schema->type)` guard in the
generator missed it and 87 properties the vendor had typed fell through to
`mixed` — with 11 inline enums lost on the same guard. Reading the list needed
no parser swap, only for paogen to read what the parser already handed over;
`nullable-type-arrays` is that work.

**No named components at all.** `components/schemas` is empty. Every payload is
declared inline at its use site: 29 inline JSON request bodies and 71 inline
JSON response schemas across the 36 operations. paogen's model planner works by
walking the component catalogue, so against this document it has nothing to walk
and emits no models whatsoever. Roughly a hundred model names have to be
synthesised, which is what makes the naming rule load-bearing rather than
cosmetic — a collision here silently overwrites an emitted file.

**Cyrillic tags.** All eleven operation tags are Russian words — `Клиенты`,
`Операции`, `Подарочные сертификаты`. Tags become sub-client names, so this
example is what forces tag-to-identifier normalisation and the profile-level
tag renaming that goes with it. A generator that assumes ASCII tags either
emits unusable type names or falls over.

**One tag per operation.** All 36 operations carry exactly one tag and none are
untagged, so the multi-tag and untagged paths need a different fixture to
exercise.

**operationIds that cannot be split by machine.** `searchclient`,
`getclientfullbalance`, `checkconfirmphonecode`, `goodslistxml`. All lowercase,
run together, no separators. `getclientfullbalance` has no algorithmic path to
`getClientFullBalance` without a dictionary, and guessing would produce a
different wrong answer per schema. Two do carry separators — `generate_promocode`
and `legal_info` — so snake_case handling still matters. The honest consequence
is that a readable method name here comes from consumer guidance, not from a
generator heuristic.

**Two XML request bodies.** 32 operations take `application/json`, two take
`application/xml` (`goodsxml`, `goodslistxml`, the XML twins of `goods` and
`goodslist`), and two take no body. Every response on every operation is
`application/json`, so XML is request-only.

Neither the schema nor `xml:` metadata name a root or item element for either
body — this document carries no `xml:` metadata at all — but both request
bodies carry a literal `example: |` block with a full XML sample, in
`schemas/loyalty_v1.yaml` around line 4305 (`/load/goodsxml`) and line 4570
(`/load/goodslistxml`). paogen never makes a live call to settle this kind of
question, but the vendor document already answers it: `goodsxml` roots at
`<goods>` with repeated item `<good>`, and `goodslistxml` roots at
`<goodslist>` with repeated item `<goodlist>`. `examples/kilbil/paogen.php`'s
`xmlElements` carried `goodslistxml.item => good` until this was checked
against the sample — wrong, fixed to `goodlist`.

Both samples nest one level further, an `<inside>` wrapper inside an item
holding more items of the same element name. `xmlElements` cannot express
that: it names one root and one item element per operation, and the
generated client's `XmlWriter` unwraps a nested array property by repeating
the property's own name, not by wrapping same-named children in a container.
A request that populates `inside` would not serialise into the vendor's
shape. This is a real limitation of the flat root/item mapping, not
something this change fixes — see the profile comment above `xmlElements`
in `paogen.php`.

**Formats that are mostly not OpenAPI formats.** Nine distinct values across 292
uses: `int` (166), `double` (94), `date time` (15), `date` (9), `phone` (4),
`data time` (3), `time` (2), `email` (2), `data` (1). Only `date` matches a
paogen built-in. `date time` is a misspelling of `date-time` with a space, and
`data`/`data time` look like further typos of it. A generator that silently
ignores an unrecognised format loses 15 timestamps quietly; one that aborts on
each loses the whole client. This is what `report-unrecognised-formats` is for,
and `#[BindsFormat('date time')]` is the mechanism a consumer repairs it with.

**Uniform, tiny error surface.** Every operation declares exactly two responses:
`200` and `403`, both JSON. So the generic `ApiException` is sufficient here and
typed-per-schema exceptions buy nothing — which is why that question stays
deferred rather than guessed at.

**Authentication is a query-string API key.** One security scheme, `h`, of type
`apiKey`, `in: query`, applied globally rather than per-operation. Six other
query parameters exist across the whole document, and there are no path, header,
or cookie parameters at all.

## Status

Generating. All 36 operations, nothing skipped, `generated/` committed:

```
php bin/paogen generate examples/kilbil/paogen.php   # exits 0
just check-examples                                  # ✅ kilbil: no drift
```

185 files: 11 tag sub-clients and their interfaces, the root client and its
interface, `ApiException`, 104 synthesised models and 53 synthesised enums. The
generated tree passes `just lint-phpstan-generated` — max level, no baseline, no
`excludePaths`, no `ignoreErrors` — and two consecutive runs produce byte-identical
output.

## What the profile has to say, and what it does not

`paogen.php` is the demonstration that guidance shapes output. Delete everything
below `namespace:` and generation still succeeds; the client is only less pleasant
to call. What is there, and why:

| Guidance | Answers |
|---|---|
| `discoverIn` + `src/ValueObject/` | Four of the nine format values: `date time`, `data time`, `data`, `phone`. 23 properties gain a real type. |
| `methodRenames` (33 entries) | Operation ids with no word boundary. `getclientfullbalance` becomes `getClientFullBalance` — and so do its models. |
| `tagRenames` (10 entries) | Russian tag names. `Клиенты` becomes `CustomersClient` rather than `KlientyClient`. |
| `xmlElements` (4 entries) | The XML root and item elements OpenAPI supplies no default for, confirmed against the vendor's own embedded XML samples (see "Two XML request bodies" above). |

Three operation ids are deliberately absent from `methodRenames`, and one tag from
`tagRenames`. `generate_promocode` and `legal_info` carry real separators, `goods`
is a single word, and `Wallet` was already ASCII — listing any of them would hide
whether the defaults work.

`int` (172 uses) and `double` (94) stay unbound, and unlike the four formats above
that is not free. A `#[BindsFormat]` binds a format string document-wide — one PHP
type per format, everywhere it appears — and `double` here covers prices,
quantities, rates and percentages alike: `goods_data/items/properties/price` is
money, `quantity` on the same object is not, and `bonus_percent`,
`discount_percent`, `purchases_sum` and the rest are neither. A `Money` bound to
`double` would type every one of those as money too, with no way to exempt the
ones that are not — a worse defect than the float price it was meant to fix. `int`
is the same shape with less at stake, so it is decided the same way.

`goods_data/items/properties/price` is the property where that is a real
limitation, not a shrug: it reaches the consumer as a plain PHP `float`, and money
in a `float` is a defect, not a style choice. There is no per-property fix while
`double` still means several other things in this document. A consumer who needs
`price` money-safe today has to do it after paogen: bind their own value object to
`double` only if their own document spends that format on money alone, or narrow
`price` to a `Money` type by hand right after hydration, leaving the rest of the
document's doubles as floats.

## The wrapper, proven rather than described

`src/PhoneConfirmation.php` implements `ConfirmationCodesClientInterface` — the
contract emitted for the vendor's `Код подтверждения` tag — delegates both calls to
the generated implementation, and adds `isCodeValid(PhoneNumber, string): bool`,
which the generator has no way to write.

Nothing under `generated/` changed to allow that: no hook, no protected region, no
subclass. And `just lint-phpstan-generated` analyses `src/` at max level too, so if
a regeneration renamed `checkConfirmPhoneCode` the wrapper would stop satisfying its
interface and the gate would say so. That is what makes the seam a contract rather
than a convention.

## Authentication

The document's only security scheme is a query-string `apiKey` named `h`, applied
globally, and it threads through: every client takes an `$h` constructor argument
and every request appends `h=<urlencoded key>` to its query string, joining the
operation's own parameters rather than producing a second `?`.

This was a silent-failure bug until `query-apikey-security-scheme` landed — paogen
recognised `apiKey` only with `in: header`, so the emitted client took no
credential, sent no credential, and exited 0. Every call would have come back 403.
