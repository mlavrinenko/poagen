#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "two generated step assertions now read the golden not fresh output",
  tags: ("tests", "fixtures", "speconaut"),
  priority: 5,
  difficulty: 3,
  status: wip(2026, 8, 2),
)

== Summary

Surfaced by fixtures-generate-to-a-scratch-tree, which redirected every fixture profile's output away from the committed golden trees. Two assertions in the speconaut-generated step files still read a hardcoded golden path after re-running the generator: ModelGeneratorSteps.php line 805 reads tests/fixtures/generated/composition/Generated/Model/Animal.php, and OperationGeneratorSteps.php line 1662 reads tests/fixtures/generated/petstore/Generated/StoreClient.php. Both used to read fresh output, because before the redirect the generator wrote over the golden and the golden was the fresh output. They now read static committed content instead. They still pass, and they may still be meaningful transitively, since ByteStabilityTest separately proves the golden matches a fresh scratch generation. But the two scenarios no longer assert what their prose says they assert: each says the generator emitted something, and each now checks a file the generator did not write during that scenario. Two of PaogenCLISteps.php's reads of the same tree are NOT this problem, since they copy the golden as CLI input rather than assert on it as output.

== Acceptance criteria

- Both assertions read the tree the scenario's own generator run produced, via the step's outputDir, not a hardcoded tests/fixtures/generated path.
- Breaking the generator on purpose makes both scenarios fail. Prove it the way fixtures-generate-to-a-scratch-tree proved its own claim, by mutating the emitter and watching the assertion go red, not by reasoning.
- A grep for the literal tests/fixtures/generated inside tests/generated returns only PaogenCLISteps.php's two copyTree calls, which are legitimate uses of the golden as an input.
- If a step body change requires the scenario prose to change, speconaut lock is refreshed and just check-generated-tests reports up to date.

== Non-goals

- Re-opening the scratch-tree redirect. It is correct and its proof stands.
- ByteStabilityTest, which is doing its job and is what makes the current state merely weak rather than wrong.
- The PaogenCLISteps.php copyTree calls.

== Files

- tests/generated/ModelGeneratorSteps.php
- tests/generated/OperationGeneratorSteps.php
