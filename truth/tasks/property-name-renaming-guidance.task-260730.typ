#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Let the profile rename model properties as it renames methods and tags",
  tags: ("generator", "dx", "naming"),
  priority: 4,
  difficulty: 6,
  status: wip(2026, 8, 2),
)

== Summary

Emitted models keep the vendor's property spelling verbatim: \`result\_code\`, \`client\_id\`, \`goods\_data\`, \`bill\_body\`. The profile can already rename an operation id and a tag, so a consumer can turn \`getclientfullbalance\` into \`getClientFullBalance\` and \`Клиенты\` into \`Customers\`, but there is no answer at all for the property names those methods hand back — and on the kilbil document that is several hundred properties across 104 models.

The result is a client whose method names read like PHP and whose object properties read like the wire. \`\$client->customers()->getClientFullBalance(...)->result\_code\` is halfway to idiomatic and stops.

The reason this is not a trivial rename is that the wire name has to survive. Hydration and marshalling both key on the schema's property name, so a rename means the emitted model carries the PHP name in the signature and the wire name in the marshalling descriptor — the machinery \`attribute-and-phpdoc-driven-serialization\` already established for exactly this kind of split.

== Acceptance criteria

- The profile accepts property renames as data, keyed in a way that scopes a rename to the model it belongs to rather than renaming every \`id\` in the document at once.
- A renamed property round-trips: hydration reads the wire name, marshalling writes the wire name, and the PHP surface shows the renamed one.
- An unrenamed property is emitted exactly as today, byte for byte.
- A rename that collides with another property in the same model fails the run with a diagnostic naming both, per \`fail-loud-never-silent\`.
- \`regeneration-is-deterministic-and-total\` holds: the same profile produces the same output.

== Non-goals

- Automatic snake\_case to camelCase conversion. That is a guess, it moves names between runs when the vendor changes a schema, and \`cheap-regeneration\` forbids the incidental rename it would cause.
- Renaming enum cases.
- Renaming anything in the request-parameter surface, which \`025-parameter-and-operation-name-normalisation\` already settled.

== Files

- \`src/Generator/Profile.php\`
- \`src/Generator/Emit/ModelEmitter.php\`
- \`src/Generator/Emit/PropertySynthesiser.php\`
- \`src/Runtime/Marshal/\`
- \`tests/\`

== Result

\`Profile::\$propertyRenames\` is a flat \`array<string,string>\` keyed
\`'<RawComponentName>.<wirePropertyName>'\`, following the dotted-key convention
\`\$xmlElements\` and \`\$inlineModels\` already set rather than introducing a nested
shape into a constructor that had settled on one. A consumer writes
\`propertyRenames: \['Client.result\_code' => 'resultCode'\]\` and the emitted model
declares \`public int \$resultCode\` carrying \`\#\[WireName('result\_code')\]\`.

The wire name survives without any new serialisation code.
\`ModelPlanner\` already knows the raw \`components.schemas\` name a model came
from, so it passes that name and the rename map into \`ModelEmitter\`, which looks
up one key per property and otherwise falls back to today's derivation. The
\`\#\[WireName\]\`-when-different machinery in \`ModelAttributeApplier\` is reused
untouched. A synthesised child model is emitted under an empty component name,
which no document component can match, so a rename cannot leak into an inline or
nested class.

The round trip is proven against the runtime, not against emitted source:
\`tests/Integration/PropertyRenameTest.php\` generates a real client, \`require\`s
the emitted class, and drives the actual \`Marshaller\` and \`Hydrator\` — marshal
produces the wire key and no PHP-named key, hydrate reads the wire key back into
the renamed property, and an unrenamed property is unaffected.

A new \`PropertyRenameValidator\` runs in \`Generator::plan()\` beside
\`SkipListValidator\` and \`ProfileTargetValidator\`, batching through the existing
\`UnrepresentableConstructsException\` so nothing is written on failure. It
refuses a key naming a component absent from the document, a key naming a
property absent from that component, and a rename colliding with a property
already using that PHP name — renamed or not. Each diagnostic names the offending
key and what to do about it.

No automatic snake\_case to camelCase conversion was added; the non-goal stands.
Every committed fixture tree is byte-identical — \`tests/fixtures/generated/\`,
\`examples/kilbil\` and \`examples/petstore\` all unchanged, with
\`just check-examples\` reporting no drift, which is the evidence that an
unrenamed property emits exactly as before.

\`CompositionResolver::materialiseAllOf()\` was extracted from a private
\`ModelPlanner\` method so the validator and the emission path resolve an
\`allOf\` component's effective property set through the same code, and to keep
\`ModelPlanner\` inside its linecop budget, which it was already sitting exactly
at.
