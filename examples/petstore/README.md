# paogen example — Petstore

The canonical [Swagger Petstore](https://petstore3.swagger.io/) schema,
generated into a typed PHP client.

## What this demonstrates

- OpenAPI 3.0 model + operation generation end-to-end.
- A `jsonSerialize` / `PROPERTY_MAP` hydration round-trip for
  `snake_case` wire keys.
- A PHP 8.1 backed enum for `status` query params.
- A synthesised inline-object class (`PetShipping`) alongside named
  component models.

## Files

```
petstore/
├── composer.json              — consumer-style project manifest
├── paogen.php                 — the Profile object paogen reads
├── schemas/
│   └── petstore-3.0.yaml      — the vendored OpenAPI document
└── generated/
    └── Generated/             — paogen's output (committed)
        ├── ApiClient.php
        ├── ApiException.php
        ├── Enum/
        │   └── FindPetsByStatusStatus.php
        └── Model/
            ├── ApiResponse.php
            ├── Category.php
            ├── Order.php
            ├── Pet.php
            ├── PetShipping.php
            ├── Tag.php
            └── User.php
```

## Running it

From this directory:

```bash
composer install
composer generate
```

`composer generate` is a thin alias for `paogen generate paogen.php`.
The output writes to `./generated/` and is idempotent — regenerating
against an unchanged schema produces byte-identical files (ADR-001).

## Using the generated client

```php
use Acme\Petstore\Generated\ApiClient;
use Acme\Petstore\Generated\ApiException;
use Acme\Petstore\Generated\Enum\FindPetsByStatusStatus;
use Mlavrinenko\Paogen\Runtime\Http\HttpTransport;

// Two facts only you can supply: where the API lives, and which exception
// this profile throws. The PSR-18 client, the PSR-17 factories and the
// marshalling machinery all default to working implementations.
$client = new ApiClient(new HttpTransport(
    'https://petstore3.swagger.io/api/v3',
    ApiException::class,
));

$pets = $client->pet()->findPetsByStatus(FindPetsByStatusStatus::Available);

foreach ($pets as $pet) {
    echo $pet->name, "\n";
}
```

Replace any part of the runtime by naming it — the transport takes each
collaborator as an interface:

```php
$transport = new HttpTransport(
    'https://petstore3.swagger.io/api/v3',
    ApiException::class,
    $guzzle,            // any PSR-18 client
    $requestFactory,    // PSR-17
    $streamFactory,     // PSR-17
    hydrator: $myHydrator,
);
```

Or replace all of it: implement `TransportInterface` and construct the same
generated client with it. Nothing under `generated/` changes either way.

## How the Profile is wired

See `paogen.php`. The minimum a profile needs is:

- `schema` — absolute path to the OpenAPI document.
- `output` — directory to write under (paogen creates a `Generated/`
  subtree, never touches anything outside it).
- `namespace` — root namespace prefix for every emitted class.

Two optional fields not exercised here but worth knowing:

- `discoverIn: [...]` — namespaces to scan for `#[BindsFormat]`
  attributes on your own value objects.
- `renames: [raw => Pascal]` — override the class name for a specific
  schema component. See `examples/digitalocean/` for a real use.

## Known limitations

None for this schema at the current generator state.
