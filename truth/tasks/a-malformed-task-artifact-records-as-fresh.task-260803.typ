#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "a malformed task artifact records as fresh",
  tags: ("tooling", "gates"),
  priority: 4,
  difficulty: 3,
  status: accepted(
    2026,
    8,
    3,
  )[Found by walking into it. Filed rather than folded into gate-freshness-misses-the-files-linecop-lints, because that task's own criteria require the exclusion this one questions, and its comment's reason for the exclusion is sound.],
)

== Summary

`scripts/gate-fresh.inputs` excludes `truth/tasks`, and the comment above the
exclusion gives a good reason: `mt flip` writes the very task file it is
gating, so hashing task artifacts would change the hash out from under the
flip and no second flip could ever be fresh again.

The reason is right and the exclusion should stay. The hole is that
`speconaut check truth/` — which `just check` runs through `check-specs` —
does read `truth/tasks`, and can fail on it. So a task artifact can break the
gate while the freshness record still reads fresh, which is the same defect
`gate-freshness-misses-the-files-linecop-lints` closed for Markdown, pointing
at the one directory that task was required to leave alone.

=== How it was found, 2026-08-03

Not theoretically. A done-reason was written containing a bare
`skip` sigil in prose — the dollar form, unbackticked. Typst reads a bare
dollar as opening math mode, the artifact stopped parsing, and
`speconaut check truth/` failed with `eval error: unclosed delimiter`.

The sequence is the whole point:

+ the merged head was gated, exit 0, and the pass recorded;
+ two task files were then flipped to `done`, one carrying the typo;
+ the recorded pass still read fresh, because `truth/tasks` is excluded;
+ every subsequent `gated-check` in the repo failed, on every branch, until
  the one line was fixed.

An agent working an unrelated task in its own worktree hit the failure and
had to trace it back across a file boundary it was explicitly forbidden to
touch. That is the cost: the break is invisible where it happens and lands on
whoever runs the gate next.

=== Why the obvious fixes do not work

- *Hash `truth/tasks`.* This is what the exclusion's comment already rules
  out, for the reason it gives. Do not reopen it.
- *Hash task files with the status block excluded.* Makes the hash depend on
  parsing the artifact the hash exists to distrust, and a flip also writes a
  note, not only a status.
- *Track `truth/tasks` by path only*, the way this session's fix now tracks
  `truth/notes`. Catches an added or deleted task and misses exactly this
  case, which is content.

The shape that does work is to stop asking the hash to carry it. Freshness
answers "has anything the gate reads changed", and validity answers "does the
tree the gate reads still parse". They are different questions and the second
one is cheap — `speconaut check truth/` runs in about a second, against a full
gate of several minutes.

== Acceptance criteria

- A malformed artifact under `truth/tasks` cannot be recorded as, or read as,
  a fresh pass. Proven by doing it: break a task file, and show the freshness
  predicate refuses, rather than by reading the inputs list.
- The `truth/tasks` exclusion from the content hash stays, and its comment's
  reasoning stays true. Whatever closes this does not reintroduce the
  flip-invalidates-itself problem that comment describes — show a second flip
  still works after a first.
- The cost is bounded. Whatever the predicate gains must stay far cheaper than
  a gate run, or it defeats the point of recording a pass at all.
- The comment in `scripts/gate-fresh.inputs` says which question the hash
  answers and which it does not, so the next reader does not re-derive this.

== Non-goals

- Changing what `just check` runs.
- Validating task artifacts more strictly than `speconaut check` already does.
  This is about when the existing check is consulted, not what it checks.
- Teaching the freshness record to repair anything. It reports; it does not
  fix.

== Files

- `scripts/gate-fresh`
- `scripts/gate-fresh.inputs`
