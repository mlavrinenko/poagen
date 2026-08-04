#import "@local/speconaut:0.1.0": *
#import "../domain/guidance.context.typ": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "Profile-driven generation",
  status: accepted(2026, 4, 18),
  contexts: (guidance-context, generation-context),
  goals: (link("../goals/user-code-guides-generation.goal.typ"),),
  standards: (link("../standards/guidance-is-data-not-code.standard-260729.typ"),),
)

== Context

poagen takes an OpenAPI 3.0 schema and emits a typed PHP client. Users need
to influence what #the(Generator) emits (rename a poorly-named schema
component, swap a generic string for their own value object, exclude
internal endpoints) without hand-editing generated files. Established
generators (openapi-generator, Mustache templates) solve this with
templates plus protected regions, both of which corrupt easily and resist
tooling.

== Choice

#The(Generator) consumes two inputs and is otherwise a pure function:

+ The OpenAPI schema (`openapi.yaml`).
+ #A(Profile): a value supplied by the user that says how to specialise
  generation for their project.

Output is fully regenerated every run. No #a(GeneratedFile) is ever
hand-edited. Re-running #the(Generator) with the same `(schema, profile)`
is byte-for-byte identical (CI gates this).

=== Profile is a value, not a callback container

#The(Profile) is declarative PHP data — type bindings, renames, exclusions,
discoverable namespaces, output paths. It is parsed, never executed.
Closures, custom emitters, and template overrides are explicitly excluded.

This buys us:

- Determinism: pure inputs produce byte-stable output.
- Reviewability: profile diffs are tiny and obvious.
- AI-authorability: agents can synthesise and refactor profiles
  mechanically.
- No sandboxing concerns: profiles never execute project code at
  generation time.

== Consequences

- #The(Generator) never parses its previous output. There are no
  protected regions, no roundtripping, no header magic.
- All user customisation lives in either #the(Profile), or #a(UserFile)
  #the(Generator) scans for opt-in attributes (see
  #link("typed-profile-and-colocated-attributes.decision-260418.typ")[Profile DX: typed Profile object + attributes co-located on user value objects]).
- Behaviour #the(Profile) cannot express (per-call retries, custom auth) is
  provided at runtime via decorators and constructor-injected strategies,
  not at generation time. This is a non-goal for the PoC.

Alternatives that would smuggle user code inside generated output —
subclassing, protected regions, embedded attributes — are rejected in
#link("no-inheritance-no-protected-regions.decision-260418.typ")[No inheritance, no protected regions, no attributes-in-generated-files].
