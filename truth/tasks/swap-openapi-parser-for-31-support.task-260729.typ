#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Swap the OpenAPI parser to devizzent/cebe-php-openapi for 3.1 support",
  tags: ("parser", "openapi-31", "generator"),
  priority: 6,
  difficulty: 5,
  status: done(
    2026,
    8,
    2,
  )[Landed as 4745242. devizzent/cebe-php-openapi 1.1.5 in, patch and composer-patches wiring out; const/prefixItems/unevaluatedProperties/contentMediaType/webhooks abort by name with schema pointer and owner; kilbil and petstore byte-identical.],
)

== Summary

paogen parses OpenAPI through \`cebe/php-openapi\`, which is unmaintained enough that we carry \`patches/cebe-php-openapi-php84-nullable.patch\` to silence its PHP 8.4 deprecations. ADR-008 deferred 3.1 to post-v0.1 and named an external pre-processor as the interim answer; that interim is over, because the schemas worth generating against have moved to 3.1.

Two claims that were in this task's first draft were wrong, and correcting them is why this is no longer a priority-9 blocker.

There is no version gate. paogen never inspects \`\$openApi->openapi\` and never calls \`validate()\`, so a document declaring 3.1 is read structurally like any other. Nothing rejects it.

And the kilbil document uses no 3.1 construct at all — no \`type: \[T, "null"\]\`, no \`const\`, no \`prefixItems\`, no \`unevaluatedProperties\`. It is a 3.0-shaped document with a 3.1 version string, which is why it parses and reaches the emitters. The acceptance target therefore does not depend on this task; \`inline-body-and-response-schemas\` is its sole blocker.

=== Correction, 2026-08-02

The paragraph above is wrong in its second claim, and the error is a
measurement error worth naming: the sweep that produced it searched for the
JSON/flow spelling \`type: \[T, "null"\]\` and the kilbil document writes the
YAML block spelling. Counted directly, the document carries 87 multi-member
\`type\` declarations — 48 \`string\`+\`null\`, 26 \`integer\`+\`null\`, 12
\`array\`+\`null\`, 1 \`number\`+\`null\`. Every one is a 2020-12 construct with no
3.0 equivalent; the 3.0 spelling is the \`nullable\` flag, which the document
uses zero times.

Cross-checked with a validator that implements 3.1 rather than by grep alone:
\`redocly lint\` reads the document as OpenAPI 3.1 and reports the union types
back in its own diagnostics (\`type must be string,null\`). Its one error is a
vendor defect unrelated to this task — an \`enum\` at line 1282 carrying \`null\`
against a plain \`integer\` type — and the remaining 37 findings are
example-vs-schema mismatches in the vendor's own samples.

So the first claim stands (there is no version gate, and nothing rejects a
3.1 document) but the second is reversed: kilbil is a 3.1 document by content.
It parses today only because \`cebe/php-openapi\` hands the member list through
verbatim as a PHP array despite declaring \`Schema::\$type\` as \`string\`, and
paogen reads that array itself. That reading is the subject of four separate
tasks — \`nullable-type-arrays\`,
\`nullable-type-array-lost-in-property-synthesis\`,
\`scalar-union-path-parameter-degrades-to-mixed\` and
\`three-more-sites-read-only-the-30-nullable-flag\` — because it had to be
reimplemented at every call site that touched a type, and was still wrong at
three of them as of this correction.

That is the real argument for the swap, and it is not the one this task was
filed on. The cost is not a document paogen cannot read; it is that paogen
maintains a 3.1 type reader on top of a parser whose own type declaration
denies the shape exists, and every new call site starts out wrong by default.

What remains genuinely worth doing: the fork is maintained, it drops the patch we carry, and it handles documents that really do use 2020-12 constructs. The failure mode this prevents is not rejection but silent misreading — a 3.0-shaped parser handed \`type: \["string", "null"\]\` does not refuse it, and what it does instead is the thing to pin down.

\`devizzent/cebe-php-openapi\` is a maintained fork that declares \`replace: cebe/php-openapi\`, keeps the identical \`cebe\\openapi\\\` PSR-4 namespace, and fixes the PHP 8.4 deprecations upstream. The swap is therefore a composer change plus whatever the 3.1 object model exposes that the 3.0 one did not, and it lets the patch file go away entirely.

The risk this task must contain: a 3.1-native parser hands the emitters JSON Schema 2020-12 constructs they have never seen. That risk is now contained rather than theoretical — \`abort-on-unrepresentable-constructs\` has landed, so a construct the emitters cannot represent is a named failure rather than a quietly smaller client, and the swap will surface its own gaps.

Verified against the real document before this task was written, in a scratch project rather than by reading the fork's README. The fork installs clean, reads the kilbil 3.1.0 file, returns \`true\` from \`validate()\` with an empty error list, resolves all 36 operations, and emits no PHP 8.4 deprecation notices. So the parse side of this task carries little unknown risk; the unknown is entirely on the emitter side, downstream of the parser.

== Acceptance criteria

- \`composer.json\` requires \`devizzent/cebe-php-openapi\` and no longer requires \`cebe/php-openapi\`.
- \`patches/cebe-php-openapi-php84-nullable.patch\` is deleted and the \`composer\` patch wiring that applied it is removed.
- A document that genuinely uses 2020-12 constructs is either handled correctly or refused by name. What must not survive this task is the third option: read, misinterpreted, and emitted as something else. Prove it with a fixture using \`type: \[T, "null"\]\` and \`const\`, and record what the old parser did with it, since that is the regression this guards.
- The 3.0 nullable idiom and the 3.1 \`type: \[T, "null"\]\` idiom both resolve to the same emitted PHP nullable type, proven by two fixtures that differ only in that idiom and generate byte-identical output.
- kilbil's 87 multi-member \`type\` declarations emit the same PHP types after the swap as before it, byte for byte. \`SchemaType\` either stays the single reader of a \`type\` keyword or is retired against the parser's own accessor — what must not happen is a second reader appearing beside it.
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
