#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Drop the committed trees for examples the generator cannot generate",
  tags: ("examples", "quality-gates", "strictness"),
  priority: 7,
  difficulty: 2,
  status: proposed(2026, 7, 30),
)

== Summary

`examples/digitalocean/` and `examples/github/` each carry an
`.expected-failure` marker and a committed `generated/` tree. Both statements
cannot be true at once: the marker says the generator cannot produce a tree for
this document, and the tree says it did. What is committed is output from an
older generator, and no run reproduces it — `php bin/paogen generate --dry-run`
on either profile exits non-zero and writes nothing.

`regeneration-is-deterministic-and-total` calls a stale emitted file "the most
expensive kind of wrong, because nothing surfaces it", and these are 3,400 files
of exactly that, sitting in the directory a newcomer browses first.

It also blocks `analyse-example-generated-trees`, which widens
`phpstan-generated.neon` to `examples/*/generated/` with no `excludePaths` and
no `ignoreErrors`. Pointed at what is committed today, that gate reports:

```
examples/petstore/generated      exit 0     0 errors
examples/digitalocean/generated  exit 1   113 errors
examples/github/generated        exit 1  7294 errors
```

with `parameter.requiredAfterOptional` accounting for 7,083 of them. Those are
not findings to fix at the emitter, because the emitter that produced them is
gone and the current one refuses these documents outright — there is no
regeneration that could clear them. The tree has to go, or the gate needs the
exclusion that task forbids.

That task's own non-goals already assume this state: "An example that does not
generate has no tree to analyse." Today one does.

== Acceptance criteria

- No example carrying `.expected-failure` also carries a `generated/` tree.
- `just check-examples` fails when an `.expected-failure` example has a
  `generated/` directory, with a message naming the example — the same way it
  already fails on a stale marker whose generator has started succeeding.
- The `examples/README.md` and each affected example's `README.md` say what a
  reader should expect to find in an expected-failure example, so the absence
  reads as deliberate rather than as a missing commit.
- Clearing an example's marker and committing its tree stays a single reviewable
  step, unchanged by this task.
- `just check-examples` still reports every example in its expected state.

== Non-goals

- Making the DigitalOcean or GitHub documents generate. That stays with
  `clear-example-expected-failures`, and this task must not make it harder — the
  tree it deletes is one those runs will re-emit.
- Widening `phpstan-generated.neon`. That is
  `analyse-example-generated-trees`, which this unblocks.
- Removing either example. The profile, README and schema all stay.

== Files

- `examples/digitalocean/generated/`
- `examples/github/generated/`
- `examples/digitalocean/README.md`
- `examples/github/README.md`
- `examples/README.md`
- `Justfile`
