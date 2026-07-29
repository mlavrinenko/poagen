#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Swap the OpenAPI parser to devizzent/cebe-php-openapi for 3.1 support",
  tags: ("parser", "openapi-31", "generator"),
  priority: 9,
  difficulty: 5,
  status: proposed(2026, 7, 29),
)

== Summary

paogen parses OpenAPI 3.0 through \`cebe/php-openapi\`, which is unmaintained enough that we carry \`patches/cebe-php-openapi-php84-nullable.patch\` to silence its PHP 8.4 deprecations, and which rejects a 3.1 document outright at the version gate. Every schema we actually want to generate against is 3.1, including the kilbil loyalty document that is this project's acceptance target. ADR-008 deferred the whole question to post-v0.1 and named an external pre-processor as the interim answer; that interim is over.

\`devizzent/cebe-php-openapi\` is a maintained fork that declares \`replace: cebe/php-openapi\`, keeps the identical \`cebe\\openapi\\\` PSR-4 namespace, and fixes the PHP 8.4 deprecations upstream. The swap is therefore a composer change plus whatever the 3.1 object model exposes that the 3.0 one did not, and it lets the patch file go away entirely.

The risk this task must contain: a 3.1-native parser hands the emitters JSON Schema 2020-12 constructs they have never seen, and today those fall through \`TypeResolver\` into the silent-skip paths. This task therefore lands after \`abort-on-unrepresentable-constructs\`, so a construct the emitters cannot represent becomes a named failure rather than a quietly smaller client.

== Acceptance criteria

- \`composer.json\` requires \`devizzent/cebe-php-openapi\` and no longer requires \`cebe/php-openapi\`.
- \`patches/cebe-php-openapi-php84-nullable.patch\` is deleted and the \`composer\` patch wiring that applied it is removed.
- \`paogen generate\` accepts a document declaring \`openapi: 3.1.0\` without a version-gate rejection, proven by a test fixture committed under the validation-tier schemas.
- The 3.0 nullable idiom and the 3.1 \`type: \[T, "null"\]\` idiom both resolve to the same emitted PHP nullable type, proven by two fixtures that differ only in that idiom and generate byte-identical output.
- A document using a 2020-12 construct the emitters do not implement fails the run with a message naming the construct, the schema pointer, and the operation or component it appeared in. It does not emit a smaller client.
- \`just check\` passes with no new PHPStan baseline entries and no suppressions.
- The existing example fixtures regenerate byte-identically, or their diff is reviewed and committed as an intended parser-behaviour change.

== Non-goals

- Implementing emitter support for \`prefixItems\`, \`unevaluatedProperties\`, \`contentMediaType\`, or webhooks. Those abort with a named failure until a task asks for each one.
- Supporting OpenAPI 2.0 or Swagger documents.
- Changing how the parser resolves external references.

== Files

- \`composer.json\`, \`composer.lock\`
- \`patches/cebe-php-openapi-php84-nullable.patch\` (deleted)
- \`src/SchemaLoader.php\` or wherever the version gate lives
- \`src/Generator/Emit/TypeResolver.php\`
- \`tests/\` fixtures for the 3.0 and 3.1 nullable idioms
