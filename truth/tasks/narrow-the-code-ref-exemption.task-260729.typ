#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Narrow the code-reference exemption to the output vocabulary alone",
  tags: ("speconaut", "specs", "debt"),
  priority: 4,
  difficulty: 4,
  status: status(
    "needs-review",
    2026,
    7,
    31,
    note: [landed this session; verified on the merged head by the orchestrator],
  ),
)

== Summary

speconaut forbids file paths, member chains, and call shapes in specs, decisions, standards, and domain artifacts, so those layers survive a reimplementation. paogen exempts all of them in \`.speconaut/config.toml\`, and only half of that exemption is defensible.

The defensible half: paogen's product is emitted PHP, so a signature like \`addPet(Pet \$body): Pet\` or an attribute form is the observable behaviour a scenario asserts. Rephrasing those behaviourally would describe the generator by describing nothing.

The indefensible half: 140 references point at paogen's own tree — \`src/Generator/...\` and friends — which is exactly what the rule exists to prevent. A spec that names the class implementing a behaviour has bound itself to one implementation, and the next refactor makes it a lie. They were suppressed to unblock the speconaut migration in one pass, not because they are right.

The work is to rewrite those references in terms of what the generator does rather than which file does it, then delete the \`src/\`, \`bin/\`, and \`tests/\` entries from the allowlist.

== Acceptance criteria

- No spec, decision, standard, or domain artifact names a path under \`src/\`, \`bin/\`, or \`tests/\`.
- The \`src/\`, \`bin/\`, and \`tests/\` entries are gone from the \`\[check.code-refs\] allowlist\`, and the remaining entries cover only emitted-output vocabulary.
- \`speconaut check\` passes with the narrowed list.
- Every rewritten step still asserts the same behaviour. A step that only made sense as a statement about a file is rewritten to say what a consumer observes, or deleted with its scenario if it asserted nothing observable.
- The task's own diff shows no scenario silently losing an assertion.

== Non-goals

- Removing the exemption for call shapes and attribute forms. Those are the product and stay permitted.
- Rewriting task artifacts, which speconaut exempts from this rule by design — tasks are the implementation bridge and are meant to name files.
- Adding new scenarios. This rewrites how existing ones are phrased.

== Files

- \`.speconaut/config.toml\`
- \`truth/specs/\*.feature-\*.typ\`
- \`truth/decisions/\*.decision-\*.typ\`
