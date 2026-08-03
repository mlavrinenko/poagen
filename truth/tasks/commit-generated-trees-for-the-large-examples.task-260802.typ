#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Commit generated trees for the two large examples",
  tags: ("examples", "gate"),
  priority: 6,
  difficulty: 3,
  status: wip(2026, 8, 3),
  links: (depends-on("clear-example-expected-failures.task-260728.typ"),),
)

== Summary

kilbil and petstore commit their generated trees; DigitalOcean and GitHub do
not have one anywhere in the repository. Every measurement of emitted output —
the type-honesty audit, the duplication gate, the strict analysis of the
generated tier, the byte-stability check — therefore covers the two small
documents and skips the two that exercise the generator hardest.

That was defensible while both large examples carried an expected-failure
marker, because there was nothing correct to commit. Once they generate, the
absence becomes the thing that hides regressions: a change that widens a type
or drops a property on a GitHub-shaped document would pass every gate this
repository runs.

== Acceptance criteria

- Both trees are generated and committed once their example clears, and the
  byte-stability check covers all four examples rather than two.
- The strict analysis configured for the generated tier runs over both, with no
  suppression and no baseline.
- The repository's size and duplication gates are re-measured against the
  larger corpus, and any threshold that moves is moved deliberately, with the
  reason recorded, rather than adjusted until green.
- A regeneration that changes either tree fails until the diff is reviewed and
  committed, the same way the two small examples already behave.

== Non-goals

- Committing a tree for an example that still carries an expected-failure
  marker. This task waits for the marker to clear; it does not clear it.
- Running any example's client against a live API.

== Files

- `examples/digitalocean/generated/`, `examples/github/generated/`
- `Justfile`
- `phpstan-generated.neon`
- `.gitignore`, if it currently excludes them
