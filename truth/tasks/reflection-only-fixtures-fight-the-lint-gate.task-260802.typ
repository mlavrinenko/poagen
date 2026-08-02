#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "write down what a reflection only test fixture needs to survive the lint gate",
  tags: ("process", "tests", "dx"),
  priority: 3,
  difficulty: 2,
  status: proposed(2026, 8, 2),
)

== Summary

Cost measured, not guessed: writing the two fixtures for cover-map-kind-round-trip and cover-methoddocscanner-token-scan took three separate rewrites, each forced by a different tool, before the gate went green. A reflection-only fixture exists for its syntactic shape alone. Nothing calls it, and that is the point, because the code under test reads it through Reflection or token\_get\_all rather than by invoking it. Three tools in this project's gate all read that shape as dead code and act on it. Rector's RemoveEmptyClassMethodRector deletes an empty method body, which is exactly the body such a fixture wants. php-cs-fixer's modifier\_keywords rule force-adds public, which changes the token stream a token-scan fixture is pinning down. PHPStan's shipmonk deadProperty.neverRead flags a constructor-promoted property that exists only to carry a phpdoc type and is never read. Each has a workaround: a throwing body instead of an empty one, a non-promoted constructor parameter, and accepting the forced visibility keyword. None of them is discoverable before the gate rejects the file, so every future agent writing such a fixture pays the same three rounds.

== Acceptance criteria

- The three constraints and their workarounds are written down where someone about to add a fixture under tests/Unit/Runtime/Fixtures will meet them, with the tool and rule name for each so the error message maps to the fix.
- Whichever artifact it lands in is reachable from truth/main.typ if it lands under truth/, per the tree's own include rule.
- The existing fixtures added by the two mutation-triage tasks are cited as the worked example, so the reader can look at a file that already satisfies all three.

== Non-goals

- Exempting the fixture directory from any of the three tools. The rules are right in general and the fixtures are the unusual case; a blanket exemption would hide a real dead-code finding later.
- Rewriting the existing fixtures.
- Anything about mutation testing itself.

== Files

- AGENT.md, or CONTRIBUTING.md, or a standard under truth/standards/ — deciding which is part of the task
