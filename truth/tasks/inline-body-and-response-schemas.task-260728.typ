#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Synthesise models from inline request and response schemas",
  tags: ("generator",),
  priority: 9,
  difficulty: 7,
  status: proposed(2026, 7, 28),
)

== Summary

The whole model pipeline is rooted in the named components of the document. The request body analyser only accepts a reference to a component, or an array of such references; an inline object body returns nothing and the operation is dropped. Responses behave the same way, which is why the two kilbil operations that survive generation return void despite documenting a JSON object. The kilbil loyalty schema declares zero components and zero references — every payload is inline — so paogen emits two files for a 36-operation API. The machinery to fix this already exists: inline objects nested inside a named component are already promoted to synthesised classes and drained from a queue. It is simply never fed from operations.

== Acceptance criteria

- An inline object request body produces a typed parameter backed by a synthesised model.
- An inline object response produces a typed return value.
- Inline arrays of inline objects work at both ends.
- Inline enums inside operation payloads become backed enums, as they already do inside components.
- Synthesised names are derived deterministically from the operation identifier and are stable across runs.
- The profile can pin an explicit class name for any synthesised model, keyed on the operation identifier, overriding the derivation. When a vendor renames an operation identifier the consumer restores the old class name by pointing the pin at the new identifier, so an upstream rename costs a config line rather than a breaking change to their own callers.
- A pin naming an operation identifier absent from the document fails the run rather than being ignored.
- A schema with no components at all generates a complete client.
- The kilbil loyalty schema emits all 36 operations.
- The kilbil loyalty schema emits a usable set of models despite declaring zero named components. Measured directly against the parsed document: \`components/schemas\` is empty, and the operations carry 29 inline JSON request bodies and 71 inline JSON response schemas. Every model in that client has to be synthesised — none can come from the component catalogue, because there is no catalogue.
- Roughly a hundred synthesised names land in one client, so the naming rule is load-bearing rather than cosmetic. Two operations whose payloads differ must not collide, and a collision must fail the run rather than silently overwrite an emitted file.

== Non-goals

- De-duplicating structurally identical inline shapes into one shared model; a follow-up task once naming is settled.
- Changing how named components are emitted.

== Files

- \`src/Generator/Emit/RequestBodyAnalyzer.php\`
- \`src/Generator/Emit/OperationAnalyzer.php\`
- \`src/Generator/ModelPlanner.php\`
- \`src/Generator/Emit/InlineObjectResolver.php\`
- \`truth/specs/model-generator.typ\`
- \`truth/specs/operation-generator.typ\`
