#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Adopt jscpd as a duplication gate on both tiers",
  tags: ("quality", "tooling"),
  priority: 7,
  difficulty: 4,
  status: proposed(2026, 7, 30),
)

== Summary

Nothing measures duplication, and there is a lot of it. Measured with jscpd 5.0.11 at its defaults over PHP sources:

\`\`\`
examples/kilbil/generated   88 clones   30.69%
examples/petstore/generated 25 clones   32.64%
tests/                      91 clones   14.05%
src/                        36 clones    3.76%
\`\`\`

The emitted trees are the worst because \`RequestAssembler\` and \`ResponseHandler\` write the same 12 to 15 token-identical lines into every operation. In \`examples/kilbil/generated/Generated/TagsClient.php\`, lines 40 to 51 repeat verbatim four times in a 117-line file. \`collapse-operations-onto-a-runtime-transport\` is the fix for that; this task is the instrument that proves it worked and keeps it from coming back.

The tool is available through the qahq flake, which devbox installs the same way it already installs linecop at \`devbox.json:9\`. Verified: \`nix run github:mlavrinenko/qahq\#jscpd -- --version\` prints \`cpd 5.0.11\` and fetches 3.2 MiB prebuilt from qahq.cachix.org rather than compiling.

One configuration problem is known in advance. At the default \`minTokens: 50\` a third of the findings in \`src/\` are import blocks, not code — \`InlineObjectResolver.php:1\` matching \`TypeResolver.php:1\` for 14 lines is a licence header, a namespace and a \`use\` list. jscpd cannot skip a file header, only a region marked by \`jscpd:ignore-start\` and \`jscpd:ignore-end\` comments. Wrapping the import block in those markers is the answer, in the generator's own sources and in emitted files alike.

Emitting the markers has to stay data. A per-project callback hook that decorates output would put consumer code in paogen's execution path, which \`guidance-is-data-not-code\` forbids in as many words: guidance is "read by the generator as a value and never executed as a template, a hook, or a callback that shapes output". A profile field naming which pragmas to emit is data and is fine; a closure is not.

== Acceptance criteria

- \`devbox.json\` installs jscpd from the qahq flake, and \`devbox.lock\` pins the resolved revision.
- A committed jscpd configuration sets the thresholds, and \`minTokens\` is chosen from a measured run rather than left at the default.
- Two recipes exist, mirroring the two PHPStan tiers: one over \`src/\` and \`tests/\`, one over \`tests/fixtures/generated\`, \`examples/\*/generated\` and \`examples/\*/src\`. The generated-tier recipe resolves its paths the way \`lint-phpstan-generated\` does, since not every example has a \`generated/\` directory.
- Both recipes report rather than fail while the duplication is still being removed, and a follow-up flips them to failing. Which one flips them is named in this task.
- The generator's own import blocks are wrapped in \`jscpd:ignore-start\` / \`jscpd:ignore-end\`, and the measured \`src/\` figure after that wrapping is recorded here.
- \`CONTRIBUTING.md\` lists the tool alongside the others.
- No consumer-supplied callback runs during generation.

== Non-goals

- Removing the duplication itself. \`collapse-operations-onto-a-runtime-transport\` and \`deduplicate-the-test-suite\` do that.
- Wiring the marker emission into generated files, which belongs with whichever task is emitting those files at the time.
- Replacing the existing pinned linecop entry with qahq's, whose linecop input is unpinned.

== Files

- \`devbox.json\`
- \`devbox.lock\`
- \`.jscpd.json\`
- \`Justfile\`
- \`CONTRIBUTING.md\`
- \`src/\`
