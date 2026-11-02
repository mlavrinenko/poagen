<!-- Generated from docs/src/readme.typ by `just docs md`. Do not edit; edit the source. -->

<h1 align="center">poagen</h1>

<h4 align="center">OpenAPI-driven PHP client generator producing typed, extensible clients.</h4>

<h4 align="center"><a href="https://mlavrinenko.github.io/poagen/">Documentation</a> · <a href="https://mlavrinenko.github.io/poagen/quickstart/">Quickstart</a></h4>

---

poagen reads an OpenAPI 3.0 or 3.1 document and emits a PHP 8.4 HTTP client. The generated tree is disposable: every run rewrites it whole, and your own code lives beside it. The output is deterministic, so a diff after regeneration shows only real changes.

## Why poagen

- **Typed.** Exhaustive PHPStan annotations, backed enums, readonly models, and one method per operation.
- **Extensible.** Guidance lives in a typed `Profile` and in attributes on your own value objects, never in an edit to generated code.
- **PSR-aligned.** The emitted client depends on PSR-18, PSR-17 and PSR-7, so Guzzle, Symfony HTTP Client, or anything else that implements them plugs in.
- **Fail loud.** An unsupported construct stops the run by name. poagen never drops an operation and calls the result a success.
- **Proven on real documents.** Petstore, DigitalOcean, GitHub, and kilbil’s loyalty API all generate and pass their own gates.

## Install

The runtime goes in `require`, because generated code runs in production. The generator goes in `require-dev`, because it only runs while you generate:

```bash
composer require poagen/client-runtime
composer require --dev poagen/client-generator
```

## Quickstart

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

Every operation returns an `Envelope` carrying `->status`, `->body` and the PSR-7 `->response`. A declared non-2xx status is a value to inspect, not an exception.

## Documentation

- [Quickstart](https://mlavrinenko.github.io/poagen/quickstart/) takes you from an empty project to a first response.
- [Installation](https://mlavrinenko.github.io/poagen/installation/) covers requirements and versions.
- [Profile](https://mlavrinenko.github.io/poagen/profile/) is the configuration reference.
- [Generated code](https://mlavrinenko.github.io/poagen/generated-code/) explains models, enums, clients and envelopes.
- [Formats](https://mlavrinenko.github.io/poagen/formats/) covers value objects, codecs and date-time zones.
- [CLI](https://mlavrinenko.github.io/poagen/cli/) covers generate, validate, dry runs and diffs.
- [Examples](https://mlavrinenko.github.io/poagen/examples/) shows the four real documents.
- [Status](https://mlavrinenko.github.io/poagen/status/) lists what poagen refuses by name.

## Contributing

See [CONTRIBUTING.md](https://github.com/mlavrinenko/poagen/blob/main/CONTRIBUTING.md). The project’s decisions and specs live under `truth/`, next to the code they describe.

## License

MIT.
