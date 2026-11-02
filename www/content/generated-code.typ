#import "/templates/page.typ": page
#import "/utils/site.typ": u

#let meta = (
  title: "Generated code",
  summary: "What poagen writes: a root client, typed sub-clients, models, enums, an envelope, and one exception for the cases the document did not describe.",
)
#metadata(meta) <page-meta>

#show: page.with(..meta)

Every run rewrites the output tree whole. The generated header names the
profile and the command that produced it, and no generated file is meant to
be edited by hand.

= The tree

```text
generated/Generated/
  ApiClient.php
  ApiClientInterface.php
  ApiException.php
  <Tag>Client.php
  <Tag>ClientInterface.php
  Model/
  Enum/
  ResponseMaps.php        # only when the profile names shared maps
```

`ApiClient` is the root. Each OpenAPI tag becomes a sub-client, reached by a
method named after the tag. A client takes the transport plus whatever
credentials the document declares:

```php
$client = new ApiClient(
    new HttpTransport(ApiClient::SERVER_1, ApiException::class),
    apiKey: $apiKey,
    petstoreAuth: $token,
);
```

`SERVER_1` is the first server the document declares, emitted as a value. The
transport still takes its base address as a plain constructor argument, so a
staging host or a test server is a different string away.

= Models

Models are `final readonly` classes with promoted constructor properties.
Nullable properties are nullable, unions are native union types, and list and
map properties carry their item type in PHPDoc. Serialization is driven by
attributes, not by generated boilerplate:

- `#[WireName]` when the PHP name differs from the wire name.
- `#[Format]` when the property is bound to a value object or codec.
- `#[Discriminator]` and the generated `UnionInterface` markers for
  undiscriminated unions.
- `#[AdditionalProperties]` for an object whose unknown keys are kept.

= Enums

OpenAPI string and integer enums become backed PHP enums. A case name comes
from the value, sanitised deterministically, so two runs produce the same
class.

= Responses

Every operation returns an `Envelope`:

- `->status` is the HTTP status the wire sent.
- `->body` is the declared body hydrated into the declared type.
- `->response` is the PSR-7 response both came from.

A status the document describes, including a 4xx or 5xx, is a return value.
`Generated\ApiException` is raised only for a status the document declared
nothing for, or for a declared body that failed to hydrate. That keeps the
document's error shapes usable instead of turning every non-2xx into the same
throw.

#table(
  columns: 2,
  table.header([Response], [What you get]),
  [`200` with a schema], [`Envelope<Model>`],
  [`200` with no schema], [`Envelope<null>`],
  [`403` with a schema], [`Envelope<Model403>`],
  [undeclared status], [`ApiException`],
  [body fails to hydrate], [`ApiException`],
)

= Regeneration

The output is deterministic. Two runs over the same document and profile
produce the same bytes, so a diff after regeneration shows only real changes.
If a change is not in the document or the profile, it does not belong in the
tree.

See #link(u("/status/"))[Status] for the constructs poagen refuses rather
than guesses.
