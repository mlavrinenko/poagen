#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Update the pinned QA tools and clear what they find",
  tags: (),
  priority: 4,
  difficulty: 3,
  status: status(
    "needs-review",
    2026,
    7,
    31,
    note: [landed this session; verified on the merged head by the orchestrator],
  ),
  links: depends-on("commit-composer-lock.task-260731.typ"),
)

== Summary

Once \`composer.lock\` is committed, moving the pinned QA tools becomes a deliberate change with a visible diff. The current lock is April's; resolving fresh today gives phpstan 2.2.7, rector 2.5.9 and php-cs-fixer 3.95.18, and those versions find real work:

- \`NegatedAndsToPositiveOrsRector\` in \`src/Runtime/Marshal/PropertyTypeResolver.php:138\`
- fifteen \`isset.offset\` findings — "Offset 0 ... always exists" — across \`tests/Integration/\`, \`tests/Support/\`, \`tests/generated/ModelGeneratorSteps.php\`, \`tests/generated/OperationGeneratorSteps.php:312\` and \`tests/generated/ProfileSteps.php\`

None of these are false positives on their face; they are findings the project has not seen because its tooling stopped moving.

== Acceptance criteria

- the lock pins current versions of phpstan, rector and php-cs-fixer
- \`just check\` exits 0 under them, in a fresh worktree as well as the main checkout
- every finding was fixed rather than suppressed; any exemption added carries an inline comment naming the tool's blind spot, per the analysis-runs-at-maximum-strictness standard

== Non-goals

- does not change which tools run or how the gate is composed
- does not touch generated trees under \`Generated/\`
- blocked until \`commit-composer-lock\` lands; without a committed lock there is nothing to move

== Files

- \`composer.lock\`
- \`src/Cli.php\`
- \`src/Runtime/Marshal/PropertyTypeResolver.php\`
- \`tests/Integration/\`
- \`tests/Support/GeneratedTreeSandbox.php\`
- \`tests/generated/\`
