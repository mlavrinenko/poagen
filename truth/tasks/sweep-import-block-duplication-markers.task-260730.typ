#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Wrap import blocks in duplication markers and lower the jscpd threshold",
  tags: ("quality", "tooling"),
  priority: 5,
  difficulty: 3,
  status: cancelled(
    2026,
    7,
    30,
  )[Superseded by an ignorePattern in .jscpd.json. jscpd can drop preamble lines before detection, so no marker sweep across ~97 source files is needed, no emitter has to learn to write pragmas, and no profile field has to exist for a consumer to ask for them. minTokens comes back to the default 50 with zero header matches in src/.],
)

== Summary

\`.jscpd.json\` carries \`minTokens: 84\`, and that number is a workaround rather than a judgement. It was measured as the exact point where the last pure import-block match in \`src/\` stops being reported: the longest one, \`FormatAdvisor.php:1\` against \`TypeListScanner.php:1\`, runs 83 tokens. Every real clone in \`src/\` survives at 84, so nothing is lost today — but the threshold is fitted to the current shape of the tree, and any file whose header grows past it puts the noise back.

It also hides real findings. A genuine 60-token clone is exactly the kind a duplication gate exists to catch, and at 84 nobody hears about it.

The fix jscpd actually offers is \`jscpd:ignore-start\` / \`jscpd:ignore-end\` around the region that should not count. Wrapping the licence header, namespace and \`use\` list in those markers removes the noise at its source, and the threshold can then come back toward the default 50 where short clones are visible again.

Two tiers need it and they need different mechanisms. \`src/\` and \`tests/\` are hand-written, so a one-time mechanical sweep does it. \`tests/\` is the more urgent of the two: its import-block matches run up to 103 tokens, so it stays noisy even at 84.

Generated trees cannot be swept, because generated output is never hand-edited. The markers have to be emitted, which makes them a generator feature — and it has to be a data one. A profile field naming which pragmas to emit is data paogen reads; a callback that decorates output is code paogen runs, which \`guidance-is-data-not-code\` forbids. A project that does not run jscpd should get no markers at all.

== Acceptance criteria

- The licence header, namespace and import block of every hand-written PHP file under \`src/\` and \`tests/\` is wrapped in \`jscpd:ignore-start\` / \`jscpd:ignore-end\`.
- The sweep is mechanical and reproducible: whatever performed it is committed or described well enough to run again, since new files will need the same treatment.
- \`minTokens\` comes down, and the value is justified by a measured sweep the way 84 was. The \`src/\` and \`tests/\` figures before and after are recorded here.
- No pure import-block match appears in the \`src/\` or \`tests/\` report at the new threshold.
- Generated files carry the markers only when the profile asks for them, expressed as data. A profile that says nothing produces output with no markers, byte-identical to today's.
- \`just check\` is green and \`just check-examples\` reports no drift.

== Non-goals

- Flipping either jscpd recipe to failing, or folding them into \`lint\`. \`collapse-operations-onto-a-runtime-transport\` and \`deduplicate-the-test-suite\` remove the duplication first; the flip follows them.
- Removing any duplication.
- Any consumer-supplied callback, closure or template. The markers are declared, not computed.
- \`tests/generated/\` and \`tests/fixtures/generated/\`, which are tool output.

== Files

- \`.jscpd.json\`
- \`src/\`
- \`tests/\`
- \`src/Generator/Profile.php\`
- \`src/Generator/Emit/\`
