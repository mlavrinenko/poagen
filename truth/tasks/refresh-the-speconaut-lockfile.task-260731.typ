#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Refresh the speconaut lockfile against the current truth tree",
  tags: ("speconaut",),
  priority: 6,
  difficulty: 3,
  status: proposed(2026, 7, 31),
  links: depends-on("implement-the-outrun-step-bodies.task-260731.typ"),
)

== Summary

\`.speconaut/state.lock\` was last written 2026-04-21 and records a tree that no longer exists. All four spec paths it names — \`truth/specs/{model-generator,operation-generator,profile,cli}.typ\` — predate the \`.feature-\<yymmdd>\` rename and are gone from disk. Five of its 76 traced source paths were renamed or deleted. It holds 74 scenarios; the tree now has 93.

Nothing in it can verify, so \`speconaut status\` and \`speconaut diff\` report against a fiction and \`check-drift\` cannot honestly sit in the gate.

=== The adapter has to be named first, 2026-07-31

\`speconaut lock\` and \`speconaut status\` both spawn the adapter to resolve
traces, and \`.speconaut/config.toml\` never sets one — so both fall through to
the default, which is \`rust\`:

```
error: failed to resolve traces via TraceProvider: failed to load manifest for
rpc audit-traces against /etc/profiles/per-user/tank/bin/speconaut-rust:
read manifest .../tests/generated/manifest.json: No such file or directory
```

paogen is a PHP project and wants the PHPUnit adapter. Setting
\`\[audit-traces\] adapter\` to the name that adapter actually answers to is part
of this task; \`make-the-php-adapter-usable-by-a-consumer\` in the speconaut repo
settles what that name is.

=== Two blockers, measured 2026-07-31

Naming the adapter was necessary and is not sufficient. `lock`, `lock --check`
and `status` all resolve traces first, unconditionally, with no degraded path —
and trace resolution needs `tests/generated/manifest.json`, which does not
exist:

```
error: failed to resolve traces via TraceProvider: failed to load manifest for
rpc audit-traces against .../speconaut-php-phpunit:
read manifest tests/generated/manifest.json: No such file or directory
```

The manifest is an output of a real `generate-tests` run. Producing one means
accepting roughly 200 appended `Implement:` stubs and 149 orphaned-step
warnings, which is `implement-the-outrun-step-bodies`.

A second blocker — `lock` demanding an open session despite the opt-out — was
fixed upstream the same day, as `session-opt-out-does-not-reach-lock`. `lock`
now reaches trace resolution here and fails only on the manifest, so that is
the single thing left.

This cannot be done by hand-editing the lockfile — its own header forbids that,
and fabricating trace data would be worse. It waits on one thing.

== Acceptance criteria

- \`speconaut lock\` completes against the current tree
- every spec path in \`.speconaut/state.lock\` names a \`.feature-\<yymmdd>.typ\` file that exists
- every traced source path in the lockfile exists on disk
- \`speconaut lock --check\` exits 0 on a clean tree
- \`speconaut status\` reports zero content mismatches

== Non-goals

- does not restore coverage-derived traces; \`restore-coverage-derived-traceability\` owns that
- does not promote any scenario to \`mature\` — every scenario stays \`unstable\` this milestone
- does not edit scenario prose to make the lock converge

== Files

- \`.speconaut/state.lock\`
- \`.speconaut/config.toml\` — the \`[audit-traces]\` adapter name
- \`Justfile\`
