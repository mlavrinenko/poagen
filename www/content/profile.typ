#import "/templates/page.typ": page
#import "/utils/site.typ": REPO, u

#let meta = (
  title: "Profile",
  summary: "The typed Profile is the whole configuration surface: schema, output, namespace, and the guidance that shapes names and types.",
)
#metadata(meta) <page-meta>

#show: page.with(..meta)

`poagen.php` returns a `Poagen\Generator\Generator\Profile`. The profile is
read as data, never executed, and every entry is validated against the
document before anything is written.

= Minimal profile

```php
<?php

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/schemas/petstore-3.0.yaml',
    output: __DIR__ . '/generated',
    namespace: 'App\\Petstore',
);
```

`namespace` is the root of the emitted classes. Generated files land under
`namespace\Generated\`, so `App\Petstore` becomes
`App\Petstore\Generated\ApiClient` and `App\Petstore\Generated\Model\Pet`.

= Fields

#table(
  columns: 2,
  table.header([Field], [What it answers]),
  [`schema`], [`Path to the OpenAPI YAML or JSON document.`],
  [`output`], [`Directory poagen owns and rewrites.`],
  [`namespace`], [`Root namespace for emitted classes.`],
  [`formats`], [`Format string to a value object or codec, document-wide.`],
  [`propertyFormats`], [`Format binding for one property of one model.`],
  [`discoverIn`], [`Namespaces scanned for #[BindsFormat] attributes.`],
  [`methodRenames`], [`Operation id to the method name you want.`],
  [`tagRenames`], [`OpenAPI tag to the sub-client name you want.`],
  [`propertyRenames`], [`Wire property to the PHP property name.`],
  [`renames`], [`Schema component to the model class name.`],
  [`xmlElements`], [`Root, item and nested-container elements for XML request bodies.`],
  [`dateTimeZone`], [`The zone a document means when it sends a date-time without an offset.`],
  [`securitySchemes`], [`Schemes a security requirement names but the document never declares.`],
  [`inlineModels`], [`Names, and optional merges, for synthesised inline payload models.`],
  [`responseMaps`], [`Operations that share one response-map declaration.`],
  [`skip`], [`Operations or components to leave out, each with a reason.`],
)

The constructor and every field are documented in
#link(REPO + "/blob/main/src/Generator/Profile.php")[`src/Generator/Profile.php`].
That file is the reference; this page is the map.

= Naming

OpenAPI often names operations in a way no algorithm can split
(`getclientfullbalance`), and tags may be Cyrillic. poagen will not guess:
it keeps the vendor spelling, reports it on stderr, and lets the profile
answer.

```php
methodRenames: [
    'getclientfullbalance' => 'getClientFullBalance',
],
tagRenames: [
    'Клиенты' => 'Customers',
],
```

A rename that names an operation, tag or property the document does not
carry fails the run. A rename that collides with another name fails too.

= Types

`formats` and `propertyFormats` bind a format to a class. `formats` applies
wherever the format appears; `propertyFormats` applies to one property of one
model, keyed by the emitted class name and the wire property name.

```php
formats: [
    'uuid' => RamseyUuidCodec::class,
],
propertyFormats: [
    'SearchClientRequestContentGoodsDataItem.price' => Money::class,
],
```

See #link(u("/formats/"))[Formats and value objects] for the binding shapes
and the date-time zone handling.

= XML request bodies

OpenAPI names the elements of a property, but not the document root or the
repeated element of a bare array. The document may also nest a container one
level deeper than the schema suggests. `xmlElements` answers all three:

```php
xmlElements: [
    'goodsxml' => 'goods',
    'goodsxml.item' => 'good',
    'goodsxml.item.inside' => 'good',
],
```

A binding naming a property absent from the item schema fails the run.

= Leaving work out

`skip` is the explicit way to accept an operation poagen cannot represent.
Each entry carries a reason, and the run reports it:

```php
skip: [
    'uploadForm' => 'multipart/form-data request body',
],
```

Skipping is a decision, not a silent fallback. A skipped operation still
appears in the run report.
