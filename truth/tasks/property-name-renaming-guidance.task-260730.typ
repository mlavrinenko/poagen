#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Let the profile rename model properties as it renames methods and tags",
  tags: ("generator", "dx", "naming"),
  priority: 4,
  difficulty: 6,
  status: accepted(2026, 8, 2),
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
