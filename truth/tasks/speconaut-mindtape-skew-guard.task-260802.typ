#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Keep speconaut's embedded mindtape in step with the installed mt",
  tags: ("speconaut", "mindtape", "interop", "upstream"),
  priority: 5,
  difficulty: 4,
  status: proposed(2026, 8, 2),
)

== Summary

The config-skew defect is fixed. On 2026-08-02 \`speconaut check truth/\` parsed
paogen's full gated preset with the \`\[\[on.flip\]\]\` hooks uncommented, and the
parse was proven real rather than skipped: appending an extra hook block still
passed, while appending an unknown key under \`tasks\` failed the check with two
errors. The cause was healed upstream when speconaut's Cargo workspace was
repointed at the extracted sibling crates, so it could rebuild against current
mindtape again.

What was never done is the durability half. speconaut still takes a path
dependency on \`../mindtape/crates/mindtape\` for its task model and config
validation, while the binary anyone actually runs is separately installed from
the nix profile. Nothing ties those two together. The next key mindtape's
config schema gains will reproduce the same failure: \`mt\` writes a config that
the installed speconaut rejects, and the symptom will again read as a paogen
problem rather than a version gap.

The mechanism that keeps them in step is speconaut's design call, not paogen's.
What paogen needs is only that some mechanism exists.


== Acceptance criteria

- speconaut carries a written account of how its embedded mindtape and the
  separately-installed \`mt\` stay in step, next to the dependency it describes.
- Whatever mechanism is chosen fails visibly when the two drift, rather than
  surfacing as an unrelated parse error in a consuming project.
- Re-running the proof from this task's summary against paogen still passes:
  an added hook block parses, an unknown key under \`tasks\` fails.


== Non-goals

- Changing paogen's MindTape preset. The config is correct and the reader has
  caught up.
- Pinning paogen to a locally-built speconaut binary.
- Publishing either crate.


== Files

- The speconaut repository, which is where the whole fix lives.
- Nothing in paogen; this is tracked here because paogen is what breaks when it
  drifts.

