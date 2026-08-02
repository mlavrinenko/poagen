#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Let a profile declare an undiscriminated union as raw data",
  tags: ("generator", "guidance", "strictness"),
  priority: 8,
  difficulty: 6,
  status: accepted(2026, 8, 2),
)

== Summary

A property-level union with no discriminator aborts the run. That is right by
default — hydrating one by guessing at its shape mis-hydrates silently, which
is the worst outcome available. What is wrong is that the abort leaves the
consumer nowhere to go.

The generator offers two forms of guidance for a union: name its discriminator
property, or skip the component. `clear-example-expected-failures` proved both
unusable on the two large vendor documents. All fifteen flagged unions — four
in DigitalOcean, eleven across ten GitHub components — were checked branch by
branch, and not one has a field present in every branch, so no
`Profile::$discriminators` entry could be written that was not a lie. GitHub's
`commit.author` is the extreme case: one branch is declared
`properties: {}` with `additionalProperties: false`, so it can never carry any
field at all. And skipping instead removes types the rest of the document still
references — measured at 8 dangling references on DigitalOcean and 231 on
GitHub, cascading through `Issue`, `Deployment`, `CheckRun` and dozens of
webhook payload models.

So the largest real-world schemas there are cannot be generated at all, and the
goal that says real published schemas produce usable clients is unmet for the
reason that goal itself anticipated: "where a document is genuinely ambiguous
rather than merely awkward, the generator asks for guidance and says exactly
what it needs." Today it asks for guidance that cannot exist.

The missing third form is the consumer saying: I know this union is
undiscriminated, do not guess, hand me the decoded value and I will deal with
it. That is not a degraded emission — the value the vendor sent arrives intact.
What is lost is the static type over it, knowingly, by name, one property at a
time.

=== Owner ruling, 2026-08-02

This form of guidance is added. The governing principle: where a document is
ambiguous, either pick a default that is right in almost every case, or error
and require the consumer to configure generation better — and configuring it
better has to be possible.

That means `skip-is-the-only-opt-out` is narrowed rather than kept. Its
reasoning stands against the shape it was written about: a method whose body
throws, a lossy `void` return, a hollow method that compiles and fails when
called. A property carrying the vendor's own decoded value is none of those.
The new decision has to say where the line now sits, in those terms, and why
this side of it is not the third button that decision refused.

== Acceptance criteria

- `Profile` accepts a map keyed the same way `$discriminators` is keyed —
  component and property — valued by a human-readable reason, exactly as
  `$skip` is. Declaring an entry makes that property emit as the decoded value
  rather than aborting.
- The emitted property's docblock names every branch the schema declared, so a
  reader knows what shapes may arrive without opening the vendor's document.
- The property is not silently `mixed` everywhere: where every branch is an
  object, the declared type says so; where the branches are scalars, the
  existing scalar-union path already covers it and this entry is refused as
  unnecessary.
- An entry naming a property that is not an undiscriminated union fails the run
  as stale, the same way a stale `$skip` entry does.
- Without an entry, the abort is unchanged. Nothing about the default moves.
- A decision artifact records the narrowing of `skip-is-the-only-opt-out`,
  naming the shape that is still forbidden and why this one differs, citing the
  real-world-schemas goal and the evidence above.
- The fifteen unions in the two large examples are declared through this
  mechanism, and both documents generate.

== Non-goals

- Discriminator inference, or any shape-based guessing at hydration time. The
  abort exists to prevent exactly that and is untouched.
- A discriminator read from a sibling field on the parent object. Two GitHub
  components (`event.payload`, `secret-scanning-location.details`) do carry a
  real tag one level up, and supporting that is a better answer for them than
  raw data — it is a separate task, and this one does not block on it.
- Category-wide opt-outs. Every entry names one property, as `$skip` names one
  operation or component.

== Files

- `src/Generator/Profile.php`
- `src/Generator/Emit/DiscriminatorEnforcer.php`
- `src/Generator/Emit/CompositionResolver.php`
- `src/Generator/Emit/TypeResolver.php`
- `examples/digitalocean/paogen.php`, `examples/github/paogen.php`
- `truth/decisions/`
