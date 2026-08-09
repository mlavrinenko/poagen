#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Land the dependabot action bumps",
  tags: ("gates",),
  priority: 4,
  difficulty: 1,
  status: proposed(2026, 8, 9),
  links: (related("v01-release-exit-criteria.task-260728.typ"),),
)

== Summary

Two dependabot branches have been sitting on `origin` since 2026-08-06,
both branched from `b370f638` and both a four-line edit to the one workflow
file:

- `dependabot/github_actions/actions/checkout-7` — `actions/checkout` v4 → v7
- `dependabot/github_actions/ramsey/composer-install-4` —
  `ramsey/composer-install` v3 → v4

`main` is 46 commits past that base and has not been pushed, so neither
branch can fast-forward and neither has been looked at. Both are major
bumps, which is the kind nobody merges on autopilot and therefore the kind
that rots: `actions/checkout@v4` is three majors behind and the node runtime
under it is what actually moves in those releases.

There is a second reason they cannot simply be merged. Every commit in this
repo carries a `Refs:` trailer resolving to a real task file, enforced by
`.githooks/commit-msg`; dependabot's `build(deps):` commits carry none and
`build` is not one of the exempt types. So landing them is a decision about
history as much as about CI — this task is the trailer they will name.

== Acceptance criteria

- Both bumps are on `main`, with dependabot's authorship preserved, and each
  commit carries a `Refs:` trailer naming this task.
- `just check-commit-trailers origin/main..HEAD` passes over the result.
- Each major bump is checked against what the workflow actually uses, not
  merged blind: `ramsey/composer-install@v4`'s inputs are confirmed to still
  include `dependency-versions` (the `lowest`/`highest` matrix leg depends on
  it), and `actions/checkout@v7`'s runner requirements are confirmed against
  `ubuntu-latest` and `macos-latest`, both of which this workflow uses.
- The workflow file parses and the job graph is unchanged — same jobs, same
  `needs`, same matrix.
- Whether the two stale remote branches are deleted after landing is decided
  here rather than left to accumulate.

== Non-goals

- Bumping anything else pinned in the workflow (`shivammathur/setup-php@v2`
  and friends) opportunistically.
- Configuring or re-tuning dependabot itself. If its grouping or schedule
  wants changing, that is its own task.
- Pushing `main`. The 46 unpushed commits are a separate decision.

== Files

- `.github/workflows/continuous-integration.yml`
