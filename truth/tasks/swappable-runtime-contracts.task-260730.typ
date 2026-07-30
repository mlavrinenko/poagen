#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Declare the runtime as interfaces a consumer can replace wholesale",
  tags: ("runtime", "packaging", "dx"),
  priority: 7,
  difficulty: 7,
  status: status("needs-review", 2026, 7, 30),
)

== Summary

\`runtime-package-split\` answers the packaging half of the runtime question: generated code should depend on a small runtime package rather than on the whole generator. It does not answer the substitution half. Today the runtime is concrete classes — \`Hydrator\`, \`Marshaller\`, \`XmlWriter\`, \`DescriptorParser\` — and a generated client names them directly in its constructor defaults. A consumer who wants different hydration has nothing to implement against.

\`caller-surface-is-injectable\` already says the hydration machinery arrives through the constructor, and it does. But injecting a \`final readonly class\` is not substitution; the type is the implementation. The PSR packages are the model worth copying: \`psr/http-client\` ships an interface and nothing else, and the generated clients already type-hint \`ClientInterface\`, \`RequestFactoryInterface\` and \`StreamFactoryInterface\` rather than any concrete transport. Everything paogen emits should reach its runtime the same way.

This matters more once \`collapse-operations-onto-a-runtime-transport\` lands, because that moves request assembly and response decoding into the runtime too. The more behaviour sits behind the runtime, the more a consumer needs the option to replace all of it — and the more a concrete-class dependency costs them.

== Acceptance criteria

- Every runtime collaborator a generated file names is an interface, and every emitted type-hint points at the interface rather than at an implementation.
- The contracts are separable from their implementations, so a consumer can depend on the contracts alone.
- A consumer replaces every runtime implementation with their own, wired from their own configuration, without editing a generated file — proven by a test that does exactly that and asserts the substitutes were called.
- A consumer who replaces nothing gets working defaults and writes no wiring, so the substitution is opt-in rather than a tax.
- The default implementations remain the ones the examples use, and the examples are unchanged by this task beyond regeneration.
- The interfaces are documented well enough to implement against without reading the default implementation.

== Non-goals

- Registry publication and versioning; that is release work.
- Splitting the repository into several repositories.
- Changing what the default implementations do.
- Making the OpenAPI parser or the code-generation library swappable. Those are the generator's business, not the runtime's.

== Files

- \`composer.json\`
- \`src/Runtime/\`
- \`src/Generator/Emit/ClientConstructor.php\`
- \`src/Generator/Emit/ClientEmitter.php\`
- \`src/Generator/Emit/ModelEmitter.php\`
- \`tests/\`

== Result

Contracts live in \`src/Runtime/Contract/\` and depend on nothing but the PSR HTTP interfaces. Everything a generated file names is one of them: the transport, the hydrator, the marshaller, the XML writer, the descriptor parser. \`PropertyType\` and \`PropertyDescriptor\` moved there too, so a consumer implementing a contract does not have to reach back into the implementation namespace for the types it speaks in.

A consumer who replaces nothing writes one line and gets working defaults, with the PSR-18 client discovered lazily on first send:

\`\`\`php
new ApiClient(new HttpTransport('https://api.example.com', ApiException::class))
\`\`\`

From there they replace one collaborator by name, or several, or implement the transport interface and replace the lot. \`tests/Integration/RuntimeSubstitutionTest.php\` proves each case and asserts the substitutes were actually called rather than merely accepted.

Two shapes are deliberately not interfaces. \`Endpoint\` is the message rather than the messenger --- it carries no behaviour a consumer would want to swap, and making it injectable would cost a constructor parameter and a longer call at every emitted site. The response descriptor is the same argument.

\`HttpTransport\` takes the profile's exception class as a required argument rather than defaulting it. The runtime cannot name a per-profile generated class, and a default would hand somebody the wrong exception type silently --- which is the failure mode \`fail-loud-never-silent\` exists to prevent.
