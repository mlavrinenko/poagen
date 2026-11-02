#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Migrate the MindTape config to the current mt",
  status: proposed(2026, 10, 10),
)

== Summary

`mt check` fails under an `mt` built from mindtape main (382711d9, installed
2026-10-10):

```
.mindtape/config.toml:302:1: can't parse config: unknown field `visibility`, expected `when`
```

Every `mt` command that loads the config refuses, so the backlog is unreadable
until the config follows the current schema.

The same gap is in the dev shell. `devbox.json` carries no `mt`, so the binary
on `PATH` was installed by hand; that is why a session can run `mt` against a
schema its checkout's tooling does not pin. The latest mindtape input from
`qahq` fixes both the version and the schema, and `mt check` then finds the
task files and template the new rules refuse.

== Acceptance criteria

- `mt check` passes under the current `mt`.
- The dev shell installs that `mt` from `qahq`'s `mindtape` package, so a fresh
  checkout does not depend on a hand-installed binary.
- `.mindtape/config.toml` uses the current schema, including `when` on the
  `file` column.
- Every `related` link carries its note, and the task template fills its
  `title` slot for `mt check`.
- `just check` (or the repo's gate) is green again.

== Non-goals

- Rewriting task bodies beyond what the new rules require.
- Pinning `mt` to a released tag when no release carries the schema yet.

== Files

- `.mindtape/config.toml`
- #link("../../.mindtape/templates/task.typ")
- `devbox.json`, `devbox.lock`
- `truth/tasks/*.typ` whose `links:` the note rule refuses
