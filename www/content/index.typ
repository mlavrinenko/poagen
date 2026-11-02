// The site root.
#import "/templates/page.typ": page
#import "/utils/site.typ": REPO, u

#let meta = (
  title: "poagen",
  summary: "Point poagen at an OpenAPI 3.0 or 3.1 document and get a typed PHP 8.4 client you never edit.",
  home: true,
)
#metadata(meta) <page-meta>

#show: page.with(..meta)

poagen reads an OpenAPI 3.0 or 3.1 document and emits a PHP 8.4 HTTP client.
The generated tree is disposable: every run rewrites it whole, and your own
code lives beside it.

= Why poagen

- *Typed.* Exhaustive PHPStan annotations, backed enums, readonly models, and
  one method per operation.
- *Extensible.* Guidance lives in a typed `Profile` and in attributes on your
  own value objects, never in an edit to generated code.
- *PSR-aligned.* The emitted client depends on PSR-18, PSR-17 and PSR-7, so
  Guzzle, Symfony HTTP Client, or anything else that implements them plugs in.
- *Proven on real documents.* Petstore, DigitalOcean, GitHub, and kilbil's
  loyalty API all generate and pass their own gates.

= Start

```bash
composer require poagen/client-runtime
composer require --dev poagen/client-generator
```

Write a profile, generate, and call the result. #link(u("/quickstart/"))[The
quickstart] takes you from an empty project to a first response.

= Documentation

- #link(u("/quickstart/"))[Quickstart]
- #link(u("/installation/"))[Installation]
- #link(u("/profile/"))[Profile reference]
- #link(u("/generated-code/"))[What gets generated]
- #link(u("/formats/"))[Formats and value objects]
- #link(u("/cli/"))[CLI reference]
- #link(u("/examples/"))[Examples]
- #link(u("/status/"))[Status and limits]

The source lives at #link(REPO)[github.com/mlavrinenko/poagen].
