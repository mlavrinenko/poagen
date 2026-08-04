#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "write the lessons this session paid for into the guide",
  tags: ("docs", "process"),
  priority: 3,
  difficulty: 2,
  status: done(2026, 8, 4),
)

== Summary

`agent-guide-is-nine-lines-from-its-own-cap` makes headroom in `AGENT.md`. This
fills some of it, and it is deliberately a second task: a split reviewed as a
pure move is checkable at a glance, and the same diff carrying new prose is
not.

Depends on that task landing first, because the whole point is that there is no
room today.

== The four, with what each one cost

=== A task that fixes another project is filed in that project's tracker

Not in the tracker of the project that suffers from it.
`speconaut-mindtape-skew-guard` sat in this repo naming no paogen file at all;
it became speconaut's `keep-the-embedded-mindtape-in-step-with-the-installed-mt`
and was retired here, with `speconaut-mindtape-config-skew` recording where it
went. A task filed against the wrong repository is invisible to whoever can fix
it and clutters whoever cannot. This was already identified as belonging in the
guide; it has been waiting on room.

=== `speconaut check truth/` is a one-second validator, and a bare sigil breaks it

The full gate takes minutes. `speconaut check truth/` parses every artifact
under `truth/` and returns in about a second, so it is the right feedback loop
for any artifact edit — run it directly rather than discovering the failure
inside a gate run.

What it catches, and cost a session real time to learn: Typst reads a bare
dollar sign in prose as opening math mode. Writing a PHP sigil unbackticked in
a task artifact produces `eval error: unclosed delimiter`, and the failure
surfaces to whoever runs the gate next rather than to whoever wrote it, because
`truth/tasks` is excluded from the freshness hash. Backtick every sigil.

That excluded-yet-read asymmetry is itself filed, as
`a-malformed-task-artifact-records-as-fresh`. This entry is the workaround; that
task is the fix.

=== `mt` builds from source, so its failure is not this repo's failure

The `mt` on `PATH` is a wrapper that rebuilds the mindtape checkout on every
invocation. When that checkout does not compile — an uncommitted dependency
edit was enough on 2026-08-03 — every `mt` subcommand exits 101, including
`mt ls` and `mt check`. Nothing about paogen is wrong when this happens and no
amount of debugging in this repo will move it.

The workarounds, both proven that day: edit task artifacts by hand, since the
format is plain Typst, and validate them with `speconaut check truth/`; and
call `scripts/gate-fresh is-fresh` directly, which is exactly what the
`[[on.flip]]` predicate in `.mindtape/config.toml` calls.

=== Gate after the last commit, not after the merge

A gate pass covers the tree it ran against and nothing later. Recording a pass,
then committing a status flip on top of it, then treating the earlier pass as
covering the flip, is how a broken artifact reached `main` on 2026-08-03. The
freshness record did not object, correctly, because the file in question is
excluded from its inputs.

So: run the gate as the last thing before the work is called done, after every
commit that will be part of it. The rule generalises past this repo — a
recorded pass is a claim about a specific tree.

== Acceptance criteria

- All four entries are in the guide, each stating the trap and what it costs,
  in the voice the surrounding entries already use.
- Each says what to do, not only what went wrong. An entry a reader cannot act
  on is a paragraph against the cap.
- The guide stays under the linecop Markdown cap, with the remaining headroom
  stated, and `just check` passes.
- The cross-project-tracker entry is placed where someone about to file a task
  will meet it, not appended to a list of tool traps. It is a different kind of
  rule from the other three.

== Non-goals

- Re-doing the split. `agent-guide-is-nine-lines-from-its-own-cap` owns where
  things live; this owns what is added afterwards.
- Fixing `mt`, or touching the mindtape checkout. This records how to work
  while it is broken.
- Fixing the freshness asymmetry, which is
  `a-malformed-task-artifact-records-as-fresh`.

== Files

- `AGENT.md`, or whichever file the split gives these entries to
