#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Generate fixture trees to a scratch directory instead of over the golden",
  tags: ("tests", "fixtures", "robustness"),
  priority: 4,
  difficulty: 4,
  status: done(2026, 8, 2),
)

== Summary

The fixture profiles under \`tests/fixtures/profiles/\` point their \`output:\`
at the committed golden trees themselves — \`parameters.php\` writes to
\`tests/fixtures/generated/parameters\`. A test run therefore regenerates the
goldens in place and, when the generator is correct, rewrites them
byte-identically, so nothing looks wrong.

It stops being harmless the moment the generator under test is deliberately
wrong. Wiring mutation testing on 2026-08-02 surfaced it immediately: a
single-file run against \`SecurityScheme.php\` produced a mutant of
\`camelize()\` that left
\`tests/fixtures/generated/parameters/Generated/ApiClient.php\` carrying
\`\$ApiKey\` where \`\$apiKey\` belongs — as a tracked modification that outlived
the run. A \`git commit -a\` afterwards would have shipped mutated generator
output as the golden truth, and every byte-stability assertion would then
have agreed with it, because the golden is what they compare against.

\`scripts/mutation-run\` guards the mutation path today: it refuses to start
when a generated tree is already dirty and restores those trees afterwards
whatever the exit status. That is a guard on one caller, not a fix. Any
future harness that runs the suite against an intentionally broken generator
— a fuzzer, a fault-injection test, a bisect over a bad commit — walks into
the same trap.


== Acceptance criteria

- A test run generates into a scratch directory and compares against the
  committed golden, rather than writing over it.
- Running the suite with a deliberately broken generator leaves every
  committed fixture tree unmodified. Prove it by breaking one on purpose and
  checking \`git status\`, not by reasoning about it.
- Regenerating a golden on purpose is still a supported, documented action —
  this makes the overwrite deliberate, it does not remove it.
- \`scripts/mutation-run\`'s restore step becomes redundant. Say so, or remove
  it, rather than leaving two mechanisms guarding the same thing.


== Non-goals

- Changing what the fixtures contain, or which schemas they cover.
- The byte-stability comparison itself, which is doing its job.


== Files

- \`tests/fixtures/profiles/\`
- \`tests/Integration/ByteStabilityTest.php\`
- \`scripts/mutation-run\`


== Result

Every fixture profile under `tests/fixtures/profiles/` now defaults its
`output:` to a scratch directory under `$TMPDIR`, computed by a new
`tests/fixtures/profiles/scratch-output.php`. Nothing under
`tests/fixtures/generated/` is a default write target for any caller any more,
including the speconaut-generated step files that load a profile and call the
generator directly — those needed no change, because they read
`$profile->output` dynamically, so redirecting the profile's own default reached
them transparently.

Proved rather than argued, as the second criterion demanded. `camelize()` was
mutated to reproduce the original defect exactly, the full suite ran and
genuinely caught it with real failures, and `git status --porcelain` showed
every committed tree under `tests/fixtures/generated/` unchanged. The break was
then reverted and the gate came back green.

Regenerating a golden on purpose stays supported through the CLI's existing
`--output` override, now wrapped as `just regenerate-fixture <name>` and
documented in CONTRIBUTING.md — the overwrite is deliberate now, not removed.
`scripts/mutation-run`'s restore step is gone, since it is structurally
unreachable; its dirty-tree check stays, re-purposed as a fail-loud assertion
that would catch a regression of this fix instead of papering over one.

One thing the redirect weakened, filed rather than left implicit: two step
assertions that used to read fresh output now read the committed golden, because
before this change the golden was the fresh output. See
`step-assertions-read-the-golden-not-fresh-output`.
