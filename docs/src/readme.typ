// docs/src/readme.typ is the source of README.md.
//
// Rendered by docs/generate-md.sh with typlite. The source is plain Typst: it
// imports no Tola page rule, so typlite can walk it on its own.
#import "lib.typ": repo, site

#html.elem("h1", attrs: (align: "center"))[poagen]

#html.elem("h4", attrs: (align: "center"))[
  OpenAPI-driven PHP client generator producing typed, extensible clients.
]

#html.elem("h4", attrs: (align: "center"))[
  #link(site("/"))[Documentation] · #link(site("/quickstart/"))[Quickstart]
]

\-\-\-

poagen reads an OpenAPI 3.0 or 3.1 document and emits a PHP 8.4 HTTP client.
The generated tree is disposable: every run rewrites it whole, and your own
code lives beside it. The output is deterministic, so a diff after
regeneration shows only real changes.

= Why poagen

- *Typed.* Exhaustive PHPStan annotations, backed enums, readonly models, and
  one method per operation.
- *Extensible.* Guidance lives in a typed `Profile` and in attributes on your
  own value objects, never in an edit to generated code.
- *PSR-aligned.* The emitted client depends on PSR-18, PSR-17 and PSR-7, so
  Guzzle, Symfony HTTP Client, or anything else that implements them plugs in.
- *Fail loud.* An unsupported construct stops the run by name. poagen never
  drops an operation and calls the result a success.
- *Proven on real documents.* Petstore, DigitalOcean, GitHub, and kilbil's
  loyalty API all generate and pass their own gates.

= Install

The runtime goes in `require`, because generated code runs in production.
The generator goes in `require-dev`, because it only runs while you generate:

```bash
composer require poagen/client-runtime
composer require --dev poagen/client-generator
```

= Quickstart

Write a profile:

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

Generate:

```bash
vendor/bin/poagen generate poagen.php
```

Use the client:

```php
use App\Petstore\Generated\ApiClient;
use App\Petstore\Generated\ApiException;
use Poagen\Runtime\Http\HttpTransport;

$client = new ApiClient(
    new HttpTransport(ApiClient::SERVER_1, ApiException::class),
    apiKey: $apiKey,
    petstoreAuth: $token,
);

$response = $client->pet()->getPetById(1);

echo $response->body?->name;
```

Every operation returns an `Envelope` carrying `->status`, `->body` and the
PSR-7 `->response`. A declared non-2xx status is a value to inspect, not an
exception.

= Documentation

- #link(site("/quickstart/"))[Quickstart] takes you from an empty project to a first response.
- #link(site("/installation/"))[Installation] covers requirements and versions.
- #link(site("/profile/"))[Profile] is the configuration reference.
- #link(site("/generated-code/"))[Generated code] explains models, enums, clients and envelopes.
- #link(site("/formats/"))[Formats] covers value objects, codecs and date-time zones.
- #link(site("/cli/"))[CLI] covers generate, validate, dry runs and diffs.
- #link(site("/examples/"))[Examples] shows the four real documents.
- #link(site("/status/"))[Status] lists what poagen refuses by name.

= Contributing

See #link(repo + "/blob/main/CONTRIBUTING.md")[CONTRIBUTING.md]. The project's
decisions and specs live under `truth/`, next to the code they describe.

= License

MIT.
