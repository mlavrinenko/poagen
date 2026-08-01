#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Collapse emitted operation bodies onto an injected runtime transport",
  tags: ("generator", "runtime", "dx"),
  priority: 8,
  difficulty: 7,
  status: done(2026, 8, 1),
)

== Summary

Every emitted operation writes out the whole request-and-response dance inline. \`RequestAssembler\` emits the path, the query assembly, the \`createRequest\` call and the body attachment; \`ResponseHandler\` emits the send, the status branch, the decode and the hydrate. Across a client that is the same 12 to 15 lines per method, token for token. \`examples/kilbil/generated/Generated/TagsClient.php\` is 117 lines of which four blocks are byte-identical apart from a path literal and a class name, and jscpd puts the kilbil tree at 30.69% duplicated.

The duplication is a symptom. The cause is that generated code carries logic that does not vary with the schema, so every operation pays to restate it and every consumer reads it thirty-six times.

Move the invariant half into the runtime and leave the varying half in the client:

\`\`\`php
public function addClientTags(AddClientTagsRequest \\\$body): AddClientTagsResponse
{
return \\\$this->transport->send(
Endpoint::post('/load/addclienttags')->query('h', \\\$this->h)->json(\\\$body),
AddClientTagsResponse::class,
);
}
\`\`\`

The constructor collapses with it. Twelve client classes currently take the same seven promoted parameters — the PSR trio, the base address, the credential, the hydrator and the marshaller — which is the second clone family jscpd finds. Injecting one transport plus whatever credentials the schema declares makes it two.

\`caller-surface-is-injectable\` already requires that the transport, the message factories, the base address and the hydration machinery all arrive through the constructor, so bundling them behind one injected collaborator is a continuation of that rule rather than a departure from it. But it does narrow what \`generated-types-are-total\` covers: behaviour that is currently visible in the emitted tree and analysed at max strictness with nothing ignored moves into a library. \`Hydrator\` and \`Marshaller\` already set that precedent. The trade is real and this needs a decision artifact recording it before the code lands.

The transport must be replaceable, not merely injected — see \`swappable-runtime-contracts\`, which this task should land against rather than around.

== Acceptance criteria

- A decision artifact under \`truth/decisions/\` records the move, citing at least one goal and one standard, and states plainly what leaves the generated tree.
- An emitted operation body is a single call describing the request and naming the response type. No status branching, no decoding, no hydration call appears in generated code.
- All five \`ReturnSpec\` shapes are covered: void, single model, list of model, scalar, and \`additionalProperties\` map.
- All body shapes are covered: absent, JSON object, JSON list, XML, and \`x-www-form-urlencoded\`.
- Path parameters, required and optional scalar query parameters, \`explode: true\` array query parameters, optional headers, and query-string and header credentials all still reach the wire exactly as they do today. \`explode: true\` still serialises as repeated keys, not as bracketed indices.
- A non-2xx response still throws \`ApiException\` carrying the original request and response.
- The emitted client is still injectable and still hackable: a consumer supplies their own transport without touching a generated file.
- \`just lint-phpstan-generated\` is green at max level with no baseline, no \`excludePaths\` and no \`ignoreErrors\`.
- \`just check-examples\` reports no drift and the byte-stability test passes.
- jscpd over the regenerated example trees is materially below the 30.69% recorded before the change; the measured figure is written into this task.

== Non-goals

- Retry, backoff, caching, logging or any other transport policy. Those compose underneath the PSR client, per ADR-002.
- Changing the emitted method signatures, which are the consumer-facing contract.
- Moving authentication out of the client into a decorator.
- Publishing the runtime as its own package; \`runtime-package-split\` owns that.

== Files

- \`truth/decisions/\`
- \`src/Runtime/\`
- \`src/Generator/Emit/RequestAssembler.php\`
- \`src/Generator/Emit/ResponseHandler.php\`
- \`src/Generator/Emit/OperationEmitter.php\`
- \`src/Generator/Emit/BodyAttachmentEmitter.php\`
- \`src/Generator/Emit/ClientConstructor.php\`
- \`src/Generator/Emit/ClientEmitter.php\`
- \`src/Generator/Emit/SubClientEmitter.php\`
- \`src/Generator/Emit/SecurityEmitter.php\`
- \`tests/\`
- \`tests/fixtures/generated/\`
- \`examples/petstore/generated/\`
- \`examples/kilbil/generated/\`

== Result

Every figure below was re-measured on the merged commit rather than taken from the branch that produced it.

#table(
  columns: 3,
  [*Measure*], [*Before*], [*After*],
  [Generated trees, clones], [115], [38],
  [Generated trees, duplicated lines], [39.92%], [22.40%],
  [Generated trees, duplicated tokens], [47.67%], [28.19%],
  [Generated lines analysed], [5218], [4053],
  [kilbil tree, total lines], [4514], [3851],
  [\`TagsClient.php\`], [117 lines], [58],
)

The emitted shape:

\`\`\`php
public function addClientTags(AddClientTagsRequest \$body): AddClientTagsResponse
{
return \$this->transport->send(
Endpoint::post('/load/addclienttags')->query('h', \$this->h)->json(\$body),
ResponseType::object(AddClientTagsResponse::class),
);
}
\`\`\`

The second argument diverges from the shape originally sketched, and the reason is worth keeping. Passing a bare class name cannot express void, list, scalar or map returns without one transport method per kind --- seven or eight of them. That would have cost the single-method interface, which is the thing that makes a substitute or a decorator cheap to write. A generic response descriptor keeps \`send()\` alone on the interface and still lets static analysis agree the call returns a model, a list of models, or a typed map, with no annotation anywhere in the emitted tree.

Emitted bodies also lost every conditional: a null query value, header or form field drops itself at the boundary, so an optional parameter costs no branch in generated code.

One behaviour fix came with it. A scalar \`int\`/\`float\`/\`bool\` return used to cast the response stream object rather than its contents, which raised a warning and yielded 1. The runtime casts the body string.
