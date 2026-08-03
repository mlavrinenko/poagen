#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "agent guide is nine lines from its own cap",
  tags: ("docs", "process"),
  priority: 3,
  difficulty: 2,
  status: done(
    2026,
    8,
    3,
  )[Landed as 4fc3d88, merged and re-gated on the integrated HEAD. Split by audience rather than by size: process guidance read once at the start of a task stays in AGENT.md, and trap material consulted when a gate goes red moved to AGENT_HAZARDS.md, with the four parser accessors kept together as one list. Nothing deleted — every prior line survives verbatim in one of the two files. 219 lines with 81 to spare, and 86 with 214. The agent checked rather than assumed whether the new file was covered by the freshness manifest, found it was not, and reported it instead of editing out of boundary; that gap is the-freshness-manifest-enumerates-root-docs-and-drifts.],
)

== Summary

AGENT.md is at 289 code-comment lines against linecop's 300-line Markdown cap, which is enforced in just check across the whole repo. It grew by about 35 lines in one day: four parser accessors that lie, two rector-versus-phpstan loops, and a note that shipmonk's dead-property finding is not confined to reflection-only fixtures.

Every one of those earned its place — each cost an agent real time and each is the kind of thing a reader cannot rediscover cheaply. That is the problem. The file is doing its job well enough that it will hit the cap, and the agent who hits it will be mid-task on something unrelated, discovering that the gate rejects a paragraph rather than their code.

Nine lines is roughly one more trap.

The guide's own rule applies to itself: a stale sentence reads exactly like a current one, and a file nobody can add to is a file that goes stale.

== Acceptance criteria

- AGENT.md is under the cap with room for several more entries, and just check passes.
- The split is by audience, not by size. A reader looking for one thing finds it without knowing which file it landed in, and the entry point says what lives where.
- Nothing is deleted to make room. If something is genuinely obsolete it goes because it is obsolete, and the report says which and why.
- The parser-accessor traps stay together as one list. They are read as a set, not looked up individually.
- Whatever file the split creates is covered by the same linecop cap, and its own headroom is stated.

== Non-goals

- Rewriting the guidance itself. This is about where it lives.
- Raising or excluding anything from the Markdown cap. The cap is the forcing function that surfaced this.
- CONTRIBUTING.md and README.md, which are separately capped and not near it.

== Files

- AGENT.md
- whatever file the split creates
- .linecop.yaml only if a new path needs covering
