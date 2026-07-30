#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Rewire the speconaut recipes onto the current CLI and restore them to the gate",
  tags: ("speconaut",),
  priority: 6,
  difficulty: 3,
  status: proposed(2026, 7, 28),
)

== Summary

The Justfile drives speconaut through \`speconaut interop extract --format json | speconaut-phpunit ...\`. The \`interop\` subcommand no longer exists; test generation is now \`speconaut generate-tests --adapter phpunit\`, and the adapter binary still ships. The speconaut recipes are currently out of the \`just check\` aggregate so the gate can stay green during the migration; they need to come back once the truth tree validates.

=== Reproduction, 2026-07-30

Three separate problems sit behind the one symptom, and only the first is what this task originally assumed.

One: the adapter shim on PATH pointed at a directory that had been renamed. That is now fixed in the nix module, and the working invocation is:

\`\`\`
speconaut generate-tests truth/ --adapter php-phpunit -o <dir>
\`\`\`

Two things about it are easy to get wrong. The adapter is named \`php-phpunit\`, not \`phpunit\` --- the core CLI resolves \`--adapter X\` to a \`speconaut-X\` binary on PATH, so the old name now fails with \`no backend found for adapter 'phpunit'\`. And the adapter is a PHP script, so \`php\` has to be on PATH; without it the adapter dies on startup and the caller reports a broken pipe rather than anything about PHP:

\`\`\`
error: rpc generate-tests failed against .../speconaut-php-phpunit:
failed to write rpc request: Broken pipe (os error 32)
\`\`\`

Since \`php\` here comes from devbox and not from the system profile, any recipe or hook invoking this needs the devbox profile on PATH. With both right, generation exits 0: \`Generated 9 test module(s)\`.

Two: generation cannot be run against the repository root at all, because \`speconaut\` reads the project's MindTape config and rejects keys \`mt\` itself writes. Copy \`truth/\` and \`.speconaut/\` somewhere without a \`.mindtape/\` and it works. That is \`speconaut-mindtape-config-skew\`.

Three, and this is the one that changes the shape of this task: regenerating does not reproduce the committed tree, and would destroy work if it did. \`speconaut generate-tests\` emits stubs. The committed step files are those stubs plus hand-written bodies --- \`ProfileSteps.php\` is 145 lines against a freshly generated 100, and \`OperationGeneratorSteps.php\` is 1171 against 778. The fresh output also lands in namespace \`Speconaut\\Generated\` rather than the project's, and the new subcommand takes no \`--namespace\` flag where the retired pipeline did.

So the acceptance criterion below asking for "no diff against the committed tree" cannot be met as written, and the non-goal forbidding hand edits contradicts the files' own header: "This file is yours --- speconaut only appends new step stubs." Both need rewriting as part of this task: decide what speconaut owns in that tree, what a human owns, and what \`--check --strict\` is actually allowed to assert. The answer is visible in the artifacts already --- speconaut owns the \`\*Test.php\` stubs and the set of step methods; a human owns every step body --- it is just written down nowhere the check can use.

== Acceptance criteria

- \`just check-specs\`, \`just check-drift\`, \`just generate-tests\` and \`just check-generated-tests\` all invoke subcommands the installed binary actually has.
- Regenerating the PHPUnit stubs from the specs produces no diff against the committed \`tests/generated/\` tree, or the diff is reviewed and committed.
- The speconaut recipes are back in the \`just check\` aggregate and the whole gate is green.
- The drift check reads whatever field the current \`status\` output actually exposes, rather than the retired \`content\_mismatches\` key.

== Non-goals

- Changing what the generated tests assert.
- Hand-editing anything under \`tests/generated/\`.

== Files

- \`Justfile\`
- \`tests/generated/\*.php\`
