#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "specs still name ApiClient hydrate which attribute-and-phpdoc-driven-serialization retired",
  tags: ("truth", "specs", "drift"),
  priority: 6,
  difficulty: 3,
  status: done(2026, 8, 2),
)

== Summary

Found by running the structural sweep method the moment it was written down, in structural-sweep-for-retired-call-shapes — the method's first unscoped run, against a refactor it was not written for. Three steps in truth/specs/model-generator.feature-260418.typ name the receiver ApiClient::hydrate: lines 104, 202 and 211. Nothing has carried that call since attribute-and-phpdoc-driven-serialization replaced the generated client's private hydrate helper with a free-standing Hydrator instance. Verified: rg for ApiClient::hydrate across src, runtime and examples returns zero hits, and the only matches anywhere are in tests/generated/ModelGeneratorTest.php, which is derived from these very spec lines and so echoes the drift rather than evidencing the call. The same feature file already says the right thing twice, at lines 147 and 178, where the steps read (new Hydrator())->hydrate(...). So the file contradicts itself, and the generated step method names carry the stale receiver into the test suite. This is unrelated to the transport collapse both pre-transport sweep tasks chased; it traces to attribute-and-phpdoc-driven-serialization, and it survived every sweep so far because no sweep compared spec vocabulary against the emitted tree until now.

== Acceptance criteria

- The three steps at lines 104, 202 and 211 name the receiver the code actually has, matching the form lines 147 and 178 already use.
- The regenerated step methods in tests/generated no longer carry the retired receiver in their names, and just check-generated-tests reports them up to date.
- The structural sweep recorded in truth/notes/decisions-audit-procedure.md, run unscoped over every feature file, returns hydrate to the settled column alongside getDocComment and marshal.
- speconaut lock is refreshed so the scenario hashes match the rewritten prose.

== Non-goals

- Rewriting scenario prose beyond the receiver each step names. The behaviour these three scenarios assert is correct and is not in question.
- Re-opening `attribute-and-phpdoc-driven-serialization`.
- Auditing the other three feature files for unrelated drift; the sweep already cleared them.

== Files

- truth/specs/model-generator.feature-260418.typ
- tests/generated/ModelGeneratorTest.php
- tests/generated/ModelGeneratorSteps.php
- .speconaut/state.lock
