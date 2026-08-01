#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Implement the step bodies paogen's specs have outrun",
  tags: ("speconaut",),
  priority: 7,
  difficulty: 4,
  status: done(2026, 8, 1),
)

== Summary

Regenerating paogen's tests against its current specs appends roughly 200 \`Implement:\` stubs across the four Steps files, and the regenerated suite runs 93 tests with 89 failures — every one of them a stub, none a real defect. Measured in a scratch copy on 2026-07-31; paogen's own tree was not written to.

Before regeneration that same suite is 77 tests with no failures. So the gap is not damage done by regenerating: it is the specs having grown while the recipes that keep the generated tree in step sat outside the gate. The scenarios were written and nobody was ever told the steps behind them did not exist.

Append-only holds — zero lines were removed from any Steps file — so the hand-written bodies already there are safe.

== Acceptance criteria

- regenerating the tree adds no \`Implement:\` stub that stays unimplemented
- the generated suite runs green, and its test count is stated before and after
- \`speconaut generate-tests --adapter php-phpunit --check\` exits 0
- any scenario that turns out to assert something paogen does not do is reported rather than given a body that fakes agreement

== Non-goals

- does not change any scenario to make a step easier to implement; if a scenario is wrong that is a separate finding
- does not touch the emitter under \`src/\`
- does not restage any scenario

== Files

- \`.php-cs-fixer.dist.php\`
- \`phpstan.neon.dist\`
- \`tests/generated/\`
