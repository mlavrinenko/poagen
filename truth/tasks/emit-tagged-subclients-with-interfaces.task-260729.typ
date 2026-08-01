#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Emit tagged sub-clients, each behind its own interface",
  tags: ("dx", "architecture", "generator", "interfaces"),
  priority: 8,
  difficulty: 7,
  status: done(2026, 8, 1),
)

== Summary

The generated \`ApiClient\` is a \`final readonly class\` implementing no interface, carrying every operation in the document as a flat method. Two things follow, and both block the architecture this project exists to support.

First, there is no declared contract. A consumer who wants to add retries, a paginated iterator, or a method taking a domain object has nothing to implement and nothing to decorate; the only way in is to edit generated code, which \`never-edit-generated\` forbids. Hand-written convenience and generated core have no seam to meet at.

Second, a flat client is the wrong injection unit. A service that touches three endpoints has to accept an object exposing all of them, and a unit test has to fake the whole surface to exercise one call. Against kilbil that is a 36-method dependency for code that uses two of them.

Both are the same fix: group operations by their OpenAPI tag, emit one sub-client per tag, emit an interface for each, and make the root client a composition root that hands them out. Sub-clients become the primary surface — separately constructible, separately injectable, separately fakeable.

== Acceptance criteria

- Every operation carrying a tag is emitted as a method on a sub-client named after that tag, and each sub-client is a class implementing an emitted interface declaring exactly its own methods.
- An operation carrying several tags is emitted on every one of its sub-clients. The profile can override this with an explicit per-operation tag choice, and an override naming a tag the operation does not carry fails the run.
- Operations carrying no tag are emitted on the root client directly. No \`DefaultApi\` type is invented.
- The profile can assign a tag to an untagged operation, so a consumer can repair a vendor's under-tagged document without editing the schema.
- The root client exposes one accessor per tag and no flat operation methods. Exactly one way exists to reach any given endpoint.
- Each sub-client is constructible on its own from the PSR-18 client, the PSR-17 factories, the base URI, and the hydration collaborators — it does not require the root client to exist.
- Each emitted interface is what a consumer type-hints. A hand-written decorator implementing a sub-client interface and delegating to the generated one compiles and satisfies PHPStan at max level, proven by a committed example.
- A tag that is not already a legal, readable PHP identifier is normalised into one deterministically. kilbil proves this is not hypothetical: all eleven of its tags are Russian words — \`Клиенты\`, \`Операции\`, \`Подарочные сертификаты\`. PHP would accept them as identifiers and the result would be unusable.
- The profile can rename any tag, so a consumer maps \`Клиенты\` onto \`Customers\` and gets the sub-client name they want rather than the transliteration paogen guessed. A rename naming a tag absent from the document fails the run.
- Regenerating a document whose tags did not change produces no diff.
- \`just check\` passes, and \`phpstan-generated.neon\` reports the emitted tree clean at max level.

== Non-goals

- Typed exceptions per declared error schema. That stays with \`typed-error-responses\`.
- Splitting the runtime out of the generator package. That stays with \`runtime-package-split\`.
- Emitting an interface for the model types. Only the caller surface gets one here.
- Asynchronous or streaming call styles.

== Files

- \`src/Generator/Emit/ClientEmitter.php\`
- \`src/Generator/Emit/OperationEmitter.php\`
- \`src/Generator/Emit/OperationAnalyzer.php\`
- \`src/Generator/Profile.php\` (tag assignment and tag-choice overrides)
- \`src/Generator/ClientPlanner.php\` or a new planner for tag grouping
- \`examples/\*/generated/\`
- \`tests/\`
