#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Import global functions and constants instead of prefixing them with a backslash",
  tags: ("style", "dx"),
  priority: 6,
  difficulty: 1,
  status: done(2026, 8, 1),
)

== Summary

\`.php-cs-fixer.dist.php:19\` sets \`native\_function\_invocation\` with \`\@compiler\_optimized\`, so every call to a compiler-optimised global function is written \`\\json\_decode(...)\` and every global constant \`\\JSON\_THROW\_ON\_ERROR\`. The rule buys the same symbol resolution an import buys, and pays for it in a leading backslash on every call site.

The project prefers the import. \`use function json\_decode;\` and \`use const JSON\_THROW\_ON\_ERROR;\` resolve just as directly, say where the symbol came from at the top of the file rather than at each use, and read like the class imports directly above them. \`ordered\_imports\` at \`.php-cs-fixer.dist.php:20\` already declares an order for \`class\`, \`function\` and \`const\` groups, so the configuration anticipated this.

The two rules are mutually exclusive: \`global\_namespace\_import\` with \`import\_functions\` strips the prefix that \`native\_function\_invocation\` adds, so the latter has to go in the same change.

== Acceptance criteria

- \`native\_function\_invocation\` is gone from \`.php-cs-fixer.dist.php\` and \`global\_namespace\_import\` replaces it, importing classes, functions and constants.
- No \`\\\`-prefixed global function or constant call remains under \`src/\`, \`tests/\` or \`bin/\`.
- \`just check\` is green: cs-fixer, both PHPStan tiers, rector, linecop and PHPUnit.
- Emitted output is unchanged by this task — the cs-fixer finder never touched generated trees, and \`import-generated-type-references\` is what changes those.

== Non-goals

- Generated code. \`import-generated-type-references\` owns the emitted tree.
- Any behavioural change. This is a spelling change the formatter applies.
- Widening the cs-fixer finder to cover \`examples/\`.

== Files

- \`.php-cs-fixer.dist.php\`
- \`src/\`
- \`tests/\`
- \`bin/\`

The import lines pushed three files past linecop's 250-line limit, so the change
carried three splits it did not set out to make:

- \`src/Runtime/Marshal/PropertyTypeResolver.php\` takes the type-resolution half
  of \`DescriptorParser\` (259 lines to 139).
- \`src/Generator/PrunePlanner.php\` takes the \`Generated/\` tree walk out of
  \`Generator\` (253 to 216).
- \`tests/Support/GeneratedTreeSandbox.php\` takes the scratch-directory,
  autoloader and cleanup helpers out of
  \`tests/Integration/QueryApiKeySecuritySchemeTest.php\` (256 to 213). All ten
  integration tests carry their own copy of those three helpers; only this one
  moved onto the shared trait, and \`deduplicate-the-test-suite\` moves the rest.
