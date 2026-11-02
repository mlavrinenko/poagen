#import "/templates/page.typ": page
#import "/utils/site.typ": u

#let meta = (
  title: "Quickstart",
  summary: "Install poagen, write a profile, generate a client, and make the first call.",
)
#metadata(meta) <page-meta>

#show: page.with(..meta)

= Install

Add the runtime to the project's production dependencies and the generator
to its development dependencies:

```bash
composer require poagen/client-runtime
composer require --dev poagen/client-generator
```

The split matters. Generated code runs in production and needs only
`poagen/client-runtime`; the generator, its OpenAPI parser and its code
emitter stay out of a `--no-dev` install.

= Write a profile

`poagen.php` is a plain PHP file that returns a typed `Profile`:

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

`schema` is the document to read, `output` is the directory poagen owns, and
`namespace` is the root of the emitted classes. Everything else is optional
guidance covered in #link(u("/profile/"))[the profile reference].

= Generate

```bash
vendor/bin/poagen generate poagen.php
```

The run prints what it wrote and what it refused. `--dry-run` previews the
writes and deletes, and `--diff` shows a unified diff against disk. A document
that reaches an unsupported construct stops by name instead of guessing.

= Use the client

A generated `ApiClient` takes a transport plus whatever credentials the
document declares. The Petstore document declares an API key and an OAuth2
token:

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

Every operation returns an `Envelope`. `->status` is the HTTP status the wire
sent, `->body` is the declared body hydrated into the declared type, and
`->response` is the PSR-7 response both came from. A declared non-2xx status
is a value to inspect, not an exception.

= Keep the generated tree disposable

Do not edit anything under `generated/`. Change the document or the profile,
run the generator again, and commit the result. The emitted header names the
profile and the command that rewrote the file.
