#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Split unseparated operation identifiers into readable method names",
  tags: ("dx", "generator"),
  priority: 5,
  difficulty: 4,
  status: done(2026, 8, 1),
)

== Summary

Operation identifiers are normalised by camel-casing on existing word boundaries. When a schema supplies none, the output is the identifier unchanged: the kilbil loyalty document yields methods named after runs like `getclientfullbalance` and `searchgiftcard`. These are valid but unpleasant, and unpleasant method names are exactly what drives a consumer to wrap the generated client and hand-maintain the wrapper forever. A user can already supply a custom normalisation pipeline, so the escape hatch exists; what is missing is a decent default and a documented path.

== Acceptance criteria

- An identifier that carries a real separator is split on it. This one was
  silently broken: `CamelCaseSanitiser`'s "already camelCase" test admitted
  `_`, so `generate_promocode` and `legal_info` passed through untouched — and
  so did every snake_case *parameter* name, which is why `ssh_key_id` reached
  the emitted method as `$ssh_key_id` despite T-025 documenting the opposite
  intent.
- An identifier with no separator keeps the vendor's spelling, and the run says
  so, naming every such id and the profile key that answers it.

  This criterion first read: "a default strategy produces readable names for
  unseparated lowercase identifiers, using the schema's own vocabulary as the
  dictionary". That is withdrawn, and the reason is worth keeping. There is no
  correct split for `getclientfullbalance` — a vocabulary-derived one would
  produce a *different wrong answer per schema*, and it would move when
  unrelated parts of the schema changed, which is precisely the incidental
  rename `cheap-regeneration` forbids. A stable literal name is worse to read
  and better to depend on. `real-world-schemas` covers the rest: where a
  document is genuinely ambiguous rather than merely awkward, the generator asks
  for guidance and says exactly what it needs, and does not guess.
- The report is a notice and never a failure. Nothing was omitted, so the exit
  status does not move — `user-code-guides-generation` is explicit that the
  absence of guidance is never an error.
- `Profile::$methodRenames` maps a raw operation id to the method name the
  consumer wants, and the same entry also names the models synthesised for that
  operation's inline payloads — one entry buys `getClientFullBalance()` and
  `GetClientFullBalanceRequest` together.
- An entry naming an operation id absent from the document fails the run, on the
  same reasoning as the stale-`$skip` check: guidance that outlives its target
  is worse than none.
- Each rename map is scoped to the symbol kind it names. `$renames` applied to
  every kind before this, so a component rename would also rename an operation
  that happened to share its raw name.
- Names remain deterministic and collision-free; a collision fails the run rather than silently suffixing.
- The existing example schemas produce unchanged output, or their golden trees are regenerated deliberately.
- The kilbil profile carries the renames for all 33 of its 36 operation ids that
  need one, and does *not* carry entries for the two with real separators or the
  one that is a single word — listing those would hide whether the default
  works.

== Non-goals

- Natural-language word segmentation, with an external dictionary or a
  schema-derived one. See the withdrawn criterion above.
- Renaming components; this is about operations and parameters.

== Files

- `src/Generator/Naming/CamelCaseSanitiser.php`, `RenamesNormaliser.php`, `NormaliserFactory.php`
- `src/Generator/Emit/OperationIdAdvisor.php` (new)
- `src/Generator/Profile.php`, `src/Generator/ProfileTargetValidator.php`, `src/Generator/GenerationPlan.php`, `src/GenerateCommand.php`
- #link("../specs/operation-generator.feature-260418.typ")
- `examples/kilbil/paogen.php`
- `tests/`
