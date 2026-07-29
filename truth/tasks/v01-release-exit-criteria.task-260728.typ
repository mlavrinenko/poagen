#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Close the outstanding v0.1 release criteria",
  tags: ("release",),
  priority: 3,
  difficulty: 2,
  status: proposed(2026, 7, 28),
)

== Summary

Every phase in the release roadmap is ticked but six exit criteria under it are not. Some are now stale in their own right: one of them requires a clean report from a tool whose wiring is being replaced, and another refers to a task-status command that no longer governs this project. The list needs reconciling against the recovered workflow before it can be closed, and it should not gate on anything the goals do not actually require.

== Acceptance criteria

- The package stability declaration is flipped and the package installs from a clean checkout.
- The changelog section for the release is accurate against what shipped.
- Criteria that referenced the retired workflow are rewritten or dropped, with the reason recorded.
- The whole gate is green with no deprecation output.
- The roadmap is retired into the backlog once its remaining items are filed as tasks.

== Non-goals

- Publishing to the registry.
- Shipping any feature currently sitting in the backlog.

== Files

- \`composer.json\`
- \`CHANGELOG.md\`
- \`ROADMAP.md\`
