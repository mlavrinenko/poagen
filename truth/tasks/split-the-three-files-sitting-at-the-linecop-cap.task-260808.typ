#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "split the three files sitting at the linecop cap",
  tags: ("debt",),
  priority: 5,
  difficulty: 3,
  status: proposed(2026, 8, 8),
)

== Summary

`ModelPlanner`, `ModelEmitter` and `Profile` are each exactly 250 lines, which
is `.linecop.yaml`'s PHP cap. A file at its cap is not passing the gate — it is
one line from failing it, and the next change to any of them pays for the split
whether or not the split belongs to that change.

Measured on 2026-08-08: a three-line plumbing change through
`ModelPlanner` and `ModelEmitter` (carrying a compatibility failure out to
`Generator::plan()`) cost three refactor-and-relint cycles and one trailing
comment moved onto a code line purely to buy back a line. That is the cap doing
the opposite of its job — it bought a worse comment instead of a smaller file.

The split is owed before the next feature lands in any of them.
`bind-a-format-per-property` is queued against `Profile` and the emitters, so
the cost is about to be paid a second time by a task that has nothing to do
with file size.

== Acceptance criteria

- Each of `ModelPlanner`, `ModelEmitter` and `Profile` is meaningfully below
  the 250-line cap, with enough headroom that an ordinary change does not
  re-trip it. A file left at 248 has not been split.
- Every extracted unit has a name that says what it owns, not where it came
  from. `ModelEmitterHelper` is the failure mode.
- The trailing comment that was folded onto a code line to save one line is
  restored to its own line.
- `just check` is green, and the generated trees are byte-identical before and
  after — this is a refactor, so `ByteStabilityTest` proves it changed nothing.
- Coverage does not fall: the extracted units are covered by the tests that
  covered them in place.

== Non-goals

- Does not change what any of the three do. No behaviour moves.
- Does not raise the cap. The cap is the gate working; the files are what is
  wrong.
- Does not sweep every other file near the cap. These three are the ones a
  queued task is about to hit.

== Files

- `src/Generator/ModelPlanner.php`
- `src/Generator/Emit/ModelEmitter.php`
- `src/Generator/Profile.php`
