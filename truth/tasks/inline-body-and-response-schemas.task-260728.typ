#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Synthesise models from inline request and response schemas",
  tags: ("generator",),
  priority: 9,
  difficulty: 7,
  status: done(2026, 8, 1),
)

== Summary

The whole model pipeline is rooted in the named components of the document. The request body analyser only accepts a reference to a component, or an array of such references; an inline object body returns nothing and the operation is dropped. Responses behave the same way, which is why the two kilbil operations that survive generation return void despite documenting a JSON object. The kilbil loyalty schema declares zero components and zero references — every payload is inline — so paogen emits two files for a 36-operation API. The machinery to fix this already exists: inline objects nested inside a named component are already promoted to synthesised classes and drained from a queue. It is simply never fed from operations.

== Acceptance criteria

- An inline object request body produces a typed parameter backed by a synthesised model.
- An inline object response produces a typed return value.
- Inline arrays of inline objects work at both ends.
- Inline enums inside operation payloads become backed enums. This criterion originally read "as they already do inside components", which was wrong: only a *top-level* enum component and a parameter's inline enum were ever backed. A property-level inline enum resolved to its base type wherever it appeared — \`Pet.status\` in the petstore fixture was emitted \`?string\` despite declaring three values. So the reading has to be fixed for both, not just for payloads; a generator that types one location and not the other has no contract a reader can rely on.
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

- \`src/Generator/Emit/InlinePayloadPlanner.php\` and \`InlinePayloadCatalog.php\` (new — name the payload classes once, for both halves of the run)
- \`src/Generator/Emit/PropertySynthesiser.php\` (new — extracted from \`ModelEmitter\` so both stay under the linecop limit)
- \`src/Generator/Emit/ModelNameLedger.php\` (new — the collision guard for names no raw key covers)
- \`src/Generator/Emit/ModelEmitter.php\`
- \`src/Generator/Emit/OperationEmitter.php\`
- \`src/Generator/Emit/OperationAnalyzer.php\`
- \`src/Generator/Emit/BodySpec.php\`, \`RequestBodyParameterEmitter.php\`, \`RequestAssembler.php\`
- \`src/Generator/ModelPlanner.php\`
- \`src/Generator/Profile.php\` and \`src/Generator/InlineModelPinValidator.php\`
- \`truth/specs/model-generator.feature-260418.typ\`
- \`truth/specs/operation-generator.feature-260418.typ\`
- \`tests/\`
