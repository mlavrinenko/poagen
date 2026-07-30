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

One: the adapter shim on PATH points at a directory that was renamed. \`/home/tank/.nix/modules/apps/speconaut.nix\` lines 50--51 build the wrapper against \`adapters/speconaut-phpunit\`, and the adapter now lives at \`adapters/speconaut-php-phpunit\` with the binary renamed to match. So the wrapper exits 1 before doing anything, and \`speconaut generate-tests\` fails through it too, because the core CLI shells out to the same name:

\`\`\`
error: rpc generate-tests failed against /etc/profiles/per-user/tank/bin/speconaut-phpunit:
failed to write rpc request: Broken pipe (os error 32)
\`\`\`

Point a shim at the real binary and generation succeeds --- \`Generated 9 test module(s)\`, exit 0. That is the fix, and it belongs in the nix module, not here.

Two: generation cannot be run against the repository root at all, because \`speconaut\` reads the project's MindTape config and rejects keys \`mt\` itself writes. Copy \`truth/\` and \`.speconaut/\` somewhere without a \`.mindtape/\` and it works. That is \`speconaut-mindtape-config-skew\`.

Three, and this is the one that changes the shape of this task: regenerating does not reproduce the committed tree, and would destroy work if it did. \`speconaut generate-tests\` emits stubs. The committed step files are those stubs plus hand-written bodies --- \`ProfileSteps.php\` is 145 lines against a freshly generated 100, and \`OperationGeneratorSteps.php\` is 1171 against 778. The fresh output also lands in namespace \`Speconaut\\Generated\` rather than the project's, and the new subcommand takes no \`--namespace\` flag where the retired pipeline did.

So the acceptance criterion below asking for "no diff against the committed tree" cannot be met as written, and the non-goal forbidding hand edits does not describe how these files are actually maintained. Both need rewriting as part of this task: decide what speconaut owns in that tree, what a human owns, and what \`--check --strict\` is actually allowed to assert.

Ten literal-string assertions in \`ModelGeneratorSteps.php\` and \`OperationGeneratorSteps.php\` were hand-edited under \`import-generated-type-references\` because the emitted spellings they pin changed and no tool could regenerate them. Those edits are debt this task settles.

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
