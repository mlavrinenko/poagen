#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Emit imported names in generated code instead of fully qualified ones",
  tags: ("generator", "dx", "strictness"),
  priority: 7,
  difficulty: 3,
  status: proposed(2026, 7, 30),
)

== Summary

Generated code refers to types by their fully qualified name in every PHPDoc it writes, including types it has already imported and types that live in the file's own namespace.

\`OperationEmitter.php:231\` adds the \`use\` and \`:235\` then writes the FQCN anyway:

\`\`\`php
\$namespace->addUse(ltrim(\$fqcn, '\\\\'));
\$method->addComment('\@return list\<' . \$fqcn . '>');
\`\`\`

\`ModelEmitter.php:167\` is worse, because the type is in the same namespace as the file. In \`examples/kilbil/generated/Generated/Model/GetProgramsResponse.php\`:

\`\`\`php
namespace Acme\\Kilbil\\Generated\\Model;

/\*\* \@param ?list\<\\Acme\\Kilbil\\Generated\\Model\\GetProgramsResponseDataItem> \$data \*/
\`\`\`

Signatures are already correct, because nette resolves types it owns. Only comment strings escaped, since nette treats a comment as an opaque literal and paogen concatenates the FQCN into it by hand.

Global functions and constants are the same complaint from the other side: emitted bodies write \`\\json\_decode\`, \`\\JSON\_THROW\_ON\_ERROR\`, \`\\assert\`, \`\\urlencode\`, \`\\implode\`, \`\\rtrim\`, \`\\str\_replace\`, \`\\array\_values\`, \`\\array\_map\`, \`\\http\_build\_query\`. These should be imported with \`use function\` and \`use const\`, matching what \`import-global-functions-in-source\` settles for the generator's own sources.

== Acceptance criteria

- Every PHPDoc type emitted into a generated file uses the shortest name valid in that file's namespace: bare for a same-namespace type, the alias for an imported one, FQCN only when neither applies.
- Every global function and constant a generated body calls is imported with \`use function\` / \`use const\` and written unqualified.
- No \`use\` is emitted for a symbol nothing in the file references; the emitted tree stays clean under an unused-import check.
- \`just lint-phpstan-generated\` is green at max level with no baseline, no \`excludePaths\` and no \`ignoreErrors\`, per \`analysis-runs-at-maximum-strictness\`.
- \`tests/fixtures/generated\`, \`examples/petstore/generated\` and \`examples/kilbil/generated\` are regenerated and committed; \`just check-examples\` reports no drift.
- The byte-stability test still passes: two consecutive runs produce identical output.
- A test asserts the shortened form directly, so a regression to FQCNs fails rather than merely looking untidy.

== Non-goals

- Restructuring what the bodies do. \`collapse-operations-onto-a-runtime-transport\` owns that, and will delete many of these call sites outright.
- The generator's own sources; \`import-global-functions-in-source\` covers those.
- Changing emitted signatures, which are already correct.

== Files

- \`src/Generator/Emit/OperationEmitter.php\`
- \`src/Generator/Emit/ModelEmitter.php\`
- \`src/Generator/Emit/ParameterAdder.php\`
- \`src/Generator/Emit/RequestBodyParameterEmitter.php\`
- \`src/Generator/Emit/ArrayWrapperEmitter.php\`
- \`src/Generator/Emit/ResponseHandler.php\`
- \`src/Generator/Emit/RequestAssembler.php\`
- \`src/Generator/Emit/BodyAttachmentEmitter.php\`
- \`src/Generator/Emit/ScalarVoEmitter.php\`
- \`src/Generator/Emit/SecurityEmitter.php\`
- \`tests/fixtures/generated/\`
- \`examples/petstore/generated/\`
- \`examples/kilbil/generated/\`
