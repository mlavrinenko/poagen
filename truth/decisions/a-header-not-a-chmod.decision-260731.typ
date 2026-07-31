#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/guidance.context.typ": *

#show: decision.with(
  title: "Emitted files declare themselves in a header; paogen does not make them read-only",
  status: accepted(2026, 7, 31),
  contexts: (generation-context,),
  goals: (
    link("../goals/never-edit-generated.goal.typ"),
    link("../goals/cheap-regeneration.goal.typ"),
  ),
  standards: (
    link("../standards/generated-types-are-total.standard-260729.typ"),
    link("../standards/regeneration-is-deterministic-and-total.standard-260729.typ"),
  ),
)

== Context

#A(GeneratedFile) said nothing about itself. A reader opening one saw
ordinary PHP, and the rule that keeps it whole lived somewhere else
entirely — in a standard, in a contributor guide, in a task. A rule that
is not in the artifact is a rule that gets broken by whoever did not read
the other document first, and it was: an automated run edited assertions
inside another tool's emitted tree after its own tooling failed, and
reported the edit afterwards rather than stopping.

Two mechanisms were on the table, and they answer different halves of the
problem. One tells the reader. The other stops the write.

== Choice

Every file #the(Generator) emits opens with a comment naming itself as
emitted, naming #the(Profile) that produced it, and printing the command
that reproduces it. It costs one stamping pass over the finished write
set, it survives a clone, and it is the first thing both a reader and an
automated agent see in the file they were about to edit.

Nothing is made read-only. That half is declined, deliberately rather
than by omission:

+ *It does not survive a clone.* Git records no write permission beyond
  the executable bit, so a fresh checkout hands every consumer a writable
  tree regardless. The protection would exist only on the machine that
  last ran #the(Generator) — the one machine whose owner already knows.
+ *It can strand a tree.* Only the writer can apply it, at generation
  time, which means the writer must also restore write permission before
  overwriting. A run that fails between those two steps leaves output the
  next run cannot replace, and the recovery is a `chmod` nobody
  documented. Trading a regeneration that always works for a barrier that
  only sometimes exists is the wrong side of `cheap-regeneration`.
+ *It protects the wrong tree.* The edit that prompted this landed in
  another generator's output. A permission bit paogen sets on its own
  files would not have been anywhere near it.

The header is honest about what it can do: it states the rule where the
rule applies. Nothing here claims to make the edit impossible, because
nothing available can.

== Consequences

- The header carries no timestamp, no version and no absolute path, so
  two runs over the same inputs still emit identical bytes and a
  regeneration diff stays readable.
- #The(Profile) is named by the path the run was given, relative to the
  directory it was invoked from. A profile built in code rather than
  loaded from a file names itself by paogen's conventional file name, and
  can say otherwise when it stands in for a real one.
- Reproducing a committed tree means invoking paogen the way its header
  prints, from the root the header's path is relative to. Generating the
  same tree from a different directory is a diff in the header — visible
  and self-explaining, which is the point.
- Anyone who wants the permission bit can set it themselves after a run.
  paogen does not, and will not restore it either.
