#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Commit composer.lock so the gate means the same thing everywhere",
  tags: (),
  priority: 8,
  difficulty: 2,
  status: done(2026, 8, 1),
)

== Summary

\`.gitignore:3\` ignores \`/composer.lock\`. paogen is an application, not a library, so nothing pins its QA tooling — every checkout resolves its own versions from \`composer.json\` and gets a different gate.

Measured 2026-07-31. The working checkout, whose lock was resolved in April, runs phpstan 2.1.50 / rector 2.4.2 / php-cs-fixer 3.95.1 and \`just check\` exits 0. A worktree created the same day resolved phpstan 2.2.7 / rector 2.5.9 / php-cs-fixer 3.95.18 and \`just check\` exits 2 — one \`NegatedAndsToPositiveOrsRector\` finding in \`src/Runtime/Marshal/PropertyTypeResolver.php:138\` and fifteen \`isset.offset\` findings across \`tests/\`.

So the gate is green here and red on a fresh clone, and neither result is more real than the other. An agent that reports a red gate is telling the truth; an agent that reports green is also telling the truth. That makes the gate useless as evidence.

== Acceptance criteria

- \`/composer.lock\` is no longer ignored and the lock is committed
- \`composer install\` in a fresh worktree installs the same versions as the working checkout
- \`just check\` gives the same result in a fresh worktree as in the main checkout; say in the report which versions and which result
- CONTRIBUTING.md or AGENT.md says which command a contributor runs to get the pinned tooling

== Non-goals

- does not upgrade any pinned tool; whichever versions are pinned now are the ones committed, and \`update-the-pinned-qa-tools\` owns moving them
- does not fix the rector and phpstan findings the newer versions surface — they are that task's problem
- does not change \`composer.json\` constraints

== Files

- \`.gitignore\`
- \`CONTRIBUTING.md\`
- \`composer.lock\`
