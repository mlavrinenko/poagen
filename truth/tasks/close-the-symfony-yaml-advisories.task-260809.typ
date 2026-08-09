#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Close the symfony/yaml advisories",
  tags: ("gates",),
  priority: 5,
  difficulty: 1,
  status: done(
    2026,
    8,
    9,
  )[symfony/yaml 8.1.2 on the lock; composer audit clean in both package roots; all four goldens byte-identical],
  links: (related("v01-release-exit-criteria.task-260728.typ"),),
)

== Summary

`composer audit` reports three advisories against the installed
`symfony/yaml` 7.4.8: CVE-2026-45304 (billion-laughs memory blowup through
recursive collection aliases), CVE-2026-45305 (ReDoS in `Parser::cleanup()`),
CVE-2026-45133 (stack exhaustion on unbounded nesting). All three are fixed
from 7.4.12 and 8.0.12.

Low severity, and none of them is poagen's code — but poagen's exposure is not
theoretical. `symfony/yaml` arrives through `devizzent/cebe-php-openapi`,
which is in `require`, not `require-dev`, and it is the parser that reads the
YAML OpenAPI document a consumer hands `poagen generate`. All three
advisories describe a hostile document exhausting the process. That is
precisely the input this tool takes.

Shipping 0.1.0 with a known-vulnerable parser on the production path is the
wrong first impression for a tool whose pitch is that its gates are real.

== Acceptance criteria

- `composer audit` reports no advisories, and the version it lands on is
  recorded in the commit message rather than only in the lock diff.
- The bump is a lock-only change if it can be: nothing is added to
  `composer.json` unless a constraint genuinely has to move, since
  `symfony/yaml` is transitive and pinning it in this package would make
  poagen an opinion on a dependency it does not use directly.
- `just check` green, including the CI matrix's `lowest` leg reasoning — if
  the resolved version crosses a major, say why that is safe against the
  declared PHP floor rather than assuming it.
- `poagen generate` still reads every YAML fixture and example document. The
  golden trees stay byte-identical, or any change is explained.

== Non-goals

- Auditing the rest of the dependency tree or bumping anything else in the
  same commit.
- Hardening poagen against hostile documents in general — depth limits,
  alias budgets, a parser swap. If the fixed parser is not enough, that is a
  separate task with a separate argument.
- Adding `composer audit` to `just check`. Worth doing, but it needs network
  and that decision belongs with the release gate task.

== Files

- `composer.lock`
- `runtime/composer.lock`
- `CHANGELOG.md`
