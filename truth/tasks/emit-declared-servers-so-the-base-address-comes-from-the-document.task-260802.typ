#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Emit the document's declared servers so the base address comes from the schema",
  tags: ("generator", "dx"),
  priority: 6,
  difficulty: 3,
  status: wip(2026, 8, 2),
)

== Summary

`servers:` is read by nothing. The generator never looks at it, and the base
address reaches the runtime as a `string $baseUri` the consumer types by hand
when they construct the transport.

Every one of the four vendored documents declares it: `https://bonus.kilbil.ru`,
`https://petstore3.swagger.io/api/v3`, `https://api.digitalocean.com` (described
"production"), `https://api.github.com`. So in every case the consumer retypes a
value the document already carries, and a typo in it is a runtime 404 rather
than anything a type could catch.

This is the same gap the security-scheme ruling closes for credentials, one
field over: paogen does not implement transport, but everything the document
says that helps a consumer wire theirs should arrive in the emitted tree rather
than staying in a YAML file they have to open.

== Acceptance criteria

- Each declared server is emitted as a constant on the client, carrying its URL
  and its description where the document gives one.
- A document declaring several servers emits all of them, in declaration order,
  distinguishable by name or description. The first is not silently treated as
  the only one.
- Server variables — `{region}` style templates with declared enums and
  defaults — are either substituted from the profile and emitted resolved, or
  refused by name if that is not built. What must not happen is a constant
  carrying an unsubstituted template that looks like a usable URL. No vendored
  example exercises this today, so a fixture has to.
- The base address stays a transport constructor argument. Nothing about this
  makes the emitted client choose its own address, which would make it
  unswappable for a test server or a staging host.
- The four examples' wiring reads the constant instead of a literal, and the
  READMEs show it.

== Non-goals

- Choosing a server at runtime, load balancing, or failover. Transport.
- Reading `servers:` declared at the path-item or operation level, which
  OpenAPI permits and no vendored example uses. Refused by name until a task
  asks for it.

== Files

- `src/Generator/Emit/ClientEmitter.php`
- `src/Generator/Emit/`
- `examples/`
