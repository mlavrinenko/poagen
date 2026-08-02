#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "Zero-statement files are pinned as plumbing by hand",
  status: accepted(2026, 8, 2),
  contexts: (generation-context,),
  goals: (link("../goals/strict-clean-output.goal.typ"),),
  process-only: "governs paogen's own audit-traces plumbing configuration — how three specific zero-statement files are classified by the untraced-source check — not what the generator produces or what a reimplementation must do",
)

== Context

`zero-statement-files-never-register-as-covered` found three files a
human had explicitly declared traced in the deleted hand-authored
`traces:` tuples, still untraced under a real coverage run, sharing one
shape: none carries an executable PHP statement of its own.
`src/Generator/Naming/NameNormaliser.php` is a bare interface used only in
phpdoc array-shape hints, never a native param type, so nothing forces
the autoloader to load it. `src/Generator/Naming/SymbolKind.php` is a
plain, caseless enum, same story. `src/Exception/InvalidProfileException.php`
is `final class InvalidProfileException extends RuntimeException {}`, no
body at all. All three are almost certainly exercised — `NameNormaliser`'s
four concrete implementers are covered by the same scenario that named
the interface; `InvalidProfileException`'s own scenario ("A PHP file that
does not return a Profile is rejected") still runs today, and its
coverage shows `ProfileLoader.php` throwing and presumably catching it —
but line coverage has nothing of the file's own to mark as hit, so each
falls through both the "covered" and "plumbing" buckets into "untraced",
indistinguishable from a real gap.

The sharpest single measurement is the contrast the task itself surfaced:
`src/Exception/ModelNameCollisionException.php` is an equally
pure-data exception, and it *is* auto-classified plumbing today, purely
because its static `between()` factory carries one executable `sprintf`
line. The only difference between a file the classifier already handles
correctly and one it does not is that one happens to have a line to
count. That is a coverage-tool artifact, not a judgement about whether
either file's behaviour is exercised.

Two routes were on the table: have the classifier (or the host-side
untraced-source check) special-case files with no executable statement,
auto-classifying them plumbing regardless of touch; or pin the three
files by hand through the existing `[[audit-traces.plumbing.files]]`
mechanism, the same one a human already uses to mark one file plumbing by
hash today.

== Choice

Pin the three files by hand. `.speconaut/config.toml` gains three
`[[audit-traces.plumbing.files]]` entries — one per file, each with its
own comment stating the reason above — rather than a speconaut-side
auto-classification rule.

speconaut already ships this exact mechanism for the identical shape of
problem, and the precedent settles it. speconaut's own
`.speconaut/config.toml` carries eight `[[audit-traces.plumbing.files]]`
entries today — `src/main.rs`, `src/cli_resolve.rs`,
`src/extraction/mod.rs`, and five more — each pinning a file no scenario
tests directly because every scenario that reaches it merely transits it:
dispatch, thin wrappers, barrel re-exports. paogen's three zero-statement
files are the same phenomenon from the opposite direction — reached and
exercised, but with no line of their own for the collector to mark —
and the pin mechanism does not care which direction produced the
"transited, not directly hit" outcome. Reusing it needs no upstream
change, stays inside `.speconaut/config.toml`, and ships today.

The tooling-side alternative would need speconaut, a host that talks to
adapters over a language-agnostic wire protocol, to learn what "zero
executable PHP statements" means well enough to auto-classify — a
PHP-specific static-analysis capability inside a otherwise
language-agnostic host, for a problem three hand-picked, hash-pinned
config entries already solve. It would also drop the one property the
pin mechanism gives for free: the `sha256` gate forces a human to look
again the moment any of these three files' contents change, so a file
that grows from zero statements to one (the same transition that made
`ModelNameCollisionException.php` correctly fall out of "untraced" on its
own) gets a deliberate re-review rather than a silent, automatic
reclassification either way.

== Consequences

- `.speconaut/config.toml` gains three `[[audit-traces.plumbing.files]]`
  entries: `src/Generator/Naming/NameNormaliser.php`,
  `src/Generator/Naming/SymbolKind.php`, and
  `src/Exception/InvalidProfileException.php`, each pinned by its current
  `sha256` and a `max-lines` ceiling with headroom for incidental
  docblock growth, and each carrying its own comment stating why it is
  plumbing.
- Once the upstream `audit-traces-ignores-the-configured-namespace` fix
  lands and the untraced-source ratchet from `untraced-source-is-a-
  ratcheted-warning` is actually wired, its starting ceiling drops by 3
  on account of this decision.
- Any future edit to one of the three pinned files invalidates its
  `sha256` and the override is rejected as a hard-error finding until
  `speconaut audit-traces --refresh-plumbing` re-blesses it — an explicit
  act, not an automatic pass-through.
- No speconaut-side change is needed or filed. The classifier's
  line-coverage-only view of "covered" is unchanged; this decision works
  around its blind spot for these three files rather than closing the
  blind spot itself.
- Any other zero-statement file this project discovers later gets the
  same treatment — a new `[[audit-traces.plumbing.files]]` entry with its
  own reason — rather than reopening this decision, unless the number of
  such files grows large enough that hand-pinning each one stops being
  the honest choice, at which point a tooling-side rule becomes worth
  revisiting.
