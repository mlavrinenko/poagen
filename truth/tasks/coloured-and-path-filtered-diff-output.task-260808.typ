#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Add coloured and path-filtered output to poagen generate --diff",
  tags: ("generator", "dx"),
  priority: 2,
  difficulty: 2,
  status: done(2026, 8, 9),
)

== Summary

T-019 shipped `--diff` as a plain, unfiltered unified diff via
`sebastian/diff` and named two extensions as explicit non-goals: colouring the
output and filtering it to a path glob (e.g. `--diff Generated/Model/\*\*`).
Both stayed out of scope for the DX flags task itself and were carried
forward in `ROADMAP.md`'s post-v0.1 follow-ups as a single bullet. Filed here
as its own task now that the roadmap is retiring, so the intent survives in
MindTape rather than only in prose that is about to be retired.

== Acceptance criteria

- `poagen generate --diff` colours additions and deletions when the output is
  a TTY, and stays plain when it is not (piped to a file, CI log).
- `poagen generate --diff` accepts a path filter so a consumer can scope the
  diff to a subtree of the generated output.
- Both are additive: the existing plain, unfiltered `--diff` behaviour is
  still reachable with no new flags.
- A regression test locks each new behaviour.
- `just check` green end-to-end.

== Non-goals

- Machine-readable diff output (`--diff --format=json`). T-019 named this as
  a separate non-goal and it stays out of this task too.
- Changing `--dry-run` or `--output`, which are unaffected by this work.

== Files

- `src/Cli.php`
- `src/GenerateCommand.php`
