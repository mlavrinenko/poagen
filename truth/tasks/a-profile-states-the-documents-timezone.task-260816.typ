#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "A profile states the document's timezone when the vendor fixed one",
  tags: ("generator", "profile"),
  priority: 2,
  difficulty: 4,
  status: done(2026, 8, 16),
  links: (
    related("an-offset-free-datetime-takes-an-explicit-zone.task-260816.typ"),
    related("report-a-datetime-the-document-left-offset-free.task-260816.typ"),
  ),
)

== Summary

`an-offset-free-datetime-takes-an-explicit-zone` gives a consumer a way to
state, per client instance, which zone an offset-free `date-time` means. That
is the right home for a fact that varies by installation — one published
document, many tenants, each possibly in a different zone.

It is the wrong home for the other case. Some vendors return one zone for
every call from every installation, and then the zone is a property of the
document rather than of the deployment. Stating it at each construction site
means restating it: every consumer of that client rediscovers the same fact,
and a standalone client package published from the profile carries no trace
of it at all.

The profile is where this repository already puts facts a document failed to
state and a consumer knows anyway — `xmlElements` names root elements OpenAPI
never named, `methodRenames` supplies readable names an operation id has no
algorithmic path to, `propertyFormats` says which `double` is money. A
vendor-wide timezone is the same category, and `guidance-is-data-not-code`
already describes the shape: data poagen reads, never code poagen runs.

What it cannot be is automatic. `operations-delegate-to-an-injected-transport`
puts hydration in a transport the consumer constructs before the generated
client exists, so no generated class is in a position to hand the runtime a
default. The emitted form is therefore a constant the consumer reads at the
one construction site they already write by hand — beside `ApiClient::SERVER_1`
and the `ApiException::class` they already pass. One place per tree, which
also keeps the generated duplication tier out of it; an attribute repeated on
every date property would not.

== Acceptance criteria

- A profile can state one timezone for the document, and the emitted client
  carries it as a single constant the consumer reads when constructing the
  transport.
- The value is validated at generation time against PHP's own timezone
  database, and an unknown identifier fails the run naming the entry — the
  shape every other profile validator here already follows, and before the
  document is read.
- Precedence is stated in `README.md` and in the decision, and it is stated
  rather than tested on purpose — this criterion said "and tested" when it
  was written, which overstated what there is to test. The constant is inert
  data the consumer reads; nothing in poagen applies it, so a context passed
  at construction wins by there being no competitor, and a test asserting
  that would assert its own setup. What IS tested is that the constant is
  emitted, that it is not referenced from the constructor, and that stating
  nothing emits nothing.
- Stating nothing emits nothing: every existing golden tree and example tree
  is byte-identical, and no consumer that ignores this feature changes
  behaviour.
- Documented in `README.md` next to the other profile fields, saying plainly
  which of the two homes to pick — document-wide fact here, installation fact
  in the `BindingContext`.
- `just check`, `just check-examples` and `just verify-runtime-standalone`
  green end-to-end.

== Non-goals

- The runtime mechanism itself. This task adds a way to state the fact and a
  place to emit it; carrying it through hydration is
  `an-offset-free-datetime-takes-an-explicit-zone` and lands first.
- Making the constant apply without the consumer wiring it. That would need
  the generated client to reach the transport, which
  `operations-delegate-to-an-injected-transport` rules out.
- Per-operation or per-property zones.
- Guessing a zone from the document. Nothing in OpenAPI carries one, and
  inferring it from an example string is the silent guess this repository
  exists to refuse.

== Files

- `src/Generator/Profile.php`
- `src/Generator/Emit/`
- `README.md`
- `tests/`
- `truth/decisions/`
