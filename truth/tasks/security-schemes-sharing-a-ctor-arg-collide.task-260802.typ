#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "two security schemes that share a constructor argument are not deduplicated",
  tags: ("generator", "security"),
  priority: 6,
  difficulty: 3,
  status: proposed(2026, 8, 2),
)

== Summary

Found while attempting clear-example-expected-failures, independent of the discriminator work that task was about. The DigitalOcean document declares two named http bearer security schemes, bearer\_auth and inference\_bearer\_auth. SecuritySchemeCatalog and ClientConstructor key emitted constructor parameters by the scheme's fixed ctorArg, which for http bearer is always bearerToken, and neither deduplicates. Every sub-client constructor therefore forwards the same argument twice against a two-parameter signature, producing 50 PHPStan arguments.count errors on an otherwise clean tree. This is not specific to DigitalOcean. Any document declaring two schemes of the same kind hits it, and http bearer plus a second bearer for a different audience is a common shape. The failure is loud, which is the one good thing about it, but it is loud at analysis time rather than at generation time, so the generator reports success and hands over a tree that does not compile against its own gate.

== Acceptance criteria

- Two declared schemes that collapse to the same ctorArg emit one constructor parameter, or emit distinct ones named so they cannot collide.
- Whichever is chosen, the choice is recorded, because a single parameter for two audiences is a semantic claim about the document and not obviously right.
- Generating the DigitalOcean tree produces zero arguments.count errors under the generated tier's PHPStan config.
- A document with a single scheme emits exactly as today, byte for byte.
- A regression test covers two same-kind schemes, driven from a fixture rather than from the DigitalOcean document.

== Non-goals

- The unwireable-scheme reporting question, which report-unsupported-security-schemes owns and which is blocked on an owner ruling.
- oauth2 or openIdConnect.
- Renaming the ctorArg for the single-scheme case.

== Files

- src/Generator/Emit/SecuritySchemeCatalog.php
- src/Generator/Emit/ClientConstructor.php
- tests/fixtures/
- truth/decisions/
