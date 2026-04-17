#import "@local/speconaut:0.1.0": adr, accepted

#show: adr.with(
  number: 1,
  title: "Profile-driven generation",
  status: accepted,
  date: datetime(year: 2026, month: 4, day: 18),
)

== Context

paogen takes an OpenAPI 3.0 schema and emits a typed PHP client. Users need
to influence what gets emitted (rename a poorly-named schema, swap a generic
string for their own value object, exclude internal endpoints) without
hand-editing generated files. Established generators (openapi-generator,
Mustache templates) solve this with templates + protected regions, both of
which corrupt easily and resist tooling.

== Decision

The generator consumes two inputs and is otherwise a *pure function*:

+ The OpenAPI schema (`openapi.yaml`).
+ A *Profile*: a value supplied by the user that says how to specialise
  generation for their project.

Output is fully regenerated every run. *No file under `Generated/` is ever
hand-edited.* Re-running the generator with the same `(schema, profile)` is
byte-for-byte identical (CI gates this).

== Profile is a value, not a callback container

The Profile is *declarative* PHP data — type bindings, renames, exclusions,
discoverable namespaces, output paths. It is parsed, never executed.
Closures, custom emitters, and template overrides are explicitly excluded.

This buys us:

- *Determinism*: pure inputs → byte-stable output.
- *Reviewability*: profile diffs are tiny and obvious.
- *AI-authorability*: agents can synthesise/refactor profiles mechanically.
- *No sandboxing concerns*: profiles never execute project code at gen time.

== Consequences

- The generator never parses its previous output. There are no protected
  regions, no roundtripping, no header magic.
- All user customisation lives in either: (a) the Profile, or (b) user
  code that the generator scans for opt-in attributes (see #link("003-profile-and-attribute-dx.typ")[ADR-003]).
- Behaviour the Profile cannot express (per-call retries, custom auth) is
  provided at *runtime* via decorators and constructor-injected strategies,
  not at generation time. This is a non-goal for the PoC.

== Alternatives rejected

See #link("002-no-inheritance-no-protected-regions.typ")[ADR-002].
