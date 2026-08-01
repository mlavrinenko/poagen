#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Scope the PHP tool cache to the checkout that built it",
  tags: (),
  priority: 5,
  difficulty: 2,
  status: done(2026, 8, 1),
)

== Summary

Rector pins its compiled DI container to \`sys\_get\_temp\_dir()\` and PHPStan does the same when no \`tmpDir\` is configured. The default is machine-wide \`/tmp\`, keyed by config hash rather than by checkout, so every paogen worktree on the box shares one cache and a deleted worktree leaves absolute paths baked into it. A later run hits that cache and dies in the worker pool with \`ProcessPool.php line 30: Process "\<random>" not found\`, which reads like a tool regression and is not one.

This cost two agents time on 2026-07-31 and made a third report a red gate against a base that was green, because the answer depended on which stale cache the run happened to hit.

== Acceptance criteria

- \`just check\` exits 0 from a clean tree with nothing set in the environment; verified after \`just clean\`
- the cache lives under the checkout, so \`just clean\` clears it
- \`AGENT.md\` documents the symptom rather than the workaround, since there is no longer a workaround to run

== Non-goals

- does not configure \`tmpDir\` inside \`phpstan.neon.dist\` or \`rector.php\`; one export covers every tool that reads the variable
- does not change which linters run or how the gate is composed

== Files

- \`Justfile\`
- \`AGENT.md\`
