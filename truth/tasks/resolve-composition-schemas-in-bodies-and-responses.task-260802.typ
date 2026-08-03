#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Resolve composition schemas in request bodies and responses",
  tags: ("generator", "strictness"),
  priority: 8,
  difficulty: 7,
  status: cancelled(
    2026,
    8,
    3,
  )[Split into four, because it bundled four independent mechanisms behind one stale count. Its 68 operations was measured when the skip lists held 100 entries; they hold 78 now, and the composition half is 55: merge-allof-members-into-one-model (19, plus 9 operations it un-widens), a-union-request-body-takes-a-union-parameter (27), a-union-response-selects-its-branch (8), a-media-type-with-no-schema-takes-a-raw-body (1). Its fourth shape, properties with no type keyword, was already closed by close-the-three-sites-that-widen-a-declared-shape and its named example kubernetes\_upgrade\_cluster generates today.],
  links: (
    depends-on("declare-an-undiscriminated-union-as-raw-data.task-260802.typ"),
  ),
)

== Summary

Sixty-eight of the hundred skipped operations across the two large examples are
refused for one reason, and the reason is not the one the skip entries name.
They say "inline (non-`$ref`) schema", which sounds like the gap
`inline-body-and-response-schemas` closed. It is not. That task taught the
generator to synthesise a model from an inline `type: object` with declared
`properties`, and kilbil proves it works — 29 inline request bodies, 107
synthesised models, from a document with no components at all.

What still refuses is anything whose schema node carries no literal `type`
keyword, because `SchemaType` reads that keyword and nothing else. Four shapes
land there, traced through the code rather than inferred:

- `allOf` — DigitalOcean's `addons_create` is `allOf: [$ref]` plus a `required`
  list. Merging the members is the whole answer and there is no ambiguity in
  it.
- `oneOf`/`anyOf` in a request body — DigitalOcean's `droplets_create` is
  `oneOf: [droplet_single_create, droplet_multi_create]`, `domains_create_record`
  is an `anyOf` of eight record types. Outgoing, this is easy in a way the
  response direction is not: the consumer passes one of the branches, so the
  method takes a union parameter and the marshaller serialises whichever object
  it was handed. Nothing has to be inferred from a payload.
- `oneOf`/`anyOf` in a response — nine GitHub operations. This is the direction
  that needs branch selection from the payload, which
  `declare-an-undiscriminated-union-as-raw-data` builds.
- A schema declaring `properties` with no `type: object` — DigitalOcean's
  `kubernetes_upgrade_cluster`. JSON Schema does not require the keyword and
  vendors routinely omit it; a node with `properties` is an object shape by
  every other reading.

One further case is not a schema problem at all: GitHub's `repos/get-content`
declares an `application/json` request body carrying `examples` and no `schema`
key. The refusal fires purely on the media type being present. A body with no
declared schema has no shape to represent, so the honest outcome is a raw
payload argument, not a refusal.

Counted: 43 DigitalOcean and 16 GitHub request bodies, plus 9 GitHub responses.

== Acceptance criteria

- `allOf` resolves by merging its members into one synthesised model, in both
  the request and response directions. A member that is a `$ref` is
  dereferenced; a member carrying only `required` contributes its requirements.
  A conflict between members — the same property declared with two different
  types — refuses by name rather than picking one.
- A `oneOf`/`anyOf` request body emits a union parameter type across the
  branches, and the marshaller serialises whichever branch the caller passed.
  No branch selection is inferred, because none is needed outgoing.
- A `oneOf`/`anyOf` response resolves through the shape-matching mechanism this
  task depends on, and refuses at generation time when two branches are not
  distinguishable.
- A schema with declared `properties` and no `type` keyword is treated as an
  object. A schema with neither is unchanged.
- A body whose media type carries no `schema` at all takes a raw payload
  argument and is reported as such, rather than refusing the operation.
- The sixty-eight operations drop out of the two skip lists, entries removed,
  and both examples' remaining entries still name live refusals.
- Nothing about the abort weakens: a composition the resolver genuinely cannot
  represent refuses by name, with the construct and the schema pointer.

== Non-goals

- `not`, which no vendored document uses and which has no PHP type.
- Inferring a discriminator. Branch selection is the depended-on task's
  business and stays there.
- `multipart/form-data` and binary bodies, which are a media-type gap rather
  than a schema gap and have their own task.

== Files

- `src/Generator/Emit/SchemaType.php`
- `src/Generator/Emit/CompositionResolver.php`
- `src/Generator/Emit/InlinePayloadPlanner.php`
- `src/Generator/Emit/RequestBodyAnalyzer.php`
- `src/Generator/Emit/ResponseAnalyzer.php`
- `examples/digitalocean/paogen.php`, `examples/github/paogen.php`
- `tests/`
