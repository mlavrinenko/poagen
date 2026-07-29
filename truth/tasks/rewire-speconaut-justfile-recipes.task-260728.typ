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
