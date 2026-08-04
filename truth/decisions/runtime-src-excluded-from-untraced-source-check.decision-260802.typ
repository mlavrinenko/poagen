#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "runtime/src leaves the untraced-source check's source roots",
  status: accepted(2026, 8, 2),
  contexts: (generation-context,),
  goals: (link("../goals/strict-clean-output.goal.typ"),),
  process-only: "governs poagen's own traceability-gate configuration — what `[check].source-roots` walks — not what the generator produces or what a reimplementation must do",
)

== Context

`untraced-source-is-a-ratcheted-warning` measured, against a real (locally
patched around the upstream namespace blocker) `speconaut audit-traces`
run, that every one of `runtime/src/`'s 26 files is untraced across all 96
checked scenarios — not a handful, all of them. It classified this as a
scope boundary rather than a real gap and deferred the actual
`[check].source-roots` call to this task: "Nothing here changes
`[check].source-roots` itself; that is
`decide-runtimes-place-in-spec-derived-coverage`'s call to make."

The 26-of-26 figure is not partial. `speconaut audit-traces` instruments
only the manifest-listed `tests/generated/*Test.php` suite, and
`truth/specs/`'s four features (Model Generator, Operation Generator,
poagen CLI, Profile) describe #the(Generator)'s own behaviour — what PHP
it emits — never the behaviour of the separately-packaged runtime library
(`runtime-ships-as-a-separate-package`). No scenario poagen could write
inside its own spec scope changes that: a scenario exercises the
generator producing #a(GeneratedFile), never a consumer's own code
calling into the runtime that file imports. `runtime/src/` is fully
tested — `tests/Unit/Runtime/*` and
`tests/Integration/RuntimeSubstitutionTest.php` exercise it directly —
just entirely outside the BDD loop `audit-traces` measures.

Three options were on the table: drop `runtime/src` from
`[check].source-roots`; write BDD scenarios describing `runtime/src`'s own
behaviour (marshal/hydrate round trips, transport dispatch) so it
participates in coverage-derived traceability on its own terms; or leave
it configured and accept the 26-file warning permanently, with a comment
explaining why it will never shrink.

== Choice

Drop `runtime/src` from `[check].source-roots`. It now reads
`["src", "bin"]`.

The 26-of-26 figure is what settles it against the other two options.
Writing BDD scenarios for `runtime/src` would mean the generator's own
specs start describing a second package's behaviour — exactly the
coupling `runtime-ships-as-a-separate-package` cut when it split the
runtime into its own installable unit with its own dependency direction,
tested by its own PHPUnit suite. It would also duplicate coverage that
already exists: `tests/Unit/Runtime/*` and
`tests/Integration/RuntimeSubstitutionTest.php` already assert the same
round trips a runtime feature file would restate in Gherkin-flavoured
Typst. Leaving it configured and accepting a permanent warning keeps
`[check].source-roots` naming a root the untraced-source finding can never
report progress against — once `zero-statement-files-pinned-as-plumbing`
closes the other 3, every future run of that finding would carry a fixed,
un-movable 26-file floor forever. `untraced-source-is-a-ratcheted-warning`
already rejected exactly this shape of bar, quoting
`coverage-floor-in-the-gate`'s own reasoning: "a bar nobody is actually
watching is worse than no bar." A ceiling that can only ever sit at 26,
watched by nobody because nobody can move it, is that bar.

Dropping the root does not touch `[audit-traces].source-roots`, the
separate key just above it in `.speconaut/config.toml` that filters the
coverage collector's raw report before it reaches trace attribution or
plumbing classification. That key stays `["src", "runtime/src", "bin"]`
— harmless to leave as is, since nothing downstream of it depends on
`[check].source-roots` narrowing, and narrowing it too would only remove
information the collector is capable of reporting, for no benefit.

== Consequences

- `.speconaut/config.toml`'s `[check].source-roots` reads `["src", "bin"]`,
  with a comment stating the 26-of-26 measurement and the structural
  reason so a future reader does not have to re-derive either.
- Once the upstream `audit-traces-ignores-the-configured-namespace` fix
  lands and `untraced-source-is-a-ratcheted-warning`'s ratchet is actually
  wired, its starting ceiling drops by up to 26 on account of this
  decision alone, before `zero-statement-files-pinned-as-plumbing`'s
  separate 3-file contribution is even counted.
- `runtime/src/`'s own test coverage is unaffected. `tests/Unit/Runtime/*`
  and `tests/Integration/RuntimeSubstitutionTest.php` keep exercising it
  exactly as before; only the untraced-source finding's walk changes.
- Writing BDD scenarios for `runtime/src` remains available as future
  work if this project ever decides the runtime library deserves its own
  spec-derived traceability story on its own terms — this decision closes
  the policy question for `[check].source-roots` today, not that
  possibility permanently.
- A future decision that widens `[check].source-roots` back to include
  `runtime/src` (for instance, alongside a runtime feature file) should
  supersede this one rather than silently re-adding the entry.
