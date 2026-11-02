# kilbil loyalty — acceptance target

The vendor's OpenAPI document for the kilbil loyalty API, committed exactly as
published at <https://docs.kilbil.ru/openapi/loyalty_v1.yaml>. It is not
reformatted, trimmed, or bundled through a normaliser — see the
`fixtures-are-unmodified-vendor-documents` standard.

This example exists because it is hard in the specific ways real documents are
hard, and poagen's claim to work is measured against it rather than against
Petstore.

The client this example generates is published as
[`maximaster/kilbil-client`](https://github.com/maximaster/kilbil-client).
This directory remains the acceptance target — that is what the example is for
— and this repository's gates regenerate and check it.

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

The part that held: poagen has no version gate. It never inspects
`$openApi->openapi` and never calls `validate()`, so the document parses
cleanly and reaches the emitters. The parser swap was never what blocked this
client.

The part that did not: this file previously asserted "no `type: [T, "null"]`"
in as many words, and structurally called it a 3.0 document. It is not one.
`cebe/php-openapi` handed the list over verbatim as a PHP array while declaring
`Schema::$type` as `string`, so every `is_string($schema->type)` guard in the
generator missed it and 87 properties the vendor had typed fell through to
`mixed` — with 11 inline enums lost on the same guard. Reading the list needed
no parser swap, only for poagen to read what the parser already handed over;
`nullable-type-arrays` is that work, and it landed before the swap did.

The swap has since landed anyway (`swap-openapi-parser-for-31-support`):
poagen parses through `devizzent/cebe-php-openapi`, which declares
`Schema::$type` as `string|string[]` — the shape this document was always
using. Every type above is emitted byte-identically before and after,
which is how the swap was checked.

**No named components at all.** `components/schemas` is empty. Every payload is
declared inline at its use site: 29 inline JSON request bodies and 71 inline
JSON response schemas across the 36 operations. poagen's model planner works by
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
(`/load/goodslistxml`). poagen never makes a live call to settle this kind of
question, but the vendor document already answers it: `goodsxml` roots at
`<goods>` with repeated item `<good>`, and `goodslistxml` roots at
`<goodslist>` with repeated item `<goodlist>`. `examples/kilbil/poagen.php`'s
`xmlElements` carried `goodslistxml.item => good` until this was checked
against the sample — wrong, fixed to `goodlist`.

Both samples nest one level further, an `<inside>` wrapper inside an item
holding more items of the same element name. `xmlElements` names that too:
`'goodsxml.item.inside' => 'good'` and `'goodslistxml.item.inside' =>
'goodlist'` tell poagen that `inside` is a container wrapping repeated
`good`/`goodlist` children, rather than OpenAPI's unwrapped default of
repeating `inside` itself as a sibling once per entry
(kilbil-xml-nesting-is-unrepresentable). poagen validates these entries
against the schema — a property absent from the item schema fails the run —
and wires them onto the generated call itself: `goodsXml()`/`goodsListXml()`
emit `->xmlList($body, 'goods', 'good', ['inside' => 'good'])` (and the
`goodlist` equivalent), so a caller who passes a populated `inside` gets the
vendor's nested shape from the plain client shown above — no `XmlWriter` to
construct, no map to keep in step with the profile by hand
(thread-the-validated-nested-container-map-into-the-generated-client).

`tests/Integration/Kilbil/KilbilXmlNestedContainerTest.php` proves the
emitted XML against both vendor samples, structurally rather than by eye.

**Formats that are mostly not OpenAPI formats.** Nine distinct values across 292
uses: `int` (166), `double` (94), `date time` (15), `date` (9), `phone` (4),
`data time` (3), `time` (2), `email` (2), `data` (1). Only `date` matches a
poagen built-in. `date time` is a misspelling of `date-time` with a space, and
`data`/`data time` look like further typos of it. A generator that silently
ignores an unrecognised format loses 15 timestamps quietly; one that aborts on
each loses the whole client. This is what `report-unrecognised-formats` is for,
and `#[BindsFormat('date time')]` is the mechanism a consumer repairs it with.
The count for `double` still reads 94 after `propertyFormats` binds `Money` to
two of them — the report counts a *format string*, document-wide, and a
per-property binding answers for one property without changing what the format
string means anywhere else; see "What the profile has to say" below.

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
php bin/poagen generate examples/kilbil/poagen.php   # exits 0
just check-examples                                  # ✅ kilbil: no drift
```

185 files: 11 tag sub-clients and their interfaces, the root client and its
interface, `ApiException`, 104 synthesised models and 53 synthesised enums. The
generated tree passes `just lint-phpstan-generated` — max level, no baseline, no
`excludePaths`, no `ignoreErrors` — and two consecutive runs produce byte-identical
output.

## Using the generated client

The document declares one server, `https://bonus.kilbil.ru`, and poagen reads
it onto the client as a constant instead of leaving it for a consumer to copy
out of the schema by hand:

```php
use Acme\Kilbil\Generated\ApiClient;
use Acme\Kilbil\Generated\ApiException;
use Poagen\Runtime\Http\HttpTransport;

$client = new ApiClient(
    new HttpTransport(ApiClient::SERVER_1, ApiException::class),
    h: getenv('KILBIL_API_KEY'),
);
```

`ApiClient::SERVER_1` is a value, not wiring — the transport still takes the
base address as a plain constructor argument, so a test server or a staging
host is still a different string away. See "Authentication" below for what
`$h` carries and why it is a constructor argument rather than a header.

## What the profile has to say, and what it does not

`poagen.php` is the demonstration that guidance shapes output. Delete everything
below `namespace:` and generation still succeeds; the client is only less pleasant
to call. What is there, and why:

| Guidance | Answers |
|---|---|
| `discoverIn` + `src/ValueObject/` | Four of the nine format values: `date time`, `data time`, `data`, `phone`. 23 properties gain a real type. |
| `propertyFormats` (2 entries) | Binds `Money` to `price` alone, on the two models where it is unambiguously money — see below. |
| `methodRenames` (33 entries) | Operation ids with no word boundary. `getclientfullbalance` becomes `getClientFullBalance` — and so do its models. |
| `tagRenames` (10 entries) | Russian tag names. `Клиенты` becomes `CustomersClient` rather than `KlientyClient`. |
| `xmlElements` (6 entries) | The XML root, item, and nested-container elements OpenAPI supplies no default for, confirmed against the vendor's own embedded XML samples (see "Two XML request bodies" above). |

Three operation ids are deliberately absent from `methodRenames`, and one tag from
`tagRenames`. `generate_promocode` and `legal_info` carry real separators, `goods`
is a single word, and `Wallet` was already ASCII — listing any of them would hide
whether the defaults work.

`int` (172 uses) and `double` (94) stay unbound *document-wide*, and unlike the
four formats above that is not free. A `#[BindsFormat]` binds a format string
everywhere it appears in the document, and `double` here covers prices,
quantities, rates and percentages alike: `goods_data/items/properties/price` is
money, `quantity` on the same object is not, and `bonus_percent`,
`discount_percent`, `purchases_sum` and the rest are neither. A `Money` bound to
`double` that way would type every one of those as money too, with no way to
exempt the ones that are not — a worse defect than the float price it was meant
to fix. `int` is the same shape with less at stake, so it is decided the same way
and stays unbound.

`price` on `goods_data` no longer pays for that, though. It is unambiguously
money — the vendor's own description says so ("цена без скидки за единицу
номенклатуры", "price per unit, before discount") — declared on exactly two
shapes: the request bodies `searchclient` and `processsale` both accept, which
poagen synthesises as `SearchClientRequestContentGoodsDataItem` and
`ProcessSaleRequestContentGoodsDataItem` (`components.schemas` is empty in this
document, so neither has a raw component name of its own — see "No named
components at all" above). `propertyFormats` binds `Money` to `price` on both,
keyed by the class name poagen assigns each rather than by a document name that
does not exist (`bind-a-format-per-property`), and does so without touching what
`double` means anywhere else: `quantity` on the same two models,
`price1`..`price5` on `GoodsRequestContentItem`, and every other `double`-typed
field in the document are still a plain `float`. Money in a `float` was a defect
here, not a style choice, and this is the fix rather than a documented shrug —
inferring which *other* fields are money is a different question this profile
does not answer, because the vendor did not say and a guess would be exactly the
kind of inference `cheap-regeneration` forbids.

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

What `isCodeValid` reads is a `result_code` the vendor puts inside a 200 body, and
poagen deliberately does nothing with it. The document never marks that property as
a failure signal — a generator acting on it would be acting on vendor knowledge it
was never given, and a wrong guess turns a call that succeeded into a thrown
exception. So the payload envelope stays the consumer's business, and this wrapper
is the shape that answer takes; see
`truth/decisions/payload-envelope-stays-the-consumers-business.decision-260804.typ`.

## Authentication

The document's only security scheme is a query-string `apiKey` named `h`, applied
globally, and it threads through: every client takes an `$h` constructor argument
and every request appends `h=<urlencoded key>` to its query string, joining the
operation's own parameters rather than producing a second `?`.

This was a silent-failure bug until `query-apikey-security-scheme` landed — poagen
recognised `apiKey` only with `in: header`, so the emitted client took no
credential, sent no credential, and exited 0. Every call would have come back 403.

## Corrections against the live API

The vendor's document was checked against the real test API for the first time on
2026-08-05 (`reconcile-the-kilbil-schema-with-what-the-live-api-actually-sends`),
using a live credential restricted to read-only calls. Two classes of defect
surfaced, both describing an API the vendor's document does not actually serve.
Both are corrected in this repository's copy of `schemas/loyalty_v1.yaml` — a
deliberate, recorded exception to `fixtures-are-unmodified-vendor-documents` —
rather than reported upstream; see the task file for why. `addclient`,
`processsale`, `confirmsale`, `askconfirmphone` and `checkconfirmphonecode` could
not be re-verified live: the credential is read-only-safe calls only, and every
one of those five mutates state or sends an SMS.

**`result_code`: one field name, two JSON kinds, same document.** Every
operation's success (`200`) response carries a `result_code` the document
declared `type: string`. The wire disagrees by operation, observed 2026-08-05:

| Operation | Case | Vendor declares | Wire sends |
|---|---|---|---|
| `getprograms` | success | `type: string` | JSON int `0` |
| `searchclient` | not found | `type: string` | JSON string `"6"` |
| `searchclient` | found | `type: string` | JSON string `"0"` |
| `getdetailingbymove` | not found | `type: string` | JSON int `1` |
| `getdetailingbymove` | found | `type: string` | JSON int `0` |

Three operations disagree with the same declaration three different ways. All 30
`200`-response occurrences of `result_code` in the document are now
`type: [string, integer]` — corrected by pattern for the 27 not directly
exercised, since the same field name is already proven to vary two different
ways and a wrong type crashes hydration outright rather than degrading. The
`403` responses' `result_code` (always `type: integer`, 36 occurrences) were left
alone: never observed to disagree, and every 403 body already agrees with its
own declaration.

`type: [string, integer]` was chosen over two alternatives considered and
rejected:

- `anyOf: [{type: string}, {type: integer}]` resolves to the identical PHP type
  (`string|int`) through a different code path
  (`CompositionResolver::resolveScalarUnion`), but introduces a second OpenAPI
  3.1 construct into a document this README already documents as using exactly
  one (`type: [T, "null"]`, "What makes it a real test" above). No benefit for
  the extra construct.
- Dropping `type` entirely resolves to `mixed`, which works but is strictly less
  precise: it also accepts booleans, arrays and objects the field will never
  actually hold.

Verified empirically, not assumed: regenerating with `type: [string, integer]`
emits `public string|int $result_code` (`SchemaType::isScalarUnion()` /
`unionPhpType()`), and `PropertyTypeResolver::resolveUnion()` treats a union of
builtins as passthrough — the `Hydrator` never attempts a coercion, so whichever
JSON kind the wire sends passes straight through to a PHP type that already
accepts it.

**`searchclient`: required fields the "not found" response omits or nulls.**
`SearchClient200Content` modelled only the "client found" shape: roughly fifty
fields declared required and non-nullable. The real "not found" response (HTTP
200, `search_mode: 0`, a phone with no matching client, observed 2026-08-05)
disagrees on two different axes:

| Field | Vendor declares | Wire sends |
|---|---|---|
| `_bill_data` | required, `type: object` | key omitted entirely |
| `bonus_percent` | required, `type: string` | key present, JSON `null` |
| `discount_percent` | required, `type: string` | key present, JSON `null` |
| `bonus_out_percent` | required, `type: string` | key present, JSON `null` |
| `program_name` | required, `type: string` | key present, JSON `null` |
| `program_type` | required, `type: string` (enum) | key present, JSON `null` |
| `client_email` | required, `type: string` | key present, JSON `null` |
| `not_to_send_sms` | required, `type: integer` (enum) | key present, JSON `null` |
| `not_to_send_email` | required, `type: integer` (enum) | key present, JSON `null` |

`_bill_data` is now optional (removed from `required`) rather than nullable —
poagen's own emission rule already makes an optional property nullable, so no
`type` change was needed once it left the `required` list. The other eight are
still required (the key is always present) with `'null'` added to their `type`.

A third, unrelated defect surfaced from the same two recorded calls:
`discount`, `discounted_total`, `max_bonus_out` and `max_bill_bonus_out` — all
declared `type: string` — arrive as a bare JSON int `0` when the value is zero,
in both the "found" and "not found" calls; `purchases_sum`, the same family,
arrives as JSON int `0` not found and JSON string `"44.00"` found. Fixed the
same way as `result_code`: `type: [string, integer]`.

**What could not be verified live.** `addclient`, `processsale`, `confirmsale`,
`askconfirmphone` and `checkconfirmphonecode` were re-read statically for both
defect classes — breadth bounded by the port map in the consuming project's
`api-kilbil.md`, per this task's Non-goals — but never called. None show an
*additional* `result_code`-shaped inconsistency beyond the document-wide fix
above, and none have an obviously-omittable required field beyond what the
vendor's own declarations already say (`processsale`'s `_bill_body`/
`_bill_header`/`_bill_footer` are already `type: [T, "null"]` while required,
consistent with "always present, sometimes null"). `addclient`'s response
shares `searchclient`'s general shape (`client_id`, `result_code`, `result_text`
all required) and could plausibly repeat the same omission on a partial
failure; recorded here as an open risk rather than guessed at, since chasing it
needs a mutating call the read-only credential rule forbids.

`getmovesbyclient` and `getdetailingbymove` were called live (both read-only)
for a real client's history and a bogus move id. Neither declares any field
required beyond `result_code`/`result_text`, so both were already resilient to
the "found-shape-only" defect once `result_code` was fixed — no further schema
change was needed. `getclientfullbalance` remains as clean as the original live
proof found it: its `200` response is a bare array of balances with no
`result_code` envelope at all.

Recorded, scrubbed fixtures and the tests that hydrate them:
`fixtures/responses/getprograms.json` (the int `result_code`),
`fixtures/responses/searchclient-not-found.json` and
`fixtures/responses/searchclient-found-live.json` (the omitted/nulled required
fields and the int-vs-string money fields), all in
`tests/Integration/Kilbil/KilbilLiveShapeReconciliationTest.php`. Every personal
field (name, phone, email, birth date, client id) in the found-response fixture
is the vendor's own placeholder example from `schemas/loyalty_v1.yaml`, not the
real client's data.
